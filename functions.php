  <?php
function jelszoHash($jelszo){
$hashFormat = "$2y$10$";
$hossz = 22;
$salt = saltGen($hossz);
$formatAndSalt = "$hashFormat.$salt";
$hash = crypt($jelszo, $formatAndSalt);
return $hash;
}
?>
<?php
function saltGen($hossz){
$egyediRandom = md5(uniqid(mt_rand(),true));
$base64 = base64_encode($egyediRandom);
$javit = str_replace('+', '.', $base64);
$salt = substr($javit, 0 , $hossz);
return $salt;
}
?>
<?php
function ellenorzes($jelszo, $hashGen){
$hash = crypt($jelszo,$hashGen);
if ($hash === $hashGen) {
  return true;
}else {
  return false;
}
}
function userKeres ($user){
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$safeUser = mysqli_real_escape_string($viapanServer, $user);
$query = "SELECT * FROM felhasznalok WHERE felhasznalo = '$safeUser' LIMIT 1";
$userSet = mysqli_query($viapanServer, $query);
if ($admin = mysqli_fetch_assoc($userSet)) {

return $admin;
} else {
  return null;
}
}
function login($user, $jelszo) {
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$admin = userKeres($user);
if ($admin) {
  // megkeressuk a jelszot
if (jelszoMatch($jelszo, $admin['jelszo'])) {
return $user;
} else {
return false;
}
}else {
//  echo "it got denied";
  return false;
}
}
function jelszoMatch($jelszo, $existingHash){
$hash = crypt($jelszo, $existingHash);
if ($hash === $existingHash) {

  return true;
}else {
  return false;
}
}
function getUserAuth($userId){
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $query = "SELECT * FROM felhasznalok WHERE id = '$userId'";
  $Set = mysqli_query($viapanServer, $query);
  if ($admin = mysqli_fetch_assoc($Set)) {
  $auth = $admin['authority'];
  return $auth;
}else {
return null;
}
}
function getUserId($safeUser){
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$query = "SELECT * FROM felhasznalok WHERE felhasznalo = '$safeUser' LIMIT 1";
$userSet = mysqli_query($viapanServer, $query);
if ($admin = mysqli_fetch_assoc($userSet)) {
$id = $admin['id'];
return $id;
} else {
  return null;
}
}
function felhasznalok(){
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$query = "SELECT * FROM felhasznalok";
$userSet = mysqli_query($viapanServer, $query);
$felhasznalok = mysqli_fetch_assoc($userSet);
return $felhasznalok;
}
function ujFelhasznalo($userName, $hashed, $auth) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $safeUserName = mysqli_real_escape_string($viapanServer, $userName);
  $ide = "INSERT INTO felhasznalok (felhasznalo, jelszo, authority) VALUES ('{$safeUserName}', '{$hashed}', '{$auth}')";
  $siker = mysqli_query($viapanServer, $ide);
}
function felhasznaloTorol($userName) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $safeUserName = mysqli_real_escape_string($viapanServer, $userName);
  $ide = "DELETE FROM felhasznalok WHERE felhasznalo = '$safeUserName'";
  $siker = mysqli_query($viapanServer, $ide);
  $torlQuery = "DELETE FROM hozzarendel WHERE felhasznalo = '{$userName}'";
  $torol = mysqli_query($viapanServer, $torlQuery);
}

function editUser($userId,$userName,$userAuth){
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $safeUserName = mysqli_real_escape_string($viapanServer, $userName);
  $ide = "UPDATE felhasznalok SET authority='{$userAuth}' WHERE id='$userId'";
  $siker = mysqli_query($viapanServer, $ide);
?>
<script type="text/javascript">
  window.location="ujfelhasznalo.php";
</script>
<?php
}
function ujCeg($ceg, $telep, $id, $dij) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $safeceg = mysqli_real_escape_string($viapanServer, $ceg);
  $safetelep = mysqli_real_escape_string($viapanServer, $telep);
  $ide = "INSERT INTO cegek (ceg, telep, id, dij) VALUES ('{$safeceg}', '{$safetelep}', '{$id}', '{$dij}')";
  $siker = mysqli_query($viapanServer, $ide);
  if (!$siker) {
    return "not ok";
  } else {
    return "ok";
  }
}
?>
<?php
 function CegEdit($ceg,$telep,$id,$dij) {
   $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
   $safeceg = mysqli_real_escape_string($viapanServer, $ceg);
   $safetelep = mysqli_real_escape_string($viapanServer, $telep);
   $id = trim($id, "'");
   if ($dij < 1) {
     $ide = "UPDATE cegek SET ceg = '{$safeceg}', telep = '{$safetelep}', dij = NULL WHERE id = '{$id}'";
 } else {
   $ide = "UPDATE cegek SET ceg = '{$safeceg}', telep = '{$safetelep}', dij = '{$dij}' WHERE id = '{$id}'";
}

   $siker = mysqli_query($viapanServer, $ide);
   if (!$siker) {
     return "$viapanServer->error";
   } else {
     return "ok";
   }
 }
 ?>
