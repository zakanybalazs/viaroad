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
if (!empty($_GET['siker'])) {
  if ($_GET['siker']==1) {

 ?>
  <body>
    <script type="text/javascript">
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
});
    </script>
    <div class="container alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Sikeresen rögzítve!</strong>
    </div>
<?php
} else {
  if ($_GET['siker']==2) {
    ?>
    <div class="container alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Sikeresen törölve!</strong>
    </div>
  <?php
  }
}
}
?>
  <body>

    <div class="container jumbotron">
      <div class="col-lg-3 col-md-3 col-sm-2">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >

              <h2 class="form-control-heading">Új autó hozzáadása az autóimhoz</h2>
              <label for="rendszam">Autó rendszáma</label>
              <input type="string" id="rendszam" class="form-control" placeholder="pl: VIA581" required autofocus>
              <p></p>
              <label for="kategoria">Normál elszámolás vagy tankolókártyás?</label>
              <select class="form-control" id="kategoria">
                  <option value="normal">Normál</option>
                  <option value="kartyas">Tankolókártyás</option>
              </select>
              <script type="text/javascript">
                  $('#kategoria').change(function() {
                    if ($(this).val() == "kartyas") {
                      $('#tkarty').slideDown(1000);
                    } else {
                      $('#tkarty').slideUp(1000);
                    }
                  });
              </script>
              <p></p>
              <div id="tkarty" hidden="hidden">
              <label>Tankolókártya száma</label>
              <input type="text" id="tankolokartya" placeholder="pl: 7081678014337910" class="form-control">
              <p></p>
            </div>
              <label for="marka">Az autó márkája</label>
              <input type="string" id="marka" class="form-control" placeholder="pl: Skoda" required>
              <p></p>
              <label for="tipus">Az autó típusa</label>
              <input type="string" id="tipus" class="form-control" placeholder="pl: Rapid GT" required>
              <p></p>
              <label for="tipus">Motor lökettérfogat</label>
              <input type="number" id="terfogat" class="form-control" placeholder="pl: 1394" required>
              <p></p>
              <label for="fogyasztas">Az autó fogyasztása (liter/100kilóméter)</label>
              <input type="number" step="0.1" id="fogyasztas" class="form-control" placeholder="pl: 6,8" required>
              <p></p>
              <label for="uzemanyag">Üzemanyag típusa</label>
              <select class="select form-control" id="uzemanyag">
                <option value"benzin">Benzin</option>
                <option value="diesel">Diesel</option>
              </select>
              <p></p>
              <label for="forgalmni">Forgalmi engedély szkennelve</label>
              <p></p>
              <input type="file" name="kep" id="file-1" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple required />
    					<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path
                 d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
               </svg> <span>Szkennelt fájl feltöltése</span></label>
              <p></p>
              <h5 for="file-2">Amennyiben nem saját tulajdonú autó, a kölcsonadási szeződés feltöltése kötelező.</h5>
              <input type="file" name="kep1" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple required />
              <label for="file-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path
                 d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
               </svg> <span>Dokumentum feltöltése</span></label>
               <a href="uploads/Gepjarmu_kolcsonadasi_szerzodes.doc" onclick="window.open('uploads/Gepjarmu_kolcsonadasi_szerzodes.doc','_blank');window.close();return false">
              <input type="button"  name="kep2" id="down" class="inputfile inputfile-2 form-control"/>
              <label for="down"><span>Sablon letöltése</span></label></a>
              <p></p>
              <!-- stylesheet for the loading button -->
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
              <button onclick="somethingElse()" class="btn btn-success form-control">
                <div id="dolgozunk" hidden="hidden">
                <i class="fa fa-spinner fa-spin" id="dolgozunk"></i> Dolgozunk
              </div>
              <div id="mehet">
                <i id="mehet"></i>Mentés
              </div>
              </button>
            <h1></h1>
      </div>
</div>
<div class="container">
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Rendszám</th>
        <th>Márka</th>
        <th>Tipus</th>
        <th>Üzemanyag</th>
        <th>Fogasztás (l/100km)</th>
        <th>Törlés</th>
        <th>Forgalmi</th>
        <th>Kölcsönadási szerződés</th>
      </tr>
    </thead>
    <tbody>
        <?php
          $query = "SELECT * FROM autok WHERE tulaj = '{$userName}'";
          $autokSet = mysqli_query($viapanServer, $query);
          while ($autok = mysqli_fetch_assoc($autokSet)) {
            $rendszam = $autok['rendszam'];
            $marka = $autok['marka'];
            $tipus = $autok['tipus'];
            $uzemanyag = $autok['uzemanyag'];
            $fogyasztas = $autok['fogyasztas'];
            $forgalminev = $autok['forgalminev'];
            $forgalmihely = $autok['forgalmihely'];
            $szerzodeshely = $autok['szerzodeshely'];
            $szerzodesnev = $autok['szerzodesnev'];
?>
         <tr><td><?php echo "$rendszam"?></td>
         <td><?php echo "$marka"?></td>
         <td><?php echo "$tipus"?></td>
         <td><?php echo "$uzemanyag"?></td>
         <td><?php echo "$fogyasztas"?></td>
         <td><a class='btn btn-success' type='submit' href='ujsajatauto.php?delete=<?php echo"$rendszam" ?>'>Törlés</a></td>
         <?php
         if ($forgalminev != "NA") {
           ?>
         <td><a data-toggle="lightbox" data-type="image" class='btn btn-success' href='<?php echo "$forgalmihely"; ?>' onclick="window.open(<?php echo $forgalmihely; ?>,'_blank');window.close();return false">Forgalmi letöltése</a></td>
         <?php
        } else {
          ?>
         <td></td>
         <?php
       }
         if ($szerzodesnev != "N/A") {
         ?>
         <td><a data-toggle="lightbox" class='btn btn-success' href='<?php echo "$szerzodeshely"; ?>'>Szerődés letöltése</a></td>
         <?php
       } else {
         ?>
         <td></td>
         <?php
       }
       ?>
        </tr>
        <?php
          }

