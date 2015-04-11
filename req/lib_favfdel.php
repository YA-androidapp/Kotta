<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
 if ( !is_dir($base_dirfav.'/') ) { die('(!) 引数が不正です favfdel-1'); }
 if ( !preg_match("/^[_a-zA-Z0-9][-_a-zA-Z0-9]*$/", $arguments['favnum'])){ die('(!) 引数が不正です favfdel-2'); }
 $favfile = $base_dirfav.'/'.$id.'_'.$arguments['favnum'].'.cgi';
 if ( is_file($favfile) ) {
  if ( unlink($favfile) ) {
   die('お気に入り: 「'.$arguments['favnum'].'」を削除しました');
  } else { die('(!) 引数が不正です favfdel-3'); }
 } else { die('(!) 引数が不正です favfdel-4'); }
 die('(!) 引数が不正です favfdel-5');
