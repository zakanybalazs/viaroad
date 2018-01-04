<?php
session_start();
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
include "functions.php";
include 'css/headerAdmin.php';
$userName = $_SESSION['userName'];
if (!isset($userName)) {
  ?>
  <script type="text/javascript">
    window.location="index.php";
  </script>
<?php } ?>
  <body>
    <div class="container">
    <div class="jumbotron">
      <h1>
<?php
$userId = $_SESSION['userName'];
$userAuth = $_SESSION['auth'];
echo "hello, $userId  aki: $userAuth";
 ?>
 </h1>
 </div>
</div>

  </body>
</html>
