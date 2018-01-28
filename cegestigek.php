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
  <style media="screen">
  #thewell2 {
    overflow: visible;
    position: absolute;
    z-index: 4;
  }
  </style>
  <div class="container jumbotron">
    <div id="thewell2" class="well col-lg-7" hidden="hidden">
      <h2 align="center">A következő teljesítésigazolások elkészítése folyamatban</h2>

      <script type="text/javascript">
      function getit() {
        var z = 0;
        $( '#thewell2' ).fadeIn(1200);
        var kezdet = $( '#kezdet' ).val();
        var vegzet = $( '#vegzet' ).val();
        if (kezdet == '' || vegzet == '') {
          bootbox.alert({
            title : 'Hiba',
            message : 'Nincsenek megfelelően kitöltve az adatok!',
            callback : function() {
              $( '#thewell2' ).fadeOut(1200);
            }
          });
        } else {


          $.post( "ajax/ajax.create.php", {
            Pkezd : kezdet,
            Pvege : vegzet
          },
          "json").done(function( response ) {
            for (var i = 0; i < 100; i++) {
              if (response[0][i].rendszam == 'end') {
                break;
              } else {
                var rend = response[0][i].rendszam;
                var vev = response[0][i].cegnev;
                var veve = response[0][i].ceg;
                var km = response[0][i].km;
                if (km != 0) {
                  z = z + 1;
                  $('#todobody').append( '<tr><td id="rend' + z + '">' + rend + '</td><td id="vev' + z + '">' + vev + '</td><td id="km' + z + '">' + km + '</td><td id="st' + z +'">⚪</td><td hidden="hidden" id="veve' + z + '">' + veve + '</td><td hidden="hidden"><a id="cx' + z + '" target="_blank" download></a></td></tr>' );
                } // not null
              } // didn't hit the END yet
            } // counting till 100, which can never heppen, because it hits end mark, and break
            if (z == 0) {
              bootbox.alert({
                title: "Hiba",
                message: "Nincs olyan autó, melyre lehetne teljesítésigazolás készíteni!",
                animate: true,
                backdrop: true,
                callback: function() {
                  $( '#thewell2' ).hide();
                }
              });
            } else {
              $( '#ghtj' ).attr('onclick', 'megy("' + z + '")')
            }
          }); // done function
        }
      } // getit
    </script>
    <script>
    function megy(z) {
      var esc = [];
      for (var r = 1; r <= z; r++) {
        /* kezdet es vegzet mar nem kell, mert korabban meghataroztuk,
        viszont kelleni fog meg a nem nullas rendszam es ceg.
        Ezeket az idkat mi hataroztuk meg a tablazatba valo rendereleskor */
        var rendszam = $( '#rend' + r ).text();
        var kolcson = $( '#vev' + r ).text();
        var kezdet = $( '#kezdet' ).val();
        var vegzet = $( '#vegzet' ).val();
        // alert(rendszam);
        var submitData = new Array({kezdet, vegzet, rendszam, kolcson});
        var filename = 'uploads/cegeselszamolasok/TIG-' + rendszam + '-' + kolcson + '-' + vegzet + '.pdf';
        $( '#st' + r ).html('✔️');
        $( '#cx' + r ).attr('href',filename);

        esc.push(submitData);
      } // for z, z = records that are not 0
      console.log(esc);
      // TODO: 1 make a php api, to get all the well formed data, for making the pdf
      $.post( "ajax/ajax.ceges_ut_api.php", {
        data : esc,
      },
      "json").done(function( r ) {
        console.log(r);

      // TODO: 2 make the pdf, and handle the errors
      $.post( "http://localhost:3000/tig_ceges", {
        r
      },
      "json").done(function( response ) {
        if (response == "ok") {
        // TODO: 3 save the data to database
        console.log("sending to db");
        $( '#ghtj' ).text('Lezárás');
        $( '#ghtj' ).attr('onclick',"hideopen2('thewell2','" + r + "')");
      }
      }).fail((err) => {
        console.error(err);
      });
    }).fail((err) => {
      console.error(err);
      bootbox.alert({
        title: "Hiba",
        message: "Hiba történt az adatok beolvasásánál!",
        animate: true,
        backdrop: true,
      });
    });
      // TODO: 3 save the data to database
      $( '#ghtj' ).text('Lezárás');
      $( '#ghtj' ).attr('onclick',"hideopen2('thewell2','" + r + "')");
    } // megy
  </script>
  <table id="todot" class="table table-striped table-hover">
    <thead>
      <th>Rendszám</th>
      <th>Kölcsönbe vevő</th>
      <th>Összkilóméter</th>
      <th>Státusz</th>
      <th hidden="hidden">id</th>
    </thead>
    <tbody id="todobody">

    </tbody>
  </table>


  <button type="button" class="btn btn-success" id="ghtj">Teljesítésigazolások váglegesítése</button>


