<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $json = array();
 $ceg = $_POST['PostCeg'];
 $telep = $_POST['PostTelep'];
 $id = $_POST['id'];
 $dij = $_POST['PostDij'];
 

if (!empty($_POST['PostCeg'])) {
$cegedit =  CegEdit($ceg,$telep,$id,$dij);
  if($cegedit=="ok") {
     $json[]=array(
       "ok"
     );
   } else {
     # send something to say it didn't work
     $json[]=array(
       "$cegedit"
     );
   }
}
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
