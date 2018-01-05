<?php
session_start();
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
include "functions.php";
include 'css/headerAdmin.php';
$userName = $_SESSION['userName'];
$kilometerQuery = "SELECT * FROM piszkozat WHERE felhasznalo = '{$userName}'"; // userName a headerben már definiálva van
$piszkozatBetoltes = mysqli_query($viapanServer, $kilometerQuery);
while ($piszkozatResult = mysqli_fetch_assoc($piszkozatBetoltes)) {
$prevLocation = $piszkozatResult['honnan'];
$prevKM = $piszkozatResult['kezdokm'];
}
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVgzq8IW5TgMx7Xcjz2UOVdgSoSd3Flpo" charset="utf-8"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
 // form validation before submit
    function loadScript(url) {
      var head = document.getElementsByTagName("head")[0];
      var script = document.createElement("script");
      script.type = "text/javascript";
      script.src = url;
      head.appendChild(script);
          var geocoder;
           if (navigator.geolocation) {
             navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
          }
          //Get the latitude and the longitude;
          function successFunction(position) {
             var lat = position.coords.latitude;
             var lng = position.coords.longitude;
             codeLatLng(lat, lng)
          }
          function errorFunction(){
            //  alert("Geocoder failed");
          }
           function initialize() {
             geocoder = new google.maps.Geocoder();
           }
           function codeLatLng(lat, lng) {
        var geocoder = new google.maps.Geocoder();
             var latlng = new google.maps.LatLng(lat, lng);
             geocoder.geocode({'location': latlng}, function(results, status) {
               if (status == google.maps.GeocoderStatus.OK) {
               console.log(results)
                 if (results[1]) {
                  var s = results[1].formatted_address;
                  var here = results[1].place_id;
                  var directionsService = new google.maps.DirectionsService();
                  var request = {
                    origin : '<?php echo "$prevLocation"; ?>',
                    destination : s,
                    travelMode  : google.maps.DirectionsTravelMode.DRIVING
                  };
                  directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                      var distance = response.routes[0].legs[0].distance.value;
                      Number(distance);
                      var prevKM = <?php echo "$prevKM"; ?>;
                      Number(prevKM);
                      var distance3 = Math.round(distance / 1000);
                       $( '#zarokm' ).attr('value', distance3 + prevKM);
                    }
                  });
                  var n = s.indexOf(',');
                  s = s.substring(0, n != -1 ? n : s.length);
                  document.getElementById('address').value = s;
                 } else {
                  //  alert("No results found");
                 }
               } else {
                //  alert("Geocoder failed due to: " + status);
               }
             });
           }
         }
 </script>
<script>
  $(document).ready(function() {
      loadScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyBVgzq8IW5TgMx7Xcjz2UOVdgSoSd3Flpo");
    })
