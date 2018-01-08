<?php
session_start();
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
// this is getting a push
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="container">
      <a id="click" class="btn btn-success" onclick="elrejt()"><strong>+</strong></a>
      <p></p>
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
        #hidewell {
          overflow: visible;
          position: absolute;
        }
      </style>
      <div id="hidewell" class="well" hidden="hidden">
        <a onclick="pin('hidewell')"><p align="right">📌</p></a>
      <h3>Új Cég hozzáadása az adatbázishoz</h3>
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <p></p>
          <label>Cég neve</label>
          <input type="text" id="ceg" value="" class="form-control" placeholder="pl: Hr Trainer Kft.">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
          <p></p>
          <label>Cég telephelye</label>
          <input type="text" id="telep" value="" class="form-control" placeholder="pl: 7661 Kozármisleny Róka utca 81.">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
          <p></p>
          <label>Cég rendszerazonosítója</label>
          <input type="text" id="id" value="" class="form-control" placeholder="pl: md">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
          <p></p>
          <label>Autó igénybevételi díja (Ft/Km)</label>
          <input type="number" id="dij" value="" class="form-control" placeholder="pl: 354">
        </div>
        <p></p>

      </div>
      <p></p>
      <button type="button" id="ujmentes" class="btn btn-success" onclick="sendNew()">Adatok mentése</button>
    </div>
</div>
      <p></p>
<div class="jumbotron">
<div class="container well">
<div class="table-responsive">
<table class="table table-striped table-hover">
<thead>
  <th>Cég neve</th>
  <th>Cég telephelye</th>
  <th>Cég azonosítója</th>
  <th>Igénybevételi díj</th>
</thead>
<tbody>
  <?php
    $cegquery = "SELECT * FROM cegek";
    $doit = mysqli_query($viapanServer, $cegquery);
    while ($cegAdat = mysqli_fetch_assoc($doit)) {
        $nev = $cegAdat['ceg'];
        $telep = $cegAdat['telep'];
        $id = $cegAdat['id'];
        $dij = $cegAdat['dij'];
        $idMod = '"' . $id . '"';
        $trMod = $id . "tr";
        $nevMod = '"' . $id . 'nev"';
        $telepMod ='"' . $id . 'telep"';
        $dijMod ='"' . $id . 'dij"';
        $ididMod ='"' . $id . 'id"';
        $nev2 = '"nev"';
        echo "<tr id='$trMod'>";
        echo "<td id=$nevMod contenteditable='true'>$nev</td>";
        echo "<td id=$telepMod contenteditable='true'>$telep</td>";
        echo "<td id=$ididMod>$id</td>";
        echo "<td id=$dijMod contenteditable='true'>$dij</td>";
        echo "<td><button type='button' class='btn btn-success' onclick='ajaxMent($idMod,$nevMod,$telepMod,$dijMod)'>Mentés</button></td>";
        echo "<td><button type='button' class='btn btn-danger' onclick='torlesc($idMod)'>Törlés</button></td>";
        echo '</tr>';
    }
   ?>
</tbody>
</table>
</div>
</div>
</div>
<div class="container jumbotron">
  <h3>MOL ellenörző feltöltése</h3>
  <p></p>
  <div class="col-lg-4 col-md-4 col-sm-6">
    <label>Időszak</label>
  <input type="month" id="idoszak" class="form-control" style="width=60%">
</div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
  <label>Amortizásiós díj kilométerenként (Ft)</label>
  <input type="number" id="amortizacio" value="" class="form-control">
  <label>Amortizációs költség érvényességének kezdete</label>
  <input type="month" id="amortizacio_ervenyesseg" value=""class="form-control">
  <p></p>
  <button type="button" onclick="amortizacio()" class="btn btn-success">Rögzítés újként</button>
  <script type="text/javascript">
    function amortizacio() {
      var dij = $('#amortizacio').val();
      var ervenyes = $('#amortizacio_ervenyesseg').val();
      if (dij == '' || ervenyes == '') {
        bootbox.alert({
          title: "Hiba",
          message: "Minden mező kitöltése kötelező!",
        });
        return;
      }
      $.post("ajax/ajax.uj_amort.php", {
        dij: dij,
        ervenyes: ervenyes,
      },
      "json").done(function( response ) {
        if (response != "ok") {
          bootbox.alert({
            title: "Siker",
            message: "Sikeresen rögzítettük.",
          });
        }
      });
    }
  </script>
