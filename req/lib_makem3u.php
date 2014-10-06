<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
header("Content-Type: audio/x-mpegurl");
echo ($arguments['m3uextended']!='0') ? '#EXTM3U'."\n\n" : '';

makem3ulist($dirarr);

function makem3ulist($tree){
 global $arguments, $base_dir, $base_uri_s, $baseuri, $confs, $depth1, $folders;

 if (!is_array($tree)) { return false; }

 $depth1++;
 $i = 0;
 foreach ($tree as $key => $value) {
  if (is_array($value)) {
   if ($depth1 < $arguments['depth']) {
    makem3ulist($value);
   }
  } else {
   if (stripos(realpath($value), '.mp3') !== FALSE) {
    $getmp3info_parts = array();
    $getmp3info_parts = getmp3info(realpath($value));
    if (  ($arguments['filter_album']=='') || (($arguments['filter_album']!='')&&(preg_match('/^'.$arguments['filter_album'].'$/isu',$getmp3info_parts[2])==1)) ) {
     if ( ($arguments['filter_genre']=='') || (($arguments['filter_genre']!='')&&(preg_match('/^'.$arguments['filter_genre'].'$/isu',$getmp3info_parts[4])==1)) ) {
      if (    ($confs['filter_album']=='') || (    ($confs['filter_album']!='')&&    (preg_match('/^'.$confs['filter_album'].'$/isu',$getmp3info_parts[2])==1)) ) {
       if (   ($confs['filter_genre']=='') || (    ($confs['filter_genre']!='')&&    (preg_match('/^'.$confs['filter_genre'].'$/isu',$getmp3info_parts[4])==1)) ) {
        // コメント:メタデータ
        echo ($arguments['m3uextended']!='0') ? '#EXTINF:'.($getmp3info_parts[5] * 60 + $getmp3info_parts[6]).','.$getmp3info_parts[0]."\n" : '';
        echo str_replace($base_dir, str_replace('https://','http://',$base_uri_s) , realpath($value))."\n";
        flush();
       }
      }
     }
    }
   }
  }
  $i++;
 }
 $depth1--;
 return true;
}

die();
