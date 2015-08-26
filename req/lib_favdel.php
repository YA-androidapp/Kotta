<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
 if (file_exists($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkdel'])) {
  if ( !is_dir($base_dirfav) ) { die('(!) 引数が不正です favdel-1'); }
  $title = (getmp3info($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkdel'])[0] != '') ? getmp3info($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkdel'])[0] : basename($arguments['linkdel']);
  $favfile = $base_dirfav.$id.'_'.$arguments['favname'].'.cgi';
  if ( !is_file($favfile) ) { die('(!) 引数が不正です favdel-2'); }
  $line = file($favfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
  $dirarr = array();
  foreach ($line as $val) {
   if ($val != $base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkdel']) {
    $dirarr[basename($val)] = $val;
   }
  }
  $dirarr = array_unique($dirarr);
  $dirarr = array_filter($dirarr, 'strlen');
  sort($dirarr);
  if ( file_put_contents($favfile, implode("\n", $dirarr), LOCK_EX) ) {
   die('「'.$title.'」をお気に入りから削除しました');
  } else { die('(!) 引数が不正です favdel-3'); }
 } else { die('(!) 引数が不正です favdel-4'); }
 die('(!) 引数が不正です favdel-5');
