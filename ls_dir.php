<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

require_once(realpath(__DIR__).'/req/lib_auth_idpw.php');

require_once(dirname(__FILE__).'/conf/index.php');
require_once(dirname(__FILE__).'/req/mp3tag_getid3.php');

if ( $_REQUEST['dirname'] != '' )       { $dirname = $_REQUEST['dirname'];
} elseif ( $_SESSION['dirname'] != '' ) { $dirname = $_SESSION['dirname'];
} else                              { $dirname = ''; }

if ( $_REQUEST['onlyname'] != '' )       { $onlyname = $_REQUEST['onlyname'];
} elseif ( $_SESSION['onlyname'] != '' ) { $onlyname = $_SESSION['onlyname'];
} else                                   { $onlyname = ''; }

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
$depth2 = 0;
if ($onlyname === '1') {
 getdirnametree($base_dir.$dirname);
} else {
 getdirtree($base_dir.$dirname);
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
   if (is_dir($rpath.'/'.$file)) {
    if ($depth2 <= $arguments['depth']) {
     $dirs[rawurlencode($rpath.'/'.$file)] = getdirtree($rpath.'/'.$file);
    }
   } elseif ( (is_file($rpath.'/'.$file)) && (stripos(realpath($rpath.'/'.$file), '.mp3') !== FALSE) ) {
    $r2path = str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', $rpath.'/');
    if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
     if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
      if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
       if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
        $getmp3info_parts = array();
        $getmp3info_parts = getmp3info(realpath($rpath.'/'.$file));
        $json = json_encode( 
         array(
          'track' => $i,
          'datasrc' => str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($rpath.'/'.$file)),
          'title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
          'favcheck' => rawurlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($rpath.'/'.$file))),
          'basename' => basename($rpath.'/'.$file),
          'id' => $id,
          'favnum' => '',
          'artistdirtmp' => str_replace(array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '/'.basename($rpath.'/'.$file)), array('', ''), realpath($rpath.'/'.$file)),
          'artist' => htmlspecialchars($getmp3info_parts[1], ENT_QUOTES),
          'album' => htmlspecialchars($getmp3info_parts[2], ENT_QUOTES),
          'number' => htmlspecialchars($getmp3info_parts[3], ENT_QUOTES),
          'genre' => htmlspecialchars($getmp3info_parts[4], ENT_QUOTES),
          'time_m' => htmlspecialchars( (($getmp3info_parts[5]<10)?('0'.$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES),
          'time_s' => htmlspecialchars( (($getmp3info_parts[6]<10)?('0'.$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES),
         ) 
        ); 
        output_chunk($json.str_repeat(' ', 8000)."\n");
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
   if (is_dir($rpath.'/'.$file)) {
    $r2path = str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', $rpath.'/');
    if ( ($arguments['filter_dir']=='') || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1)) ) {
     if (   ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1)) ) {
      $json = json_encode( 
       array(
        'id' => $i,
        'path' => $rpath.'/'.$file,
        'dirname' => basename($rpath.'/'.$file),
       ) 
      ); 
      output_chunk($json.str_repeat(' ', 8000)."\n");
      flush();
      $i++;
     }
    }
    getdirnametree($rpath.'/'.$file);
   }
  }
  closedir($handle);
 }
 return $dirs;
}
