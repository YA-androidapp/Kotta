Kotta
====

## Overview
---

PHPで書かれたWebベースのオーディオプレーヤシステムです

## Install
---

### pwd/<USERNAME>.cgi

ファイルの中身がパスワードであるようなファイル( <USERNAME>.cgi )を作成し，pwdディレクトリに設置する

同じディレクトリ内に，ファイルの中身が半角英数16文字であるファイル( <USERNAME>_otp.cgi )を設置すると二段階認証を利用できるようになる（使用できる文字は 234567QWERTYUIOPASDFGHJKLZXCVBNM のみ）

### conf/index.php及びtweet/config.php

1.$base_uriを，サーバのドメイン・音楽ファイルが置かれているディレクトリに合わせて変更
2.$base_dirを，音楽ファイルが置かれているディレクトリに合わせて変更

### config_id_oauth_consumer.php

Twitter開発者サイトからConsumer Key・Consumer Secretを取得し，書き込む

## Libraries

### [GNU LESSER GENERAL PUBLIC LICENSE Version 3](http://www.gnu.org/licenses/lgpl.html)

* [PHP Google two-factor authentication module](http://www.idontplaydarts.com/2011/07/google-totp-two-factor-authentication-for-php/)

### [MIT License](http://www.opensource.org/licenses/mit-license.php)

* [audiojs](http://kolber.github.io/audiojs/)
* [jQuery-Notify-bar](http://www.whoop.ee/posts/2013-04-05-the-resurrection-of-jquery-notify-bar/)
* [kirinlyric](https://github.com/kirinsan-org/kirinlyric)

### [Mozilla MPL](http://www.mozilla.org/MPL/2.0/)

* [getID3](http://getid3.sourceforge.net/)

### Other Licence

* [twitteroauth](https://github.com/abraham/twitteroauth)

## Licence

[Apache License, 2.0](http://www.apache.org/licenses/LICENSE-2.0)

## Author

[YA-androidapp](https://github.com/YA-androidapp)

---

Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.