<?php
require_once 'azaz.php';
$data = $_POST['data'];
$szambetu = szam($data);

header("Content-Type: text/json");
echo json_encode($szambetu);

 ?>