</script>
<?php
if (!isset($userName)) {
  ?>
  <script type="text/javascript">
  window.location="index.php";
  </script>
  <?php }
  // "nincs" vagy "van" ad csak vissza
  $PreLoads = piszkozatKereso($userName);
  if ($PreLoads == "nincs") {
    ?>
    <script type="text/javascript">
    // history.back();
    alert("Nincs elmentve indulásod!");
    </script>
    <?php
  }
    /* Ezeket mindenképpen kikeressük, hogy tudjunk vele dolgozni, akkor is ha a felhasználó végül nem tud
    elmenteni egy utat. Ezekre az adatokra mindenképp szükség van, hogy létre tudjuk hozni a html alapot
    a custom alert boxunkhoz, hogy megmutassuk a felhasználónak hogy mit fog rügziteni*/
    $kilometerQuery = "SELECT * FROM piszkozat WHERE felhasznalo = '{$userName}'"; // userName a headerben már definiálva van
    $piszkozatBetoltes = mysqli_query($viapanServer, $kilometerQuery);
    while ($piszkozatResult = mysqli_fetch_assoc($piszkozatBetoltes)) {
      $rendszamPre = $piszkozatResult['rendszam'];
      $datumPre = $piszkozatResult['datum'];
      if (!empty($piszkozatResult['kolcsonbe'])) {
        $kolcsonbePre = $piszkozatResult['kolcsonbe'];
      } else { $kolcsonbePre = null; }
      $honnanPre = $piszkozatResult['honnan'];
      $celPre = $piszkozatResult['cel'];
      $kezdokmPre = $piszkozatResult['kezdokm'];
      if ($kezdokmPre == null) {
        $kezdokmPlus = 1;
      } else {
        $kezdokmPlus = $kezdokmPre + 1;
      }
      $kilo = kilometerCheck($rendszamPre,$kezdokmPre);
  }
  // Megkeresük az autó adatait, hogy azt is rögzithessük az úthoz
  $autoQuery = "SELECT * FROM autok WHERE rendszam = '{$rendszamPre}'";
  $autokBetoltes = mysqli_query($viapanServer, $autoQuery);
  while ($autoResult = mysqli_fetch_assoc($autokBetoltes)) {
    $tulajPre = $autoResult['tulaj'];
    $fogyasztasPre = $autoResult['fogyasztas'];
    $uzemanyagPre = $autoResult['uzemanyag'];
    $cegPre = $autoResult['ceg'];
    $kartya = $autoResult['kategoria'];
    if ($kartya == "kartyas") {?>
      <script type="text/javascript">
      setTimeout(function(){
          $('#honapzaro').show();
        }, 500);
      </script>
      <?php}
  }

    if (!empty($_GET['siker'])) {
      if ($_GET['siker']==1) {
        ?>
        <body onload="initialize()">
          <?php
        } else {
          ?>
          <div class="container alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Sikertelen rögzítés</strong>
          </div>
          <?php
        }
      }
      ?>
    <body>
