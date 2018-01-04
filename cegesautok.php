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
<?php
$userId = $_SESSION['userName'];
$userAuth = $_SESSION['auth'];
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
$ceges = "ceges";
$query = "SELECT * FROM autok WHERE tulaj = '$ceges'";
$userSet = mysqli_query($viapanServer, $query);
 ?>

  <form action="ujauto.php" method="post">

  <h2>Céges autók listája
    <?php if ($auth=="superuser") {

    ?>
    <button class="btn btn-group-lg btn-success" type="submit">Autók kezelése</button>
  <?php } ?>
    <p></p>
  </h2>
</div>
</form>
<div class="container">
<div class="jumotron">
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
         <th>Engedélyek</th>
       </tr>
     </thead>
     <tbody>
<script src="https://code.jquery.com/jquery-1.9.1.min.js" charset="utf-8"></script>
<script type="text/javascript">
$.noConflict();
  $( document ).ready( function() {
    $('[data-toggle="popover"]').popover()
  })
</script>
         <?php
  //       itt a céget kiválasztjuk
         $ceges = "ceges";
         $query = "SELECT * FROM autok WHERE tulaj = '$ceges'";
         $autokSet = mysqli_query($viapanServer, $query);
         while ($autok = mysqli_fetch_assoc($autokSet)) {
           $rendszam = $autok['rendszam'];
           $ceg = $autok['ceg'];
           $marka = $autok['marka'];
           $tipus = $autok['tipus'];
           $uzemanyag = $autok['uzemanyag'];
           $fogyasztas = $autok['fogyasztas'];
           $berletszam = $autok['berletszam'];
        echo "<tr><td>$rendszam</td>";
        echo "<td>$ceg</td>";
        echo "<td>$marka</td>";
        echo "<td>$tipus</td>";
        echo "<td>$uzemanyag</td>";
        echo "<td>$fogyasztas</td>";
        echo "<td>$berletszam</td>";
        if ($auth == "superuser" || $auth == "admin") {
            $userList = "";
            $userQ = "SELECT * FROM hozzarendel WHERE rendszam = '{$rendszam}'";
            $userSet = mysqli_query($viapanServer, $userQ);
            while ($felhasznalok = mysqli_fetch_assoc($userSet)) {
              $userSelected = $felhasznalok['felhasznalo'];
              $userList = $userList . $userSelected . ", ";
            }
            if ($userList == "") {
              $userList = "Jelenleg nincs az autóhoz rendelve egy felhasználó sem.";
            }
        echo "<td><button class='btn btn-success' data-toggle='popover' data-trigger='focus' data-placement='top' title='Felhasználók listája' data-content='$userList'>Ki vezetheti?</button></td>";
      }
        echo "</tr>";
         }
          ?>
     </tbody>
   </table>
 </div>
 </div>
  </body>
</html>
