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
          <a class="btn btn-success" href="ujfelhasznalo.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Vissza</a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >
              <h2 class="form-signin-heading"><?php echo $felhasznalo ?> Szerkesztése</h2>
      <p></p>
              <div class="checkbox">
              <select class="select form-control" id="auth" required>
                <option value="admin">admin</option>
                <option value="user">felhasznalo</option>
              </select>
              </div>
              <button class="btn btn-success btn-block" onclick="szerk()">Mentés</button>

            <h1></h1>
      </div>
</div>
<script type="text/javascript">
  function szerk() {
    var auth = $('#auth option:selected').val();
    var felhasznalo_nev = '<?php echo $felhasznalo ?>';
    $.post("ajax/ajax.felhasznalo_szerk.php", {
      felhasznalo_nev: felhasznalo_nev,
      auth: auth,
    },
    "json").done(function( response ) {
      if (response != "error") {
        window.location="ujfelhasznalo.php";
      }
    });
  }
</script>

  </body>
</html>
