<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
 if ( !is_dir($base_dirfav.'/') ) { mkdir($base_dirfav.'/', '0777', TRUE); }
 if ( !preg_match("/^[a-zA-Z0-9][-_a-zA-Z0-9]*$/", $arguments['favnum'])){ die('(!) 引数が不正です favfadd-1'); }
 $favfile = $base_dirfav.'/'.$id.'_'.$arguments['favnum'].'.cgi';
 if ( !is_file($favfile) ) {
  if ( touch($favfile) ) {
   die('お気に入り: 「'.$arguments['favnum'].'」を作成しました');
  } else { die('(!) 引数が不正です favfadd-2'); }
 } else { die('(!) 引数が不正です favfadd-3'); }
 die('(!) 引数が不正です favfadd-4');
