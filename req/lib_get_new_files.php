<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function getNewFiles($dir) {
 global $base_dir;
 $dirname = str_replace("\0", '', $dir);
 $dirname = realpath($dir);
 if ( is_dir($dir) ) {
  if ( stripos($dir.((mb_substr($dir,-1)=='/')?'':'/'),$base_dir) === 0 ) {
   $cmd = 'find '.$dir.' -mtime -1 2>&1';
   $list = array();
   $return_var = 0;
   exec($cmd, $list, $return_var);
   if (0 === $return_var) {
    return array_values(array_filter($list));
   }
  }
 }
}
