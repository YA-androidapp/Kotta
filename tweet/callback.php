<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
error_reporting(0);
session_start();
require("../conf/tweet.php");
require("config_id_oauth_consumer.php");
require("twitteroauth.php");

$verifier = $_REQUEST['oauth_verifier'];
$to = new TwitterOAuth($consumer_key,$consumer_secret,$_SESSION['request_token'],$_SESSION['request_token_secret']);
$access_token = $to->getAccessToken($verifier);
$_SESSION['oauth_token'] = $access_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $access_token['oauth_token_secret'];
$_SESSION['user_id'] = $access_token['user_id'];
$_SESSION['screen_name'] = $access_token['screen_name'];

header("HTTP/1.1 301 Moved Permanently");
header("Location: index.php");
