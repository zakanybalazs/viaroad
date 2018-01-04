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
    <?php
  $userId = getUserId($userName);
$q = "SELECT * FROM szemelyadatok WHERE felhasznaloid = '{$userId}'";
$mq = mysqli_query($viapanServer, $q);
$AB = 0;
while ($adatok = mysqli_fetch_assoc($mq)) {
  /* Itt kikeressük a felhasználó adatokat, hogy betöltsük őket az inputok helyére */
  $vezeteknev = $adatok['vezeteknev'];
  $keresztnev = $adatok['keresztnev'];
  $adoszam = $adatok['adoszam'];
  $beosztas = $adatok['beosztas'];
  $lakcim = $adatok['lakcim'];
  $szuletesiido = $adatok['szuletesiido'];
  $szuletesihely = $adatok['szuletesihely'];
  $szolgalatihely = $adatok['szolgalatihely'];
  $alairoid = $adatok['alairoid'];
  $irodavezetoidid = $adatok['irodavezetoid'];
  $AB = $AB + 1;

  $q2 = "SELECT * FROM felhasznalok WHERE id = '{$alairoid}'";
  $mq2 = mysqli_query($viapanServer, $q2);
  while ($adatok2 = mysqli_fetch_assoc($mq2)) {
    $alairo = $adatok2['felhasznalo'];
  }

    $q3 = "SELECT * FROM felhasznalok WHERE id = '{$irodavezetoidid}'";
    $mq3 = mysqli_query($viapanServer, $q3);
    while ($adatok3 = mysqli_fetch_assoc($mq3)) {
      $irodavezeto = $adatok3['felhasznalo'];
    }
}

     ?>
<script type="text/javascript">

