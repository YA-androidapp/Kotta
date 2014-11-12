<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);
require_once(dirname(__FILE__).'/conf/index.php');

if ( $_REQUEST['id'] != '' )       { $id = $_REQUEST['id'];
} elseif ( $_SESSION['id'] != '' ) { $id = $_SESSION['id'];
} else                             { $id = ''; }
if ( $_REQUEST['pw'] != '' )       { $pw = $_REQUEST['pw'];
} elseif ( $_SESSION['pw'] != '' ) { $pw = $_SESSION['pw'];
} else                             { $pw = ''; }
if ( $_REQUEST['pw2'] != '' )       { $pw2 = $_REQUEST['pw2'];
} elseif ( $_SESSION['pw2'] != '' ) { $pw2 = $_SESSION['pw2']; }

$pname = str_replace('.php', '', basename($_SERVER['SCRIPT_NAME']));
require_once('conf/index.php');
$pwdfile = 'pwd/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( (($pw !== '') && ($pw === $tpassword)) || (($pw !== '') && ($pw2 === sha1($tpassword))) ) {
  $pw2 = sha1($pw);

  $base_dirfav = 'fav/';
  $favnumarr = glob($base_dirfav.'/'.$id.'_*.cgi');

  $keywords = array();

  @ini_set('zlib.output_compression', 'Off');
  @ini_set('output_buffering', 'Off');
  @ini_set('output_handler', '');
  @apache_setenv('no-gzip', 1);
  function output_chunk($chunk) {
   echo sprintf("%x\r\n", strlen($chunk));
   echo $chunk."\r\n";
  }
  header("Content-type: application/octet-stream");
  header("Transfer-encoding: chunked");
  // ob_flush();
  flush();
  $i = 0;
  foreach ($favnumarr as $val) {
   $json = json_encode( 
    array(
     "id" => $i, 
     "favnum" => str_replace('.cgi', '', str_replace($id.'_', '', basename($val)))
    ) 
   ); 
   output_chunk($json.str_repeat(' ', 8000)."\n");
   // ob_flush();
   flush();
   $i++;
  }
  echo "0\r\n\r\n";
 }
}
