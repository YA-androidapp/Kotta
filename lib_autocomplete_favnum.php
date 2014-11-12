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
require_once('conf/index.php');
if ( $enable_autocomplete_favnum == 0 ) { die(''); }
$pwdfile = 'pwd/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( ($pw !== '') && ($pw === $tpassword) ) {
  $base_dirfav = 'fav/'; // $favfile = 'fav/'.$pname.'/'.$id.'_'.$arguments['favnum'].'.cgi';
  $favnumarr = glob($base_dirfav.'/'.$id.'_*.cgi');
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
