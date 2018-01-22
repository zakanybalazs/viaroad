<?php
require_once 'azaz.php';
$data = $_GET['data'];
$data = (int)$data;
$szambetu = szam($data);
header("Content-Type: text/json; charset=utf8");
echo json_encode($szambetu, JSON_UNESCAPED_UNICODE);
 ?>