</div>

<h2 align="center">Teljestásigazolások elkészítése, adott időszakra</h2>
<div class="col-lg-5">
  <label>Időszak kezdete</label>
  <input type="date" id="kezdet" class="form-control">
</div>
<div class="col-lg-5">
  <label>Időszak vége</label>
  <input type="date" id="vegzet" class="form-control">
</div>
<div class="col-lg-2">
  <br>
  <p></p>
  <button align="bottom" type="button" class="btn btn-success" name="button" onclick="getit()">Elkészítés</button>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
  <script type="text/javascript">
    function hideopen(section) {
      var vis = $('#' + section).is(':visible');
      if (vis == true) {
        $('#' + section).fadeOut('1200');
        $('#thebutton').text('Egy autóra');
      } else {
        $('#' + section).fadeIn('1200');
        $('#thebutton').text('Bezárás');
      }
    }
  </script>
  <script type="text/javascript">
    function hideopen2(section, r) {

      for (var w = 1; w < r; w++) {
        document.getElementById('cx' + w).click();
      }
      var vis = $('#' + section).is(':visible');
      if (vis == true) {
        $('#' + section).fadeOut('1200');
        // $('#thebutton').text('Egy autóra');
      } else {
        $('#' + section).fadeIn('1200');
        // $('#thebutton').text('Bezárás');
      }

      location.reload();

    }
  </script>

  <p></p>
  <button type="button" id="thebutton" class="btn btn-success" onclick="hideopen('thewell')">Egy autóra</button>
  <p></p>
  <style media="screen">
  #thewell {
    overflow: visible;
    position: absolute;
  }
  </style>
  <script type="text/javascript">
    function egytig() {
      var rendszam = $( '#1rendszam' ).val();
      var kolcson = $( '#1kolcson option:selected' ).html();
      var kezdet = $( '#1kezdo' ).val();
      var vegzet = $( '#1vege' ).val();
      if (rendszam == '' || kolcson == '' || kezdet == '' || vegzet == '') {
        bootbox.alert({
          title : 'Hiba',
          message : 'Nincsenek megfelelően kitöltve az adatok!',
        });
      } else {
        var esc = [];
        var submitData = new Array({kezdet, vegzet, rendszam, kolcson});
        var filename = 'uploads/cegeselszamolasok/TIG-' + rendszam + '-' + kolcson + '-' + vegzet + '.pdf';
        esc.push(submitData);

        console.log(esc);
        // TODO: 1 make a php api, to get all the well formed data, for making the pdf
        $.post( "ajax/ajax.ceges_ut_api.php", {
          data : esc,
        },
        "json").done(function( r ) {
          console.log(r);
        // TODO: 2 make the pdf, and handle the errors
        $.post( "http://localhost:3000/tig_ceges", {
          r
        },
        "json").done(function( response ) {
          if (response == "ok") {
          // TODO: 3 save the data to database
          console.log("sending to db");
          bootbox.alert({
            title : 'Siker',
            message : 'TIG elkészítve',
          });
        }
        }).fail((err) => {
          console.error(err);
        });
        }).fail(() => {
          bootbox.alert({
            title : 'Hiba',
            message : 'Nem sikerült létrehozni a teljesítésigazolást!',
          });
        }).always(function() {
        $( '#tigklikk' ).attr('target', '_blank');
        $( '#tigklikk' ).removeAttr('hidden');
        $( '#tigklikk' ).attr('class', "btn btn-success form-control");
        $( '#tigklikk' ).html('Megtekintés');
        $( '#tigklikk' ).attr('href', filename);
      });

      //  location.reload();
      }
    }
  </script>
  <div id="thewell" class="well" hidden="hidden">

    <div class="col-lg-12 col-mg-12">
      <h2 align="center">Egy autóhoz tartozó teljesítésigazolás elkészítése</h2>
    </div>
    <h1></h1>
    <div id="thediv">

      <select class="form-control" id="1rendszam" required autofocus>
        <option value="" disabled selected style="display:none;">Rendszam</option>
        <?php
        $ceges = "ceges";
        $mquery = "SELECT * FROM autok WHERE tulaj ='$ceges'";
        $atkSet = mysqli_query($viapanServer, $mquery);
        while ($rendszamok = mysqli_fetch_assoc($atkSet)) {
          $kivRendszam = $rendszamok['rendszam'];
          echo "<option value='$kivRendszam'>$kivRendszam</option>";
        }
        ?>
      </select>

      <p></p>
      <input class="form-control" type="date" id="1kezdo" placeholder="Időszak kezdete" required>
      <p></p>
      <input class="form-control" type="date" id="1vege" placeholder="Időszak vége" required>
      <p></p>
      <select class="form-control" id="1kolcson" required>
        <option value="" disabled selected style="display:none;">Igénybevevő cég</option>
        <?php
        $q = "SELECT * FROM cegek WHERE dij is null";
        $sq = mysqli_query($viapanServer,$q);
        while ($sqa = mysqli_fetch_assoc($sq)) {
          $sqID = $sqa['id'];
          $sqCEG = $sqa['ceg'];
          ?>
          <option value='<?php echo "$sqID" ?>'><?php echo "$sqCEG" ?></option>
        <?php  } ?>
      </select>
    </div>
    <h1></h1>
    <a class="btn form-control btn-success btn-block" id="egytigklikk" onclick="egytig()">Elkészítés</a>
    <a id="tigklikk" hidden="hidden"></a>
  </div>
