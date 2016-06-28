<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='utf-8'>
  <title>Kotta</title>
</head>

<body>
<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();

function endsWith($str, $suffix) {
 $len = strlen($suffix);
 return $len == 0 || substr($str,  strlen($str) - $len, $len) === $suffix;
}

if ( (isset($_REQUEST['check']) == false) || ($_REQUEST['check'] == '0') ) { die('<small><small><ul><li><a href="db_write.php?check=1">DB-Rebuilding</a></li><li><a href="db_write.php?check=1&reset=1">DB-Rebuilding(Reset)</a></li></ul></small></small>'); }

ignore_user_abort(true);
set_time_limit(0);
error_reporting(0);

require_once(realpath(__DIR__).DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'lib_io.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_idpw.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_otp.php');
require_once(arsep(__DIR__,'conf').DSEP.'index.php');
require_once(arsep(__DIR__,'req').DSEP.'mp3tag_getid3.php');

if ( (isset($confs['dbfilename']) == false) || ($confs['dbfilename'] == '') ) { $confs['dbfilename'] = 'musics.sqlite3'; }
try {
 if ( (isset($_REQUEST['reset'])) && ($_REQUEST['reset'] == '1') ) {
  if( file_exists(arsep(__DIR__,'conf').DSEP.$confs['dbfilename'])){
    unlink(arsep(__DIR__,'conf').DSEP.$confs['dbfilename']);
  }
}
} catch (Exception $e) {
 echo 'Exception: ' . $e->getMessage() . '<br>';
}
try {
 $db = new PDO('sqlite:'.asep('.','').asep('conf','').$confs['dbfilename']);
 $sql = 'CREATE TABLE IF NOT EXISTS musics(i integer primary key autoincrement, datasrc text, title text, relapath text, basename text, artistdirtmp text, artist text, album text, number integer, genre text, time_m text, time_s text)';
 $db->query($sql);
 $db = null;
} catch (Exception $e) {
 die('Exception: ' . $e->getMessage());
}
try {
 $db = new PDO('sqlite:'.asep('.','').asep('conf','').$confs['dbfilename']);
 $sql = 'INSERT INTO musics( datasrc , title , relapath , basename , artistdirtmp , artist , album , number , genre , time_m , time_s)'
 .' values (:datasrc, :title, :relapath, :basename, :artistdirtmp, :artist, :album, :number, :genre, :time_m, :time_s)';
 $sth = $db->prepare($sql);
 $db->beginTransaction();
 $i = 0;
 if ( (isset($_REQUEST['dirname'])) && ($_REQUEST['dirname'] != '') ) {
  getdirtree(arsep($base_dir,$_REQUEST['dirname']).DSEP.asep($_REQUEST['dirname'],''));
} else {
  getdirtree(arsep($base_dir,''));
}
$db->commit();
$db = null;
echo '完了しました<br>';
} catch (Exception $e) {
 die('Exception: ' . $e->getMessage());
}

