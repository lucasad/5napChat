<?
ini_set('display_errors',1);
session_start();
if(!isset($_SESSION['u']))
{
  header('Location: login.php');
  exit();
}
?>
<!doctype html>
<html>
  
  <head>
    <title>5napChat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<!--    <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/2.1.1/superhero/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  </head>
<? flush(); ?>
  <body>
    <div class="container container-fluid">
<!--      <div class="hero-unit">
        <h1 class="page-header">5nap Chat</h1>
        <p>A SnapChat client using WebRTC</p>
      </div>-->
      <div class="well">
        <a href="/logout.php" class="btn btn-danger pull-right">Logout</a>
        <h2>Welome <?=$_SESSION['u']?></h2>
      </div>
      <div class="row-fluid">
        <div class="span4">
          <div class="well">
            <ul class="nav nav-list" id="friends">
              <li class="nav-header">Friends <button class="btn btn-primary pull-right" onclick="addUser(this)"><b class="icon-plus"></b></button></li>
              <li class="divider"></li>
            </ul>
          </div>

          <div class="well">
            <ul class="nav nav-list" id="snaps">
              <li class="nav-header">Snaps</li>
              <li class="divider"></li>
            </ul>
          </div>
        </div>
        <div class="span8">
          <div class="well">
            <ul class="nav nav-tabs" id="views">
              <li>
                <a href="#view" data-toggle="tab">View Photo</a> 
              </li>
              <li class="active">
                <a href="#capture" data-toggle="tab">Take Photo</a> 
              </li>
            </ul>
            <div class="tab-content">

              <div class="tab-pane" id="view">
                <img src="http://placehold.it/640x480" id="image"></img>
                <div class="progress progress-striped active hidden" id="bar">&nbsp; <div class="bar" style="width: 98%;"></div></div>
              </div>

              <div class="tab-pane active" id="capture">
	        <div id="file">
		  Select File:
		  <input type="file" onchange="updateImage(event)" />
         	</div>
                <div id="webcam" class="stretch r4-3"></div>
                <div id="newSnap" style="display:none">
                  <img src="http://placehold.it/640x480" id="newImage"></img>
                  <div class="control-group">
                    <label class="control-label">Friends</label>
                    <div class="controls" id="snapFriends"></div>
                  </div>
                 <a class="btn btn-primary btn-block" onclick="sendSnap()">Send</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<? flush(); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script src="scripts/photobooth.js"></script>
    <script>
      var username = "<?=$_SESSION['u']?>";
      var allSnaps = [];
      var allFriends = [];
      setInterval(function(){
        $.ajax({
          dataType: "json",
          url: 'snaps.php',
          success: writeSnaps
        });
      }, 5000);
    </script>
    </script>
    <script src="scripts/newsnap.js"></script>
    <script src="snaps.php?callback=writeSnaps"></script>
    <script src="friends.php?callback=writeFriends"></script>

  </body>
</html>
