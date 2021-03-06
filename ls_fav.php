<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

require_once(realpath(__DIR__).DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'lib_io.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_idpw.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_otp.php');

require_once(arsep(__DIR__,'conf').DSEP.'index.php');

require_once(arsep(__DIR__,'req').DSEP.'lib_get_new_files.php');
require_once(arsep(__DIR__,'req').DSEP.'mp3tag_getid3.php');

if ( $_REQUEST['dirname'] != '' )       { $dirname = $_REQUEST['dirname'];
} elseif ( $_SESSION['dirname'] != '' ) { $dirname = $_SESSION['dirname'];
} else                                  { $dirname = ''; }

if ( $_REQUEST['relapath'] != '' )       { $relapath = $_REQUEST['relapath'];
} elseif ( $_SESSION['relapath'] != '' ) { $relapath = $_SESSION['relapath'];
} else                                  { $relapath = ''; }

if ( $_REQUEST['favname'] != '' )       { $favname = $_REQUEST['favname'];
} elseif ( $_SESSION['favname'] != '' ) { $favname = $_SESSION['favname'];
} else                                  { $favname = ''; }

if ( $_REQUEST['onlyname'] != '' )       { $onlyname = $_REQUEST['onlyname'];
} elseif ( $_SESSION['onlyname'] != '' ) { $onlyname = $_SESSION['onlyname'];
} else                                   { $onlyname = ''; }

if ( $_GET['makem3u'] != '' )        { $makem3u = $_GET['makem3u'];
} elseif ( $_POST['makem3u'] != '' ) { $makem3u = $_POST['makem3u'];
} else                               { $makem3u = ''; }

if ( $onlyname == '1' ) {
 $line = glob($base_dirfav.$id.'_*.cgi');
 $line[] = $base_dirfav.$id.'__recently_added.cgi';
} elseif ( $favname === '_recently_added' ) {
  $line = getNewFiles(($dirname!=='')?(arsep($base_dir,$dirname)):(arsep($base_dir,'')));
} else {
  $line = file(asep('fav',$id.'_'.$favname.'.cgi'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
}
@ini_set('zlib.output_compression', 'Off');
@ini_set('output_buffering', 'Off');
@ini_set('output_handler', '');
@apache_setenv('no-gzip', 1);
function output_chunk($chunk) {
 echo sprintf("%x\r\n", strlen($chunk));
 echo $chunk."\r\n";
}

if ( $makem3u !== '' ) {
 header('Content-Type: audio/x-mpegurl');
 header('Accept-Ranges: bytes');
 header('Content-Disposition: attachment; filename='.$favname.'.m3u');
 echo ($makem3u==='2') ? '#EXTM3U'."\n\n" : '';
} else if (DIRECTORY_SEPARATOR != '\\') {
  header('Content-type: application/octet-stream');
  header('Transfer-encoding: chunked');
}

flush();
$i = 0;
foreach ($line as $value) {
 if ( $onlyname == '1' ) {
   $getmp3info_parts = array();
   $getmp3info_parts = getmp3info(arsep($base_dir,$relapath));
   $json = json_encode(
     array(
      'id' => $i,
      'favname' => str_replace('.cgi', '', str_replace($id.'_', '', basename($value))),
      'hassong' => (($relapath == '') ? (false) :
        (
          (true == in_array(arsep($base_dir,$relapath), file($value, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES )))
        ||
          (true == in_array(str_replace('/','\\',arsep($base_dir,$relapath)), file($value, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES )))
        )
        ),
      'relapath' => rawurlencode($relapath),
      'title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
      )
     );
   output_chunk($json.str_repeat(' ', 8000)."\n");
 } else {
  if (!is_array($value)) {
   $getmp3info_parts = array();
   $getmp3info_parts = getmp3info(realpath($value));
   if ( $makem3u !== '' ) {
    echo ($makem3u==='2') ? '#EXTINF:'.($getmp3info_parts[5] * 60 + $getmp3info_parts[6]).','.$getmp3info_parts[0]."\n" : '';
    echo (empty($_SERVER['HTTPS'])?'http://':'https://').$_SERVER['HTTP_HOST'].str_replace($base_dir, $base_uri , realpath($value))."\n";
  } else {
    $json = json_encode(
     array(
      'track' => $i,
      'datasrc' => str_replace('\\','/',str_replace(arsep($base_dir,''), $base_uri, realpath($value))),
      'title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
      'relapath' => rawurlencode(str_replace('\\','/',str_replace(arsep($base_dir,''), '', realpath($value)))),
      'basename' => basename($value),
      'id' => $id,
      'favname' => $favname,
      'artistdirtmp' => str_replace(array(arsep($base_dir,''), DSEP.basename($value)), array('', ''), realpath($value)),
      'artist' => htmlspecialchars($getmp3info_parts[1], ENT_QUOTES),
      'album' => htmlspecialchars($getmp3info_parts[2], ENT_QUOTES),
      'number' => htmlspecialchars($getmp3info_parts[3], ENT_QUOTES),
      'genre' => htmlspecialchars($getmp3info_parts[4], ENT_QUOTES),
      'time_m' => htmlspecialchars( (($getmp3info_parts[5]<10)?('0'.$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES),
      'time_s' => htmlspecialchars( (($getmp3info_parts[6]<10)?('0'.$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES),
      )
     );
    output_chunk($json.str_repeat(' ', 8000)."\n");
  }
  flush();
  $i++;
}
}
}
echo "0\r\n\r\n";
