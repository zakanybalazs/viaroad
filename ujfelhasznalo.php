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

<?php
}


 ?>
 <?php if ($auth=="superuser") { ?>
    <div class="container jumbotron">
      <div class="col-lg-3 col-md-3 col-sm-2">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12" >
            <form action="ujfelhasznalo.php" method="post">
              <h2 class="form-signin-heading">Új felhasznaló hozzáadása</h2>
              <input type="text" name="user" class="form-control" placeholder="Felhasználó név" required autofocus>
      <p></p>
              <input type="password" name="jelszo" class="form-control" placeholder="Jelszó" required>
      <p></p>
              <div class="checkbox">
              <select class="select form-control" name="auth" required>
                <option value="user">Felhasználó</option>
                <option value="admin">Adminisztrátor</option>
                <?php if ($auth=="superuser") { ?>
                  <option value="cegadmin">Cég adminisztrátor</option>
                  <option value='superuser'>Superuser</option>;
                <?php } ?>

              </select>
              </div>
              <button class="btn btn-group-lg btn-success btn-block" type="submit">Hozzáadás</button>
            </form>
            <?php } ?>
            <h1></h1>
      </div>
</div>
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
        <th></th>
      </tr>
    </thead>
    <tbody>
        <?php
        if (empty($_POST['user'])) {
      //  $viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
        $query = "SELECT * FROM felhasznalok";
        $userSet = mysqli_query($viapanServer, $query);
        while ($felhasznalok = mysqli_fetch_assoc($userSet)) {
          $nev = $felhasznalok['felhasznalo'];
          $authh = $felhasznalok['authority'];
        echo "<tr><td>$nev</td>";
        echo "<td>$authh</td>";
        if ($auth=="superuser") {
        echo "<td><a class='btn btn-success' type='submit' href='ujfelhasznalo.php?delete=$nev'>Törlés ";
        echo "</a></td> <td><a class='btn btn-success' type='submit' href='felhasznaloszerkeszt.php?szerkeszt=$nev'>Szerkeszt</a></td>";
        }
        echo "<td><a class='btn btn-success' type='submit' href='autohozzarendeles.php?szerkeszt=$nev'>Autok</a></td></tr> ";
            }
  // <button class="btn btn-lg btn-success btn-block" type="submit">hozzaadas</button>

    }else {
    if (!empty($_POST['user'])) {
      $userName = $_POST['user'];
      $password = $_POST['jelszo'];
      $authh = $_POST['auth'];
      $hashed = jelszoHash($password);
      ujFelhasznalo($userName, $hashed, $authh);
      ?>
      <script type="text/javascript">
      window.location.href = "ujfelhasznalo.php?siker=1";
      </script>
      <?php
}
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
$query = "SELECT * FROM felhasznalok";
$userSet = mysqli_query($viapanServer, $query);
while ($felhasznalok = mysqli_fetch_assoc($userSet)) {
  $nev = $felhasznalok['felhasznalo'];
  $authh = $felhasznalok['authority'];
echo "<tr><td>$nev</td>";
echo "<td>$authh</td>";
if ($auth=="superuser") {
echo "<td><a class='btn btn-success' type='submit' href='ujfelhasznalo.php?delete=$nev'>Törlés ";
echo "</a></td> <td><a class='btn btn-success' type='submit' href='felhasznaloszerkeszt.php?szerkeszt=$nev'>Szerkeszt</a></td>";
}
echo "<td><a class='btn btn-success' type='submit' href='autohozzarendeles.php?szerkeszt=$nev'>Autok</a></td></tr> ";
}
}
if (!empty($_GET['delete'])) {
  $torlendo = $_GET['delete'];
  //echo "$torlendo";
felhasznaloTorol($torlendo);
  ?>
  <script type="text/javascript">
  window.location.href = "ujfelhasznalo.php?siker=2";
  </script>
<?php
}
 ?>

    </tbody>
  </table>
</div>
</div>
  </body>
</html>
