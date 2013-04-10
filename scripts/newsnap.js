var allSnaps = [];
var allFriends = [];

var currentSnap;

var photoboothIni = false;

$('#views a:first').tab('show');
$('#views a:last').click(function() {
  if(!photoboothIni)
    {
      setTimeout(function() {
        $('#webcam').photobooth().on("image", function(event, dataUrl) {
          $('#webcam').data("photobooth").pause();
          $('#newSnap').show();
          $('#webcam').hide()
          $('#newImage').attr('src', dataUrl);
        });

        $('#webcam').parent().resize(function(){
          $(this).data("photobooth").resize($(this).width(),$(this).height())
        });
      }, 100);

    }
});

function writeFriends(friends)
{
  $("#friends li a").parent().remove();
  $("#snapFriends").empty();

  for(n in friends)
  {
    var friend = friends[n];
    var friendCont = $('<label class="checkbox inline" for="friends"></label>');
    var display = friend.display ? (friend.display + ' (' + friend.name + ')') : friend.name;
     $('<input type="checkbox" value="' + friend.name + '" name="friends" /><span>' + display + '</span></label>').appendTo(friendCont);
    friendCont.appendTo('#snapFriends');

    $('<li><a href="#">&nbsp;</a></li>')
     .children().text(display)
     .popover({'html': true, 'content':'<button class="btn btn-danger hbtn" onclick="deleteUser(this)"><b class="icon-trash"></b>Remove User</button><button onclick="modifyUser(this)" class="btn btn-info hbtn"><b class="icon-pencil"></b>Change Display Name</button>', 'placement': 'top'})
     .click(function() {
       $("#friends li.active").removeClass('active').children().popover('hide');
       $(this).parent().addClass('active');
     })
     .parent().data('name', friend.name).appendTo('#friends');

  }
  allFriends = friends;
}

function writeSnaps(snaps)
{
  $("#snaps li a").parent().remove();
  for(n in snaps)
  {
    snap = snaps[n];
    if(snap.sn && (snap.m == 0) && (snap.t))
    {
      li = $('<li><a href="view.php?snap=' + snap.id + '" data-id="' + snap.id + '">' + snap.sn  + '</a></li>');
      if(currentSnap == snap.id)
        li.addClass('active');
      li.click(viewSnap).appendTo('#snaps');
    }
  }
  allSnaps = snaps;

  if($("#snaps .active").length == 0)
    $("#snaps li a").first().click();
}

$('#image').on("load", function() {
  $(this).show();
  $('#bar').addClass('hidden');
});

function viewSnap(event)
{
  event.preventDefault();
  currentSnap = $(this.firstChild).data('id');
  $('#image').attr('src', event.currentTarget.firstChild.href).hide();
  target = $(event.currentTarget)
  target.parent().children().removeClass('active');
  target.addClass('active');
  $('#views a:first').tab('show');
  $('#bar').removeClass('hidden');
}

function sendSnap(friend)
{
  var data = {};
  data['url'] = $('#newImage').attr('src');
  val = [];
  $("input[name='friends']").each(function(i)
  {
    if(this.checked)
      val.push(this.value);
  });
  data['friends'] = val;
  console.log(data);
  $.post('upload.php', data);
  $("#newSnap").hide();
  $('#webcam').data("photobooth").resume();
  $("#webcam").show();
}

function addUser(btn)
{
  $(btn).popover({'html': true, 'content': '<input id="newUser" placeholder="username" onkeyup="reallyAddUser(event)"/>', 'placement': 'bottom'});
}

function reallyAddUser()
{
    if(window.event.which != 13)
      return;
    var name = $(window.event.target).val();
    $.post('/friend.php', {'action': 'add', 'friend': name});
    $.ajax('/friends.php?callback=writeFriends', {dataType: 'script'});
    $(window.event.target).parent().parent().parent().remove();
}

function deleteUser(e)
{
  var li = $(e).parent().parent().parent().parent();
  var name = li.data('name');
  $.post('/friend.php', {'action': 'delete', 'friend': name});
  li.remove();
  $.ajax('/friends.php?callback=writeFriends', {dataType: 'script'});
}

function modifyUser(e)
{
  var li = $(e).parent().parent().parent().parent();
  var name = li.data('name');
  $(e).parent().empty().html('<input type="text"/>').attr('placeholder', li.text()).keypress(function(event) {
    if(event.which != 13)
      return;

    var newName =  $(event.currentTarget).children().val();
    $.post('/friend.php', {'action': 'display', 'friend': name, 'display': newName});
    li.children().popover('hide');
    $.ajax('/friends.php?callback=writeFriends', {dataType: 'script'});
  });
}
