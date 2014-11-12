<?php
$allowedExtensions = array("mp3");
$allowedSizeLimit = 10 * 1024 * 1024;
set_time_limit(600);
$base_dir = '/path/to/musics/';
$base_dirfav = 'fav/';
// if(strpos($_SERVER["REMOTE_ADDR"], '192.168.11.', 0) === 0){
//  // ネットワークの都合でURLを指定してのアクセスが弾かれる場合は
//  // この部分を有効にしてローカルIPアドレスでアクセスする
//  $base_uri = 'https://EXAMPLE.COM/musics/uri/';
//  $base_uri = 'https://EXAMPLE.COM/kotta2/index.php?output_path=';
// }else{
$base_uri = '/musics/uri/'; // Absolute path
// }

$enable_autocomplete_dir = 1;
$enable_autocomplete_favnum = 1;
$rpadd_max = 50;

$confs = array();
$confs['filter_dir'] = '';
$confs['filter_file'] = '';
$confs['filter_album'] = '';
$confs['filter_genre'] = '';

// $confs['sns_format'] = '%t / %a [ %l ] #nowplaying %u';
$confs['sns_format'] = '%t / %a [ %l ] #nowplaying';
 // %a => artist
 // %g => genre
 // %l => album
 // %m => time_m
 // %n => number
 // %s => time_s
 // %t => title
