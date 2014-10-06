<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$base_dir = '/var/www/media';
$baseuri = 'https://EXAMPLE.COM/media';
$enable_autocomplete_dir = 1;
$enable_autocomplete_favnum = 1;
$enable_upload = 1;
$rpadd_max = 30;

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
