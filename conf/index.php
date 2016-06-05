<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

// 音楽ファイルが存在するディレクトリの指定
if (DIRECTORY_SEPARATOR != '\\') {
 $base_dir = '../musics/';
 $base_dirfav = 'fav/';
} else {
 // Windows版PHPで動かす場合の設定
 $base_dir = realpath('..'.DIRECTORY_SEPARATOR.'musics'.DIRECTORY_SEPARATOR);
 $base_dirfav = 'fav'.DIRECTORY_SEPARATOR;
}

$base_uri = '/musics/';

$enable_autocomplete_dirname = 1;
$enable_autocomplete_favname = 1;
$rpadd_max = 50;

$confs = array();
$confs['dbfilename'] = 'musics.sqlite3';
$confs['filter_dir'] = '';
$confs['filter_file'] = '';
$confs['filter_album'] = '';
$confs['filter_genre'] = '';

$confs['sns_format'] = '@home %t / %a [ %l ] #nowplaying';
 // %a => artist
 // %g => genre
 // %l => album
 // %m => time_m
 // %n => number
 // %s => time_s
 // %t => title

set_time_limit(600);
