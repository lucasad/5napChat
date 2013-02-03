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
$opts['debug'] = 1;
$s=new Snaphax($opts);
$request = $s->login();

//echo json_encode($request);

$data = Array();
if(isset($_REQUEST['data']))
  $data = json_decode($_REQUEST['data']);

$ts = $s->api->time();

$data['timestamp'] = $ts;
$data['username'] = $_SESSION['u'];

echo json_encode($s->api->postCall($_REQUEST['path'], $data, $s->auth_token, $ts, isset($_REQUEST['json']) ? 1 : 0));