</div>
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
<table class="table table-responsive table-bordered table-hover table-striped">
  <thead>
    <th>Időszak</th>
    <th>Igénybevevő cég</th>
    <th>Auitó rendszáma</th>
    <th>Összeg</th>
    <th>Megtekintés</th>
    <th>Törlés</th>
  </thead>
  <tbody>
    <?php
    $tq = "SELECT * FROM cegestigek ORDER BY id desc";
    $tsq = mysqli_query($viapanServer, $tq);
    while ($tsqa = mysqli_fetch_assoc($tsq)) {
      $id = $tsqa['id'];
      $cegID = $tsqa['kolcsonid'];
      $ceg = getCegNameByID($cegID);
      $rendszam = $tsqa['rendszam'];
      $kezdi = $tsqa['kezd'];
      $vegei = $tsqa['vege'];
      $osszeg = $tsqa['osszeg'];
      $link = $tsqa['pdfhely'];
      ?>
      <tr id="ab_<?php echo $id; ?>">
        <td><?php echo "$kezdi - $vegei"; ?></td>
        <td><?php echo "$ceg"; ?></td>
        <td><?php echo "$rendszam"; ?></td>
        <td><?php echo "$osszeg"; ?></td>
        <td><a class="btn btn-success iframe" href='<?php echo "$link"; ?>'>Megtekintés</a></td>
        <td><button class="btn btn-success" onclick='torles(<?php echo "$id"; ?>)'>Törlés</button></td>
      </tr>
    <?php  }
    ?>
  </tbody>
</table>
</div>

<script type="text/javascript">
function torles(id) {
  $.post("ajax/ajax.delete_cegestig.php", {
    id: id,
  },
  "json").done(function( response ) {
    if (response == "ok") {
      $('#ab_'+id).hide(1000);
    }
  });
}
</script>

</body>
</html>
