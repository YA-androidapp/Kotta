<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

if ( $_REQUEST['id'] != '' )       { $id = $_REQUEST['id'];
} elseif ( $_SESSION['id'] != '' ) { $id = $_SESSION['id'];
} else                             { $id = ''; }
if ( $_REQUEST['pw'] != '' )       { $pw = $_REQUEST['pw'];
} elseif ( $_SESSION['pw'] != '' ) { $pw = $_SESSION['pw'];
} else                             { $pw = ''; }

$pname = str_replace('.php', '', basename($_SERVER['SCRIPT_NAME']));
require_once('conf/'.$pname.'_conf.php');
if ( $enable_autocomplete_dir == 0 ) { die(''); }
$pwdfile = 'pwd/'.$pname.'/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( ($pw !== '') && ($pw === $tpassword) ) {

  require_once('req/lib_getdirtree_flat.php');
  $dirs = array();
  $arguments['depth'] = mb_substr_count($_REQUEST['bdir'].'/'.$_REQUEST['term'], '/') + 1;
  $keywords = getdirtree_flat(realpath($base_dir.'/'.$_REQUEST['bdir']), 'dir');
  $keywords2 = array();
  foreach ($keywords as $k => $v) {
   $keywords2[str_replace(realpath($base_dir.'/'.$_REQUEST['bdir']).'/', '', urldecode($v))] = str_replace(realpath($base_dir.'/'.$_REQUEST['bdir']).'/', '', urldecode($v));
  }

  array_walk(
   $keywords2,
   function($value, $key) {
    global $base_dir, $result;
    if (mb_strpos(strtolower($key), strtolower($_REQUEST['term'])) === 0) {
     $result[] = array('id' => $value,
                       'label' => $key,
                       'value' => $key
                      );
    }
   });
  print(json_encode($result));

 }
}
