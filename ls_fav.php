<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

require_once(realpath(__DIR__).'/req/lib_auth_idpw.php');

require_once(dirname(__FILE__).'/conf/index.php');
require_once(dirname(__FILE__).'/req/lib_get_new_files.php');
require_once(dirname(__FILE__).'/req/mp3tag_getid3.php');

if ( $_REQUEST['dirname'] != '' )       { $dirname = $_REQUEST['dirname'];
} elseif ( $_SESSION['dirname'] != '' ) { $dirname = $_SESSION['dirname'];
} else                                  { $dirname = ''; }

if ( $_REQUEST['favname'] != '' )       { $favname = $_REQUEST['favname'];
} elseif ( $_SESSION['favname'] != '' ) { $favname = $_SESSION['favname'];
} else                                  { $favname = ''; }

if ( $_REQUEST['onlyname'] != '' )       { $onlyname = $_REQUEST['onlyname'];
} elseif ( $_SESSION['onlyname'] != '' ) { $onlyname = $_SESSION['onlyname'];
} else                                   { $onlyname = ''; }

if ( $onlyname == '1' ) {
 $line = glob($base_dirfav.$id.'_*.cgi');
 $line[] = $base_dirfav.$id.'__recently_added.cgi';
} elseif ( $favname === '_recently_added' ) {
  $line = getNewFiles($base_dir.(($dirname!=='')?((mb_substr($base_dir,-1)=='/')?'':'/').$dirname:''));
} else {
  $line = file('fav/'.$id.'_'.$favname.'.cgi', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
}
@ini_set('zlib.output_compression', 'Off');
@ini_set('output_buffering', 'Off');
@ini_set('output_handler', '');
@apache_setenv('no-gzip', 1);
function output_chunk($chunk) {
 echo sprintf("%x\r\n", strlen($chunk));
 echo $chunk."\r\n";
}
header('Content-type: application/octet-stream');
header('Transfer-encoding: chunked');
flush();
$i = 0;
foreach ($line as $value) {
 if ( $onlyname == '1' ) {
  $json = json_encode( 
   array(
    'id' => $i, 
    'favname' => str_replace('.cgi', '', str_replace($id.'_', '', basename($value)))
   ) 
  ); 
 } else {
  if (!is_array($value)) {
   $getmp3info_parts = array();
   $getmp3info_parts = getmp3info(realpath($value));
   $json = json_encode( 
    array(
     'track' => $i,
     'datasrc' => str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($value)),
     'title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
     'favcheck' => rawurlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))),
     'basename' => basename($value),
     'id' => $id,
     'favname' => $favname,
     'artistdirtmp' => str_replace(array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '/'.basename($value)), array('', ''), realpath($value)),
     'artist' => htmlspecialchars($getmp3info_parts[1], ENT_QUOTES),
     'album' => htmlspecialchars($getmp3info_parts[2], ENT_QUOTES),
     'number' => htmlspecialchars($getmp3info_parts[3], ENT_QUOTES),
     'genre' => htmlspecialchars($getmp3info_parts[4], ENT_QUOTES),
     'time_m' => htmlspecialchars( (($getmp3info_parts[5]<10)?('0'.$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES),
     'time_s' => htmlspecialchars( (($getmp3info_parts[6]<10)?('0'.$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES),
    )
   );
  }
 }
 output_chunk($json.str_repeat(' ', 8000)."\n");
 flush();
 $i++;
}
echo "0\r\n\r\n";