</div>
<p></p>
<div class="col-lg-12" id="filefeltoltes" hidden>
  <div class="col-lg-12 col-md-12 col-sm-12"></div>
  <p></p>
  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><p></p>
  <input type="file" name="kep" id="file-1" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple required />
  <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path
     d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
   </svg> <span>CSV feltöltése</span></label>
  </div>
  <div class="col-lg-12 col-md-12"></div>
  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><p></p> </div>
</div>
<div class="container">
<table class="table table-striped table-hover">
  <thead>
    <th>Név</th>
    <th>Rendszám</th>
    <th>Lezárva</th>
  </thead>
  <tbody id="setBody">
  </tbody>
</table>
</div>
<script type="text/javascript">
  $('#idoszak').change(function() {
    $('#setBody').empty();
    var idoszak = $(this).val();
    $.post("ajax/ajax.getAmort.php", {
      idoszak: idoszak,
    },
    "json").done(function( response ) {
      console.log(response[0]);
        $('#amortizacio').val(response[0].egyseg);

      $('#amortizacio_ervenyesseg').val(response[0].ervenyes);
    });
      $.post("ajax/ajax.getKartya.php", {
        idoszak: idoszak,
      },
      "json").done(function( response ) {
        console.log(response);
        if (response != "error") {
          var x = 0;
          for (var i = 0; i < response.length; i++) {
            var tbody = $('#setBody');
            if (response[i].isSet == 'set') {
              var indicator = "<i style='color:#a0cc3a' class='fa fa-check' aria-hidden='true'></i>";
              x++;
            } else {
              var indicator = "<i style='color:red' class='fa fa-times' aria-hidden='true'></i>";
            }
            var string = "<tr><td>"+response[i].nev+"</td><td>"+response[i].rendszam+"</td><td>"+indicator+"</td></tr>";
            tbody.append(string);
          }
          if (i == x) {
            $('#filefeltoltes').slideDown(1200);
          } else {
            $('#filefeltoltes').slideUp(1200);
          }
        }
      });
  });
</script>
</div>

  </body>
