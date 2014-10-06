<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
//$_SESSION['pname'] = 'logout.php';
require_once("config_oauth.php");
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="UTF-8">
  <title>Kottaのログイン情報は保持したままtwitterからログアウトする</title>
  <meta http-equiv="refresh" content="3;URL=<?php echo htmlspecialchars($myurl.$_SESSION['pname'], ENT_QUOTES); ?>">
 </head>
 <body>
  <div style="background-color:white;width:300px;">
<?php
$oa_screen_name_tmp = $_SESSION['oa_screen_name'];
echo "<ul>\n";
echo "<li>ユーザー名: ".$oa_screen_name_tmp."</li>\n";
$_SESSION['oauth_token'] = NULL;
$_SESSION['oauth_token_secret'] = NULL;
echo "<li>".htmlspecialchars($myname_short, ENT_QUOTES)."のログイン情報は保持したままtwitterからログアウトしました！<br>\n <a href='".htmlspecialchars($myurl, ENT_QUOTES)."'>トップページに戻る</a></li>\n";
echo "</ul>\n";
?>
  </div>
 </body>
</html>
