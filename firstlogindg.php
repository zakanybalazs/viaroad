<?php
session_start();
//$viapanServer = mysqli_connect("localhost","root","ASDW1298","viapan");
include "functions.php";
include "css/loginheader.php";

  ?>
  <div>
    <p></p>
  </div>
  <div class="container jumbotron">
    <center>
      <img src="uploads/logo3.png" alt="" >
    </center/>
    <p></p>
    <div class="col-lg-2 col-md-1">
    </div>
    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12" >
      <form action="firstlogin.php" method="post">
        <h2 class="form-signin-heading">Felhasználói fiók létrehozása</h2>
        <input type="text" name="user" class="form-control" placeholder="Felhasználó név" required autofocus>
        <p></p>
        <input type="password" name="pass1" id="pass1" class="form-control" placeholder="Jelszó, minimum 4 karakter" pattern=".{4,}" required>
        <p></p>
        <input type="password" id="pass2" class="form-control" placeholder="Jelszó ismét" onkeyup="checkPass(); return false;" required>
        <p></p>
        <span id="confirmMessage" class="confirmMessage"></span>
        <p></p>
        <button class="btn btn-lg btn-success btn-block" type="submit">Létrehozás</button>
        <h1></h1>
      </form>
    </div>
  </div>
</body>
</html>
<script type="text/javascript">
function checkPass()
{
  //Store the password field objects into variables ...
  var pass1 = document.getElementById('pass1');
  var pass2 = document.getElementById('pass2');
  //Store the Confimation Message Object ...
  var message = document.getElementById('confirmMessage');
  //Set the colors we will be using ...
  var goodColor = "#5cb85c";
  var badColor = "#fc6e6e";
  //Compare the values in the password field
  //and the confirmation field
  if(pass1.value == pass2.value){
    //The passwords match.
    //Set the color to the good color and inform
    //the user that they have entered the correct password
    pass2.style.backgroundColor = goodColor;
    message.style.color = goodColor;
    message.innerHTML = "A jelszavak egyeznek"
  }else{
    //The passwords do not match.
    //Set the color to the bad color and
    //notify the user.
    pass2.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.innerHTML = "A jelszavak nem egyeznek"
  }
}
</script>
<?php
if (!empty($_POST['user'])) {
  $userName = $_POST['user'];
  $password = $_POST['pass1'];

  if (userValidate($userName) == true) {
    // Ha ide jut akkor nincs még ilyen felhasználó
    $auth = "admin";
    $hashed = jelszoHash($password);
    ujFelhasznalo($userName, $hashed, $auth);
    ?>
    <?php
  } else {
    // itt szólni kell hogy ilyen már van
    ?>
    <script type="text/javascript">
    alert("A felhaszáló név már foglalt");
    window.location.href = "firstlogin.php";
    </script>
    <?php
  }
}
?>
