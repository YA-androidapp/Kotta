<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
if ( count(glob(arsep(__DIR__,'..').DSEP.'pwd'.DSEP.'*.cgi')) == 0) {
 die('パスワードが設定されていません．pwdディレクトリの中に，パスワードを記した\'<User Name>.cgi\'ファイルを置いて下さい');
}

if (  file_exists(realpath($base_dir)) === false ) {
 die('音楽ファイルが置かれているディレクトリの指定($base_dir)が間違っています');
};

require_once(arsep(__DIR__,'..').DSEP.'conf'.DSEP.'tweet.php');
if ( ($consumer_key == '') && ($consumer_secret = '') ) {
 echo 'Twitterのコンシューマキー・コンシューマシークレットが登録されていないため，Twitter連携機能は利用できません';
}