<?php
function ujHozzaRendeles($safeUser,$hozzarendelAuto){
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $ide = "INSERT INTO hozzarendel (felhasznalo, rendszam) VALUES ('{$safeUser}', '{$hozzarendelAuto}')";
  $siker = mysqli_query($viapanServer, $ide);
}
 ?>
<?php
function validHozzaRendel($felhasznalo,$rendszam) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $myquery = "SELECT * FROM hozzarendel WHERE felhasznalo = '$felhasznalo' AND rendszam = '$rendszam'";
  $ms = mysqli_query($viapanServer, $myquery);
  if (!$result = mysqli_fetch_assoc($ms)) {
return true;
echo "nem találd ilyet az adatbázisban";
  } else {
    echo "nemgyó";
    return false;
  }
}
 ?>
 <?php
 function ujCegesAuto($rendszam, $tulaj, $ceg, $marka, $tipus, $uzemanyag, $fogyasztas, $terfogat, $berletszam, $berletkezdete, $berletvege){
 $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$safeCeg = mysqli_real_escape_string($viapanServer, $ceg);
$safeBerletszam = mysqli_real_escape_string($viapanServer, $berletszam);
$safeTulaj = mysqli_real_escape_string($viapanServer, $tulaj);
 $ide = "INSERT INTO autok (rendszam, tulaj, ceg, marka, tipus, uzemanyag, terfogat, fogyasztas, berletszam, berletkezdete, berletvege) VALUES ('{$rendszam}', '{$safeTulaj}', '{$safeCeg}', '{$marka}', '{$tipus}', '{$uzemanyag}', '{$terfogat}', '{$fogyasztas}','{$safeBerletszam}','{$berletkezdete}','{$berletvege}')";
 $siker = mysqli_query($viapanServer, $ide);
 if (!$siker) {
  // echo "das ist nicht gut";
 }
 $kilometer = "INSERT INTO kilometer (rendszam) VALUES ('{$rendszam}')";
   $siker2 = mysqli_query($viapanServer, $kilometer);
  }
  ?>
  <?php
  function autoTorol($rendszam) {
    $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
    $ide = "DELETE FROM autok WHERE rendszam = '$rendszam'";
    $siker = mysqli_query($viapanServer, $ide);
    $torlQuery = "DELETE FROM hozzarendel WHERE rendszam = '{$rendszam}'";
    $torol = mysqli_query($viapanServer, $torlQuery);
  }
   ?>
   <?php
function ujSajatAuto($PostuserName,$Postrendszam,$Postkategoria,$Postmarka,$Posttipus,$Postterfogat,$Postfogyasztas,$Postuzemanyag,$Postforgalmihely,$Postforgalminev,$Postszerzodeshely,$Postszerzodesnev, $Postkartya) {
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$safeTulaj = mysqli_real_escape_string($viapanServer, $PostuserName);
  $ide = "INSERT INTO autok (rendszam, tulaj,kategoria, marka, tipus, uzemanyag, fogyasztas, terfogat, forgalmihely, forgalminev, szerzodeshely, szerzodesnev, kartyaszam) VALUES ('{$Postrendszam}', '{$PostuserName}', '{$Postkategoria}', '{$Postmarka}', '{$Posttipus}','{$Postuzemanyag}' ,'{$Postfogyasztas}', '{$Postterfogat}', '{$Postforgalmihely}', '{$Postforgalminev}', '{$Postszerzodeshely}', '{$Postszerzodesnev}','{$Postkartya}')";
  $siker = mysqli_query($viapanServer, $ide);
$kilometer = "INSERT INTO kilometer (rendszam) VALUES ('{$Postrendszam}')";
  $siker2 = mysqli_query($viapanServer, $kilometer);
  if (!$siker) {
    return "not ok";
  } elseif (!$siker2) {
    return 'not ok';
  } else {
    return "ok";
  }
}
  ?>
