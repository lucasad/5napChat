<?php
session_start();
if(!isset($_SESSION['u']))
{
  header('Location: login.php');
  exit();
}

require('snaphax.php');
$opts['username'] = $_SESSION['u'];
$opts['password'] = $_SESSION['p'];

$s = new Snaphax($opts);
$s->login();

$display = NULL;
if(isset($_POST['display']))
  $display = $_POST['display'];

echo json_encode($s->friend($_POST['action'], $_POST['friend'], $display));
