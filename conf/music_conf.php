<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$allowedExtensions = array("mp3", "ogg");
$allowedSizeLimit = 10 * 1024 * 1024;
$base_dir = '/var/www/media/';

// if(strpos($_SERVER["REMOTE_ADDR"], '192.168.11.', 0) === 0){
//  // �l�b�g���[�N�̓s����URL���w�肵�ẴA�N�Z�X���e�����ꍇ��
//  // ���̕�����L���ɂ��ă��[�J��IP�A�h���X�ŃA�N�Z�X����
//  $baseuri = 'https://LOCAL_IP/kotta/music.php?output_path=';
//  $base_uri_s = 'https://LOCAL_IP/media/musics/';
// }else{
 $baseuri = 'https://EXAMPLE.COM/kotta/music.php?output_path='; // �f�B���N�g���\�����B�����߂�music.php�o�R�ŉ��y�t�@�C�����o��
 $base_uri_s = 'https://EXAMPLE.COM/media/';
// }

$enable_autocomplete_dir = 1;
$enable_autocomplete_favnum = 1;
$enable_upload = 1;
$rpadd_max = 50;

$confs = array();
$confs['filter_dir'] = '';
$confs['filter_file'] = '';
$confs['filter_album'] = '';
$confs['filter_genre'] = '';

$confs['sns_format'] = '%t / %a [ %l ] #nowplaying %u';
 // %a => artist
 // %g => genre
 // %l => album
 // %m => time_m
 // %n => number
 // %s => time_s
 // %t => title
