<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

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
if ( $_REQUEST['term'] != '' ) {
 $term = $_REQUEST['term'];
} elseif ( $_SESSION['term'] != '' ) {
 $term = $_SESSION['term'];
} else {
 $term = '';
}

require_once(realpath(__DIR__).'/conf/index.php');
if ( $enable_autocomplete_favnum == 0 ) { die(''); }
$pwdfile = 'pwd/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( ($pw !== '') && ($pw === $tpassword) ) {
  $favnumarr = glob($base_dirfav.$id.'_*.cgi');
  $keywords = array();
  foreach ($favnumarr as $val) {
   $val2 = basename($val);
   $val2 = str_replace($id.'_', '', $val2);
   $val2 = str_replace('.cgi', '', $val2);
   $keywords[$val2] = $val2;
  }
  array_walk(
   $keywords,
   function($value, $key) {
    global $base_dir, $result,$term;
    if (mb_strpos(strtolower($key), strtolower($term)) === 0) {
     $result[] = array('id' => $value,
                       'label' => $key,
                       'value' => $key
                      );
    }
   });
  print(json_encode($result));

 }
}
