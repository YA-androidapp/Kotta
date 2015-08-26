<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

if ( isset($pwdfile) == false ) { require_once(dirname(__FILE__).'/req/lib_auth_idpw.php'); }

if ( (isset($_REQUEST['pw2'])) && ($_REQUEST['pw2'] != '') ) {
 $pw2 = $_REQUEST['pw2']; $_SESSION['pw2'] = $pw2;
// } elseif ( (isset($_SESSION['pw2'])) && ($_SESSION['pw2'] != '') ) {
//  $pw2 = $_SESSION['pw2'];
// } elseif ( (isset($_COOKIE['pw2'])) && ($_COOKIE['pw2'] != '') ) {
//  $pw2 = $_COOKIE['pw2']; $_SESSION['pw2'] = $pw2;
} else {
 $pw2 = '';
}
if ( (isset($_REQUEST['otppwauthed'])) && ($_REQUEST['otppwauthed'] != '') ) {
 // force reset
 $_SESSION['otppwauthed'] = '';
}

$otpfile = 'pwd/'.$id.'_otp.cgi';
if ( file_exists($otpfile) ) {
 // echo 'OTP認証が有効';
 $totpkey = file_get_contents($otpfile);
 $totpkey = str_replace(array("\r\n","\n","\r",' '), '', $totpkey);
 require_once(realpath(__DIR__).'/ga.php');
 $otp = Google2FA::oath_hotp(Google2FA::base32_decode($totpkey), Google2FA::get_timestamp());
 // echo 'otp: '.$otp.' totpkey: '.$totpkey.' time: '.Google2FA::get_timestamp();
 if ( $_SESSION['otppwauthed'] === 'otppwauthed' ) {
  // echo 'OTP認証に成功(再)';
  ;
 } elseif ( Google2FA::verify_key($totpkey, $pw2) ) {
  // echo 'OTP認証に成功';
  $_SESSION['otppwauthed'] = 'otppwauthed';
  ;
 } else {
  // echo 'OTP認証に失敗';
  require_once(realpath(__DIR__).'/lib_menu.php');die(' auth_idpw-01');
 }
}
