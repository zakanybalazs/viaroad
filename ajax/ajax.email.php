<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

session_start();
$userName = $_SESSION['userName'];
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");

$id = $_POST['elszamolas_id'];
$action = $_POST['action'];

$q = "SELECT * FROM elszamolasok WHERE id = '{$id}'";
$sq = mysqli_query($viapanServer, $q);
$json = array();
$counter = 0;
while($sqa = mysqli_fetch_assoc($sq)) {
      $felhasznalo_id = $sqa['felhasznaloID'];
      $rendszam = $sqa['rendszam'];
      $kezdo = $sqa['kezdo'];
      $vege = $sqa['vege'];
}

$w = "SELECT * FROM szemelyadatok WHERE felhasznaloid = '{$felhasznalo_id}'";
$sw = mysqli_query($viapanServer, $w);
while($swa = mysqli_fetch_assoc($sw)) {
      $vezeteknev = $swa['vezeteknev'];
      $keresztnev = $swa['keresztnev'];
      $email = $swa['email'];
}

$torles_template = <<<TEMPLATE
<div class="col-lg-6 col-md-6">
<h3>Kedves {$vezeteknev} {$keresztnev}!</h3>
<p>
  {$rendszam} rendszámhoz kögzített {$kezdo} - {$vege} dátumú elszámolását törölték.
</p>
<p></p>
<h4>Üdvözlettel,</h4>
<h4>Viaroad rendszer</h4>
</div>
TEMPLATE;

$alairo_template = <<<TEMPLATE
<div class="col-lg-6 col-md-6">
<h3>Kedves {$vezeteknev} {$keresztnev}!</h3>
<p>
  {$rendszam} rendszámhoz kögzített {$kezdo} - {$vege} dátumú elszámolását engedélyezték.
</p>
<p></p>
<h4>Üdvözlettel,</h4>
<h4>Viaroad rendszer</h4>
</div>
TEMPLATE;

$admin_template = <<<TEMPLATE
<div class="col-lg-6 col-md-6">
<h3>Kedves {$vezeteknev} {$keresztnev}!</h3>
<p>
  {$rendszam} rendszámhoz kögzített {$kezdo} - {$vege} dátumú elszámolását utalásra küldték.
</p>
<p></p>
<h4>Üdvözlettel,</h4>
<h4>Viaroad rendszer</h4>
</div>
TEMPLATE;

switch ($action) {
  case 'torles':
  $template = $torles_template;
    break;
  case 'alairo':
  $template = $alairo_template;
    break;
  case 'admin':
  $template = $admin_template;
    break;
  default:
    break;
}

$mail = new PHPMailer();

$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.viapangroup.com';
$mail->Port = 2525;
$mail->SMTPAuth = false;
$mail->SMTPSecure = '';
$mail->SMTPAutoTLS = false;
$mail->Username = 'sender@viapangroup.com';
$mail->Password = '7kBd5ab8';

$mail->CharSet = 'UTF-8';
$mail->setFrom('viaroad@viapangroup.com','Viaroad');
$mail->addAddress($email, $vezeteknev." ".$keresztnev );
$mail->Subject = 'Elszámolás értesítő';
$mail->Body = $template;
$mail->IsHTML(true);

if (!$mail->Send()) {
 // echo $mail->ErrorInfo;
  } else {
  echo 'Sent';
}




header("Content-Type: text/json");
echo json_encode($json);
$viapanServer->close();
?>
