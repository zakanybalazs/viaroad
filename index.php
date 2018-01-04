<?php include_once "css/loginheader.php" ?>
  <body>
<?php $user= "";  ?>

    <div class="container">

<div class="col-lg-4 col-md-4 col-sm-3">

</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
      <form action="index.php" method="post">
        <h2 class="form-signin-heading">Bejelentkezés</h2>
        <input type="text" name="user" class="form-control" value="<?php if (isset($_COOKIE['nev'])){echo $_COOKIE['nev'];} ?>" placeholder="Felhasználó név" required autofocus>
<p></p>
        <input type="password" name="jelszo" class="form-control" placeholder="Jelszó" value = "<?php if (isset($_COOKIE['nev'])){echo $_COOKIE['jelszo'];} ?>" required>
<p></p>
        <div class="checkbox">
          <label>
            <input name="boxi" type="checkbox" value="1" <?php if(isset($_COOKIE['nev'])) {
		echo 'checked="checked"';
	}
	else {
		echo '';
	}
	?>> Emlékezz rám
          </label>
        </div>
        <button class="btn btn-group-lg btn-success btn-block" type="submit">Bejelentkezés</button>
      </form>
</div>
</div>
<?php
if (!empty($_POST)) {
  //ha mar a formot elkuldte maganak
$user = $_POST['user'];
$jelszo = $_POST['jelszo'];
//$hash= jelszoHash($jelszo);
$siker = login($user, $jelszo);
if ($siker) {
  //sikerult
  session_start();
  $safeUser = mysqli_real_escape_string($viapanServer, $user);
  $userId = getUserId($safeUser);
  $auth = getUserAuth($userId);
  $_SESSION["userName"] = $user;
  $_SESSION["auth"] = $auth;
  $_SESSION['login'] = 1;
if ($_POST['boxi']) {
  //Ebben az esetben szeretné ha emlékeznénk rá
  $ev = time() + 31536000;
setcookie('nev',$user,$ev);
setcookie('jelszo',$jelszo,$ev);
}elseif (!$_POST['boxi']) {
  // Ne emlékezzünk rá

  setcookie('nev','',1);
  setcookie('jelszo','',1);
}
echo "<br></br>";

?>
<script type="text/javascript">
  window.location="switch.php";
</script>
<?php
} else {
  //nem sikerult
  ?>
  <script type="text/javascript">
  //function ligonFailed() {
  alert("Hibás jelszó vagy felhasználónév");
//}
  </script>
<?php
  $_SESSION['message'] = "Hibás jelszó vagy felhasználónév";
}
}
?>

  </body>
</html>
<?php mysqli_close($viapanServer); ?>
