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

</div>

  </body>
<script type="text/javascript">
      document.getElementById('filecsoportos').onchange = function(){
      var arr = [];
      var file = this.files[0];
      var reader = new FileReader();
      reader.onload = function(progressEvent) {
        // Entire file

        // By lines
        var lines = this.result.split('\n');
        console.log(lines);
        console.log(lines.lenght)
        var i = 0;
        setTimeout(function(){
        while (lines) {
          var str = lines[i].replace(/\"/g, '');
          console.log(lines[i]);
          var str = str.split(';');
          var sor = str[0];
          var nev = str[1];
          var jel = str[2];
          var array = new Array({sor: sor, nev:nev, jel:jel});
          // var array = new Array({nevek: nev, kirendeltseg:kir});
        // console.log(str);

            $.post("ajax/ajax.insert.php", {
              Ptable: 'diszk',
              data: array,
            },
            "json");
          i += 1;
        }
      }, 120);

      };
      reader.readAsText(file);
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
