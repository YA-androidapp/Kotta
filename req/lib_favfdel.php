<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
if ( !is_dir($base_dirfav) ) { die('(!) 引数が不正です favfdel-1'); }
if ( !preg_match('/^[_a-zA-Z0-9][-_a-zA-Z0-9]*$/', $arguments['favname'])){ die('(!) 引数が不正です favfdel-2'); }
$favfile = $base_dirfav.$id.'_'.$arguments['favname'].'.cgi';
if ( is_file($favfile) ) {
  if ( unlink($favfile) ) {
     die('お気に入り: 「'.$arguments['favname'].'」を削除しました');
 } else { die('(!) 引数が不正です favfdel-3'); }
} else { die('(!) 引数が不正です favfdel-4'); }
die('(!) 引数が不正です favfdel-5');