<?php
function logout() {
  $_SESSION["userName"] = "";
  $_SESSION["auth"] = "";
  $_SESSION['login'] = 0;
}
 ?>
 <?php
function ujUtCeges($userName,$kivCeg,$kivRendszam,$datum,$kolcsonbe,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag,$kivKep,$kepNev) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  //megkezdem megfelelo formaba hozni amiket kell
  $safeUser = mysqli_real_escape_string($viapanServer, $userName);
  $safeCeg = mysqli_real_escape_string($viapanServer, $kivCeg);
  $safeKolcsonbe = mysqli_real_escape_string($viapanServer, $kolcsonbe);
  $safeHonnan = mysqli_real_escape_string($viapanServer, $honnan);
  $safeHova = mysqli_real_escape_string($viapanServer, $hova);
  $safeCel = mysqli_real_escape_string($viapanServer, $cel);
  $safeKep =mysqli_real_escape_string($viapanServer, $kivKep);
  $safeKepNev = mysqli_real_escape_string($viapanServer, $kepNev);
  $ide = "INSERT INTO utak (felhasznalo, datum, rendszam, honnan, ceg, hova, cel, kezdokm, zarokm, km, kolcsonbe, fogyasztas, uzemanyag, kep, kepnev) VALUES ('{$safeUser}', '{$datum}', '{$kivRendszam}', '{$safeHonnan}', '{$safeCeg}', '{$safeHova}', '{$safeCel}', '{$kezdokm}', '{$zarokm}', '{$km}', '{$safeKolcsonbe}', '{$kivFogyasztas}', '$kivUzemanyag','$safeKep', '{$safeKepNev}')";
  $siker = mysqli_query($viapanServer, $ide);
     if (!$siker) { return "Not ok"; } else { return "ok"; }
}
  ?>
  <?php
 function ujUtMagan($userName,$kivRendszam,$datum,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag,$kivKep,$kepNev) {
   $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
   //megkezdem megfelelo formaba hozni amiket kell
   $safeUser = mysqli_real_escape_string($viapanServer, $userName);
   $safeHonnan = mysqli_real_escape_string($viapanServer, $honnan);
   $safeHova = mysqli_real_escape_string($viapanServer, $hova);
   $safeCel = mysqli_real_escape_string($viapanServer, $cel);
   $safeKep =mysqli_real_escape_string($viapanServer, $kivKep);
   $safeKepNev = mysqli_real_escape_string($viapanServer, $kepNev);
   $ide = "INSERT INTO utak (felhasznalo, datum, rendszam, honnan, hova, cel, kezdokm, zarokm, km, fogyasztas, uzemanyag, kep, kepnev) VALUES ('{$safeUser}' ,'{$datum}', '{$kivRendszam}', '{$safeHonnan}', '{$safeHova}', '{$safeCel}', '{$kezdokm}', '{$zarokm}', '{$km}', '{$kivFogyasztas}', '{$kivUzemanyag}','{$safeKep}', '{$safeKepNev}')";
   $siker = mysqli_query($viapanServer, $ide);
     if (!$siker) { return "Not ok"; } else { return "ok"; }
 }
   ?>
   <?php
  function ujUtKartyas($userName,$kivRendszam,$datum,$honnan,$hova,$cel,$kezdokm,$zarokm,$km,$kivFogyasztas,$kivUzemanyag,$kivKep,$kepNev,$idoszak) {
    $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
    //megkezdem megfelelo formaba hozni amiket kell
    $safeUser = mysqli_real_escape_string($viapanServer, $userName);
    $safeHonnan = mysqli_real_escape_string($viapanServer, $honnan);
    $safeHova = mysqli_real_escape_string($viapanServer, $hova);
    $safeCel = mysqli_real_escape_string($viapanServer, $cel);
    $safeKep =mysqli_real_escape_string($viapanServer, $kivKep);
    $safeKepNev = mysqli_real_escape_string($viapanServer, $kepNev);
    $ide = "INSERT INTO utak (felhasznalo, datum, rendszam, honnan, hova, cel, kezdokm, zarokm, km, fogyasztas, uzemanyag, kep, kepnev,idoszak) VALUES ('{$safeUser}' ,'{$datum}', '{$kivRendszam}', '{$safeHonnan}', '{$safeHova}', '{$safeCel}', '{$kezdokm}', '{$zarokm}', '{$km}', '{$kivFogyasztas}', '{$kivUzemanyag}','{$safeKep}', '{$safeKepNev}','{$idoszak}')";
    $siker = mysqli_query($viapanServer, $ide);
      if (!$siker) { return "Not ok"; } else { return "ok"; }
  }
    ?>
  <?php
