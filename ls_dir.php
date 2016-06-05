<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

require_once(realpath(__DIR__).DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'lib_io.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_idpw.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_otp.php');

require_once(arsep(__DIR__,'conf').DSEP.'index.php');
require_once(arsep(__DIR__,'req').DSEP.'mp3tag_getid3.php');

if ( $_REQUEST['dirname'] != '' )       { $dirname = $_REQUEST['dirname'];
} elseif ( $_SESSION['dirname'] != '' ) { $dirname = $_SESSION['dirname'];
} else                                  { $dirname = ''; }

if ( $_REQUEST['onlyname'] != '' )       { $onlyname = $_REQUEST['onlyname'];
} elseif ( $_SESSION['onlyname'] != '' ) { $onlyname = $_SESSION['onlyname'];
} else                                   { $onlyname = ''; }

if ( $_GET['makem3u'] != '' )        { $makem3u = $_GET['makem3u'];
} elseif ( $_POST['makem3u'] != '' ) { $makem3u = $_POST['makem3u'];
} else                               { $makem3u = ''; }

@ini_set('zlib.output_compression', 'Off');
@ini_set('output_buffering', 'Off');
@ini_set('output_handler', '');
@apache_setenv('no-gzip', 1);
function output_chunk($chunk) {
 echo sprintf("%x\r\n", strlen($chunk));
 echo $chunk."\r\n";
}

if ( !empty($makem3u) ) {
 header('Content-Type: audio/x-mpegurl');
 header('Accept-Ranges: bytes');
 header('Content-Disposition: attachment; filename='.$dirname.'.m3u');
 echo ($makem3u==='2') ? '#EXTM3U'."\n\n" : '';
} else {
 if (DIRECTORY_SEPARATOR != '\\') {
  header('Content-type: application/octet-stream');
  header('Transfer-encoding: chunked');
}
}

flush();
$i = 0;
$depth2 = 0;
if ($onlyname === '1') {
 getdirnametree(arsep(arsep($base_dir,$dirname),''));
} else {
 getdirtree(arsep(arsep($base_dir,$dirname),''));
}
echo "0\r\n\r\n";

function getdirtree($path){
 global $arguments, $base_dir, $base_uri, $confs, $depth2, $i, $id;
 $rpath = realpath($path);
 $dirs = array();
 if ($handle = opendir($rpath)) {
  $depth2++;
  while (false !== ($file = readdir($handle))) {
   if ('.' == $file || '..' == $file) { continue; }
   $rfile = arsep($rpath,$file);
   if (is_dir(asep($rpath,$file))) {
    if ($depth2 <= $arguments['depth']) {
     $dirs[rawurlencode($rfile)] = getdirtree($rfile);
   }
 } elseif ( (is_file($rfile)) && (stripos(realpath($rfile), '.mp3') !== FALSE) ) {
  $r2path = str_replace(arsep($base_dir,''), '', asep($rpath,''));
  if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
   if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
    if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
     if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
      $getmp3info_parts = array();
      $getmp3info_parts = getmp3info(realpath($rfile));
      if ( !empty($makem3u) ) {
       echo ($makem3u==='2') ? '#EXTINF:'.($getmp3info_parts[5] * 60 + $getmp3info_parts[6]).','.$getmp3info_parts[0]."\n" : '';
       echo (empty($_SERVER['HTTPS'])?'http://':'https://').$_SERVER['HTTP_HOST'].str_replace($base_dir, $base_uri , realpath($rfile))."\n";
     } else {
       $json = json_encode(
        array(
         'track' => $i,
         'datasrc' => str_replace('\\','/',str_replace(arsep($base_dir,''), $base_uri, realpath($rfile))),
         'title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
         'favcheck' => rawurlencode(str_replace(arsep($base_dir,''), '', realpath($rfile))),
         'basename' => basename($rfile),
         'id' => $id,
         'favnum' => '',
         'artistdirtmp' => str_replace(array(arsep($base_dir,''), DSEP.basename($rfile)), array('', ''), realpath($rfile)),
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
}
}
}
$depth2--;
closedir($handle);
}
return $dirs;
}

function getdirnametree($path){
 global $arguments, $base_dir, $base_uri, $confs, $depth2, $i, $id;
 $rpath = realpath($path);
 $dirs = array();
 if ($handle = opendir($rpath)) {
  while (false !== ($file = readdir($handle))) {
   if ('.' == $file || '..' == $file) { continue; }
   $rfile = arsep($rpath,$file);
   if (is_dir($rfile)) {
    $r2path = str_replace(arsep($base_dir,''), '', asep($rpath,""));
    if ( ($arguments['filter_dir']=='') || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1)) ) {
     if (   ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1)) ) {
      $json = json_encode(
       array(
        'id' => $i,
        'path' => $rfile,
        'dirname' => basename($rfile),
        )
       );
      output_chunk($json.str_repeat(' ', 8000)."\n");
      flush();
      $i++;
    }
  }
  getdirnametree($rfile);
}
}
closedir($handle);
}
return $dirs;
}