function getdirtree2($path){
 global $arguments, $base_dir, $base_uri, $confs, $db, $i, $sth;

 $rpath = realpath($path);
 if ($handle = opendir($rpath)) {
  try {
   while (false !== ($file = readdir($handle))) {
    if ('.' == $file || '..' == $file) { continue; }
    if (is_dir(arsep($path,$file))) {
     getdirtree(arsep($path,$file));
   } elseif ( (is_file(arsep($path,$file))) && (stripos(realpath(arsep($path,$file)), '.mp3') !== FALSE) ) {
     echo sprintf('%05d', $i++) . ' : ' . realpath(arsep($path,$file));
     $r2path = str_replace(arsep($base_dir,''), '', asep($rpath,''));
     if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
      if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
       if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
        if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
         $getmp3info_parts = array();
         $getmp3info_parts = getmp3info(realpath(arsep($path,$file)));
         $rslt = $sth->execute(
          array(
           ':datasrc' => str_replace('\\','/',str_replace(arsep($base_dir,''), $base_uri, realpath(arsep($path,$file)))),
           ':title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
           ':relapath' => rawurlencode(str_replace('\\','/',str_replace(arsep($base_dir,''), '', realpath(arsep($path,$file))))),
           ':basename' => basename(arsep($path,$file)),
           ':artistdirtmp' => str_replace(array(arsep($base_dir,''), DSEP.basename(arsep($path,$file))), array('', ''), realpath(arsep($path,$file))),
           ':artist' => htmlspecialchars($getmp3info_parts[1], ENT_QUOTES),
           ':album' => htmlspecialchars($getmp3info_parts[2], ENT_QUOTES),
           ':number' => htmlspecialchars($getmp3info_parts[3], ENT_QUOTES),
           ':genre' => htmlspecialchars($getmp3info_parts[4], ENT_QUOTES),
           ':time_m' => htmlspecialchars( (($getmp3info_parts[5]<10)?('0'.$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES),
           ':time_s' => htmlspecialchars( (($getmp3info_parts[6]<10)?('0'.$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES),
           )
          );
         if ($rslt){
          echo '　　　データの追加に成功しました';
        }else{
          $db->rollBack();
          $db = null;
          die(' Exception: データの追加に失敗しました');
        }
      }
    }
  }
}
}
echo "<br>\n";
ob_flush();
flush();
}
closedir($handle);
} catch (PDOException $e) {
 $db->rollBack();
 $db = null;
 die('Exception: ' . $e->getMessage());
}
}
}

function getdirtree($path) {
 global $arguments, $base_dir, $base_uri, $confs, $db, $i, $sth;
 $rpath = realpath($path);

 try {
  foreach (new RecursiveIteratorIterator(
   new RecursiveDirectoryIterator(
    $path,
    FileSystemIterator::SKIP_DOTS
    )
   ) as $item) {
   switch (true) {
    case !$item->isFile():
    case (endsWith($item->getPathname(), '.mp3') == FALSE):
    break;
    default :
    echo sprintf('%05d', $i++) . ' : ' . realpath(arsep($path,$file));
    $r2path = str_replace(arsep($base_dir,''), '', asep($rpath,''));
    if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
      if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
       if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
        if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
         $getmp3info_parts = array();
         $getmp3info_parts = getmp3info(realpath(arsep($path,$file)));
         $rslt = $sth->execute(
          array(
           ':datasrc' => str_replace('\\','/',str_replace(arsep($base_dir,''), $base_uri, realpath(arsep($path,$file)))),
           ':title' => htmlspecialchars($getmp3info_parts[0], ENT_QUOTES),
           ':relapath' => rawurlencode(str_replace('\\','/',str_replace(arsep($base_dir,''), '', realpath(arsep($path,$file))))),
           ':basename' => basename(arsep($path,$file)),
           ':artistdirtmp' => str_replace(array(arsep($base_dir,''), DSEP.basename(arsep($path,$file))), array('', ''), realpath(arsep($path,$file))),
           ':artist' => htmlspecialchars($getmp3info_parts[1], ENT_QUOTES),
           ':album' => htmlspecialchars($getmp3info_parts[2], ENT_QUOTES),
           ':number' => htmlspecialchars($getmp3info_parts[3], ENT_QUOTES),
           ':genre' => htmlspecialchars($getmp3info_parts[4], ENT_QUOTES),
           ':time_m' => htmlspecialchars( (($getmp3info_parts[5]<10)?('0'.$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES),
           ':time_s' => htmlspecialchars( (($getmp3info_parts[6]<10)?('0'.$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES),
           )
          );
         if ($rslt){
          echo '　　　データの追加に成功しました';
        }else{
          $db->rollBack();
          $db = null;
          die(' Exception: データの追加に失敗しました');
        }
      }
    }
  }
}
}
echo "<br>\n";
ob_flush();
flush();
}
} catch (PDOException $e) {
  $db->rollBack();
  $db = null;
  die('Exception: ' . $e->getMessage());
}
}
?>
</body>

</html>
