<?
ini_set('display_errors',1);
session_start();
if(!isset($_SESSION['u']))
{
  header('Location: login.php');
  exit();
}
header('Content-Type: text/javascript');
require('snaphax.php');
$opts['username'] = $_SESSION['u'];
$opts['password'] = $_SESSION['p'];
//$opts['debug'] = 1;
$s=new Snaphax($opts);
$request = $s->login();
if(isset($_GET['callback']))
{
  echo $_GET['callback'], '(';
}
echo json_encode($request['snaps']);
if(isset($_GET['callback']))
{
  echo ');';
}
