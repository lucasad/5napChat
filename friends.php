<?
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
$s=new Snaphax($opts);
$request = $s->login();
if(isset($_GET['callback']))
{
  echo $_GET['callback'], '(';
}
echo json_encode($request['friends']);
if(isset($_GET['callback']))
{
  echo ');';
}
