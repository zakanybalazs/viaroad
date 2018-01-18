<?php
ini_set('upload_max_filesize', '10M');
session_start();
$userName = $_SESSION['userName'];

$hely = $_POST['nev'];
rename($_FILES['kep']['tmp_name'],$hely);

 $json  = array();

?>