<script type="text/javascript">
          function something() {
            $( '#mehet' ).attr('hidden','hidden');
            $( '#dolgozunk' ).removeAttr('hidden');
            var hova = $( '#address' ).val();
            var zarokm = $('#zarokm').val();
            var kezdokm = <?php echo $kezdokmPre ?>;
            var rendszam = "<?php echo $rendszamPre ?>";
              if (hova == '' || zarokm == '' ) {
                bootbox.alert({
                  title: "Hiba",
                  message: "Minden mező kitöltése kötelező!",
                  callback: function() {
                    $( '#dolgozunk' ).attr('hidden', 'hidden');
                    $( '#mehet' ).removeAttr('hidden');
                  }
                });
              } else if (kezdokm > zarokm) {
                bootbox.alert({
                  title: "Hiba",
                  message: "Nem lehet kisebb a záró kilóméteróra állás a kezdő kilóméteróra állásnál!"
              });
              $( '#dolgozunk' ).attr('hidden', 'hidden');
              $( '#mehet' ).removeAttr('hidden');
              } else {
            var km = zarokm - kezdokm + ' km';
            if (km < 1 || km == null) {
              km = "nincs kitöltve";
            }
            bootbox.confirm({
                title: "Adat ellenőrzés",
                message: '<h4>Kérlek ellenőrizd az adatokat!</h4> <p>Autó rendszáma: ' + rendszam + '</p><p>Útvonal: <?php echo $honnanPre?> - ' + hova + '  </p><p>Megtett távolság: ' + km + '</p><p>Amennyiben helyesnek találod az adatokat, kattints a mehet gombra!</p>',
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Mégsem'
                    },
                    confirm: {
                        label: '<i class="fa fa-check fa-success"></i> Mehet'
                    }
                },
                callback: function (result) {
                  if (result == true) {
          //this is where we send the data via ajax
          // $userName,$kivCeg,$kivRendszam,$datum,$kolcsonbe,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag,$kivKep,$kepNev
          var userName ="<?php echo "$userName"; ?>";
          var cegPre = "<?php echo "$cegPre"; ?>";
          var rendszamPre = "<?php echo $rendszamPre; ?>";
          var datumPre = "<?php echo "$datumPre"; ?>";
          var kolcsonbePre = "<?php echo "$kolcsonbePre"; ?>";
          var honnanPre = "<?php echo "$honnanPre"; ?>";
          var hova = $( '#address' ).val()
          var celPre = '<?php if ($_GET['tankolas'] == 1) { echo 'Tankolás'; } else { echo "$celPre"; }?>';
          var kezdokm = "<?php echo $kezdokmPre; ?>";
          var zarokm = $('#zarokm').val();
          var km = zarokm - kezdokm;
          var fogyasztasPre = <?php echo "$fogyasztasPre"; ?>;
          var uzemanyagPre = "<?php echo "$uzemanyagPre"; ?>";
          <?php $kepNev = $datumPre . $rendszamPre.'.jpg'; $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]","}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;","â€”", "â€“", ",", "<", ">", "/", "?"); $clean = trim(str_replace($strip, "", strip_tags($kepNev)));?>
          var kepnev = "<?php echo $clean ?>";
          var kepHely = 'uploads/' + kepnev;
          var tulaj = "<?php echo "$tulajPre"; ?>";
          var KepFile = new FormData();
          if ($('#file-1').val() == '') {
          var kepnev = "N/A";
          var kepHely = 'uploads/' + kepnev;
          } else {
            KepFile.append('kep', $('#file-1').prop('files')[0]);
          }

          $.post( "ajax/ajax.ujutsubmit.php", {
            PostuserName: userName,
            Postceg: cegPre,
            Postrendszam: rendszamPre,
            Postdatum: datumPre,
            Postkolcsonbe: kolcsonbePre,
            Posthonnan: honnanPre,
            Posthova: hova,
            Postcel: celPre,
            Postkezdokm: kezdokm,
            Postzarokm: zarokm,
            Postkm: km,
            Postfogyasztas: fogyasztasPre,
            Postuzemanyag: uzemanyagPre,
            Postkephely: kepHely,
            Postkepnev: kepnev,
            Posttulaj: tulaj
          },
          "json").done(function( response ) {
            if (response == "ok") {
              $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cashe: false,
                data: KepFile,
                url: "ajax/ajax.fileupload.php",
                dataType: 'json',
                }); //$.ajax file handling
              // itt kell a filet a helyere rakni
              $( '#dolgozunk' ).attr('hidden', 'hidden');
              $( '#mehet' ).removeAttr('hidden');
              bootbox.alert({
                  title: "Siker!",
                  size: "small",
                  message: "Az adatokat sikeresen rögzítettük!",
                  animate: true,
                  backdrop: true,
                  callback: function() {
                    window.location.href = "switch.php";
                  },
              }); //bootbox siker

            } else { // response ok
              bootbox.alert({
                  title: "Hiba",
                  size: "small",
                  message: "Probléma történt az adatok rögzítésénél!",
                  animate: true,
                  backdrop: true,
                    }); // bootbox hiba
                  } // response? ok else
                }); // done(function) end


          } // if result == true
        }// callback
      }); //bootbox confirm
     }// else
    } // end of something()
