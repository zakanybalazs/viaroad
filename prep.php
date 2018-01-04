<?php
session_start();
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
include "functions.php";
//include 'css/headerAdmin.php';
$userName = $_SESSION['userName'];
if (!isset($userName)) {
  ?>
  <script type="text/javascript">
    window.location="index.php";
  </script>
<?php } ?>
  <body>
    <div class="container">
      <div class="col-lg-3 col-md-3 col-sm-2">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >
<form class="" action="prep.php" method="post">
  <input type="string" name="ceg" placeholder="ceg">
  <input type="string" name="telep" placeholder="telep">
  <input type="string" name="id" placeholder="id">
  <input type="submit" name="" value="submit">
</form>
<?php
$ceg = mysqli_real_escape_string($viapanServer, $_POST['ceg']);
$telep = mysqli_real_escape_string($viapanServer, $_POST['telep']);
$id = mysqli_real_escape_string($viapanServer, $_POST['id']);

$query = "INSERT INTO cegek (ceg,telep,id) VALUES ('{$ceg}','{$telep}','{$id}')";
$valami = mysqli_query($viapanServer, $query);
 ?>
      </div>
      </div>
  </body>
</html>