if (!empty($_GET['delete'])) {
  $torlendo = $_GET['delete'];
  //echo "$torlendo";
autoTorol($torlendo);
 ?>
 <script type="text/javascript">
 window.location.href = "ujsajatauto.php?siker=2";
 </script>
 <?php
}
?>
    </tbody>
  </table>
</div>
</div>
<script type="text/javascript">
function somethingElse() {
  $( '#mehet' ).attr('hidden','hidden');
  $( '#dolgozunk' ).removeAttr('hidden');
  var userName = '<?php echo $userName; ?>';
  var rendszam = $( '#rendszam' ).val();
  var kategoria = $( '#kategoria' ).val();
  var marka = $( '#marka' ).val();
  var terfogat = $('#terfogat').val();
  var tipus = $('#tipus').val();
  var fogyasztas = $('#fogyasztas').val();
  var uzemanyag = $('#uzemanyag').val();
  var tankolokartya = $('#tankolokartya').val();
  var file = new FormData();
  // checking if every input has been filled
    if (rendszam == '' || kategoria == '' || terfogat == '' || marka == '' || tipus == '' || fogyasztas == '' || uzemanyag == '' || $('#file-1').val() == '') {
      bootbox.alert({
        title: "Hiba",
        message: "Minden mező kitöltése kötelező!",
        callback: function() {
          $( '#dolgozunk' ).attr('hidden', 'hidden');
          $( '#mehet' ).removeAttr('hidden');
        }
      });
    } else {
      if (kategoria == "kartyas") {
        if (tankolokartya == '') {
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

  bootbox.confirm({
      title: "Adat ellenőrzés",
      message: '<h4>Kérlek ellenőrizd az adatokat!</h4> <p>Autó rendszáma: ' + rendszam + '</p><p>Autó adatai: ' + marka + " " + tipus + " " + fogyasztas + " L/100Km (" + uzemanyag + ")" + '</p><p>' + '</p><p>Amennyiben helyesnek találod az adatokat, kattints a mehet gombra!</p>',
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
file.append('kep1', $( '#file-1' ).prop( 'files' )[0]);
var kep1ext = file.get('kep1').name.split('.').pop();
// console.log(kep1Name);

var forgalmiNev = rendszam + 'forgalmi.' + kep1ext;
var forgalmiHely = 'uploads/autok/forgalmi/' + forgalmiNev;

if ($('#file-2').val() == '') {
var szerzodesNev = "N/A";
var szerzodesHely = 'uploads/autok/kolcsonadasi/' + szerzodesNev;
} else {
  file.append('kep2', $( '#file-2' ).prop( 'files' )[0]);
  var kep2ext = file.get('kep2').name.split('.').pop();

  szerzodesNev = rendszam + 'szerzodes.' + kep2ext;
  szerzodesHely = 'uploads/autok/kolcsonadasi/' + szerzodesNev;
}

$.post( "ajax/ajax.ujautosubmit.php", {
  PostuserName: userName,
  Postrendszam: rendszam,
  Postkategoria: kategoria,
  Postmarka: marka,
  Postterfogat: terfogat,
  Posttipus: tipus,
  Postfogyasztas: fogyasztas,
  Postuzemanyag: uzemanyag,
  Postforgalmihely: forgalmiHely,
  Postforgalminev: forgalmiNev,
  Postszerzodeshely: szerzodesHely,
  Postszerzodesnev: szerzodesNev,
  Postkartya: tankolokartya,
},
"json").done(function( response ) {
  if (response == "ok") {
    $.ajax({
      type: 'POST',
      processData: false,
      contentType: false,
      cashe: false,
      data: file,
      url: "ajax/ajax.fileuploadujsauto.php",
      dataType: 'json',
    });
    if ( $( '#file-2' ).val() != '' ) {
      $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cashe: false,
        data: file,
        url: "ajax/ajax.fileuploadujsautoszer.php",
        dataType: 'json',
        });
    }

    $( '#dolgozunk' ).attr('hidden', 'hidden');
    $( '#mehet' ).removeAttr('hidden');
    bootbox.alert({
        title: "Siker!",
        size: "small",
        message: "Az adatokat sikeresen rögzítettük!",
        animate: true,
        backdrop: true,
        callback: function() {
          window.location.href = "ujsajatauto.php";
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
}// end of somethingElse()
</script>
  </body>
</html>
