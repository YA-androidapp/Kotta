<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();

if ($_REQUEST['short'] != '') { die('@'.$_SESSION['oa_screen_name']); }

if ($_REQUEST['tweettext'] != '') { $_SESSION['tweettext'] = $_REQUEST['tweettext']; }
require_once("config_oauth.php");

die('ログインしました @'.$_SESSION['oa_screen_name'].'<br><br><ul><li><a target="logout" href="logout.php">OAuth認証情報を消去</a></li><li><a target="logout" href="https://twitter.com/logout">twitterでログアウト</a></li></ul>');
