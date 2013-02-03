      for(n in friends)
      {
        friend = friends[n];
        $('#snapFriends').append("<button onclick=\"sendPhoto('" + friend.name + "')\">" + friend.name + '</button>');
      }

      $('#newSnap').hide();

      for(n in snaps)
      {
        snap = snaps[n];
        if(snap.sn)
        {
          $('#snaps').append('<li><a href="view.php?snap=' + snap.id + '">' + snap.sn  + '</a></li>');
        }
      }

      function takePhoto()
      {
        window.open("capture.html", "width=640,height=480,menubar=no,scrollbars=no");
        $('#newSnap').show();
      }

      function sendPhoto(friend)
      {
        var data = $('#newImg').attr('src');
        $.post('upload.php', { "friend": friend, "data": data});
      }
