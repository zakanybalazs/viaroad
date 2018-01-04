<?php
session_start();
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
include "functions.php";
include 'css/headerAdmin.php';

if (!isset($userName)) {
  ?>
  <script type="text/javascript">
    window.location="index.php";
  </script>
<?php }
$userID = getUserId($userName);
?>
  <body>
    <script type="text/javascript">
    function hidewell() {
      $( '#hidingWell' ).fadeOut(800);
      $( '#hidebutton' ).attr('onclick', 'showWell()');
      $( '#hidebutton' ).text('Új elszámolás készítése')
    }
    </script>
    <script type="text/javascript">
    function showWell() {
      $( '#hidingWell' ).fadeIn(800);
      $( '#hidebutton' ).attr('onclick', 'hidewell()');
      $( '#hidebutton' ).text('Bezárás')
    }
    </script>
    <script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
});
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
/* Apply fancybox to multiple items */

$("a.iframe").fancybox({
'openEffect'  : 'none',
'closeEffect' : 'none',
'iframe' : {
    'preload' : false
},
'type': 'iframe'
});

});
    </script>
    <script type="text/javascript">
      function pin(selector) {
        var vis = $('#' + selector).css('position');
        if (vis == 'absolute') {
        $( '#' + selector ).css({
            'position' : 'inherit'
        });
      } else {
        $( '#' + selector ).css({
              'position' : 'absolute'
            });
      }
      }
    </script>
    <div class="container">
      <button id="hidebutton" class="btn-success form-control" onclick="showWell()">Új elszámolás készítése</button>
      <style media="screen">
        #hidingWell {
          overflow: visible;
          position: absolute;
        }
      </style>
      <div class="well" id="hidingWell" hidden="hidden">
        <a align="right" onclick="pin('hidingWell')"><p>📌</p>
      </a>
        <h3 class="well-heading"> Új eszámolás készítése</h3>
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>


            <label>Autó rendszáma</label>
            <select id="rendszam" name="rendszam" class="form-control">
              <option disabled selected style='display:none;' required >pl: NDN-239</option>
              <?php
              $tulaj = mysqli_real_escape_string($viapanServer,$userName);
              $renQ = "SELECT * FROM autok WHERE tulaj = '{$tulaj}' AND kategoria = 'normal'";
              $Qarray = mysqli_query($viapanServer, $renQ);
              while ($autok = mysqli_fetch_assoc($Qarray)) {
                # code...
                $rendszamSelected = $autok['rendszam'];
                echo "<option value='$rendszamSelected'>$rendszamSelected</option>";
              }
              ?>
            </select>
<?php
$safeuser = mysqli_real_escape_string($viapanServer,$userName);
$userID = getUserId($safeuser);
$alQ = "SELECT * FROM szemelyadatok WHERE felhasznaloid = '{$userID}'";
$alaSendQ = mysqli_query($viapanServer,$alQ);
while ($alaAdatok = mysqli_fetch_assoc($alaSendQ)) {
  $alairoid = $alaAdatok['alairoid'];
  $irodavezetoid = $alaAdatok['irodavezetoid'];
}
$aQ = "SELECT * FROM felhasznalok WHERE id = '{$alairoid}'";
$aSendQ = mysqli_query($viapanServer,$aQ);
while ($aAdatok = mysqli_fetch_assoc($aSendQ)) {
  $alairo = $aAdatok['felhasznalo'];
}
$bQ = "SELECT * FROM felhasznalok WHERE id = '{$irodavezetoid}'";
$bSendQ = mysqli_query($viapanServer,$bQ);
while ($bAdatok = mysqli_fetch_assoc($bSendQ)) {
  $irodavezeto = $bAdatok['felhasznalo'];
}
 ?>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
