      var allSnaps = [];
      var allFriends = [];

      $('#webcam').photobooth().on("image", function(event, dataUrl) {
        $('#webcam').hide();
        $('#newSnap').show();
        $('#newImage').attr('src', dataUrl);
      });
      $('#views a:first').tab('show');

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
        for(n in snaps)
        {
          snap = snaps[n];
          if(snap.sn && (snap.m == 0))
          {
            $('<li><a href="view.php?snap=' + snap.id + '">' + snap.sn  + '</a></li>').click(viewSnap).appendTo('#snaps');
          }
        }
        allSnaps = snaps;
      }

      $('#image').on("load", function() {
        $(this).show();
        $('#bar').addClass('hidden');
      });

      $("#snaps li").first().click()

      function viewSnap(event)
      {
        event.preventDefault();
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
        $("#webcam").show();
      }
