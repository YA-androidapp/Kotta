<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
 if (file_exists($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkadd'])) {
  $fav_exists = 0;
  if ( !is_dir($base_dirfav) ) { mkdir($base_dirfav, '0777', TRUE); }
  $title = (getmp3info($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkadd'])[0] != '') ? getmp3info($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkadd'])[0] : basename($arguments['linkadd']);
  $favfile = $base_dirfav.$id.'_'.$arguments['favname'].'.cgi';
  if ( !is_file($favfile) ) { touch($favfile); }
  @chmod($base_dirfav, 0777);
  @chmod($favfile, 0777);
  $dirarr = array();
  $dirarr = file($favfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

  if ( array_search($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkadd'],$dirarr) !== FALSE ) {
   array_splice($dirarr, array_search($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkadd'],$dirarr), 1);
   $fav_exists = 1;
  }
  while ( count($dirarr) >= $rpadd_max ) {
   array_pop($dirarr);
  }
  array_unshift($dirarr, $base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['linkadd']);
  $dirarr = array_unique($dirarr);
  $dirarr = array_filter($dirarr, 'strlen');
  //sort($dirarr);
  if ( file_put_contents($favfile, implode("\n", $dirarr), LOCK_EX) !== FALSE ) {
   if ( $fav_exists == 0 ) {
    die('「'.$title.'」 お気に入りに追加しました');
   } elseif ( $fav_exists == 1 ) {
    die('「'.$title.'」 お気に入りを更新しました');
   }
  } else { die('(!) 引数が不正です favadd-1'.'   '.$favfile.'  '.implode("\n", $dirarr)); }
 } else { die('(!) 引数が不正です favadd-2'); }
 die('(!) 引数が不正です favadd-3');
