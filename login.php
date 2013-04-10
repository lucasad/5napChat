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
    <title>Login</title>
  </head>
  <body>
    <form method="post">
      <input type="text" name="u" placeholder="Username" />
      <br />
      <input type="password" name="p" placeholder="password" />
      <br />
      <input type="submit" value="Login" />
    </form>
  </body>
</html>
