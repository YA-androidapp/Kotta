<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);
require_once(dirname(__FILE__).'/conf/index.php');

if ( $_REQUEST['id'] != '' )        { $id = $_REQUEST['id'];
} elseif ( $_SESSION['id'] != '' )  { $id = $_SESSION['id'];
} else                              { $id = ''; }
if ( $_REQUEST['pw'] != '' )        { $pw = $_REQUEST['pw'];
} elseif ( $_SESSION['pw'] != '' )  { $pw = $_SESSION['pw'];
} else                              { $pw = ''; }
if ( $_REQUEST['pw2'] != '' )       { $pw2 = $_REQUEST['pw2'];
} elseif ( $_SESSION['pw2'] != '' ) { $pw2 = $_SESSION['pw2']; }

$pname = str_replace('.php', '', basename($_SERVER['SCRIPT_NAME']));
require_once('conf/index.php');
require_once(dirname(__FILE__).'/req/mp3tag_getid3.php');
$pwdfile = 'pwd/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( (($pw !== '') && ($pw === $tpassword)) || (($pw !== '') && ($pw2 === sha1($tpassword))) ) {
  $pw2 = sha1($pw);

  if ( $_REQUEST['favnum'] != '' )       { $favnum = $_REQUEST['favnum'];
  } elseif ( $_SESSION['favnum'] != '' ) { $favnum = $_SESSION['favnum'];
  } else                                 { $favnum = ''; }

  $line = file('fav/'.$id.'_'.$favnum.'.cgi', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

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
  foreach ($line as $value) {
   if (!is_array($value)) {
    $getmp3info_parts = array();
    $getmp3info_parts = getmp3info(realpath($value));
    $json = json_encode( 
     array(
      "track" => $i,
      "datasrc" => str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($value)),
      "title" => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
      "favcheck" => urlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))),
      "basename" => basename($value),
      "id" => $id,
      "pw2" => $pw2,
      "favnum" => $favnum,
      "artistdirtmp" => str_replace(array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '/'.basename($value)), array('', ''), realpath($value)),
      "artist" => htmlspecialchars($getmp3info_parts[1], ENT_QUOTES),
      "album" => htmlspecialchars($getmp3info_parts[2], ENT_QUOTES),
      "number" => htmlspecialchars($getmp3info_parts[3], ENT_QUOTES),
      "genre" => htmlspecialchars($getmp3info_parts[4], ENT_QUOTES),
      "time_m" => htmlspecialchars( (($getmp3info_parts[5]<10)?("0".$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES),
      "time_s" => htmlspecialchars( (($getmp3info_parts[6]<10)?("0".$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES),
     ) 
    ); 
    output_chunk($json.str_repeat(' ', 8000)."\n");
    // ob_flush();
    flush();
    $i++;
   }
  }
  echo "0\r\n\r\n";
 }
}
