<?
if($_SERVER['REQUEST_METHOD'] == 'POST')
  { // Login

  require('snaphax.php');

  $opts['username'] = $_POST['u'];
  $opts['password'] = $_POST['p'];
  $opts['debug'] = FALSE;

  $s = new Snaphax($opts);
  $result = $s->login();

  if(isset($result['auth_token']))
  {
    session_start();
    $_SESSION['u'] = $_POST['u'];
    $_SESSION['p'] = $_POST['p'];
    header('Location: index.php');
    exit();
  }
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
      <div class="hero-unit">
        <h1 class="page-header">5nap Chat</h1>
        <p>A SnapChat client using WebRTC</p>
      </div>
      <div class="row-fluid">
        <div class="span3">
          <div class="well">
            <form method="post">
              <fieldset>
                <legend>Login:</legend>
                <input type="text" name="u" placeholder="Username" />
                <br />
                <input type="password" name="p" placeholder="password" />
                <br />
                <input type="submit" value="Login" />
              </fieldset>
            </form>
          </div>
        </div>

        <div class="span9">
          <div class="well">
            <h2>About</h2>
            <p>5napChat started out as my pet project when I looked for a way to help my friend view her snaps without a phone</p>
            <blockquote>
              <p>If I have seen further it is by standing on the shoulders of giants.</p>
              <cite>&mdash; Isaac Newton.</cite>
            </blockquote>
            <p>5napChat is built with the following:</p>
            <ul>
              <li>Twitter's <a href="//twitter.github.com/bootstrap">Bootstrap</a></li>
              <li><a href="//jquery.org">jQuery</a></li>
              <li>Tlack's excellent <a href="http://github.com/tlack/snaphax">Snaphax</a> library. My fork <a href="https://github.com/nykac/snaphax">here</a></li>
              <li><a href="//php.net">PHP5</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
