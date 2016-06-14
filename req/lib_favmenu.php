<!DOCTYPE html>
<!-- Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<html lang='ja'>
<head>
  <meta charset='utf-8'>
  <title>Kotta Menu</title>
  <!-- style -->
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel='stylesheet' type='text/css' href='https://code.jquery.com/ui/1.10.3/themes/ui-darkness/jquery-ui.css' />
  <link rel='stylesheet' type='text/css' href='js/jQuery-Notify-bar/jquery.notifyBar.css' />
  <link rel='stylesheet' type='text/css' href='css/kirinlyric.css'>
  <link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload.css'>
  <link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-ui.css'>
  <noscript><link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-noscript.css'></noscript>
  <noscript><link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-ui-noscript.css'></noscript>
  <link rel='stylesheet' type='text/css' href='css/kotta.css'>
  <!-- Style -->
  <?php require_once(arsep(__DIR__,'lib_js.php')); ?>
  <?php require_once(arsep(__DIR__,'mp3tag_getid3.php')); ?>
  <script type='text/javascript'>
jQuery(function() {
 if ( (jQuery("input#id").val()!='') && (jQuery("input#pw").val()!='') && ( (Cookies.get('otppwauthed')=='otppwauthed') || (Cookies.get('otppwauthed')=='otppwdisabled') || (jQuery("input#pw2").val()!='') ) ) {
  setTimeout(function(){
   pullfavmenu();
 }, 2000);
}
});
  </script>
</head>
<body onload='pullfavmenu();'>
  <table id='auth'>
    <tr>
      <td>User</td>
      <td colspan='2'>
        <input type='text' id='id' name='id' title='User' value='<?php echo $id; ?>'>
      </td>
    </tr>
    <tr>
      <td>Password</td>
      <td colspan='2'>
        <input type='password' id='pw' name='pw' title='Password' value='<?php echo $pw; ?>'>
      </td>
    </tr>
    <tr>
      <td>OTP Password</td>
      <td colspan='2'>
        <input type='number' id='pw2' name='pw2' title='OTP Password' max='999999'>
      </td>
    </tr>
  </table>
  <input type='hidden' id='relapath' value='<?php echo rawurlencode($arguments['relapath']); ?>'>
  <table border='1' id='mp3info'>
   <tr>
    <td colspan='3'>
     <a href='<?php echo str_replace('\\','/',str_replace(arsep($base_dir,''), $base_uri, realpath(arsep($base_dir,$arguments['relapath'])))); ?>'>
      <?php
      $getmp3info_parts = array();
      $getmp3info_parts = getmp3info(realpath(arsep($base_dir,$arguments['relapath'])));
      $title = $getmp3info_parts[0];
 echo $title; // title
 echo ' / ';
 echo $getmp3info_parts[1]; // artist
 echo ' [';
 echo $getmp3info_parts[2]; // album
 echo ']';
 ?>
</a>
</td>
</tr>
</table>
<table border='1' id='favmenu'>
  <thead>
    <tr><td>ブックマーク名</td><td class='favmenustar'>登録済</td><td class='favmenustar'>未登録</td></tr>
  </thead>
  <tbody>
  </tbody>
</table>
</body>
</html>
