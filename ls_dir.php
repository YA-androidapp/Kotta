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

  if ( $_REQUEST['dir'] != '' )       { $dir = $_REQUEST['dir'];
  } elseif ( $_SESSION['dir'] != '' ) { $dir = $_SESSION['dir'];
  } else                                 { $dir = ''; }

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
  // // ob_flush();
  flush();
  $i = 0;
  $depth2 = 0;
  getdirtree($base_dir.$dir);
  echo "0\r\n\r\n";
 }
}

function getdirtree($path){
 global $arguments, $base_dir, $base_uri, $confs, $depth2, $i, $id, $pw2;
 $rpath = realpath($path);
 $dirs = array();
 if ($handle = opendir($rpath)) {
  $depth2++;
  while (false !== ($file = readdir($handle))) {
   if ('.' == $file || '..' == $file) { continue; }
   if (is_dir($rpath.'/'.$file)) {
    if ($depth2 <= $arguments['depth']) {
     $dirs[urlencode($rpath.'/'.$file)] = getdirtree($rpath.'/'.$file);
    }
   } elseif ( (is_file($rpath.'/'.$file)) && (stripos(realpath($rpath.'/'.$file), '.mp3') !== FALSE) ) {
    $r2path = str_replace($base_dir.'/', '', $rpath);
    if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
     if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
      if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
       if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
        $getmp3info_parts = array();
        $getmp3info_parts = getmp3info(realpath($rpath.'/'.$file));
        $json = json_encode( 
         array(
          "track" => $i,
          "datasrc" => str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($rpath.'/'.$file)),
          "title" => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
          "favcheck" => urlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($rpath.'/'.$file))),
          "basename" => basename($rpath.'/'.$file),
          "id" => $id,
          "pw2" => $pw2,
          "favnum" => "",
          "artistdirtmp" => str_replace(array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '/'.basename($rpath.'/'.$file)), array('', ''), realpath($rpath.'/'.$file)),
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
     }
    }
   }
  }
  $depth2--;
  closedir($handle);
 }
 return $dirs;
}