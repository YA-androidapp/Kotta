<!DOCTYPE HTML>
<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<html>
 <head>
  <meta charset='UTF-8'>
  <meta http-equiv='refresh' content='3;URL=<?php echo htmlspecialchars($to->getAuthorizeURL($token), ENT_QUOTES); ?>'>
 </head>
 <body>
  <center>
   <p id='config_oauth'>
    twitter社の<a href='<?php echo htmlspecialchars($to->getAuthorizeURL($token), ENT_QUOTES); ?>'>認証画面</a>に移動します。<br>
    アドレスバーがtwitter.comに変わったことを確認したうえで<br>ユーザー名とパスワードを入力してください。<br>
   </p>
  </center>
 </body>
</html>