function getCegTelepByName ($ceg){
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$safeceg = mysqli_real_escape_string($viapanServer,$ceg);
$query = "SELECT * FROM cegek WHERE ceg = '{$safeceg}'";
$siker = mysqli_query($viapanServer,$query);
while ($telep = mysqli_fetch_assoc($siker)) {
$escape = $telep['telep'];
return $escape;
}
}
?>
<?php
function getCegDijByCeg($ceg){
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$safeceg = mysqli_real_escape_string($viapanServer,$ceg);
// $safeceg = iconv('utf-8', 'iso-8859-2',$safeceg);
$query = "SELECT * FROM cegek WHERE ceg = '{$safeceg}'";
$siker = mysqli_query($viapanServer,$query);
while ($telep = mysqli_fetch_assoc($siker)) {
$escape = $telep['dij'];
return $escape;
}
}
 ?>
<?php
function getCegByRendszam($rendszam) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $query = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
  $siker = mysqli_query($viapanServer,$query);
  while ($ceg = mysqli_fetch_assoc($siker)) {
  $escape = $ceg['ceg'];
  return $escape;
  }
  return $viapanServer->error;
}
 ?>

 <?php
function getCegTelepById($kolcsonID) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $query = "SELECT * FROM cegek WHERE id = '{$kolcsonID}'";
  $siker = mysqli_query($viapanServer,$query);
  while ($telep = mysqli_fetch_assoc($siker)) {
  $escape = $telep['telep'];
  return $escape;
  }
}
  ?>
  <?php
function getCegNameByID($kolcsonID) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $query = "SELECT * FROM cegek WHERE id = '{$kolcsonID}'";
  $siker = mysqli_query($viapanServer,$query);
  while ($nev = mysqli_fetch_assoc($siker)) {
  $escape = $nev['ceg'];
  return $escape;
  }
}
   ?>

<?php
function kilometerUpdate($kivRendszam,$zarokm,$datum,$userName) {
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$update = "UPDATE kilometer SET kilometer='{$zarokm}', datum='{$datum}', felhasznalo='{$userName}' WHERE rendszam='{$kivRendszam}'";
$siker = mysqli_query($viapanServer,$update);
}
 ?>
 <?php
function kilometerCheck ($kivRendszam, $kezdokm) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $check = "SELECT * FROM kilometer WHERE rendszam='{$kivRendszam}'";
  $checking = mysqli_query($viapanServer,$check);
  while ($eredmeny = mysqli_fetch_assoc($checking)) {
    $zaro = $eredmeny['kilometer'];

  }
  if ($zaro == null) {
  return false;
  }
  if ($zaro > $kezdokm) {
  return true;
} else {
  return false;
}
}
  ?>
  <?php
function utTorles($torlesID) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $torles = "DELETE FROM utak WHERE id='{$torlesID}'";
  $ini = mysqli_query($viapanServer,$torles);
}
?>
<?php
function ujKilometerMax($rendszamMax) {
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$rend = "SELECT * FROM utak WHERE rendszam = '{$rendszamMax}'";
$sik = mysqli_query($viapanServer, $rend);
while ($keres = mysqli_fetch_assoc($sik)) {
  $km = $keres['zarokm'];
}
if (!$km) {
  $km = 0;
}
    $update = "UPDATE kilometer SET kilometer='{$km}' WHERE rendszam='{$rendszamMax}'";
  $siker = mysqli_query($viapanServer,$update);

}
     ?>

