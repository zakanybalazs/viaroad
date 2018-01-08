<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$editor = $_POST['editor'];
$editor = mysqli_real_escape_string($viapanServer, $editor);
$csv = $_POST['csv'];
$csv = json_encode($csv);
$q1 = "INSERT INTO csv (editor, csv) VALUES ('{$editor}','{$csv}')";
$sq1 = mysqli_query($viapanServer,$q1);

if ($sq1) {
  $json = array('ok');
} else {
  $json = array('error');
}
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
