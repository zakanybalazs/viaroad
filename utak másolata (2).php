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
  <?php }
  // "nincs" vagy "van" ad csak vissza
  $PreLoads = piszkozatKereso($userName);
  if (!empty($_GET['siker'])) {
    if ($_GET['siker']==1) {
      ?>
      <body>
        <div class="container alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sikeresen rögzítve!</strong>
        </div>
        <?php
      }else {
        ?>
        <div class="container alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Sikertelen rögzítés</strong>
        </div>
        <?php
      }
    }
    if (!empty($_GET['delete'])) {
      $torlesID = $_GET['delete'];
      $rendszamMax = $_GET['rendszam'];
      utTorles($torlesID);
      ujKilometerMax($rendszamMax);
    }
    ?>
    <body>
      <div class="container jumbotron">
        <form enctype="multipart/form-data" action="utak.php" method="post">
          <h2 align="center">Új út rögzítése</h2>
          <div class="col-lg-3 col-md-3 col-sm-3">
            <h1></h1>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
          <select class="form-control" name="rendszam" id="rendi">
            <?php
            //-- Ha a PreLoadshoz tartozó funkció (piszkozatKereso) nullt ad vissza, --//
            //--akkor nincsen piszkozata a felhasználónak                            --//


            if ($PreLoads == "nincs") {
              /*
              |       Itt kell megcsinállapitani, hogy van e felhasználóra          |
              |már elmentett piszkozat, mert ha van, akkor azokat kell              |
              |betölteni, ha nincsen, akkor pedig a $var SET to NULL. Ez azért kell,|
              |hogy a HTML form a placeholdert használja a value helyett            |
              */
              echo "<option disabled selected style='display:none;' required >Rendszám</option>";
              $rendszamForm = null;
              $kolcsonbeForm = null;
              $honnanForm = null;
              $hovaForm = null;
              $celForm = null;
              $kezdokmForm = null;
              $zarokmForm = null;
              $datumForm = null;

            } else {

              /*
              |Itt fogjuk kikeresni az értékeket. Amennyiben nincsen érték rögzitve, úgy nem |
              |fog visszaadni, csak nullt, de az nekünk rendben van, működik úgy is.         |
              |Viszont nem lesznek normál esetben nullok, mert akkor DEF lesz az alap amit   |
              |be kell irni a DB-be,(számoknál pedig -1) különben nem működik a funkció.     |
              |Erre külön kell csinálni, egy részt, amiben beállitjuk a változókat,          |
              |amik DEF-et vagy -1 et adnak vissza. Ehhez itt most lekérjük az összes adatot |
              */
              $piszkozatQuery = "SELECT * FROM piszkozat WHERE felhasznalo = '{$userName}'";
              $kereses = mysqli_query($viapanServer, $piszkozatQuery);
              while ($talalt = mysqli_fetch_assoc($kereses)) {
                $rendszamForm = $talalt['rendszam'];
                $datumG = $talalt['datum'];
                $kolcsonbeID = $talalt['kolcsonbe'];
                $honnanG = $talalt['honnan'];
                $hovaG = $talalt['hova'];
                $celG =  $talalt['cel'];
                $kezdokmG =  $talalt['kezdokm'];
                $zarokmG = $talalt['zarokm'];
              }

              if ($kolcsonbeID == null) {
                /* Mivel nem mentett el a piszkozatban
                cég id-t ezért resetelni kell a változót */
                $kolcsonbeForm = null;
              }  else {
                /*Amennyiben a piszkozat nem az alapbeállitáson
                van, akkor meg kell keresnünk az id-hoz tartozó céget
                erre már korábban csináltam egy funkciót, ezért nem
                kell újracsinálni :)
                */
                switch ($kolcsonbeID) {
                  case 'md':
                  $kolcsonbeForm ="Meló-Diák Dél Iskolaszövetkezet";
                  break;
                  case 'di':
                  $kolcsonbeForm ="Dologidő Kft";
                  break;
                  case 'me':
                  $kolcsonbeForm ="Munka Erő Kft";
                  break;
                  case 'oszoc':
                  $kolcsonbeForm ="Önfoglalkoztató szociális szövetkezet";
                  break;
                  default:
                  $kolcsonbeForm =null;
                  break;
                }
                //$kolcsonbeForm ;
              }

              if ($honnanG == null) {
                $honnanForm = null;
              } else {
                $honnanForm = "value='$honnanG'";
              }
              if ($hovaG == null) {
                $hovaForm = null;
              } else {
                $hovaForm = "value='$hovaG'";
              }
              if ($celG == null) {
                $celForm = null;
              } else {
                $celForm = "value='$celG'";
              }
              if ($kezdokmG == 0) {
                $kezdokmForm = null;
              } else {
                $kezdokmForm = "value='$kezdokmG'";
              }
              if ($zarokmG == 0) {
                $zarokmForm = null;
              } else {
                $zarokmForm = "value='$zarokmG'";
              }

              echo "<option selected style='display:none;' required >$rendszamForm</option>";
            }
            ?>

            <?php
            $ceges = "ceges";
            $mquery = "SELECT * FROM autok WHERE tulaj ='$userName'";
            $atkSet = mysqli_query($viapanServer, $mquery);
            while ($rendszamok = mysqli_fetch_assoc($atkSet)) {
              $kivRendszam = $rendszamok['rendszam'];
              echo "<option class='dropdown' value='$kivRendszam'>$kivRendszam</option>";
            }
            $myquery = "SELECT * FROM hozzarendel WHERE felhasznalo='$userName'";
            $atkSt = mysqli_query($viapanServer, $myquery);
            while ($rendszamk = mysqli_fetch_assoc($atkSt)) {
              $kivRendszam = $rendszamk['rendszam'];
              echo "<option class='dropdown' value='$kivRendszam'>$kivRendszam</option>";
            }
            ?>
          </select>

          <p></p>