<?php
 function piszkozatMentes($userName,$rendszam,$datum,$kolcsonbe,$honnan,$cel,$kezdokm){
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$safeUserName = mysqli_real_escape_string($viapanServer,$userName);
$rend = "INSERT INTO piszkozat (felhasznalo, rendszam, datum, kolcsonbe, honnan, cel, kezdokm) VALUES ('$userName', '$rendszam','$datum', '$kolcsonbe','$honnan','$cel','$kezdokm')";
$sik = mysqli_query($viapanServer, $rend);
if ($sik) {
  return "valami";
} else {
  return "jajj";
}
 }
 ?>
 <?php
 function piszkozatUpdate($felhasznalo,$rendszam,$datum,$kolcsonbe,$honnan,$cel,$zarokm) {
   $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
   $rend = "UPDATE piszkozat SET rendszam='{$rendszam}', datum='{$datum}', kolcsonbe='{$kolcsonbe}', honnan='{$honnan}', cel='{$cel}', kezdokm='{$zarokm}' WHERE felhasznalo='{$felhasznalo}'";
   $sik = mysqli_query($viapanServer, $rend);
   if ($sik) {
     return "valami";
   } else {
     return "jajj";
   }
 }
  ?>
  <?php
  function ujSzemelyAdat($vezeteknev,$keresztnev,$adoszam,$beosztas,$lakcim,$szuletesiido,$szuletesihely,$szolgalatihely,$alairo,$adminisztrator,$id,$email) {
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$svezeteknev = mysqli_real_escape_string($viapanServer,$vezeteknev);
$skeresztnev = mysqli_real_escape_string($viapanServer,$keresztnev);
$sbeosztas = mysqli_real_escape_string($viapanServer,$beosztas);
$slakcim = mysqli_real_escape_string($viapanServer,$lakcim);
$sszuletesihely = mysqli_real_escape_string($viapanServer,$szuletesihely);
$sszolgalatihely = mysqli_real_escape_string($viapanServer,$szolgalatihely);
if (gettype($alairo) == "integer") {
  /* ilyenkor nem kell tennünk vele semmit, mert akkor új embert rögzített, tehát annak
  az ID-ja van ott. Ilyenkor simán számként kerül be a helyére. */
} else {
  /* Ebben az esetben, vagy a már eleve ott szereplőt menti, vagy beírta a nevet nem fogadta el
  a data listben szereplő számot. Ki kell keresni, hogy ehhez a felhasználóhoz melyik ID tartozik */
  $alairo = mysqli_real_escape_string($viapanServer, $alairo);
  $alaQ = "SELECT * FROM felhasznalok WHERE felhasznalo = '{$alairo}'";
  $alaSendQ = mysqli_query($viapanServer, $alaQ); // alaQ a molekula :D
  while ($alaAdatok = mysqli_fetch_assoc($alaSendQ)) {
    $alairo = $alaAdatok['id'];
  }
}
  if (gettype($adminisztrator) == "integer") {
    /* ilyenkor nem kell tennünk vele semmit, mert akkor új embert rögzített, tehát annak
    az ID-ja van ott. Ilyenkor simán számként kerül be a helyére. */
  } else {
    /* Ebben az esetben, vagy a már eleve ott szereplőt menti, vagy beírta a nevet nem fogadta el
    a data listben szereplő számot. Ki kell keresni, hogy ehhez a felhasználóhoz melyik ID tartozik */
    $adminisztrator = mysqli_real_escape_string($viapanServer, $adminisztrator);
    $adminQ = "SELECT * FROM felhasznalok WHERE felhasznalo = '{$adminisztrator}'";
    $adminSendQ = mysqli_query($viapanServer, $adminQ); // alaQ a molekula :D
    while ($adminAdatok = mysqli_fetch_assoc($adminSendQ)) {
      $adminisztrator = $adminAdatok['id'];
    }

}

$q = "INSERT INTO szemelyadatok (felhasznaloid,vezeteknev,keresztnev,adoszam,beosztas,lakcim,szuletesiido,szuletesihely,szolgalatihely,alairoid,irodavezetoid,email) VALUES ('{$id}','{$svezeteknev}','{$skeresztnev}','{$adoszam}','{$sbeosztas}','{$slakcim}','{$szuletesiido}','{$sszuletesihely}','{$sszolgalatihely}','{$alairo}','{$adminisztrator}','{$email}')";
$do = mysqli_query($viapanServer, $q);
if ($do) {
  return "ok";
} else {
  return "$viapanServer->error";
}
}
   ?>
   <?php
   function szemelyAdatFrissit($vezeteknev,$keresztnev,$adoszam,$beosztas,$lakcim,$szuletesiido,$szuletesihely,$szolgalatihely,$alairo,$adminisztrator,$id,$email) {
 $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
 $svezeteknev = mysqli_real_escape_string($viapanServer,$vezeteknev);
 $skeresztnev = mysqli_real_escape_string($viapanServer,$keresztnev);
 $sbeosztas = mysqli_real_escape_string($viapanServer,$beosztas);
 $slakcim = mysqli_real_escape_string($viapanServer,$lakcim);
 $sszuletesihely = mysqli_real_escape_string($viapanServer,$szuletesihely);
 $sszolgalatihely = mysqli_real_escape_string($viapanServer,$szolgalatihely);
if (gettype($alairo) == "integer") {
  /* ilyenkor nem kell tennünk vele semmit, mert akkor új embert rögzített, tehát annak
  az ID-ja van ott. Ilyenkor simán számként kerül be a helyére. */
} else {
  /* Ebben az esetben, vagy a már eleve ott szereplőt menti, vagy beírta a nevet nem fogadta el
  a data listben szereplő számot. Ki kell keresni, hogy ehhez a felhasználóhoz melyik ID tartozik */
  $alairo = mysqli_real_escape_string($viapanServer, $alairo);
  $alaQ = "SELECT * FROM felhasznalok WHERE felhasznalo = '{$alairo}'";
  $alaSendQ = mysqli_query($viapanServer, $alaQ); // alaQ a molekula :D
  while ($alaAdatok = mysqli_fetch_assoc($alaSendQ)) {
    $alairo = $alaAdatok['id'];
  }
}
  if (gettype($adminisztrator) == "integer") {
    /* ilyenkor nem kell tennünk vele semmit, mert akkor új embert rögzített, tehát annak
    az ID-ja van ott. Ilyenkor simán számként kerül be a helyére. */
  } else {
    /* Ebben az esetben, vagy a már eleve ott szereplőt menti, vagy beírta a nevet nem fogadta el
    a data listben szereplő számot. Ki kell keresni, hogy ehhez a felhasználóhoz melyik ID tartozik */
    $adminisztrator = mysqli_real_escape_string($viapanServer, $adminisztrator);
    $adminQ = "SELECT * FROM felhasznalok WHERE felhasznalo = '{$adminisztrator}'";
    $adminSendQ = mysqli_query($viapanServer, $adminQ); // alaQ a molekula :D
    while ($adminAdatok = mysqli_fetch_assoc($adminSendQ)) {
      $adminisztrator = $adminAdatok['id'];
    }

}

 //
 $q = "UPDATE szemelyadatok SET vezeteknev = '{$svezeteknev}', keresztnev = '{$skeresztnev}', adoszam = '{$adoszam}', beosztas = '{$sbeosztas}',
 lakcim = '{$slakcim}', szuletesiido = '{$szuletesiido}', szuletesihely = '{$sszuletesihely}', szolgalatihely = '{$sszolgalatihely}', alairoid = '{$alairo}', irodavezetoid = '{$adminisztrator}', email = '{$email}' WHERE felhasznaloid = '{$id}'";
 $do = mysqli_query($viapanServer, $q);
 if ($do) {
   return "ok";
 } else {
   return "$viapanServer->error";
 }
 }
    ?>