<input type="hidden" name="alairoid" id="alairoid" value='<?php echo "$alairoid" ?>'>
<input type="hidden" name="irodavezetoid" id="irodavezetoid" value='<?php echo "$irodavezetoid" ?>'>
            <label>Időszak kezdete</label>
            <input type="date" id="kezdo" name="kezdo" class="form-control">
            <p></p>
            <label>Aláíró</label>
            <input type="text" id="alairo" list="users" name="alairo" value='<?php echo "$alairo"; ?>' class="form-control" disabled>
            <p></p>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Időszak vége</label>
            <input type="date" id="vege" name="vege" class="form-control">
            <p></p>
            <label>Ügyintéző (irodavezető)</label>
            <input type="text" id="irodavezeto" list="users" name="irodavezeto" value='<?php echo "$irodavezeto"; ?>' class="form-control" disabled>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <p></p>
            <label>Cég</label>
            <input type="text" id="ceg" name="ceg" list="cegList" class="form-control" autocomplete="off" placeholder="pl: Meló-Diák Dél Iskolaszövetkezet">
            <p></p>
            <datalist id="cegList">
              <?php
              $cegQ = "SELECT * FROM cegek";
              $cegSendQ = mysqli_query($viapanServer,$cegQ);
              while ($cegAdat = mysqli_fetch_assoc($cegSendQ)) {
                $cegName = $cegAdat['ceg'];?>
                <option><?php echo "$cegName"; ?></option>
            <?php  } ?>
            </datalist>
            <label>Kép a kilométeróra állásról</label>
            <input type="hidden" name="size" value="100000">
            <input type="file" name="kep" id="file-1" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple required />
            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path
              d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
            </svg> <span>Fotó feltöltése</span></label>
            <p></p>
          </div>
        </div>
        <p></p>
        <button type="submit" name="button" class="btn btn-success" onclick="elszamol()">Elkészít</button>
      </div>
    </div>
    <p></p>
    <script type="text/javascript">
    function elszamol() {
      var alairoid = $( '#alairoid' ).val();
      var irodavezetoid = $( '#irodavezetoid' ).val();
      var userName = '<?php echo "$safeuser"; ?>';
      var kezdo = $( '#kezdo' ).val();
      var vege = $( '#vege' ).val();
      var ceg = $( '#ceg' ).val();
      var rendszam = $( '#rendszam' ).val();
      var pdfhely = "uploads/elszamolasok/TIG " +  rendszam + " " + vege + ".pdf";
      var kephely = "uploads/elszamolasok/KEP " +  rendszam + " " + vege + ".jpg";
      // var kephely = encodeURI(kephely);
      var KepFile = new FormData();

      if (kezdo == '' || vege == '' || ceg == '' || rendszam == '') {
        bootbox.alert({
          title: "Hiba",
          message: "Nincs minden mező kitöltve!"
      }); // nincs kép csatolva
      } else {
        if (alairoid == '' || irodavezetoid == '') {
          bootbox.alert({
            title: "Hiba",
            message: "Nincs aláíró vagy adminisztrátor megjelelölve. Ezt az adataim menüpont alatt tudod pótolni."
        }); // nincs kép csatolva
        }


      if ($('#file-1').val() == '') {
        bootbox.alert({
          title: "Hiba",
          message: "A kép feltöltése kötelező!"
      }); // nincs kép csatolva
      } else {
        // ha ide eljutott, akkor minden adat ki van töltve és képet is töltött fel.
        KepFile.append('kep', $('#file-1').prop('files')[0]);
        KepFile.append('nev', "../" + kephely);

        // PDF készítés és tárolás (rendszám, eleje, vége, cég)
        $.post( "pdfcreator3.php", {
            Prendszam : rendszam,
            Pkezdo : kezdo,
            Pvege : vege,
            Pceg : ceg,
        },
        "json").done(function() {
          // Adatbázisba felvesszük az adatokat, hogy itt tudják elfogadni, letölteni. (felhasználó, eleje, vége, képhelye, pdf helye, aláírója, adminisztrátora)
          $.post( "ajax/ajax.ujelszamolas.php", {
              Pfelhasznalo : userName,
              Pkezdo : kezdo,
              Pvege : vege,
              Prendszam : rendszam,
              Pkephely : kephely,
              Ppdfhely : pdfhely,
              Palairoid : alairoid,
              Padminid : irodavezetoid,
          },
          "json").done(function( response ) {
            if ( response == "ok" ) {
              // if ok
              // képet feltöltjük a szerverre, a megfelelő helyre.
              $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: KepFile,
                url: "ajax/ajax.elszamolfileupload.php",
                dataType: 'json',
                }) //$.ajax file handling

                bootbox.alert({
                  title: "Siker!",
                  message: "Sikeresen rögzítettük az elszámolást",
                  callback: function() {
                    location.reload();
                  }
              });
            } else {
              // if not ok
              bootbox.alert({
                title: "Hiba",
                message: "Hiba történt az adatbázisba való feltöltésben!"
            });
            }
          });

        });

      } // van kép csatolva
    } // inputok ki vannak töltve
  } // elszamol function vége
    </script>
    <div class="container">
      <div class="well well-sm" onclick="hideopen('sajat')">
        <div class="container">
        <h3> Általam rögzített elszámolások</h3>
      </div>
      </div>
     <section id="sajat">
       <table class="table table-responsive table-bordered table-hover">
         <thead>
           <th class="well">Rendszám</th>
           <th class="well">Időszak kezdete</th>
           <th class="well">Időszak vége</th>
           <th class="well">Kép</th>
           <th class="well">Dokumentum</th>
           <th class="well">Igazolás státusza</th>
           <th class="well">Törlés</th>
         </thead>
        <?php
        $SQ = "SELECT * FROM elszamolasok WHERE felhasznaloid = '{$userId}' ORDER BY id desc";
        $SQsend = mysqli_query($viapanServer, $SQ);
        while ($SQadat = mysqli_fetch_assoc($SQsend)) {
          $rendszam = $SQadat['rendszam'];
          $elszID = $SQadat['id'];
          $kezdo = $SQadat['kezdo'];
          $vege = $SQadat['vege'];
          $kephely = $SQadat['kephely'];
          $dokhely= $SQadat['dokhely'];
          $statusz = $SQadat['statusz'];
          switch ($statusz) {
            case 'sent':
              $statusz = "Engedélyezésre vár ⚪";
            break;
            case 'allowed':
              $statusz = "Engedélyezve ✔️";
            break;
            case 'done':
              $statusz = "Utalásra küldve ✔️✔️";
            break;
          }

?>
        <tbody>
          <tr id='<?php echo "tr$elszID" ?>'>
            <td><?php echo "$rendszam"; ?></td>
            <td><?php echo "$kezdo"; ?></td>
            <td><?php echo "$vege"; ?></td>
            <td><a class="btn btn-success" data-toggle="lightbox" href='<?php echo "$kephely"; ?>'>Megtekint</a></td>
            <td><a class="btn btn-success iframe" href='<?php echo "$dokhely"; ?>'>Megtekint</a></td>
            <td><?php echo "$statusz"; ?></td>
            <td><a class="btn btn-success" onclick='torles(<?php echo "$elszID" ?>)'>Törlés</a></td>
          </tr>
        </tbody>



<?php        }?>
      </table>
    </section>
    <script type="text/javascript">
      function torles(id) {
        bootbox.confirm({
          title: "Törlés",
          message: '<h3>Biztosan törölni szeretnéd az elszámolást?</h3><p>Amennyiben valóban törölni szeretnéd, a "Mehet" gombra kattintva teheted meg.</p>',
          buttons: {
              cancel: {
                  label: '<i class="fa fa-times"></i> Mégsem'
              },
              confirm: {
                  label: '<i class="fa fa-check fa-success"></i> Mehet'
              }
          },
          callback: function (result) {
            $.post( "ajax/ajax.elszamolastorles.php", {
              Pid : id
            },
            "json").done(function( response ) {
              if (response == 'ok') {
                bootbox.alert({
                    title: "Sikeres törlés",
                    message: "A törlés sikeresen végbement! :)",
                    callback: function () {
                      $( '#tr' + id ).fadeOut(1200);
                    }
                }); // sikeres torles
              } else {
                bootbox.alert({
                    title: "Sikertelen törlés",
                    message: "Hiba történt, a törlés sikertelen volt :( ",
                }); //sikertelen torles
              }
          });
        }
        });
      }
    </script>
    <?php
    $AB = 0;
    $SQ = "SELECT * FROM elszamolasok WHERE alairoid = '{$userId}'";
    $SQsend = mysqli_query($viapanServer, $SQ);
    while ($SQadat = mysqli_fetch_assoc($SQsend)) {
      $statusz = $SQadat['statusz'];
      if ($statusz == "sent") {
      $AB = $AB + 1;
    }
    }
    if ($AB > 0) {
      # code...
     ?>
    <div class="well well-sm" onclick="hideopen('alairoS')">
      <div class="container">
      <h3> Általam aláírandó elszámolások <span><button class="btn btn-sm btn-success"><?php echo "$AB"; ?></button></span></h3>
    </div>
    </div>
    <section id="alairoS" hidden="hidden">
      <table class="table table-responsive table-bordered table-hover">
        <thead>
          <th class="well">Rendszám</th>
          <th class="well">Időszak kezdete</th>
          <th class="well">Időszak vége</th>
          <th class="well">Kép</th>
          <th class="well">Dokumentum</th>
          <th class="well">Igazolás státusza</th>
          <th class="well">Törlés</th>
        </thead>
        <tbody>
       <?php
       $SQ = "SELECT * FROM elszamolasok WHERE alairoid = '{$userId}'";
       $SQsend = mysqli_query($viapanServer, $SQ);
       while ($SQadat = mysqli_fetch_assoc($SQsend)) {
         $rendszam = $SQadat['rendszam'];
         $elszID = $SQadat['id'];
         $kezdo = $SQadat['kezdo'];
         $vege = $SQadat['vege'];
         $kephely = $SQadat['kephely'];
         $dokhely= $SQadat['dokhely'];
         $statusz = $SQadat['statusz'];
         switch ($statusz) {
           case 'sent':
             $statusz = "Engedélyezésre vár";
           break;
           case 'allowed':
             $statusz = "Engedélyezve";
           break;
           case 'done':
             $statusz = "Utalásra küldve";
           break;
         }
         if ($statusz == "Engedélyezésre vár") {
           # code...

?>
         <tr id='<?php echo "tr$elszID" ?>'>
           <td><?php echo "$rendszam"; ?></td>
           <td><?php echo "$kezdo"; ?></td>
           <td><?php echo "$vege"; ?></td>
           <td><a class="btn btn-success" data-toggle="lightbox" href='<?php echo "$kephely"; ?>'>Megtekint</a></td>
           <td><a class="btn btn-success iframe" href='<?php echo "$dokhely"; ?>'>Megtekint</a></td>
           <td><button class="btn btn-danger" onclick='akcio("alairo","<?php echo $elszID ?>")'>Engedélyezés</button></td>
           <td><button class="btn btn-success" onclick='torles(<?php echo "$elszID" ?>)'>Törlés</a></td>
         </tr>



<?php       } } }?>
</tbody>
     </table>
    </section>
    <?php
    $ABT = 0;
    $SQ = "SELECT * FROM elszamolasok WHERE irodavezetoID = '{$userId}'";
    $SQsend = mysqli_query($viapanServer, $SQ);
    while ($SQadat = mysqli_fetch_assoc($SQsend)) {
      $statusz = $SQadat['statusz'];
      if ($statusz == "allowed") {
        # code...
      $ABT = $ABT + 1;
    }
    }
      # code...
     ?>
    <div class="well well-sm" onclick="hideopen('admin')">
      <div class="container">
      <h3> Utalásra küldésre váró elszámolások <span><button class="btn btn-sm btn-success"><?php echo "$ABT"; ?></button></span></h3>
    </div>
    </div>
    <section id="admin" hidden="hidden">
      <table class="table table-responsive table-bordered table-hover">
        <thead>
          <th class="well">Rendszám</th>
          <th class="well">Időszak kezdete</th>
          <th class="well">Időszak vége</th>
          <th class="well">Kép</th>
          <th class="well">Dokumentum</th>
          <th class="well">Igazolás státusza</th>
          <th class="well">Törlés</th>
        </thead>
        <tbody>
       <?php
       $SQ = "SELECT * FROM elszamolasok WHERE irodavezetoID = '{$userId}'";
       $SQsend = mysqli_query($viapanServer, $SQ);
       while ($SQadat = mysqli_fetch_assoc($SQsend)) {
         $rendszam = $SQadat['rendszam'];
         $elszID = $SQadat['id'];
         $kezdo = $SQadat['kezdo'];
         $vege = $SQadat['vege'];
         $kephely = $SQadat['kephely'];
         $dokhely= $SQadat['dokhely'];
         $statusz = $SQadat['statusz'];
         switch ($statusz) {
           case 'sent':
             $statusz = "Engedélyezésre vár";
           break;
           case 'allowed':
             $statusz = "Engedélyezve";
           break;
           case 'done':
             $statusz = "Utalásra küldve";
           break;
         }
if ($statusz != "Engedélyezésre vár") {

?>
         <tr id='<?php echo "tr$elszID" ?>'>
           <td><?php echo "$rendszam"; ?></td>
           <td><?php echo "$kezdo"; ?></td>
           <td><?php echo "$vege"; ?></td>
           <td><a class="btn btn-success" data-toggle="lightbox" href='<?php echo "$kephely"; ?>'>Megtekint</a></td>
           <td><a class="btn btn-success iframe" href='<?php echo "$dokhely"; ?>'>Megtekint</a></td>
           <?php if ($statusz == "Engedélyezve") {?>
             <td><button class="btn btn-danger" onclick='akcio("admin","<?php echo $elszID ?>")'>Utalásra küldés</button></td>
          <?php } ?>
          <?php if ($statusz == "Utalásra küldve") {?>
            <td>Utalásra küldve ✔️✔️</td>
         <?php } ?>
           <td><button class="btn btn-success" onclick='torles(<?php echo "$elszID" ?>)'>Törlés</a></td>
         </tr>



<?php     } }  ?>
</tbody>
     </table>
    </section>


  </div>
  </body>
</html>
<script type="text/javascript">
  function akcio(section,id){
    $.post( "ajax/ajax.jovahagy.php", {
      Psection: section,
      Pid : id
    },
    "json").done(function( response ) {
      if (response == 'ok') {
        bootbox.alert({
          title: "Sikeres jóváhagyás",
          message: "Sikeren megváltoztattuk az elszámolás státuszát. Innentől nem jelen a listában.",
          callback: function() {
            $( '#tr' + id ).fadeOut(1200);
          }
        });
      } else {
        bootbox.alert({
          title: "Hiba",
          message: "Hiba tölrtént az elszámolás jóváhasgyása közben! A jövőáhagyás nem történt meg.",
        });
      }
    });
  }
</script>
<script type="text/javascript">
  function hideopen(section) {
    var vis = $('#' + section).is(':visible');
    if (vis == true) {
        $('#' + section).fadeOut('1200');
    } else {
      $('#' + section).fadeIn('1200');
    }
  }
</script>