</script>
    <div class="container well">
      <h3>Személyi adatok, felhasználó: <?php echo "$userName" ?></h3>
      <p>Az adatok kitültése elengedhetetlen az elszámolások készítéséhez</p>
      <form class="form" action="index.html" method="post">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Vezetéknév</label>
            <input type="text" id="vezeteknev" value='<?php if ($AB > 0) {echo "$vezeteknev"; } ?>' class="form-control">
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
          <p></p>
          <label>Keresztnév</label>
          <input type="text" id="keresztnev" value='<?php if ($AB > 0) {echo "$keresztnev"; } ?>' class="form-control">
        </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>

            <label>Adószám</label>
            <input type="text" id="adoszam" value='<?php if ($AB > 0) {echo "$adoszam"; } ?>' class="form-control">
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Beosztás</label>
            <input type="text" id="beosztas" value='<?php if ($AB > 0) {echo "$beosztas"; } ?>' class="form-control">
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Lakcím</label>
            <input type="text" id="lakcim" value='<?php if ($AB > 0) {echo "$lakcim"; } ?>' class="form-control">
          </div>
          <p></p>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Születési idő</label>
            <input type="date" id="szuletesiido" value='<?php if ($AB > 0) {echo "$szuletesiido"; } ?>' class="form-control">
          </div>
          <p></p>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Születési hely</label>
            <input type="text" id="szuletesihely" value='<?php if ($AB > 0) {echo "$szuletesihely"; } ?>' class="form-control">
          </div>
          <p></p>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Szolgálati hely</label>
            <input type="text" id="szolgalatihely" value='<?php if ($AB > 0) {echo "$szolgalatihely"; } ?>' class="form-control">
          </div>
          <p></p>
          <datalist id="users">
          <?php
          $usersQ = "SELECT * FROM felhasznalok WHERE authority = 'admin' OR authority = 'superuser' OR authority = 'cegadmin' AND felhasznalo != '{$userName}'";
          $userSendQ = mysqli_query($viapanServer,$usersQ);
          while ($userAdatok = mysqli_fetch_assoc($userSendQ)) {
            $ember = $userAdatok['felhasznalo'];
            $emberID = $userAdatok['id'];
            ?>
              <option><?php echo "$ember"; ?></option>
        <?php
          }
           ?>
         </datalist>
         <div class="col-lg-3 col-md-4 col-sm-6">
           <p></p>
           <label>Aláíró (kirendeltség vezető)</label>
           <input type="text" id="alairo" list="users" value='<?php if ($AB > 0) {echo "$alairo"; } ?>' class="form-control">
         </div>
         <div class="col-lg-3 col-md-4 col-sm-6">
           <p></p>
           <label>Adminisztrátor (irodavezető)</label>
           <input type="text" list="users" id="adminisztrator" value='<?php if ($AB > 0) {echo "$irodavezeto"; } ?>' class="form-control">
         </div>
        </div>
        <p></p>
        <?php if ($AB > 0) { ?>
          <!-- Ha vannak adataink, akkor zpdate kell, nem adatrögzítés -->
          <button type="button" id="ujmentes" class="btn btn-success" onclick="adatfrissit()">Adatok frissítése az adatbázisban</button>
  <?php      } else {      ?>
          <!-- ha még nincs adat, akkor csinálunk -->
          <button type="button" id="ujmentes" class="btn btn-success" onclick="sendNew()">Adatok mentése</button>
  <?php      } ?>
      </form>
   </div>

  </body>
  <script type="text/javascript">
    function adatfrissit() {
      var vezeteknev = $('#vezeteknev').val();
      var keresztnev = $('#keresztnev').val();
      var adoszam = $('#adoszam').val();
      var beosztas = $('#beosztas').val();
      var lakcim = $('#lakcim').val();
      var szuletesiido = $('#szuletesiido').val();
      var szuletesihely = $('#szuletesihely').val();
      var szolgalatihely = $('#szolgalatihely').val();
      var alairo = $('#alairo').val();
      var adminisztrator = $('#adminisztrator').val();
      if (vezeteknev == '' || keresztnev == '' || adoszam == '' || beosztas == '' || lakcim == '' || szuletesiido == '' || szuletesihely == '' || szolgalatihely == '' || alairo == '' || adminisztrator == '') {
        bootbox.alert({
          title: "Hiba",
          message: "Minden mező kitöltése kötelező!",
        });
      } else {
        $.post( "ajax/ajax.szemelyadatfrissit.php", {
          Postvezeteknev : vezeteknev,
          Postkeresztnev : keresztnev,
          Postadoszam : adoszam,
          Postbeosztas : beosztas,
          Postlakcim : lakcim,
          Postszuletesiido : szuletesiido,
          Postszuletesihely : szuletesihely,
          Postszolgalatihely : szolgalatihely,
          Postalairo : alairo,
          Postadminisztrator : adminisztrator,
          PostUserName : '<?php echo "$userName"; ?>'
        },
        "json" ).done(function( response ) {
            if (response == "ok") {
              bootbox.alert({
                  title: "Siker!",
                  size: "small",
                  message: "Az adatokat sikeresen rögzítettük!",
                  animate: true,
                  backdrop: true,
                  callback: function() {
                  },
              }); //bootbox siker
            } else {
              bootbox.alert({
                  title: "Hiba",
                  size: "small",
                  message: "Probléma történt az adatok rögzítésénél!",
                  animate: true,
                  backdrop: true,
                    }); // bootbox hiba
                  } // response? ok else
                }); // done(function) end
            }
    }
  </script>
  <script type="text/javascript">
    function sendNew() {
      var vezeteknev = $('#vezeteknev').val();
      var keresztnev = $('#keresztnev').val();
      var adoszam = $('#adoszam').val();
      var beosztas = $('#beosztas').val();
      var lakcim = $('#lakcim').val();
      var szuletesiido = $('#szuletesiido').val();
      var szuletesihely = $('#szuletesihely').val();
      var szolgalatihely = $('#szolgalatihely').val();
      var alairo = $('#alairo').val();
      var adminisztrator = $('#adminisztrator').val();
      if (vezeteknev == '' || keresztnev == '' || adoszam == '' || beosztas == '' || lakcim == '' || szuletesiido == '' || szuletesihely == '' || szolgalatihely == '' || alairo == '' || adminisztrator == '') {
        bootbox.alert({
          title: "Hiba",
          message: "Minden mező kitöltése kötelező!",
        });
      } else {
        $.post( "ajax/ajax.ujszemelyadatsubmit.php", {
          Postvezeteknev : vezeteknev,
          Postkeresztnev : keresztnev,
          Postadoszam : adoszam,
          Postbeosztas : beosztas,
          Postlakcim : lakcim,
          Postszuletesiido : szuletesiido,
          Postszuletesihely : szuletesihely,
          Postszolgalatihely : szolgalatihely,
          Postalairo : alairo,
          Postadminisztrator : adminisztrator,
          PostUserName : '<?php echo "$userName"; ?>'
        },
        "json" ).done(function( response ) {
            if (response == "ok") {
              bootbox.alert({
                  title: "Siker!",
                  size: "small",
                  message: "Az adatokat sikeresen rögzítettük!",
                  animate: true,
                  backdrop: true,
                  callback: function() {
                  },
              }); //bootbox siker
            } else {
              bootbox.alert({
                  title: "Hiba",
                  size: "small",
                  message: "Probléma történt az adatok rögzítésénél!",
                  animate: true,
                  backdrop: true,
                    }); // bootbox hiba
                  } // response? ok else
                }); // done(function) end
            }
    }
  </script>
</html>