<!--  mivel a datetime-local nem támogatott Safarin, ezért egyedi inputot fogok késziteni -->
<!-- ez az első része, ez maga az input, plusz egy kalendár -->
<!-- <input type="datetime-local" name="datum" class="form-control" autocomplete="on" accept="text/html"> -->
    <div class="row">
        <div class='col-sm-12 col-md-12'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control" placeholder="Utazás dátuma" name="datum" id="datum" value="<?php if(!empty($datumG)) { echo $datumG; }?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <style type="text/css">
          .ui-datepicker.ui-widget-content {
      background: #333;
      border: 20px solid #555;
      color: #EEE;
  }
</style>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker({
                    locale: 'hu'
                });
            });
            $(document).ready(function() {
              var dd = new Date();
              if (dd.getMonth()<9) {
                var honapP = dd.getMonth() + 1;
                var honap = '0' + honapP;
              } else {
                var honap = dd.getMonth() + 1;
              }
              if (dd.getDate('DD')<10) {
                var Nap ='0' + dd.getDate('DD');
              } else {
                var Nap = dd.getDate('DD');
              }

               var stringTime =dd.getFullYear('YYYY') + '-' + honap + '-' + Nap + ' ' + dd.getHours() + ':' + dd.getMinutes();
              document.getElementById('datum').value = stringTime;
              //  Date();
            });
        </script>
    </div>
          <p></p>
          <select class="form-control" name="kolcsonbe">
            <?php if ($PreLoads != "nincs") {
              echo "<option selected style='display:none;'>$kolcsonbeForm</option>";
            } else {
              echo "<option disabled selected style='display:none;'>Külcsönbe vevő cég neve</option>";
            }
            ?>
            <option value="md">Meló-Diák Dél Iskolaszövetkezet</option>
            <option value="di">Dologidő Kft</option>
            <option value="me">Munka Erő Kft</option>
            <option value="oszoc">Önfoglalkoztató szociális szövetkezet</option>
          </select>
          <p></p>
          <!-- <input type="string" name="honnan" class="form-control" placeholder="Honnan"> -->
          <?php

          ?>
          <?php //echo $innen; ?>
          <input type="string" id="address" name="honnan" class="form-control" <?php echo $honnanForm; ?> placeholder="Honnan" required="">
          <p></p>
          <input type="string" name="hova" class="form-control" <?php echo $hovaForm; ?> placeholder="Hova" required="">
          <p></p>
          <input type="string" name="cel" class="form-control" <?php echo $celForm; ?> placeholder="Utazás célja" required="">
          <p></p>
          <input type="number" id="kil" name="kezdokm" class="form-control" <?php echo $kezdokmForm; ?> placeholder="Nyitó kilóméteróra állás" required="">
          <p></p>
          <input type="number" name="zarokm" class="form-control" <?php echo $zarokmForm; ?> placeholder="Záró kilóméteróra állás" required="">
          <p></p>
