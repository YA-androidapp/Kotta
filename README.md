Kotta
====

## Overview
---

PHPで書かれたWebベースのオーディオプレーヤシステムです

## Install
---

### pwd/<USERNAME>.cgi

ファイルの中身がパスワードであるようなテキストファイル( <USERNAME>.cgi )を作成し，pwdディレクトリに設置する

同じディレクトリ内に，ファイルの中身が半角英数16文字であるテキストファイル( <USERNAME>_otp.cgi )を設置すると二段階認証を利用できるようになる（使用できる文字は 234567QWERTYUIOPASDFGHJKLZXCVBNM のみ）

### conf/index.php

1. $base_uriを，サーバのドメイン・音楽ファイルが置かれているディレクトリに合わせて変更
2. $base_dirを，音楽ファイルが置かれているディレクトリに合わせて変更

### conf/tweet.php

Twitter開発者サイトからConsumer Key・Consumer Secretを取得し，書き込む

---

__アップデートの場合は，conf,pwdディレクトリ以外を上書きしてください__

## Libraries

### [GNU GENERAL PUBLIC LICENSE Version 3](http://www.gnu.org/licenses/lgpl.html)

* [PHP Google two-factor authentication module](http://www.idontplaydarts.com/2011/07/google-totp-two-factor-authentication-for-php/)

### [MIT License](http://www.opensource.org/licenses/mit-license.php)

* [audiojs](http://kolber.github.io/audiojs/)
* [kirinlyric](https://github.com/kirinsan-org/kirinlyric)
* [JavaScript Cookie](https://github.com/js-cookie/js-cookie)
* [jquery.base64](https://github.com/yatt/jquery.base64)
* [jQuery-Notify-bar](http://www.whoop.ee/posts/2013-04-05-the-resurrection-of-jquery-notify-bar/)

### [Mozilla MPL](http://www.mozilla.org/MPL/2.0/)

* [getID3](http://getid3.sourceforge.net/)

### Other Licence

* [jQuery](https://github.com/jquery/jquery)
* [twitteroauth](https://github.com/abraham/twitteroauth)

## Licence

[Apache License, 2.0](http://www.apache.org/licenses/LICENSE-2.0)

## Author

[YA-androidapp](https://github.com/YA-androidapp)

---

Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.