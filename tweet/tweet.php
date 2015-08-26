<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
set_time_limit(600);
if ($_REQUEST['tweettext'] != '') { $_SESSION['tweettext'] = $_REQUEST['tweettext']; }
require_once('config_oauth.php');

$tweettext = '';
$N = '';
$E = '';
$resttsid = '';

if ($_SESSION['tweettext'] != '') {
 $tweettext = $_SESSION['tweettext'];
} elseif ($_REQUEST['tweettext'] != '') {
 $tweettext = $_REQUEST['tweettext'];
} else { die('引数が不正です'); }

if ( $_REQUEST['pass_autotweet'] != '1') {
 die('<a href=\'tweet.php?pass_autotweet=1&tweettext='.urlencode($tweettext).'\'>@'.$_SESSION['oa_screen_name'].': 『'.$tweettext.'』をツイートします</a>');
}

if (is_numeric($_REQUEST['N'])) { $N = $_REQUEST['N']; }
if (is_numeric($_REQUEST['E'])) { $E = $_REQUEST['E']; }
if (ctype_digit($_REQUEST['resttsid'])) { $resttsid = $_REQUEST['resttsid']; }

if ( ($N != '') && ($E != '') ) {
 if ( (abs($N)<91) && (abs($E)<181) ) {
  $N = number_format($N, 6, '.', '');
  $E = number_format($E, 6, '.', '');
 } else {
  $messageNE = 1;
  $N = '';
  $E = '';
 }
}
$tweettext = strip_tags(mb_convert_encoding($tweettext, 'utf8', 'auto'));
if(strlen($tweettext)>140){
 $tweettext = mb_substr($tweettext,0,139);
}

$property = array();
$property['status'] = $tweettext;

if ($resttsid != '') { $property['in_reply_to_status_id'] = $resttsid; }
if ( ($N != '') && ($E != '') ) {
 $property['display_coordinates'] = 'true';
 $property['lat'] = $N;
 $property['long'] = $E;
}

$req = $to->OAuthRequest('https://api.twitter.com/1.1/statuses/update.json','POST',$property);
$json = json_decode($req, true, 512, JSON_BIGINT_AS_STRING);
if ( isset($json['text']) ) {
 echo 'ツイートしました！　@'.$_SESSION['oa_screen_name'].'　メッセージ: '.$json['text'];
} elseif ($messageNE == 1) {
 echo 'ツイートしましたが、緯度経度値が不正です(適正範囲外)　@'.$_SESSION['oa_screen_name'].'　メッセージ: '.$json['text'];
} else {
 echo 'ツイートできませんでした　@'.$_SESSION['oa_screen_name'].'　メッセージ: '.$json['text'];
 if ( $json['errors']['message'] != '' ) {
  echo '<br><br>(エラー内容: '.$json['errors']['message'].')';
 }
}
