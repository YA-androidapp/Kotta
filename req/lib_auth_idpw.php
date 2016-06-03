<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

if ( (isset($_SERVER['PHP_AUTH_USER'])) && ($_SERVER['PHP_AUTH_USER'] != '') ) {
 $id = $_SERVER['PHP_AUTH_USER']; $_SESSION['id'] = $id;
} elseif ( (isset($_SESSION['id'])) && ($_SESSION['id'] != '') ) {
 $id = $_SESSION['id'];
} elseif ( (isset($_COOKIE['id'])) && ($_COOKIE['id'] != '') ) {
 $id = $_COOKIE['id']; $_SESSION['id'] = $id;
} elseif ( (isset($_REQUEST['id'])) && ($_REQUEST['id'] != '') ) {
 $id = $_REQUEST['id']; $_SESSION['id'] = $id;
} else {
 $id = '';
}
if ( (isset($_SERVER['PHP_AUTH_PW'])) && ($_SERVER['PHP_AUTH_PW'] != '') ) {
 $pw = $_SERVER['PHP_AUTH_PW']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_SESSION['pw'])) && ($_SESSION['pw'] != '') ) {
 $pw = $_SESSION['pw'];
} elseif ( (isset($_COOKIE['pw'])) && ($_COOKIE['pw'] != '') ) {
 $pw = $_COOKIE['pw']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_REQUEST['pw'])) && ($_REQUEST['pw'] != '') ) {
 $pw = $_REQUEST['pw']; $_SESSION['pw'] = $pw;
} else {
 $pw = '';
}

$pwdfile = 'pwd/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r",' '), '', $tpassword);
 if ( ($pw !== '') && ($pw === $tpassword) ) {
  echo "<!-- 認証されました auth_idpw-01 -->";
 } else {
  $otpfile = 'pwd/'.$id.'_otp.cgi';
  if ( file_exists($otpfile) ) {
   $pwsub = substr($pw, 0, strlen($pw) - 6);echo $pw."##".$pwsub."**".$tpassword;
   if ( ( $pwsub !== '' ) && ( $pwsub === $tpassword ) ) {
    echo "<!-- 認証されました auth_idpw-02 -->";
   } else {
    if ( ! $throughAuth ) { die('認証できません auth_idpw-05'); }
   }
  } else {
   if ( ! $throughAuth ) { die('認証できません auth_idpw-04'); }
  }
 }
} else {
 if ( ! $throughAuth ) { die('認証できません auth_idpw-03'); }
}
echo "<!-- IDPW End -->";
