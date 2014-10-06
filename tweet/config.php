<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
error_reporting(0);
set_time_limit(600);

$myurl = 'https://EXAMPLE.COM/kotta/tweet/';
$phpflag0 = 1;
$phpflag1 = 1;
$phpflag2 = 1;
$phpflag3 = 1;
$phpflag4 = 1;
$phpflag5 = 1;
$phpflag6 = 1;
$phpflag7 = 1;
$phpflag8 = 1;
$phpflag9 = 1;
$myname_short = 'Kotta';
$myver = '0.9';
$myname_long = $myname_short.' ver.'.$myver;
$common_lang = 'ja';
$fgcconf = stream_context_create(array('http' => array(
 'method' => 'GET',
 'header' => 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:6.0.2) Gecko/20100101 Firefox/6.0.2',
 )));

$myname = $myname_short;
