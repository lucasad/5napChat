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
  for(n in friends)
  {
    friend = friends[n];
    friendCont = $('<label class="checkbox inline" for="friends"></label>');
     $('<input type="checkbox" value="' + friend.name + '" name="friends" /><span>' + friend.name + '</span></label>').appendTo(friendCont);
    friendCont.appendTo('#snapFriends');
  }
  allFriends = friends;
}

function writeSnaps(snaps)
{
  $("#snaps").empty();
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
    $("#snaps li").first().click();
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
  data = {};
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
