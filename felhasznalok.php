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
    <div class="container jumbotron">
<?php
$userId = $_SESSION['userName'];
$userAuth = $_SESSION['auth'];
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
$query = "SELECT * FROM felhasznalok";
$userSet = mysqli_query($viapanServer, $query);
 ?>

  <form action="ujfelhasznalo.php" method="post">
  <h2>Felhasznalok listaja
    <button class="btn btn-group-lg btn-success" type="submit">Felhasznalók kezelése</button>
    <p></p>
  </h2>
</div>
</form>
<div class="container">

<div class="jumotron">
  <script>
  function myFunction() {
    // Declare variables
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
  </script>
  <div class="container">
  <input type="search" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Keresés a nevek között">
  <p></p>
 <div class="table-responsive">
   <table class="table table-striped table-hover" id="myTable">
     <thead>
       <tr>
         <th>Felhasznalo nev</th>
         <th>Jogosultsag</th>
       </tr>
     </thead>
     <tbody>

         <?php
         while ($felhasznalok = mysqli_fetch_assoc($userSet)) {
           $nev = $felhasznalok['felhasznalo'];
           $auth = $felhasznalok['authority'];
         echo "<tr><td>$nev</td>";
         echo "<td>$auth</td></tr>";

         }
          ?>

     </tbody>
   </table>
 </div>
 </div>
  </body>
</html>
