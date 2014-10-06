<!DOCTYPE HTML>
<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<html>
 <head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="3;URL=<?php echo htmlspecialchars($to->getAuthorizeURL($token), ENT_QUOTES); ?>">
 </head>
 <body>

   <center>
    <p style="font-size:x-small;padding:10px;width:300px;background-color:#09f;text-align:center;border:#00f;">
     <br>下のボタンを押すと、twitter社の認証画面に移動します。<br>アドレスバーがtwitter.comに変わったことを確認したうえで<br>ユーザー名とパスワードを入力してください。<br><br>
     <small>Streaming APIを必要としない機能を使う場合には、<br>当サービス(<?php echo htmlspecialchars($myurl, ENT_QUOTES); ?>)内で<br>ユーザー名などを入力していただく必要はありません。</small><br><br><br>
     <a href="<?php echo htmlspecialchars($to->getAuthorizeURL($token), ENT_QUOTES); ?>"><img src="login_twtr.png"></a><br><br>
    </p>
   </center>

   <br><br><br><br><br><br><br>

  </div>
 </body>
</html>
