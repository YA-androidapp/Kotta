<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
echo '<ul>';
$_SESSION = array();
session_destroy();
echo '<li>セッション情報を削除しました</li>';
$_GET = array();
$_POST = array();
echo '<li>HTTPリクエスト情報を削除しました</li>';
echo '<li>ログアウトしました！<br>'."\n".' <a href=\''.htmlspecialchars($_SERVER[HTTP_REFERER], ENT_QUOTES).'\'>戻る</a></li>';
echo '</ul>';
