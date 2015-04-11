<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(0);
require_once(dirname(__FILE__).'/conf/index.php');

if ( (isset($_SERVER['PHP_AUTH_USER'])) && ($_SERVER['PHP_AUTH_USER'] != '') ) {
 $id = $_SERVER['PHP_AUTH_USER']; $_SESSION['id'] = $id;
} elseif ( (isset($_SESSION['id'])) && ($_SESSION['id'] != '') ) {
 $id = $_SESSION['id'];
} elseif ( (isset($_COOKIE['id'])) && ($_COOKIE['id'] != '') ) {
 $id = $_COOKIE['id']; $_SESSION['id'] = $id;
} elseif ( (isset($_REQUEST['id'])) && ($_REQUEST['id'] != '') ) {
 $id = $_REQUEST['id']; $_SESSION['id'] = $id;
} else {
 $id = '';
}
if ( (isset($_SERVER['PHP_AUTH_PW'])) && ($_SERVER['PHP_AUTH_PW'] != '') ) {
 $pw = $_SERVER['PHP_AUTH_PW']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_SESSION['pw'])) && ($_SESSION['pw'] != '') ) {
 $pw = $_SESSION['pw'];
} elseif ( (isset($_COOKIE['pw'])) && ($_COOKIE['pw'] != '') ) {
 $pw = $_COOKIE['pw']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_REQUEST['pw'])) && ($_REQUEST['pw'] != '') ) {
 $pw = $_REQUEST['pw']; $_SESSION['pw'] = $pw;
} else {
 $pw = '';
}

require_once(realpath(__DIR__).'/conf/index.php');
require_once(dirname(__FILE__).'/req/mp3tag_getid3.php');
$pwdfile = 'pwd/'.$id.'.cgi';
if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( ($pw !== '') && ($pw === $tpassword) ) {
  if ( $_REQUEST['sqlwhere'] != '' )         { $sqlwhere = $_REQUEST['sqlwhere'];
  } elseif ( $_SESSION['sqlwhere'] != '' )   { $sqlwhere = $_SESSION['sqlwhere'];
  } else                                     { $sqlwhere = 'title'; }
  if ( $_REQUEST['sqllike'] != '' )          { $sqllike  = $_REQUEST['sqllike'];
  } elseif ( $_SESSION['sqllike'] != '' )    { $sqllike  = $_SESSION['sqllike'];
  } else                                     { $sqllike  = '4SEASONs'; }

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
  getarr($sqlwhere,$sqllike);
  echo "0\r\n\r\n";
 }
}

function getarr($sqlwhere,$sqllike){
 global $arguments, $confs, $id;

 // title, basename, artist, album, number, genre
 if( ($sqlwhere!='title') &&($sqlwhere!='basename') &&($sqlwhere!='artist') &&($sqlwhere!='album') &&($sqlwhere!='number') &&($sqlwhere!='genre') ){
  $sqlwhere='title';
 }

 try {
  $db = new PDO('sqlite:./conf/'.$confs['dbfilename']);
  $sql = "SELECT * FROM musics WHERE ".$sqlwhere." LIKE ?";
  $sth = $db->prepare($sql);
  $sth->execute(array("%".$sqllike."%"));
  while ($line = @$sth->fetch(PDO::FETCH_ASSOC)) {
   $json = json_encode( 
         array(
          "track" => $line['i'],
          "datasrc" => $line['datasrc'],
          "title" => $line['title'],
          "favcheck" => $line['favcheck'],
          "basename" => $line['basename'],
          "id" => $id,
          "favnum" => "",
          "artistdirtmp" => $line['artistdirtmp'],
          "artist" => $line['artist'],
          "album" => $line['album'],
          "number" => $line['number'],
          "genre" => $line['genre'],
          "time_m" => $line['time_m'],
          "time_s" => $line['time_s'],
         )
   );
   output_chunk($json.str_repeat(' ', 8000)."\n");
   // ob_flush();
   flush();
  }
  $sth->closeCursor();
  $sth = null;
  $db = null;
 } catch (Exception $e) {
  die("Exception: " . $e->getMessage());
 }
}
