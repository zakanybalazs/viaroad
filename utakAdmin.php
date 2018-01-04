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
  <?php } ?>
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.15/datatables.css"/> -->
  <link rel="stylesheet" type="text/css" href="css/responsive.dataTables.css"/>
  <script type="text/javascript" src="datatables.js"></script>
  <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script> -->
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>

  <script type="text/javascript">
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
  </script>



  <body>
    <script type="text/javascript">

var tour2 = new Tour({
  name: "korabbiutak",
  steps: [
  {
    element: "#hidebutton",
    title: "Új elszámolás készítése",
    content: "Új elszámolás készítéséhez meg kell jelölnöd, hogy ki fogja engedélyezni (aláíró) és ki fogja az adminisztrációját végezni az útnyilvántartásodnak. Rend szerint a kirendeltségvezető vagy közvetlen felettes, illetve az irodavezetőről van szó.",
  },
  {
    element: "#export",
    title: "Táblázat exportálása excelben",
    content: "Itt tudod exportálni a táblázatot, ha szükséged lenne rá. A képeket csak egysével tudod letölteni, ha szükséged lenne rá.",
  },
  {
    element: "#example_filter",
    title: "Keresés",
    content: "Ezzel a keresővel olyan oszlopok adataira is rá tudsz keresni, melyek nem látszanak.",
    placement: "left"
  },
]});
$( document ).ready(function() {
// tour2.init();
// tour2.start();
});
// Initialize the tour

// Start the tour


    </script>
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

    <div class="container">
      <a id="hidebutton" class="btn btn-success" onclick="showWell()">Új elszámolás készítése</a>
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
      <style media="screen">
        #hidingWell {
          overflow: visible;
          position: absolute;
        }
      </style>
      <div class="well" id="hidingWell" hidden="hidden">
        <a onclick="pin('hidingWell')"><p align="right">📌</p></a>
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
            <input type="text" id="ceg" name="ceg" list="cegList" class="form-control" placeholder="pl: Meló-Diák Dél Iskolaszövetkezet">
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
    <style>
    #example {
      border-collapse: collapse; /* Összecsukható szélek */
      border: 1px solid #ddd; /* Szürke, hogy szép legyen */
      font-size: 15px; /* Nagyobb betűtípus, hogy jobban látható legyen */
    }
    </style>
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
    <div class="container well">
      <div class="table table-responsive" >
        <table class="responsive table-responsive table table-striped table-hover" data-order='[[ 1, "desc" ]]' id="example" width="100%">
          <thead>
            <tr>
              <!-- A classal meghatározzuk, hogy mikor melyik látszik -->
              <th class="all">Utazás dátuma</th>
              <th class="all">Autó rendszáma</th>
              <th class="tablet-l desktop">Partner/ utazás célja</th>
              <th class="tablet-l desktop">Felhasználó</th>
              <th class="desktop">Indulási hely</th>
              <th class="none">Érkezési hely</th>
              <th class="none">Kilóméter összesen</th>
              <th class="none">Kép</th>
              <th></th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <!-- Ezek a keresés mezőket határozzák meg, ezt hozza fel a thba a JS -->
              <th class="well" >Utazás dátuma</th>
              <th class="well">Autó rendszáma</th>
              <th class="well">Partner/ utazás célja</th>
              <th class="well">Felhasználó</th>
              <th class="well">Indulási hely</th>
              <th class="well">Érkezési hely</th>
              <th class="well">Kilóméter összesen</th>
              <th class="well">Kép</th>
              <th class="well"></th>
            </tr>
          </tfoot>
          <tbody>
            <?php
            /* Az irodavezetők és attóól feljebb, láthatják mindenkinek az útjait, más csak a sajátját */
            if ($auth == "superuser" OR $auth == "admin") {

              $que = "SELECT * FROM utak";
            } else {

                $que = "SELECT * FROM utak WHERE felhasznalo = '{$userName}'";
            }
            $utakSet = mysqli_query($viapanServer, $que);
            while ($utjaim = mysqli_fetch_assoc($utakSet)) {
              $utID = $utjaim['id'];
              $datumT = $utjaim['datum'];
              $rendszamT = $utjaim['rendszam'];
              $felhasznalo = $utjaim['felhasznalo'];
              $honnanT = $utjaim['honnan'];
              $hovaT = $utjaim['hova'];
              $celT = $utjaim['cel'];
              $kezdoT = $utjaim['kezdokm'];
              $zaroT = $utjaim['zarokm'];
              $kmT = $utjaim ['km'];
              $kolcsonT = $utjaim['kolcsonbe'];
              $kepT = $utjaim['kep'];
              $kepNevT = $utjaim['kepnev'];
              $datumTT = date_create($datumT);
              $datumFormat = date_format($datumTT,'Y-m-d H:i');

              /* Kirenderelem a táblázat oszlopait, hogy be tudjuk azonosítani,
               hogy melyik mezőről van szó, mindegyik megkapja az út ID-ját,
               illetve mivel így nem érvényesek mint HTML id, ezért kapnak egy
               betűt is, szóval functionbe el lehet küldeni és használni.    */

              echo "<tr id='a$utID'><td data-order='$utID'>$datumFormat</td>";
              echo "<td id='b$utID'>$rendszamT</td>";
              echo "<td id='c$utID'>$celT</td>";
              echo "<td id='d$utID'>$felhasznalo</td>";
              echo "<td id='e$utID'>$honnanT</td>";
              echo "<td id='f$utID'>$hovaT</td>";
              echo "<td id='g$utID'>$kmT</td>";
              echo "<td id='h$utID'><p><a data-toggle='lightox' href='$kepT'>$kepNevT</a></p></td>";
              echo "<td id='i$utID'><button class='btn btn-success' onclick='torles($utID)'>Törlés</button></td></tr>";
            }?>
          </tbody>
        </table>
      </div>

      <button class="btn btn-success" id="export" onclick="window.exportExcel()">Táblázat exportálása excelben</button>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript">
