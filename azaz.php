<?php
 function ido(){
  list($s, $ms) = explode(' ', microtime());

  return((float) $s + (float) $ms);
 }

 $ido = ido();

 $szamok = array();
 $szamok['0'] = 'nulla';
 $szamok['1'] = 'egy';
 $szamok['2'] = 'kettő';
 $szamok['3'] = 'három';
 $szamok['4'] = 'négy';
 $szamok['5'] = 'öt';
 $szamok['6'] = 'hat';
 $szamok['7'] = 'hét';
 $szamok['8'] = 'nyolc';
 $szamok['9'] = 'kilenc';
 $szamok['10'] = 'tíz';
 $szamok['20'] = 'húsz';
 $szamok['30'] = 'harminc';
 $szamok['40'] = 'negyven';
 $szamok['50'] = 'ötven';
 $szamok['60'] = 'hatvan';
 $szamok['70'] = 'hetven';
 $szamok['80'] = 'nyolcvan';
 $szamok['90'] = 'kilencven';
 $szamok['100'] = 'száz';
 $szamok['1000'] = 'ezer';
 $szamok['1000000'] = 'millió';
 $szamok['1000000000'] = 'milliárd';
 $szamok['1000000000000'] = 'trillió';
 $szamok['1000000000000000'] = 'quadrillió';
 $szamok['1000000000000000000'] = 'quintillió';
 $szamok['1000000000000000000000'] = 'sextrillió';
 $szamok['1000000000000000000000000'] = 'septrillió';
 $szamok['1000000000000000000000000000'] = 'oktrillió';

 function tortel($tort){
  global $tortek;

  $tortek[] = $tort;
  $tortek[] = 'tíz'.$tort;
  $tortek[] = 'szaz'.$tort;
 }

 $tortek = array();
 $tortek[] = 'tized';
 $tortek[] = 'szazad';

 tortel('ezred');
 tortel('millimod');
 tortel('milliardod');
 tortel('trilliomod');
 tortel('quadrilliomod');
 tortel('quintrilliomod');
 tortel('sextrilliomod');
 tortel('septrilliomod');
 tortel('oktrilliomod');

 function szam_1($szam, $darabszam = 0){
  global $szamok;

  if(!$szam)
   return($szamok['0']);
  if(($szam == '2') && ($darabszam & 1))
   return('két');
  return($szamok[$szam]);
 }

 function szam_2($szam, $darabszam = 0){
  global $szamok;

  if(!$szam[1])
   return($szamok[$szam[0].'0']);

  switch($szam[0]){
   case '1': $return = 'tizen'; break;
   case '2': $return = 'huszon'; break;
   default: $return = $szamok[$szam[0].'0']; break;
  }

  if($szam[1])
   $return .= szam_1($szam[1], $darabszam);
  return($return);
 }

 function szam_3($szam, $darabszam = 0){
  global $szamok;

  if(($szam[0] != '1') || ($darabszam & 2))
   $return = szam($szam[0], 1);
  @$return .= $szamok['100'];
  if($szam = intval($szam[1].$szam[2]))
   $return .= szam(strval($szam), $darabszam);
  return($return);
 }

 function szam_4($szam, $darabszam = 0){
  global $szamok;

  if((intval($szam) > 1999) || ($darabszam & 4))
   $return = szam(intval(substr($szam, -strlen($szam), strlen($szam) - 3)), 1);
  @$return .= $szamok['1000'];
  if($tmp = intval(substr($szam, -3, 3))){
   if(intval($szam) > 1999)
    $return .= ' - ';
   $return .= szam(strval($tmp), $darabszam);
  }
  return($return);
 }

 function szam_5($szam, $darabszam = 0){return szam_4($szam, $darabszam);}
 function szam_6($szam, $darabszam = 0){return szam_4($szam, $darabszam);}

 function _szam($szam, $darabszam = 0){
  global $szamok;

  $strlen = intval(strlen($szam) / 3) * 3;
  if($strlen == strlen($szam))
   $strlen -= 3;
  if(!($darabszam & 8))
   $return = szam(intval(substr($szam, 0, strlen($szam) - $strlen)), 1);
  if(($darabszam & 16) && preg_match('/^[0-9]0+$/', $szam))
   @$return .= ' ';
  @$return .= $szamok['1'.str_repeat('0', $strlen)];
  if(($tmp = szam(substr($szam, -$strlen), $darabszam)) && ($tmp != $szamok['0']))
   $return .= ' - '.$tmp;
  return($return);
 }

 function szam($szam, $darabszam = 0){
  if(!strlen($szam = preg_replace('/^0+0/', '0', $szam)))
   return(null);
  if($szam[0] == '-')
   return('mínusz '.szam(substr($szam, 1), $darabszam));
  if(count($tmp = preg_split('/\./', $szam, 2)) - 1){
   global $szamok, $tortek;

   $tort = @$tortek[strlen($tmp[1] = preg_replace('/0+$/', '', $tmp[1])) - 1];
   if(($tmp[1] = szam(intval($tmp[1]))) && ($tmp[1] != $szamok['0']))
    return szam($tmp[0]).' egész '.$tmp[1].' '.$tort;
   $szam = $tmp[0];
  }
  $szam = preg_replace('/^0+0/', '0', $szam);
  if(($tmp = strlen($szam)) < 7)
   return(call_user_func('szam_'.$tmp, $szam, $darabszam));
  return(_szam($szam,$darabszam));
 }
?>
