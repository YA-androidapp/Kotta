<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);

require_once(realpath(__DIR__).DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'lib_io.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_idpw.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_otp.php');

require_once(arsep(__DIR__,'conf').DSEP.'index.php');
require_once(arsep(__DIR__,'req').DSEP.'mp3tag_getid3.php');

if ( $_REQUEST['sqlwhere'] != '' )         { $sqlwhere = $_REQUEST['sqlwhere'];
} elseif ( $_SESSION['sqlwhere'] != '' )   { $sqlwhere = $_SESSION['sqlwhere'];
} else                                     { $sqlwhere = 'title'; }
if ( $_REQUEST['sqllike'] != '' )          { $sqllike  = $_REQUEST['sqllike'];
} elseif ( $_SESSION['sqllike'] != '' )    { $sqllike  = $_SESSION['sqllike'];
} else                                     { $sqllike  = '4SEASONs'; }

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

if ( $makem3u !== '' ) {
 header('Content-Type: audio/x-mpegurl');
 header('Accept-Ranges: bytes');
 header('Content-Disposition: attachment; filename='.$favname.'.m3u');
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
getarr($sqlwhere,$sqllike);
echo "0\r\n\r\n";

function getarr($sqlwhere,$sqllike){
 global $arguments, $confs, $id;

 // title, basename, artist, album, number, genre
 if( ($sqlwhere!='title') &&($sqlwhere!='basename') &&($sqlwhere!='artist') &&($sqlwhere!='album') &&($sqlwhere!='number') &&($sqlwhere!='genre') ){
  $sqlwhere='title';
}

try {
  $db = new PDO('sqlite:'.asep('.','').asep('conf','').$confs['dbfilename']);
  $sql = 'SELECT * FROM musics WHERE '.$sqlwhere.' LIKE ?';
  $sth = $db->prepare($sql);
  $sth->execute(array('%'.$sqllike.'%'));
  while ($line = @$sth->fetch(PDO::FETCH_ASSOC)) {

   if ( $makem3u !== '' ) {
    echo ($makem3u==='2') ? '#EXTINF:'.($getmp3info_parts[5] * 60 + $getmp3info_parts[6]).','.$getmp3info_parts[0]."\n" : '';
    echo ((empty($_SERVER['HTTPS']))?(str_replace('https://','http://',$line['datasrc'])):(str_replace('http://','https://',$line['datasrc'])))."\n";
  } else {

    $json = json_encode(
     array(
      'track' => $line['i'],
      'datasrc' => $line['datasrc'],
      'title' => $line['title'],
      'relapath' => $line['relapath'],
      'basename' => $line['basename'],
      'id' => $id,
      'favname' => '',
      'artistdirtmp' => $line['artistdirtmp'],
      'artist' => $line['artist'],
      'album' => $line['album'],
      'number' => $line['number'],
      'genre' => $line['genre'],
      'time_m' => $line['time_m'],
      'time_s' => $line['time_s'],
      )
     );
    output_chunk($json.str_repeat(' ', 8000)."\n");
  }
  flush();
}
$sth->closeCursor();
$sth = null;
$db = null;
} catch (Exception $e) {
  die('Exception: ' . $e->getMessage());
}
}
