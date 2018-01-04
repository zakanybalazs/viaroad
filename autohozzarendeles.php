<?php
session_start();
require_once "functions.php";
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
    <?php
    $query = "SELECT * FROM autok WHERE tulaj = 'ceges'";
    $autokSet = mysqli_query($viapanServer, $query);

     ?>
    <div class="container jumbotron">
      <div class="col-lg-3 col-md-3 col-sm-2">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >
            <form action="autohozzarendeles.php?szerkeszt=<?php echo $felhasznalo?>" method="post">
              <h2 class="form-signin-heading">Céges autó hozzárendelése, felhasználó: <?php echo $felhasznalo ?></h2>
              <select class="select form-control" name="auto" required>
<?php   while ($autok = mysqli_fetch_assoc($autokSet)) {
                $auto = $autok['rendszam'];
                echo "<option name=$auto>$auto</option>";
}
?>
              </select>
<p></p>
              <button class="btn btn-group-lg btn-success btn-block" type="submit">Hozzárendel</button>
            </form>
            <h1></h1>
      </div>
</div>
<?php
if (!empty($_POST['auto'])) {
$hozzarendelAuto = $_POST['auto'];
$safeUser = mysqli_real_escape_string($viapanServer, $felhasznalo);
if (validHozzaRendel($safeUser,$hozzarendelAuto)) {
ujHozzaRendeles($safeUser,$hozzarendelAuto);
}
}
 ?>
 <div class="container">

 <table class="table table-striped table-hover">
 <thead>
   <tr>
     <th>Hozzárendelt és saját rendszámok</th>
     <th>Márkája</th>
    <th>Típusa</th>
    <th>Fogyasztása</th>
    <th>Üzemanyag fajtája</th>
    <th>Forgalmi engedélye (csak saját autó)</th>
   </tr>
 </thead>
 <tbody>

 <?php
 $myquery = "SELECT * FROM hozzarendel WHERE felhasznalo = '$felhasznalo'";
 $autokUser = mysqli_query($viapanServer, $myquery);
while ($au = mysqli_fetch_assoc($autokUser)) {
$rendszam = $au['rendszam'];
$autoQuery = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
$autokAdatok = mysqli_query($viapanServer, $autoQuery);
while ($autokAdat = mysqli_fetch_assoc($autokAdatok)) {
    $marka = $autokAdat['marka'];
    $tipus = $autokAdat['tipus'];
    $fogyasztas = $autokAdat['fogyasztas'];
    $uzemanyag = $autokAdat['uzemanyag'];

}
  echo "<tr>";
  echo "<td>$rendszam</td>";
  echo "<td>$marka</td>";
  echo "<td>$tipus</td>";
  echo "<td>$fogyasztas L/100Km</td>";
  echo "<td>$uzemanyag</td>";
  echo "<td></td>";
  echo "</tr>";
}
$sajatQuery = "SELECT * FROM autok WHERE tulaj = '{$felhasznalo}'";
$sajatAutoAdatok = mysqli_query($viapanServer, $sajatQuery);
while ($sajatAdat = mysqli_fetch_assoc($sajatAutoAdatok)) {
  $rendszam = $sajatAdat['rendszam'];
  $marka = $sajatAdat['marka'];
  $tipus = $sajatAdat['tipus'];
  $fogyasztas = $sajatAdat['fogyasztas'];
  $uzemanyag = $sajatAdat['uzemanyag'];
  $forgalminev = $sajatAdat['forgalminev'];
  $forgalmihely = $sajatAdat['forgalmihely'];

  echo "<tr>";
  echo "<td>$rendszam</td>";
  echo "<td>$marka</td>";
  echo "<td>$tipus</td>";
  echo "<td>$fogyasztas L/100Km</td>";
  echo "<td>$uzemanyag</td>";
  if ($forgalminev != "NA") {
  echo "<td><a class='btn btn-success' href='$forgalmihely' data-toggle='lightbox' dataType='image/jpeg' download>Forgalmi letöltése</a></td>";
} else {
  echo "<td></td>";
}
  echo "</tr>";
}

?>
</tbody>
</table>
</div>
  </body>
</html>
