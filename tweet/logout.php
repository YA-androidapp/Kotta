<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
require_once("config_oauth.php");
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Kottaのログイン情報は保持したままtwitterからログアウトする</title>
 </head>
 <body>
  <div style="background-color:white;width:300px;">
<?php
$oa_screen_name_tmp = $_SESSION['oa_screen_name'];
echo "<ul>\n";
echo "<li>ユーザー名: ".$oa_screen_name_tmp."</li>\n";
$_SESSION['oauth_token'] = NULL;
$_SESSION['oauth_token_secret'] = NULL;
echo "<li>twitterからログアウトしました</li>\n";
echo "</ul>\n";
?>
  </div>
 </body>
</html>
