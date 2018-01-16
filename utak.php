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
    if (!empty($_GET['delete'])) {
      $torlesID = $_GET['delete'];
      $rendszamMax = $_GET['rendszam'];
      utTorles($torlesID);
      ujKilometerMax($rendszamMax);
    }
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVgzq8IW5TgMx7Xcjz2UOVdgSoSd3Flpo" charset="utf-8"></script>
    <script type="text/javascript">
      $(document).ready(function() {
    function initialize() {
      geocoder = new google.maps.Geocoder();
    }
  })
  </script>
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
             navigator.geolocation.getCurrentPosition(successFunction, errorFunction, {timeout : 5000});
          }
          //Get the latitude and the longitude;
          function successFunction(position) {
             var lat = position.coords.latitude;
             var lng = position.coords.longitude;
             codeLatLng(lat, lng)
          }
          function errorFunction(){
              alert(error.message);
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
                  //formatted address
                  // alert(results[0].formatted_address)
                  var s = results[1].formatted_address;
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        // navigator.permissions && navigator.permissions.query({name: 'geolocation'}).then(function(PermissionStatus) {

            // if(PermissionStatus.state == 'granted') {
                  //allowed
                   loadScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyBVgzq8IW5TgMx7Xcjz2UOVdgSoSd3Flpo");
            // } else {
                 //denied
          //        bootbox.alert({
          //            title: "Helmyeghatározás",
          //            size: "small",
          //            message: "Kérlek engedélyezd a helmyeghatározást, hogy ne neked kelljen beírni!",
          //            animate: true,
          //            backdrop: true,
          //        });
          //        loadScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyBVgzq8IW5TgMx7Xcjz2UOVdgSoSd3Flpo");
          //
          //
          // }
        // })
        // alert("passes nav function");
      })

        </script>
    <body>
      <div class="container jumbotron">
        <form enctype="multipart/form-data" action="utak.php" method="post">
          <div class="col-lg-3 col-md-3 col-sm-3">
            <h1></h1>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <label id="autorendszama" for="rendszam"><h4>Autó rendszáma</h4></label>
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
              echo "<option disabled selected style='display:none;' required >pl: NDN-239</option>";
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
                  $kolcsonbeForm ='NA';
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
<label for="datum"><h4>Indulás dátuma és ideje</h4></label>
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
        </script>
        <?php if ($PreLoads == "nincs"): ?>
        <script type="text/javascript">
            $(document).ready(function() {
              var dd = new Date();
              if (dd.getMonth()<9) {
                var honapP = dd.getMonth() + 1;
                var honap = '0' + honapP;
              } else {
                var honap = dd.getMonth() + 1;
              }
              if (dd.getDate()<10) {
                var Nap ='0' + dd.getDate();
              } else {
                var Nap = dd.getDate();
              }
              if (dd.getHours()<10) {
                var Ora ='0' + dd.getHours();
              } else {
                var Ora = dd.getHours();
              }
              if (dd.getMinutes()<10) {
                var Perc ='0' + dd.getMinutes();
              } else {
                var Perc = dd.getMinutes();
              }

               var stringTime =dd.getFullYear('YYYY') + '-' + honap + '-' + Nap + ' ' + Ora + ':' + Perc;
              document.getElementById('datum').value = stringTime;
              //  Date();
            });
            </script>
          <?php endif; ?>

    </div>
          <label for="kolcsonbe" id="kolcsonbeID"><h4>Melyik cég nevében intézkedsz?</h4></label>
          <select class="form-control" name="kolcsonbe" id="kolcsonbe">
            <?php if ($PreLoads != "nincs") {
              if ($kolcsonbeForm == "NA") {
                ?>
                <script type="text/javascript">
                $('select[id=kolcsonbe]').hide();
                $('select[id=kolcsonbeID]').hide();
                </script>
                <?php
              } else {
                # code...
              echo "<option selected style='display:none;'>$kolcsonbeForm</option>";
            }
          } else {
              echo "<option disabled selected style='display:none;'>Válassz a listából</option>";
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
          <label for="honnan"><h4>Honnan indulsz? Eltaláltuk?</h4></label>
          <input type="string" id="address" name="honnan" class="form-control" <?php echo $honnanForm; ?> placeholder="pl: Kaposvár" required="">
          <p></p>
          <label for="cel"><h4>Utazásod oka/ partner akihez mész</h4></label>
          <input type="string" name="cel" class="form-control" <?php echo $celForm; ?> placeholder="pl: Meeting / Videoton" required="">
          <p></p>
          <label for="kezdokm"><h4>Jelenlegi kilóméteróra állás</h4></label>
          <input type="number" id="kil" name="kezdokm" class="form-control" <?php echo $kezdokmForm; ?> placeholder="pl: 1234561654" required="">
          <p></p>

<?php if ($PreLoads == "nincs") { ?>

<?php } ?>

          <p></p>
          <h1></h1>
        </div>

        <button class="btn btn-success form-control" type="submit">GO!</button>
      </form>


      <?php
      // Itt kell kikeresni az autó adatait
      if (!empty($_POST['rendszam'])) {
          if ($PreLoads=="van") {
            if (empty($_POST['kolcsonbe'])) {
              $kolcsonbeVevo = 'NA';
            } else {
              $kolcsonbeVevo = $_POST['kolcsonbe'];
            }
            $del = "DELETE FROM piszkozat WHERE felhasznalo = '{$userName}'";
            $delsiker = mysqli_query($viapanServer,$del);
            $valasz = piszkozatMentes($userName,$_POST['rendszam'],$_POST['datum'],$kolcsonbeVevo,$_POST['honnan'],$_POST['cel'],$_POST['kezdokm']);
            ?>
            <script type="text/javascript">
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
            </script>
            <?php
          } else {
            if (empty($_POST['kolcsonbe'])) {
              $kolcsonbeVevo = 'NA';
            } else {
              $kolcsonbeVevo = $_POST['kolcsonbe'];
            }
            $valasz = piszkozatMentes($userName,$_POST['rendszam'],$_POST['datum'],$kolcsonbeVevo,$_POST['honnan'],$_POST['cel'],$_POST['kezdokm']);
            ?>
            <script type="text/javascript">
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
            </script>
            <?php


        } // nem piszkozat
} // ebd of form handling
      ?>

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

    $(function(ready){
        $('#rendi').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var rendszam = this.value;
        var rendszamQ = "rdn="+rendszam;
    $.get('ajax/ajax.kolcsonbe-json.php', rendszamQ, function(response) {
    if (response != "ceges") {
      $('label[id=kolcsonbeID]').hide();
      $('select[id=kolcsonbe]').hide();
      $('select[id=kolcsonbe]').prop('required',false);
    } else {
      $('label[id=kolcsonbeID]').show();
      $('select[id=kolcsonbe]').show();
      $('select[id=kolcsonbe]').prop('required',true);
    }
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