<script type="text/javascript">
      document.getElementById('file-1').onchange = function(){
      var arr = [];
      var file = this.files[0];
      var reader = new FileReader();
      reader.onload = function(progressEvent) {
        var lines = this.result.split('\n');
        // first line will be the header, so starting form 1 instead of 0
        var i = 1;
        console.log("line length: " + lines.length);
        setTimeout(function(){
        while (i < lines.length - 1) {
          if (i < lines.length - 1) {
          var str = lines[i].replace(/\"/g, '');
          // ehhez utf-8 pontosvesszővel elválasztott fileokra van szükség
          var str = str.split(';');
          var date = str[5];
          var date = date.split(" ")[0];
          var kartyaszam = str[6];
          var kartyaszam = kartyaszam.replace(/\s/g, '');
          var rendszam = str[7];
          var rendszam = rendszam.replace(/\s/g, '');
          var kilometeroraallas = str[8];
          var kilometeroraallas = kilometeroraallas.replace(/\s/g, '');
          var egysegar = str[27];
          var osszeg = str[28];
          var array = new Array({
            date: date,
            kartyaszam:kartyaszam,
            rendszam: rendszam,
            kilometeroraallas: kilometeroraallas,
            egysegar: egysegar,
            osszeg: osszeg});
            arr[i-1] = array[0];
        }
        i += 1;
      }
      }, 120);
      console.log(arr);
      };
      reader.readAsText(file);
      bootbox.confirm({
        size: "small",
        message: "Biztosan szeretnéd az elszámolásokat elkészíteni?",
        callback: function(result){
          console.log(result);
          if (result == false) {
            return;
          } else {
            console.log('saving...');
            $.post("ajax/ajax.logcsv.php", {
              editor: "<?php echo $userName ?>",
              csv: arr,
            },
            "json");
          }
        }
      });
        $.post("pdfcreator4.php", {
          item1: a,
          item2: b,
        },
        "json").done(function( response ) {
          if (response != "error") {
          }
        });

    }

        function feltolt() {
          var nev_val = $('#nev').val();
          var kir = $('#kir').val();
          var array = new Array({nev: nev_val, kirendeltseg:kir});
          $.post("ajax/ajax.insert.php", {
            Ptable: 'nevek',
            data: array,
          },
          "json").done(function( response ) {
            if (response == "ok") {
              var next = "<tr><td>"+nev_val+"</td><td>"+kir+"</td></tr>"
              $('#tbody').append(next);
            }
          });
          }
  </script>
  <script type="text/javascript">
    function ajaxMent(Id, nev, telep, dij) {
      var PCeg = document.getElementById(nev).innerText;
      var PTelep = document.getElementById(telep).innerText;
      var PDij = document.getElementById(dij).innerText;
      if (PCeg == '' || PTelep == '' || Id == '' ) {
        bootbox.alert({
          title: "Hiba",
          message: "Minden mező kitöltése kötelező!",
        });
      } else {
        $.post( "ajax/ajax.ujcegedit.php", {
          PostCeg : PCeg,
          PostTelep : PTelep,
          id : Id,
          PostDij : PDij
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
                    window.location.href = "cegadmin.php";
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
    function torlesc(id) {
      bootbox.confirm({
        title: "Megerősítés",
        message: '<h3>Biztosan törölni akarod a céget az adatbázisből?</h3>',
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Mégsem'
            },
            confirm: {
                label: '<i class="fa fa-check fa-success"></i> Mehet'
            }
        },
        callback: function(result) {
          if (result == true) {
            $.post('ajax/ajax.torlesceg.php',{
              PostId: id
            }, "json").done(function(response){
              if (response == "ok") {
                bootbox.alert({
                    title: "Siker!",
                    size: "small",
                    message: "Az adatokat sikeresen töröltük!",
                    animate: true,
                    backdrop: true,
                    callback: function() {
                      $('#' + id + 'tr').fadeOut(800);
                    },
                }); //bootbox siker
              } else {
                bootbox.alert({
                    title: "Hiba",
                    size: "small",
                    message: "Probléma történt az adatok törlésénél!",
                    animate: true,
                    backdrop: true,
                      }); // bootbox hiba
              }
            });
          }
        }
      });
    }
  </script>
  <script type="text/javascript">
    function elrejt() {
      $('#hidewell').removeAttr('hidden');
      $('#click').removeAttr('onclick');
      $('#click').attr('onclick','felfed()');
      $('#buttontext').removeAttr('class');
      $('#buttontext').attr('class', 'glyphicon glyphicon-minus-sign');
    }
  </script>
  <script type="text/javascript">
    function felfed() {
      $('#hidewell').attr('hidden', 'hidden');
      $('#click').removeAttr('onclick');
      $('#click').attr('onclick','elrejt()');
      $('#buttontext').removeAttr('class');
      $('#buttontext').attr('class', 'glyphicon glyphicon-plus-sign');
    }
  </script>
  <script type="text/javascript">
    function sendNew() {
      var ceg = $('#ceg').val();
      var telep = $('#telep').val();
      var id = $('#id').val();
      var dij = $('#dij').val();
      if (ceg == '' || telep == '' || id == '' || dij == '') {
        bootbox.alert({
          title: "Hiba",
          message: "Minden mező kitöltése kötelező!",
        });
      } else {
        $.post( "ajax/ajax.ujcegsubmit.php", {
          PostCeg : ceg,
          PostTelep : telep,
          PostId : id,
          PostDij : dij
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
                    window.location.href = "cegadmin.php";
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
