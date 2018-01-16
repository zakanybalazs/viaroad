<?php
session_start();
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
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

    <div class="container jumbotron">
      <div class="col-lg-3 col-md-3 col-sm-2">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >
            <form action="ujauto.php" method="post">
              <h2 class="form-control-heading">Új céges autó hozzáadása</h2>
              <input type="string" name="rendszam" class="form-control" placeholder="Rendszám" required autofocus>
              <p></p>
              <input type="string" list="cegek" name="ceg" class="form-control" placeholder="Kölcsönbe adó cég neve" required>
                <datalist id="cegek">
                  <?php
                  $q = "SELECT * FROM cegek WHERE dij > 0";
                  $sq = mysqli_query($viapanServer, $q);
                  while($sqa = mysqli_fetch_assoc($sq)) {
                    ?>
                    <option><?php echo $sqa['ceg'] ?></option>
                  <?php }
                   ?>
                </datalist>
              <p></p>
              <input type="string" name="marka" class="form-control" placeholder="Autó márkája" required>
              <p></p>
              <input type="string" name="tipus" class="form-control" placeholder="Autó típusa" required>
              <p></p>
              <input type="number" step="0.1" name="fogyasztas" class="form-control" placeholder="Autó fogyasztása" required>
              <p></p>
              <input type="number" step="0.1" name="terfogat" class="form-control" placeholder="Autó motor löktérfogata" required>
              <p></p>
              <select class="select form-control" name="uzemanyag">
                <option value"benzin">Benzin</option>
                <option value="diesel">Diesel</option>
              </select>
              <p></p>
              <input type="string" name="berletszam" class="form-control" placeholder="Bérleti szerződés száma" required>
              <p></p>
              <input type="date" name="berletkezdete" class="form-control date" placeholder="Bérleti szerződés kezdete" required>
              <p></p>
              <input type="date" name="berletvege" class="form-control date" placeholder="Bérleti szerződés vége" required>
              <p></p>
              <button class="btn btn-group-lg btn-success btn-block" type="submit">hozzaadas</button>
            </form>
            <h1></h1>
      </div>
</div>
<div class="container">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Rendszám</th>
        <th>Cég</th>
        <th>Márka</th>
        <th>Tipus</th>
        <th>Üzemanyag</th>
        <th>Fogasztás (l/100km)</th>
        <th>Bérleti szerződés száma</th>
        <th>Bérleti szerződés kezdete</th>
        <th>Bérleti szerződés lejárata</th>
      </tr>
    </thead>
    <tbody>
        <?php
        if (empty($_POST['rendszam'])) {
        //  $viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
          $query = "SELECT * FROM autok WHERE tulaj='ceges'";
          $autokSet = mysqli_query($viapanServer, $query);
          while ($autok = mysqli_fetch_assoc($autokSet)) {
            $rendszam = $autok['rendszam'];
            $ceg = $autok['ceg'];
            $marka = $autok['marka'];
            $tipus = $autok['tipus'];
            $uzemanyag = $autok['uzemanyag'];
            $fogyasztas = $autok['fogyasztas'];
            $berletszam = $autok['berletszam'];
            $berletkezdete = $autok['berletkezdete'];
            $berletvege = $autok['berletvege'];
         echo "<tr><td>$rendszam</td>";
         echo "<td>$ceg</td>";
         echo "<td>$marka</td>";
         echo "<td>$tipus</td>";
         echo "<td>$uzemanyag</td>";
         echo "<td>$fogyasztas</td>";
         echo "<td>$berletszam</td>";
         echo "<td>$berletkezdete</td>";
         echo "<td>$berletvege</td>";
         echo "<td><a class='btn btn-success' type='submit' href='ujauto.php?delete=$rendszam'>Törlés</a></td></tr>";

          }

      } else {
        // itt kell az új autókat felvinni

//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
$query = "SELECT * FROM autok WHERE tulaj = 'ceges'";
$autokSet = mysqli_query($viapanServer, $query);
while ($autok = mysqli_fetch_assoc($autokSet)) {
  $rendszam = $autok['rendszam'];
  $ceg = $autok['ceg'];
  $marka = $autok['marka'];
  $tipus = $autok['tipus'];
  $uzemanyag = $autok['uzemanyag'];
  $fogyasztas = $autok['fogyasztas'];
  $berletszam = $autok['berletszam'];
  $berletkezdete = $autok['berletkezdete'];
  $berletvege = $autok['berletvege'];
echo "<tr><td>$rendszam</td>";
echo "<td>$ceg</td>";
echo "<td>$marka</td>";
echo "<td>$tipus</td>";
echo "<td>$uzemanyag</td>";
echo "<td>$fogyasztas</td>";
echo "<td>$berletszam</td>";
echo "<td>$berletkezdete</td>";
echo "<td>$berletvege</td></tr>";

}
}
if (!empty($_POST['rendszam'])) {
  // mivel csak céges autókat viszünk itt fel, ezért a tulaj mindig ceges
  $tulaj = "ceges";
  //custom function
  $rendszamf = $_POST['rendszam'];
  $cegf = $_POST['ceg'];
  $markaf = $_POST['marka'];
  $tipusf = $_POST['tipus'];
  $uzemanyagf = $_POST['uzemanyag'];
  $fogyasztasf = $_POST['fogyasztas'];
  $terfogat = $_POST['terfogat'];
  $berletszamf = $_POST['berletszam'];
  $berletkezdetef = $_POST['berletkezdete'];
  $berletvegef = $_POST['berletvege'];
  ujCegesAuto($rendszamf, $tulaj, $cegf, $markaf, $tipusf, $uzemanyagf, $terfogat, $fogyasztasf, $berletszamf, $berletkezdetef, $berletvegef);
  ?>
  <script type="text/javascript">
  window.location.href = "ujauto.php?siker=1";
  </script>
<?php
}
if (!empty($_GET['delete'])) {
  $torlendo = $_GET['delete'];
  //echo "$torlendo";
autoTorol($torlendo);
 ?>
 <script type="text/javascript">
 window.location.href = "ujauto.php?siker=2";
 </script>
<?php
}
 ?>
    </tbody>
  </table>
</div>
</div>
  </body>
</html>
