<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

require_once(realpath(__DIR__).DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'lib_io.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_idpw.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_otp.php');
require_once(arsep(__DIR__,'conf').DSEP.'index.php');

if ( $_REQUEST['mode'] == 'fav' ) {
   $mode = 'fav';
   if ( $enable_autocomplete_favname == 0 ) { die(''); }
} elseif ( $_SESSION['mode'] == 'fav' ) {
   $mode = 'fav';
   if ( $enable_autocomplete_favname == 0 ) { die(''); }
} else {
   $mode = 'dir';
   if ( $enable_autocomplete_dirname == 0 ) { die(''); }
}

if ( $_REQUEST['bdir'] != '' ) {
   $bdir = $_REQUEST['bdir'];
} elseif ( $_SESSION['bdir'] != '' ) {
   $bdir = $_SESSION['bdir'];
} else {
   $bdir = '';
}
if ( $_REQUEST['term'] != '' ) {
   $term = $_REQUEST['term'];
} elseif ( $_SESSION['term'] != '' ) {
   $term = $_SESSION['term'];
} else {
   $term = '';
}

$keywords = array();
if ( $mode == 'fav' ) {
   $keyword = glob($base_dirfav.$id.'_*.cgi');
   foreach ($keyword as $v) {
      $v2 = basename($v);
      $v2 = str_replace($id.'_', '', $v2);
      $v2 = str_replace('.cgi', '', $v2);
      $keywords[$v2] = $v2;
  }
} elseif ( $mode == 'dir' ) {
   require_once(arsep(__DIR__,'').asep('req','').'lib_getdirtree_flat.php');
   $arguments['depth'] = mb_substr_count(asep($bdir,$term), DSEP) + 1;
   $keyword = getdirtree_flat(asep(realpath(arsep($base_dir,$bdir)),''), 'dir');
   foreach ($keyword as $k => $v) {
      $keywords[str_replace(asep(realpath(arsep($base_dir,$bdir)),''), '', urldecode($v))] = str_replace(asep(realpath(arsep($base_dir,$bdir)),''), '', urldecode($v));
  }
}

array_walk(
   $keywords,
   function($value, $key) {
      global $base_dir, $result, $term;
      if (mb_strpos(strtolower($key), strtolower($term)) === 0) {
         $result[] = array('id' => $value,
           'label' => $key,
           'value' => $key
           );
     }
 });
print(json_encode($result));
