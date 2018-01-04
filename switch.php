<?php
session_start();
require_once 'functions.php';
include 'css/headerAdmin.php';
$userName = $_SESSION['userName'];
$PreLoads = piszkozatKereso($userName);
$PreRendszam = piszkozatRendszamKereso($userName);
$PreKategoria = kategoriaKereso($PreRendszam);
if (!isset($userName)) {
  ?>
  <script type="text/javascript">
  window.location="index.php";
  </script>
  <?php }
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
       <link href="css/bootstrap.css" rel="stylesheet">
   </head>
   <style media="screen">
     body {background-color: #A0CC3A;}
   </style>
   <body>
<div class="container">
  <div class="col-lg-4 col-md-3 col-sm-3">
  </div>
  <div class="col-lg-4 col-md-5 col-sm-6">
    <div class="well">
      <div class="well">
<h3>Éppen elindulsz, vagy netán éppen most érkeztél meg?</h3>
</div>
<p></p>
<button onclick="window.location.href='utak.php'" type="button" class="btn-lg btn-group-justified btn-success" data-color="success" name="button"><?php if ($PreLoads!="nincs") {echo "✔️";} else {echo "";} ?>Indulás</button>
<?php  ?>
<p type="checkbox" class="hidden" <?php if ($PreLoads!="nincs") {echo "checked";} else {echo "";} ?> />

<p></p>
<!-- $PreLoads != "NA" or  -->
<?php if ($PreLoads != "nincs" ) {
  if ($PreLoads != "NA" ) {  ?>
<button onclick="window.location.href='utakvege.php?tankolas=1'" type="button" class="btn-lg btn-group-justified btn-danger" name="button">⛽ Megállok tankolni</button>
<?php } elseif ($PreKategoria == "kartyas") {
  // Tudjuk hogy NA, tehát saját autó, ezért ha kártyás, akkor kell tankolás
  ?>
  <button onclick="window.location.href='utakvege.php?tankolas=1'" type="button" class="btn-lg btn-group-justified btn-danger" name="button">⛽ Megállok tankolni</button>
  <?php
}
} ?>
<p></p>
<button onclick="window.location.href='utakvege.php?tankolas=0'" type="button" class="btn-lg btn-group-justified btn-danger" id="vegebutton">🏁 Megérkeztem</button>
</div>

</div>
<div class="col-lg-4 col-md-3 col-sm-2">
</div>
</div>
   </body>
 </html>
<script type="text/javascript">
$(function () {
  $('.button-checkbox').each(function () {

      // Settings
      var $widget = $(this),
          $button = $widget.find('button'),
          $checkbox = $widget.find('input:checkbox'),
          color = $button.data('color'),
          settings = {
              on: {
                  icon: 'glyphicon glyphicon-check'
              },
              off: {
                  icon: 'glyphicon glyphicon-unchecked'
              }
          };

      // Event Handlers
      $button.on('click', function () {
          $checkbox.prop('checked', $checkbox.is(':checked'));
          $checkbox.triggerHandler('change');
          updateDisplay();
      });
      $checkbox.on('change', function () {
          updateDisplay();
      });

      // Actions
      function updateDisplay() {
          var isChecked = $checkbox.is(':checked');

          // Set the button's state
          $button.data('state', (isChecked) ? "on" : "off");

          // Set the button's icon
          $button.find('.state-icon')
              .removeClass()
              .addClass('state-icon ' + settings[$button.data('state')].icon);

          // Update the button's color
          // if (isChecked) {
          //     $button
          //         .removeClass('btn-default')
          //         .addClass('btn-' + color + ' active');
          // }
          // else {
          //     $button
          //         .removeClass('btn-' + color + ' active')
          //         .addClass('btn-default');
          // }
      }

      // Initialization
      function init() {

          updateDisplay();

          // Inject the icon if applicable
          if ($button.find('.state-icon').length == 0) {
              $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
          }
      }
      init();
  });
});
</script>
