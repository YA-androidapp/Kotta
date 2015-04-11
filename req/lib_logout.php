<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
 echo "<ul>\n";
 $_SESSION = array();
 session_destroy();
 echo "<li>セッション情報を削除しました</li>\n";
 $_GET = array();
 $_POST = array();
 echo "<li>HTTPリクエスト情報を削除しました</li>\n";
 echo "<li>ログアウトしました！<br>\n <a href='".htmlspecialchars($_SERVER[HTTP_REFERER], ENT_QUOTES)."'>戻る</a></li>\n";
 echo "</ul>\n";