<script type="text/javascript">
$.get("https://ipinfo.io", function (response) {
  // $("#ip").html("IP: " + response.ip);
  $("#address").html("Location: " + response.city + ", " + response.region);
  // $("#details").html(JSON.stringify(response, null, 4));
  // $("#city").html(response.city);
  document.getElementById('address').value = response.city;
}, "jsonp");
</script>
          <input type="hidden" name="size" value="350000">
  					<input type="file" name="kep" id="file-1" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple required />
  					<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path
               d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
             </svg> <span>Fotó feltöltése</span></label>

          <!-- <label for="kep">Kép a záró kilóméteróra állásról</label>
          <input type="file" name="kep" class="inputfile" id="file" required=""> -->
          <p></p>
          <h1></h1>
        </div>

        <button class="btn btn-success form-control" type="submit">hozzaadas</button>
      </form>


      <?php
      // Itt kell kikeresni az autó adatait
      if (!empty($_POST['rendszam'])) {
        $kivRendszam = $_POST['rendszam'];
        $mquery = "SELECT * FROM autok WHERE rendszam = '{$kivRendszam}'";
        $atkSet = mysqli_query($viapanServer, $mquery);
        while ($rendszamok = mysqli_fetch_assoc($atkSet)) {
          $kivTulaj = $rendszamok['tulaj'];
          $kivCeg = $rendszamok['ceg'];
          $kivMarka = $rendszamok['marka'];
          $kivTipus = $rendszamok['tipus'];
          $kivFogyasztas = $rendszamok['fogyasztas'];
          $kivUzemanyag = $rendszamok['uzemanyag'];
          $kivKep = $_FILES['kep']['name'];
          $datum = $_POST['datum'];
          $kolcsonbe = $_POST['kolcsonbe'];
          $honnan = $_POST['honnan'];
          $hova = $_POST['hova'];
          $cel = $_POST['cel'];
          $kezdokm = $_POST['kezdokm'];
          $zarokm = $_POST['zarokm'];
          $kepNev = $datum . $kivRendszam.'.jpg';
          $hely = 'uploads/teszt/'.$kepNev;
          $piszk = $_POST['piszkozat'];
        }
        /* A webes/helyi szerver adatai:
        $hely = 'C:\xampp\htdocs\viapan\uploads\teszt/'.$kepNev;
        */
        if ($piszk == "piszkozat") {
          if ($PreLoads=="van") {
            $del = "DELETE FROM piszkozat WHERE felhasznalo = '{$userName}'";
            $delsiker = mysqli_query($viapanServer,$del);
            $valasz = piszkozatMentes($userName,$_POST['rendszam'],$_POST['datum'],$_POST['kolcsonbe'],$_POST['honnan'],$_POST['hova'],$_POST['cel'],$_POST['kezdokm'],$_POST['zarokm']);
            ?>
            <script type="text/javascript">
            window.location.href = "utak.php?siker=1";
            </script>
            <?php
          } else {
            $valasz = piszkozatMentes($userName,$_POST['rendszam'],$_POST['datum'],$_POST['kolcsonbe'],$_POST['honnan'],$_POST['hova'],$_POST['cel'],$_POST['kezdokm'],$_POST['zarokm']);
            ?>
            <script type="text/javascript">
            window.location.href = "utak.php?siker=1";
            </script>
            <?php
          }
        } else {
          $km = $zarokm - $kezdokm;
          if ($_FILES['kep']['size']>0) {
          } else {
            echo "oh no, no file";
          }
          // itt meg felvinni az adatokat a mysql szerver db-be
          if ($kivTulaj=="ceges") {

            if (!move_uploaded_file($_FILES['kep']['tmp_name'], $hely)){
              echo " de nem nyert";
            }
            $sofor = $_POST['sofor'];
            if (empty($sofor)) {
              $sofor = $userName;
            }

            $kilo = kilometerCheck($kivRendszam,$kezdokm);

            if ($kilo!=false) {
              ?>
              <script type="text/javascript">
              alert("Az autóra már egy későbbi kilóméteróra állást rögzítettek. Nem lehet kisebb a nyitó kilóméteróra állás, mint a legutóbbi záró kilóméteróra állás");
              </script>
              <?php
            } //nem ment át a kilometer check teszten
            else {
              echo "$kilo";
              if ($km < 1) {
                ?>
                <script type="text/javascript">
                alert("A záró kilóméteróra állásnak többnek kell lennie, mint a nyitó kilóméteróra állás!");
                window.location.href = "utak.php?siker=2";
                </script>
                <?php
              } else {
                // ha ez sikerült, akkor új legnagyobb kilóméterünk van az autóra
                kilometerUpdate($kivRendszam,$zarokm,$datum,$userName);

                //Felvisszük az utat az utak adatbázisba
                ujUtCeges($userName,$kivCeg,$kivRendszam,$datum,$kolcsonbe,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag, $hely, $kepNev, $sofor);

                //mivel az utat mentették ezért törölni kell a piszkozatot
                $del = "DELETE FROM piszkozat WHERE felhasznalo = '{$userName}'";
                $delsiker = mysqli_query($viapanServer,$del);
                ?>
                <script type="text/javascript">
                window.location.href = "utak.php?siker=1";
                </script>
                <?php
              } // negativ értékek keresése
            } // kilometerCheck
          } //ceges a tulaj
          else { /* Ha idáig eljut, akkor jó a felvitt kilometer
            Akkor nem piszkozat, viszont törölni kell
            majd törölni kell a piszkozatot
            kell egy kilometerCheck

            */
            $kilo = kilometerCheck($kivRendszam,$kezdokm);
            if ($kilo!=false) {
              ?>
              <script type="text/javascript">
              alert("Az autóra már egy későbbi kilóméteróra állást rögzítettek. Nem lehet kisebb a nyitó kilóméteróra állás, mint a legutóbbi záró kilóméteróra állás");
              </script>
              <?php
            } //nem ment át a kilometer check teszten
            else {
              // itt van az a rész , amikor megfelelő a kilómétercheck
              if ($km < 1) { // ,egnézzük hogy valid-e a kilóméter érték
                ?>
                <script type="text/javascript">
                alert("A záró kilóméteróra állásnak többnek kell lennie, mint a nyitó kilóméteróra állás!");
                window.location.href = "utak.php?siker=2";
                </script>
                <?php
              } //nem megfelelő a kilóméter
              else {
                $sofor = $_POST['sofor'];
                if (empty($sofor)) {
                  $sofor = $userName;
                }
                // ha ez sikerült, akkor új legnagyobb kilóméterünk van az autóra
                kilometerUpdate($kivRendszam,$zarokm,$datum,$userName);
                //felvisszük az utat az utak adatbázisba
                ujUtMagan($userName,$kivRendszam,$datum,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag, $hely, $kepNev, $sofor);
                // töröljül a már nem kellő piszkozatot
                $del = "DELETE FROM piszkozat WHERE felhasznalo = '{$userName}'";
                $delsiker = mysqli_query($viapanServer,$del);
                ?>
                <script type="text/javascript">
                window.location.href = "utak.php?siker=1";
                </script>
                <?php
              } //km check
            }//kilometerCheck
            ?>

            <?php
            //    ujUtMagan($kivTulaj,$kivRendszam,$kivMarka,$kivTipus,$kivFogyasztas,$datum,$honnan,$hova,$cel,$kezdokm,$zarokm,$km);

          } // nem céges a tulaj
        } // nem piszkozat
      } // van a formnak értéke (postolva van)

      ?>
      <div class="jumbotron">
        <h2>Adatok szűrése</h2>
        <form class="form form-group" action="utak.php" method="get">
          <div class="col-lg-3 col-md-3 col-sm-6">
            <strong>Mettol</strong>
            <input class="form-control" type="date" name="szureseleje">
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <strong>Meddig</strong>
            <input class="form-control" type="date" name="szuresvege">
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <strong>Rendszám</strong>
            <select class="form-control" name="szuresrendszam">
              <option value="" disabled selected style="display:none;"></option>
              <?php
              $ceges = "ceges";
              $mquery = "SELECT * FROM autok WHERE tulaj ='$userName'";
              $atkSet = mysqli_query($viapanServer, $mquery);
              while ($rendszamok = mysqli_fetch_assoc($atkSet)) {
                $kivRendszam = $rendszamok['rendszam'];
                echo "<option value='$kivRendszam'>$kivRendszam</option>";
              }
              $myquery = "SELECT * FROM hozzarendel WHERE felhasznalo='$userName'";
              $atkSt = mysqli_query($viapanServer, $myquery);
              while ($rendszamk = mysqli_fetch_assoc($atkSt)) {
                $kivRendszam = $rendszamk['rendszam'];
                echo "<option value='$kivRendszam'>$kivRendszam</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6">
            <h3></h3>
            <input class="btn btn-success btn-block" type="submit" name="" value="Mehet">
          </div>
        </form>
      </div>
    </div>
    <div class="container">
      <button class="btn btn-success" id="export" onclick="window.exportExcel()">Táblázat exportálása excelben</button>


      <?php
      if (!empty($_GET['szureseleje']) && !empty($_GET['szuresvege']) || !empty($_GET['szuresrendszam'])){
        if (!empty($_GET['szureseleje']) && !empty($_GET['szuresvege']) && !empty($_GET['szuresrendszam'])) {
          //  mindegyik meg van adva
          ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="resultsTable">
              <thead>
                <tr name="userdata">
                  <th>Utazás dátuma</th>
                  <th>Autó rendszáma</th>
                  <th>Indulási hely</th>
                  <th>Érkezési hely</th>
                  <th>Partner/ utazás célja</th>
                  <th>Kezdő kilóméteróra állás</th>
                  <th>Záró kilóméteróra állás</th>
                  <th>Kilóméter összesen</th>
                  <th>Kép</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $ke = $_GET['szureseleje'];
                $ve = $_GET['szuresvege'];
                $re = $_GET['szuresrendszam'];
                $que = "SELECT * FROM utak WHERE felhasznalo ='$userName' AND (datum BETWEEN '$ke' AND '$ve') AND rendszam ='$re'";
                $utakSet = mysqli_query($viapanServer, $que);
                while ($utjaim = mysqli_fetch_assoc($utakSet)) {
                  $utID = $utjaim['id'];
                  $datumT = $utjaim['datum'];
                  $rendszamT = $utjaim['rendszam'];
                  $honnanT = $utjaim['honnan'];
                  $hovaT = $utjaim['hova'];
                  $celT = $utjaim['cel'];
                  $kezdoT = $utjaim['kezdokm'];
                  $zaroT = $utjaim['zarokm'];
                  $kmT = $utjaim ['km'];
                  $kolcsonT = $utjaim['kolcsonbe'];
                  $kepT = $utjaim['kep'];
                  $kepNevT = $utjaim['kepnev'];
                  //$mask = DateTime('T' ,$datumT);
                  //rtrim($datumT[,$maszk]);
                  $datumTT = date_create($datumT);
                  $datumFormat = date_format($datumTT,'Y-m-d H:i');
                  //$datumFormat = $datumT->format('Y-m-d H:i:s');
                  echo "<tr><td>$datumFormat</td>";
                  echo "<td>$rendszamT</td>";
                  echo "<td>$honnanT</td>";
                  echo "<td>$hovaT</td>";
                  echo "<td>$celT</td>";
                  echo "<td>$kezdoT</td>";
                  echo "<td>$zaroT</td>";
                  echo "<td>$kmT</td>";
                  echo "<td><p><a href='$kepT' download>$kepNevT</a></p></td>";
                  echo "<td><a class='btn btn-success' type='submit' href='utak.php?delete=$utID&rendszam=$rendszamT'>Törlés</a></td></tr>";
                }

                ?>
              </tbody>
            </table>
          </div>
          <?php
        } elseif (!empty($_GET['szureseleje']) && !empty($_GET['szuresvege']) && empty($_GET['szuresrendszam'])) {
          // eleje vege megadva rendszam ures
          ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="resultsTable">
              <thead>
                <tr>
                  <th>Utazás dátuma</th>
                  <th>Autó rendszáma</th>
                  <th>Indulási hely</th>
                  <th>Érkezési hely</th>
                  <th>Partner/ utazás célja</th>
                  <th>Kezdő kilóméteróra állás</th>
                  <th>Záró kilóméteróra állás</th>
                  <th>Kilóméter összesen</th>
                  <th>Kép</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $ke = $_GET['szureseleje'];
                $ve = $_GET['szuresvege'];
                //$re = $_GET['szuresrendszam'];
                $que = "SELECT * FROM utak WHERE felhasznalo ='$userName' AND (datum BETWEEN '$ke' AND '$ve')";
                $utakSet = mysqli_query($viapanServer, $que);
                while ($utjaim = mysqli_fetch_assoc($utakSet)) {
                  $utID = $utjaim['id'];
                  $datumT = $utjaim['datum'];
                  $rendszamT = $utjaim['rendszam'];
                  $honnanT = $utjaim['honnan'];
                  $hovaT = $utjaim['hova'];
                  $celT = $utjaim['cel'];
                  $kezdoT = $utjaim['kezdokm'];
                  $zaroT = $utjaim['zarokm'];
                  $kmT = $utjaim ['km'];
                  $kolcsonT = $utjaim['kolcsonbe'];
                  $kepT = $utjaim['kep'];
                  $kepNevT = $utjaim['kepnev'];
                  //$mask = DateTime('T' ,$datumT);
                  //rtrim($datumT[,$maszk]);
                  $datumTT = date_create($datumT);
                  $datumFormat = date_format($datumTT,'Y-m-d H:i');
                  //$datumFormat = $datumT->format('Y-m-d H:i:s');
                  echo "<tr><td>$datumFormat</td>";
                  echo "<td>$rendszamT</td>";
                  echo "<td>$honnanT</td>";
                  echo "<td>$hovaT</td>";
                  echo "<td>$celT</td>";
                  echo "<td>$kezdoT</td>";
                  echo "<td>$zaroT</td>";
                  echo "<td>$kmT</td>";
                  echo "<td><p><a href='$kepT' download>$kepNevT</a></p></td>";
                  echo "<td><a class='btn btn-success' type='submit' href='utak.php?delete=$utID&rendszam=$rendszamT'>Törlés</a></td></tr>";
                }

                ?>
              </tbody>
            </table>
          </div>
          <?php
        } elseif (empty($_GET['szureseleje']) && empty($_GET['szuresvege']) && !empty($_GET['szuresrendszam'])) {
          // csak rendszam
          ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="resultsTable">
              <thead>
                <tr>
                  <th>Utazás dátuma</th>
                  <th>Autó rendszáma</th>
                  <th>Indulási hely</th>
                  <th>Érkezési hely</th>
                  <th>Partner/ utazás célja</th>
                  <th>Kezdő kilóméteróra állás</th>
                  <th>Záró kilóméteróra állás</th>
                  <th>Kilóméter összesen</th>
                  <th>Kép</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //$ke = $_GET['szureseleje'];
                //$ve = $_GET['szuresvege'];
                $re = $_GET['szuresrendszam'];
                $que = "SELECT * FROM utak WHERE felhasznalo ='$userName' AND rendszam ='$re'";
                $utakSet = mysqli_query($viapanServer, $que);
                while ($utjaim = mysqli_fetch_assoc($utakSet)) {
                  $utID = $utjaim['id'];
                  $datumT = $utjaim['datum'];
                  $rendszamT = $utjaim['rendszam'];
                  $honnanT = $utjaim['honnan'];
                  $hovaT = $utjaim['hova'];
                  $celT = $utjaim['cel'];
                  $kezdoT = $utjaim['kezdokm'];
                  $zaroT = $utjaim['zarokm'];
                  $kmT = $utjaim ['km'];
                  $kolcsonT = $utjaim['kolcsonbe'];
                  $kepT = $utjaim['kep'];
                  $kepNevT = $utjaim['kepnev'];
                  //$mask = DateTime('T' ,$datumT);
                  //rtrim($datumT[,$maszk]);
                  $datumTT = date_create($datumT);
                  $datumFormat = date_format($datumTT,'Y-m-d H:i');
                  //$datumFormat = $datumT->format('Y-m-d H:i:s');
                  echo "<tr><td>$datumFormat</td>";
                  echo "<td>$rendszamT</td>";
                  echo "<td>$honnanT</td>";
                  echo "<td>$hovaT</td>";
                  echo "<td>$celT</td>";
                  echo "<td>$kezdoT</td>";
                  echo "<td>$zaroT</td>";
                  echo "<td>$kmT</td>";
                  echo "<td><p><a href='$kepT' download>$kepNevT</a></p></td>";
                  echo "<td><a class='btn btn-success' type='submit' href='utak.php?delete=$utID&rendszam=$rendszamT'>Törlés</a></td></tr>";
                }

                ?>
              </tbody>
            </table>
          </div>
          <?php
        }
      } else {
        ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="resultsTable">
            <thead>
              <tr>
                <th>Utazás dátuma</th>
                <th>Autó rendszáma</th>
                <th>Indulási hely</th>
                <th>Érkezési hely</th>
                <th>Partner/ utazás célja</th>
                <th>Kezdő kilóméteróra állás</th>
                <th>Záró kilóméteróra állás</th>
                <th>Kilóméter összesen</th>
                <th>Kép</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $que = "SELECT * FROM utak WHERE felhasznalo ='$userName'";
              $utakSet = mysqli_query($viapanServer, $que);
              while ($utjaim = mysqli_fetch_assoc($utakSet)) {
                $utID = $utjaim['id'];
                $datumT = $utjaim['datum'];
                $rendszamT = $utjaim['rendszam'];
                $honnanT = $utjaim['honnan'];
                $hovaT = $utjaim['hova'];
                $celT = $utjaim['cel'];
                $kezdoT = $utjaim['kezdokm'];
                $zaroT = $utjaim['zarokm'];
                $kmT = $utjaim ['km'];
                $kolcsonT = $utjaim['kolcsonbe'];
                $kepT = $utjaim['kep'];
                $kepNevT = $utjaim['kepnev'];
                //$mask = DateTime('T' ,$datumT);
                //rtrim($datumT[,$maszk]);
                $datumTT = date_create($datumT);
                $datumFormat = date_format($datumTT,'Y-m-d H:i');
                //$datumFormat = $datumT->format('Y-m-d H:i:s');
                echo "<tr><td>$datumFormat</td>";
                echo "<td>$rendszamT</td>";
                echo "<td>$honnanT</td>";
                echo "<td>$hovaT</td>";
                echo "<td>$celT</td>";
                echo "<td>$kezdoT</td>";
                echo "<td>$zaroT</td>";
                echo "<td>$kmT</td>";
                echo "<td><p><a href='$kepT' download>$kepNevT</a></p></td>";
                echo "<td><a class='btn btn-success' type='submit' href='utak.php?delete=$utID&rendszam=$rendszamT'>Törlés</a></td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <script type="text/javascript">
    window.exportExcel = function exportExcel() {
      alasql('SELECT * INTO XLSX("ViaRoadExport.xlsx",{headers:true}) \
      FROM HTML("#resultsTable",{headers:true})');

    }

    $(function(ready){
        $('#rendi').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var rendszam = this.value;

        // var rendszam = "NDN-239";
        var rendszamQ = "rdn="+rendszam;
    // $('#ajax').load('ajax.kilometer-json.php');
    $.get('ajax/ajax.kilometer-json.php', rendszamQ, function(response) {
      // $('#kil').html(response+);
      var result = response.map(function (x) {
        return parseInt(x, 10);
    });
      $('input[id=kil]').val(result);
    });
    }
    );
    });
    </script>
  </body>
  </html>
  <?php
  mysqli_close($viapanServer);
  ?>
