<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function getdirtree($path){
 global $arguments, $base_dir, $confs, $depth2;
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
   } elseif (is_file($rpath.'/'.$file)) {
    $r2path = str_replace($base_dir.'/', '', $rpath);
    if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
     if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
      if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
       if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
        $dirs[$file] = $rpath.'/'.$file;
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
