<?
ini_set('display_errors',1);
require('snaphax.php');
session_start();
$opts['username'] = $_SESSION['u'];
$opts['password'] = $_SESSION['p'];
$s=new Snaphax($opts);
$request = $s->login();

if(isset($_POST['url']))
{
  if(substr($_POST['url'], 0, 4) == "data")
    $uriPhp = 'data://' . substr($_POST['url'], 5);
  else
    $uriPhp = $_POST['url'];

  $image_data = file_get_contents($uriPhp);

  $tmpfile = tempnam("/tmp", 'img');
  file_put_contents($tmpfile, $image_data);
  $jpg_data = shell_exec("convert $tmpfile jpg:-");
  file_put_contents($tmpfile, $jpg_data);
  unlink($tmpfile);
  $resp = $s->upload($jpg_data, SnapHax::MEDIA_IMAGE, $_POST['friends']);
 // $resp = $s->upload($jpg_data, SnapHax::MEDIA_IMAGE, array("nykac"));
?>
{
  "result": "success",
   "more": <?=json_encode($resp); ?>
}
<?
}