</script>
<script type="text/javascript">
      function somethingElse() {
        $( '#mehet' ).attr('hidden','hidden');
        $( '#dolgozunk' ).removeAttr('hidden');
        var hova = $( '#address' ).val();
        var zarokm = $('#zarokm').val();
        var kezdokm = <?php echo $kezdokmPre ?>;
        var rendszam = "<?php echo $rendszamPre ?>";
        var isKartyas = $('#checkbox').val();
        if (isKartyas == "unchecked") {
          var idoszak = $('#zaroidoszak').val();
          if (idoszak == '') {
            bootbox.alert({
              title: "Hiba",
              message: "Minden mező kitöltése kötelező!",
              callback: function() {
                $( '#dolgozunk' ).attr('hidden', 'hidden');
                $( '#mehet' ).removeAttr('hidden');
              }
            });
            return;
          }
        }
          if (hova == '' || zarokm == ''
          <?php if ($_GET['tankolas'] == 1)
          { echo " || $('#file-1').val() == ''"; } ?>) {
            bootbox.alert({
              title: "Hiba",
              message: "Minden mező kitöltése kötelező!",
              callback: function() {
                $( '#dolgozunk' ).attr('hidden', 'hidden');
                $( '#mehet' ).removeAttr('hidden');
              }
            });
          } else if (kezdokm > zarokm) {
            bootbox.alert({
              title: "Hiba",
              message: "Nem lehet kisebb a záró kilóméteróra állás a kezdő kilóméteróra állásnál!"
          });
          $( '#dolgozunk' ).attr('hidden', 'hidden');
          $( '#mehet' ).removeAttr('hidden');
          } else {
        var km = zarokm - kezdokm + ' km';
        if (km < 1 || km == null) {
          km = "nincs kitöltve";
        }
        bootbox.confirm({
            title: "Adat ellenőrzés",
            message: '<h4>Kérlek ellenőrizd az adatokat!</h4> <p>Autó rendszáma: ' + rendszam + '</p><p>Útvonal: <?php echo $honnanPre ?> - ' + hova + '  </p><p>Megtett távolság: ' + km + '</p><p>Amennyiben helyesnek találod az adatokat, kattints a mehet gombra!</p>',
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Mégsem'
                },
                confirm: {
                    label: '<i class="fa fa-check fa-success"></i> Mehet'
                }
            },
            callback: function (result) {
              if (result == true) {
      //this is where we send the data via ajax
      // $userName,$kivCeg,$kivRendszam,$datum,$kolcsonbe,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag,$kivKep,$kepNev
      var userName ="<?php echo "$userName"; ?>";
      var cegPre = "<?php echo "$cegPre"; ?>";
      var rendszamPre = "<?php echo $rendszamPre; ?>";
      var datumPre = "<?php echo "$datumPre"; ?>";
      var kolcsonbePre = "<?php echo "$kolcsonbePre"; ?>";
      var honnanPre = "<?php echo "$honnanPre"; ?>";
      var hova = $( '#address' ).val()
      var celPre = '<?php echo "$celPre"; ?>';
      var kezdokm = "<?php echo $kezdokmPre; ?>";
      var zarokm = $('#zarokm').val();
      var km = zarokm - kezdokm;
      var fogyasztasPre = <?php echo "$fogyasztasPre"; ?>;
      var uzemanyagPre = '<?php echo "$uzemanyagPre"; ?>';
      <?php $kepNev = $datumPre . $rendszamPre . '.jpg'; ?>
      <?php $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=",
       "+","[", "{", "]","}", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;","&#8220;", "&#8221;",
        "&#8211;", "&#8212;","â€”", "â€“", ",", "<", ">", "/", "?"); ?>
      <?php $clean = trim(str_replace($strip, "", strip_tags($kepNev))); ?>;
      var kepnev = "<?php echo $clean ?>";
      var kepHely = 'uploads/' + kepnev;
      var tulaj = "<?php echo "$tulajPre"; ?>";
      var KepFile = new FormData();
      if ($('#file-1').val() == '') {
      var kepnev = "N/A";
      var kepHely = 'uploads/' + kepnev;
      } else {
        KepFile.append('kep', $('#file-1').prop('files')[0]);
      }

      $.post( "ajax/ajax.ujtanksubmit.php", {
        PostuserName: userName,
        Postceg: cegPre,
        Postrendszam: rendszamPre,
        Postdatum: datumPre,
        Postkolcsonbe: kolcsonbePre,
        Posthonnan: honnanPre,
        Posthova: hova,
        Postcel: celPre,
        Postkezdokm: kezdokm,
        Postzarokm: zarokm,
        Postkm: km,
        Postfogyasztas: fogyasztasPre,
        Postuzemanyag: uzemanyagPre,
        Postkephely: kepHely,
        Postkepnev: kepnev,
        Posttulaj: tulaj,
        Postidoszak: idoszak
      },
      "json").done(function( response ) {
        if (response == "ok") {

          $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cashe: false,
            data: KepFile,
            url: "ajax/ajax.fileuploadtank.php",
            dataType: 'json',
            }); //$.ajax file handling
          // itt kell a filet a helyere rakni
          $( '#dolgozunk' ).attr('hidden', 'hidden');
          $( '#mehet' ).removeAttr('hidden');
          bootbox.alert({
              title: "Siker!",
              size: "small",
              message: "Az adatokat sikeresen rögzítettük!",
              animate: true,
              backdrop: true,
              callback: function() {
                window.location.href = "switch.php";
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


      } // if result == true
      }// callback
      }); //bootbox confirm
      }// else
      } // end of something();;

</script>
      <div class="container jumbotron" action="">

          <div class="col-lg-3 col-md-3 col-sm-3">
            <h1></h1>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
          <p></p>
          <label for="hova"><h4>Hova érkeztél meg?</h4></label>
          <input type="string" id="address" name="hova" class="form-control" placeholder="pl. Kaposvár" required="">
          <p></p>
          <label for="zarokm"><h4>Kilóméteróra állás megérkezéskor</h4></label>
          <input type="number" id="zarokm" name="zarokm" min='<?php echo "$kezdokmPlus"; ?>' class="form-control" placeholder="pl.134651546" required="">
          <p></p>
          <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
            <input type="hidden" name="size" value="100000">
              <input type="file" name="kep" id="file-1" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple required />
              <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path
                 d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
               </svg> <span>Fotó feltöltése</span></label>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5">
          <p class="btn-group">
          <a class="btn btn-success" onclick="plusminus('zarokm' ,'plus')"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
          <a class="btn btn-danger" onclick="plusminus('zarokm' ,'minus')"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
        </p>
      </div>

          <p></p>
          <div class="col-lg-12 col-md-12 col-sm-12">


           </div>
           </div>
          <p></p>
          <h1></h1>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php if ($_GET['tankolas'] == 1) { ?>
  <div class="row" id="honapzaro" hidden="hidden">
    <div class="col-lg-12">
      <div class="col-lg-3 col-md-3 col-sm-3">..</div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <input type="checkbox" class="checkbox-lg" id="checkbox" value="checked">
        <label>Megjelölés hónapzáró tankolásnak</label>
      </div>
    </div>
  </div>
  <p></p>
  <div class="row" id="honapzaro_2" hidden="hidden">
    <div class="col-lg-12">
      <div class="col-lg-3 col-md-3 col-sm-3">..</div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <label>Melyik időszak záró tankolása?</label>
        <input type="month" id="zaroidoszak" class="form-control">
      </div>
    </div>
  </div>
  <p></p>
      <button onclick="somethingElse()" class="btn btn-default form-control">
        <div id="dolgozunk" hidden="hidden">
        <i class="fa fa-spinner fa-spin" id="dolgozunk"></i> Dolgozunk
      </div>
      <div id="mehet">
        <i id="mehet"></i>Mentés és út folytatása
      </div>
      </button>
      <p></p>
      <?php } else { ?>
      <button onclick="something()" class="btn btn-success form-control">
        <div id="dolgozunk" hidden="hidden">
        <i class="fa fa-spinner fa-spin" id="dolgozunk"></i> Dolgozunk
      </div>
      <div id="mehet">
        <i id="mehet"></i>Mentés
      </div>
      </button>
<?php }  ?>
  </body>
  </html>
<script type="text/javascript">
  function plusminus(elementID, operation) {
    var val1 = Number($( '#' + elementID ).val());
    if (operation == "plus") {
      var val2 = val1 + 1;
    } else {
      var val2 = val1 - 1;
    }
    $( '#' + elementID ).val(val2);
  }
  $('#checkbox').on('click', function() {
    var val = $(this).val();
    if (val == "checked") {
      $(this).val('unchecked');
      $('#honapzaro_2').slideDown(1200);
    } else {
      $(this).val('checked');
    }
  });
  $('#zaroidoszak').change(function() {
    alert($(this).val());
  });
</script>
  <?php
  mysqli_close($viapanServer);
  ?>
