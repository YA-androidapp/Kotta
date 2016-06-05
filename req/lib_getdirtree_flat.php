<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function getdirtree_flat($path, $mode = 'dir'){
 global $arguments, $base_dir, $confs, $dirs, $depth2;
 $rpath = realpath($path);
 if ($handle = opendir($rpath)) {
  $depth2++;
  while (false !== ($file = readdir($handle))) {
   if ('.' == $file || '..' == $file) { continue; }
   if (is_dir(asep($rpath,$file))) {
    if ($depth2 <= $arguments['depth']) {
     if ($mode == 'dir') {
      $dirs[] = asep($rpath,$file);
      getdirtree_flat(asep($rpath,$file), 'dir');
     } else {
      getdirtree_flat(asep($rpath,$file), 'file');
     }
    }
   } else {
    if ($mode == 'file') {
     $r2path = str_replace(arsep($base_dir,''), '', $rpath.DIRECTORY_SEPARATOR);
     if (  ($arguments['filter_dir']=='')  || (($arguments['filter_dir'] !='') &&(fnmatch($arguments['filter_dir'],$r2path)==1))          ) {
      if ( ($arguments['filter_file']=='') || (($arguments['filter_file']!='') &&(fnmatch($arguments['filter_file'],basename($file))==1)) ) {
       if (    ($confs['filter_dir']=='')  || (    ($confs['filter_dir'] !='') &&    (fnmatch($confs['filter_dir'],$r2path)==1))          ) {
        if (   ($confs['filter_file']=='') || (    ($confs['filter_file']!='') &&    (fnmatch($confs['filter_file'],basename($file))==1)) ) {
         $dirs[$file] = asep($rpath,$file);
        }
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
