<?
ini_set('display_errors',1);
require('snaphax.php');
session_start();
$opts['username'] = $_SESSION['u'];
$opts['password'] = $_SESSION['p'];
$s=new Snaphax($opts);
$request = $s->login();

$requested_snap = Array();

foreach($request['snaps'] as $snap)
{
  if($snap['id'] == $_GET['snap'])
  {
    $requested_snap = $snap;
    break;
  }
}

$blob = $s->fetch($requested_snap['id']);
if($blob)
{
  if($requested_snap['m'] == SnapHax::MEDIA_IMAGE)
  {
    header('Content-Type: image/jpeg');
  }
  else
  {
    header('Content-Type: video/mp4');
  }

  print($blob);
}
else
{
  header('Content-Type: image/png');
  passthrough('convert  -fill black label:"Error, something went wrong" png:-');
}