<?php
function piszkozatKereso($userName) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $safeUserName = mysqli_real_escape_string($viapanServer,$userName);
  $piszkozatQuery = "SELECT * FROM piszkozat WHERE felhasznalo = '{$safeUserName}'";
  $kereses = mysqli_query($viapanServer, $piszkozatQuery);

  if (!$kereses) {
    return "nincs itt semmi $userName";
  } else {

while ($talalt = mysqli_fetch_assoc($kereses)) {
$user = $talalt['kolcsonbe'];
  }
  if (isset($user)) {
    return "$user";
  } else {
  return "nincs";
}
}
}
 ?>
<?php
function userValidate ($userName) {
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $userName = mysqli_real_escape_string($viapanServer,$userName);
  $validQ = "SELECT * FROM felhasznalok WHERE felhasznalo = '{$userName}'";
  $validate = mysqli_query($viapanServer, $validQ);
  $count = 0;
  while ($name = mysqli_fetch_assoc($validate)) {
    $count += 1;
  }
  if ($count > 0) {
    return false;
  } else {
    return true;
  }

}

 ?>
 <?php
function piszkozatRendszamKereso($userName){
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $safeUserName = mysqli_real_escape_string($viapanServer,$userName);
  $piszkozatQuery = "SELECT * FROM piszkozat WHERE felhasznalo = '{$safeUserName}'";
  $kereses = mysqli_query($viapanServer, $piszkozatQuery);

  if (!$kereses) {
    return "nincs itt semmi $userName";
  } else {

while ($talalt = mysqli_fetch_assoc($kereses)) {
$user = $talalt['rendszam'];
  }
  if (isset($user)) {
    return "$user";
  } else {
  return "nincs";
}
}
}
  ?>
  <?php
function kategoriaKereso($rendszam){
  $viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
  $query = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
  $siker = mysqli_query($viapanServer,$query);
  while ($kategoria = mysqli_fetch_assoc($siker)) {
  $escape = $kategoria['kategoria'];
  return $escape;
  }
}
   ?>
