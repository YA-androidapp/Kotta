<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

if ( (isset($_SERVER['PHP_AUTH_USER'])) && ($_SERVER['PHP_AUTH_USER'] != '') ) {
 $id = $_SERVER['PHP_AUTH_USER'];
} elseif ( (isset($_SESSION['id'])) && ($_SESSION['id'] != '') ) {
 $id = $_SESSION['id'];
} elseif ( (isset($_COOKIE['id'])) && ($_COOKIE['id'] != '') ) {
 $id = $_COOKIE['id'];
} elseif ( (isset($_REQUEST['id'])) && ($_REQUEST['id'] != '') ) {
 $id = $_REQUEST['id'];
} else {
 $id = '';
}
if ( (isset($_SERVER['PHP_AUTH_PW'])) && ($_SERVER['PHP_AUTH_PW'] != '') ) {
 $pw = $_SERVER['PHP_AUTH_PW'];
} elseif ( (isset($_SESSION['pw'])) && ($_SESSION['pw'] != '') ) {
 $pw = $_SESSION['pw'];
} elseif ( (isset($_COOKIE['pw'])) && ($_COOKIE['pw'] != '') ) {
 $pw = $_COOKIE['pw'];
} elseif ( (isset($_REQUEST['pw'])) && ($_REQUEST['pw'] != '') ) {
 $pw = $_REQUEST['pw'];
} else {
 $pw = '';
}

$hashed_pwdfile = asep('pwd',$id.'_hashed.cgi');
$pwdfile = asep('pwd',$id.'.cgi');
if ( file_exists($hashed_pwdfile) ) {
 $tpassword = file_get_contents($hashed_pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r",' '), '', $tpassword);
 if ( ($pw !== '') && (hash("sha256",$pw) === $tpassword) ) {
  // echo "<!-- 認証されました auth_idpw-01 -->";
 } else {
  $otpfile = asep('pwd',$id.'_otp.cgi');
  if ( file_exists($otpfile) ) {
   $pwsub = substr($pw, 0, strlen($pw) - 6);
   if ( ( $pwsub !== '' ) && ( hash("sha256",$pwsub) === $tpassword ) ) {
    // echo "<!-- PW認証されました auth_idpw-02 -->";
   } else {
    if ( ! $throughAuth ) { die('PW認証できません auth_idpw-03'); }
   }
  } else {
   if ( ! $throughAuth ) { die('PW認証できません auth_idpw-04'); }
  }
 }
} else if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r",' '), '', $tpassword);

 // ハッシュが生成されていない初回認証時
 file_put_contents($hashed_pwdfile,hash("sha256",$tpassword));
 file_put_contents($pwdfile,""); // unlink(pwdfile);

 if ( ($pw !== '') && ($pw === $tpassword) ) {
  // echo "<!-- 認証されました auth_idpw-11 -->";
 } else {
  $otpfile = asep('pwd',$id.'_otp.cgi');
  if ( file_exists($otpfile) ) {
   $pwsub = substr($pw, 0, strlen($pw) - 6);
   if ( ( $pwsub !== '' ) && ( $pwsub === $tpassword ) ) {
    // echo "<!-- PW認証されました auth_idpw-12 -->";
   } else {
    if ( ! $throughAuth ) { die('PW認証できません auth_idpw-13'); }
   }
  } else {
   if ( ! $throughAuth ) { die('PW認証できません auth_idpw-14'); }
  }
 }
} else {
 if ( ! $throughAuth ) { die('PW認証できません auth_idpw-15'); }
}
// echo "<!-- IDPW End -->";
$_SESSION['id'] = $id;
$_SESSION['pw'] = $pw;
