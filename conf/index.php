<?php

// 音楽ファイルが存在するディレクトリの指定
$base_dir = '/path/to/musics/';
$base_dirfav = 'fav/';
$base_uri = '/musics/';

$enable_autocomplete_dir = 1;
$enable_autocomplete_favnum = 1;
$rpadd_max = 50;

$confs = array();
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

$allowedExtensions = array("mp3");
$allowedSizeLimit = 10 * 1024 * 1024;
set_time_limit(600);
