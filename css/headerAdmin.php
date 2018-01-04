<?php
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");


$auth = $_SESSION['auth'];
$userName = $_SESSION['userName'];

 ?>
 <!DOCTYPE>
  <head>
  <link rel="icon" type="image/png" href="uploads/FAV.png">
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src='datetimepicker/js/bootstrap-datetimepicker.js'></script>
    <script src="https://cdn.jsdelivr.net/alasql/0.3/alasql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.12/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js" charset="utf-8"></script>
    <script src="bootstrap-tour.min.js" charset="utf-8"></script>
    <script src="jmm/jquery-multidownload.js" charset="utf-8"></script>
    <!-- fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.js"></script>
    <title>ViaRoad</title>
    <link rel="css/bootstrap-tour.min.css" href="/css/master.css">
    <link href="boot/file/css/component.css" rel="stylesheet" type="text/css">
    <link href="datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript">
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
var msViewportStyle = document.createElement('style')
msViewportStyle.appendChild(
  document.createTextNode(
    '@-ms-viewport{width:auto!important}'
  )
)
document.head.appendChild(msViewportStyle)
}
</script>
    <div class="container container-fluid">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
          <a href="switch.php" class="navbar-brand sr">ViaRoad</a>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <!-- <a href="switch.php" class="navbar-brand sr">ViaRoad</a> -->
          <ul class="nav navbar-nav">
            <!-- <li><a href="home.php">Kezdőlap</a></li> -->
            <li><a id="autoim" href="ujsajatauto.php">Autóim</a></li>
            <li id="szempop" data-toggle='popover' data-animation='true' data-placement='left' title='Személyes adatok' data-content='Még nincsenek kitöltve a személyes adataid! Az adatok feltöltését az Adataim menüpont alatt teheted meg'><a href="adataim.php">Adataim</a></li>
            <li><a id="go" href="switch.php">GO!</a></li>
            <li><a id="korabbiutak" href="utakAdmin.php">Korábbi utak</a></li>
            <li><a href="elszamolasok.php">Elszámolások</a></li>
            <?php if ($auth == "cegadmin" || $auth == "superuser") { ?>
            <li><a href="cegadmin.php">Cég adminisztráció</a></li>
        <?php  } ?>
            <?php if ($auth=="admin" or $auth=="superuser") {?>
              <li><a href="cegestigek.php">Céges TIG</a></li>
            <li><a href="felhasznalok.php">Felhasználók</a></li>
            <li><a href="cegesautok.php">Céges autók</a></li>
            <?php } ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="./" onclick="logout()">Kijelentkezés <span class="sr-only">(current)</span></a></li>
        </ul>
        </div>
        </div><!--/.nav-collapse -->
    </nav>
    <?php
    $userId = getUserId($userName);
    $adatQ = "SELECT * FROM szemelyadatok WHERE felhasznaloid = '{$userId}'";
    $adatKeres = mysqli_query($viapanServer, $adatQ);
    while ($adatok = mysqli_fetch_assoc($adatKeres)) {
      # code...
      $keresztnev = $adatok['keresztnev'];
    }?>
    <script type="text/javascript">
    // $.noConflict();
var tour = new Tour({
  name: "korbevezetes",
  steps: [
  {
    element: "#szempop",
    title: "Személyes adatok kitöltése",
    content: "A személyes adatok kitöltését az adataim fülön tudod, megtenni. Erre az elszámolás készíte miatt van szükség. Ameddig ezt nem tetted meg, nem tudsz elszámolást készíteni.  Klikk a következőre, megmutatom",
  },
  {
    element: "#autoim",
    title: "Add hozzá az autódat!",
    content: "Itt tudod megadni az autód adatait, ez szükséges az első utad rögzítéséhez. Klikk a következőre, megmutatom",
  },
  {
    element: "#korabbiutak",
    title: "Előző utaim megtekintése",
    content: "Itt tudod megnézni korábbi utaidat. A táblázat soraira rákattintva tudsz további adatokat megnézni az útról",
  },
]});
// Initialize the tour
// tour.init();

// Start the tour
// tour.start();


    </script>




    </head>