/* Az út ID alaőján ki tudjuk választani, mit kell elküldeni az AJAXnak törlésre */
    function torles(id) {
      bootbox.confirm({ // egyedi felugró ablak, hogy szép legyen (bootbox.js API)
        title: "Ellenőrzés",
        message: '<h3>Biztosan ki akarod törölni az utat?</h3>',
        buttons: {
          cancel: {
            label: '<i class="fa fa-times"></i> Mégsem'
          },
          confirm: {
            label: '<i class="fa fa-check fa-success"></i> Igen'
          }
        },
        callback: function (result) {
          if (result == true) {
            $.post( "ajax/ajax.torles.php", {
              di: id,
            },
            "json").done(function( response ) {
              if (response == "ok") {
                bootbox.alert({
                  title: "Siker!",
                  size: "small",
                  message: "Az adatokat sikeresen töröltük!",
                  animate: true,
                  backdrop: true,
                }); //bootbox siker
                window.location="utakAdmin.php";
              } else { // response ok
                bootbox.alert({
                  title: "Hiba",
                  size: "small",
                  message: "Probléma történt az adatok törlésénél!",
                  animate: true,
                  backdrop: true,
                }); // bootbox hiba
              } // response? ok else
            }); // done(function) end
          } // end if
        } // end of callback
      }); // bootbox confirm
    } // end of t0rles
    </script>
    <script>
    /* Ha eklészült az oldal, akkor a sima HTML táblázatot átalakítjuk a DataTables.js API-val.
        Kicsit lassan tölti be, mert egyedi kellett és nem tudtam CDN-ként használni.      */
    $(document).ready(function() {
      // Setup - add a text input to each footer cell
      $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Keresés: '+title+'" />' );
      } );

      var table = $('#example').DataTable( {
        paging: false,
      } );

      // Apply the search
      table.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
          if ( that.search() !== this.value ) {
            that
            .search( this.value )
            .draw();
          }
        } );
      } );
      $('#example tfoot tr').appendTo('#example thead');
    } );
    /* A táblázat WELL divjében van, ezért úgy néz ki, mintha a táblázat része lenne.
        Sima excel export az ALASQL API segítségével, azért kell ez, mert másik excel
        exportok nem tudták kezelni a magyar speciális karaktereket, pl őá. XLSX-et ad*/
    window.exportExcel = function exportExcel() {
      alasql('SELECT * INTO XLSX("ViaRoadExport.xlsx",{headers:true}) \
      FROM HTML("#resultsTable",{headers:true})');

    } // end of document ready
    </script>
  </body>
  </html>
