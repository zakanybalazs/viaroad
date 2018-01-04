<?php
session_start();
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
include "functions.php";
include 'css/headerAdmin.php';
$userName = $_SESSION['userName'];
$felhasznalo = $_GET['szerkeszt'];
if (!isset($userName)) {
  ?>
  <script type="text/javascript">
    window.location="index.php";
  </script>
<?php } ?>

  <body>

    <div class="container jumbotron">
      <div class="col-lg-3 col-md-3 col-sm-2">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >
            <form action="felhasznaloszerkeszt.php" method="post">
              <h2 class="form-signin-heading"><?php echo $felhasznalo ?> Szerkesztése</h2>
      <p></p>
              <div class="checkbox">
              <select class="select form-control" name="auth" required>
                <option value="admin">admin</option>
                <option value="user">felhasznalo</option>
              </select>
              </div>
              <button class="btn btn-success btn-block" type="submit">Mentés</button>
            </form>
            <h1></h1>
      </div>
</div>
<?php
if (!empty($_POST['user'])) {
$userName = $_POST['user'];
$userAuth = $_POST['auth'];
$safeUser = mysqli_real_escape_string($viapanServer, $userName);
$userId = getUserId($safeUser);
//echo "$userName, $userAuth, $userId";
editUser($userId,$userName,$userAuth);

}
 ?>
  </body>
</html>
