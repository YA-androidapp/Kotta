<!DOCTYPE html>
<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
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
   <?php require_once(realpath(__DIR__).'/lib_js.php'); ?>
   <?php require_once(realpath(__DIR__).'/mp3tag_getid3.php'); ?>
 </head>
 <body>
  <table border='1' id='favmenu'>
   <tr>
    <td colspan='3'>
     <a href='<?php echo str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck'])); ?>'>
<?php
 $getmp3info_parts = array();
 $getmp3info_parts = getmp3info(realpath($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck']));
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
   <tr><td colspan='3'>　</td></tr>
   <tr><td>ブックマーク名</td><td class='favmenustar'>登録済</td><td class='favmenustar'>未登録</td></tr>
<?php
 $favnamearr = array();
 $favnamearr2 = array();
 $favnamearr = glob($base_dirfav.$id.'_*.cgi');
 foreach ($favnamearr as $val) {
  $val2 = basename($val);
  $val2 = str_replace($id.'_', '', $val2);
  $favname = str_replace('.cgi', '', $val2);
  $favnamearr2[] = $favname;
  echo '<tr><td><a href=\''.basename($_SERVER['SCRIPT_NAME']).'?mode=simple&favname='.htmlspecialchars($favname, ENT_QUOTES).'\'>'.$favname.'</a></td>';
  $dirarr = array();
  $dirarr = file($val, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
  if ( !in_array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck'], $dirarr) ) {
   echo ' <td> </td><td><span class=\'starw\' id=\'bookmarkstar'.$i.'\' alt=\'ブックマーク: 「'.htmlspecialchars($favname, ENT_QUOTES).'」に追加します\' title=\'ブックマーク: 「'.htmlspecialchars($favname, ENT_QUOTES).'」に追加します\' onClick=\'if(window.confirm("'.htmlspecialchars($title, ENT_QUOTES).'をブックマーク: 「'.htmlspecialchars($favname, ENT_QUOTES).'」に追加してよろしいですか？")){ $(function(){ $.get("?id='.$id.'&mode=favadd&favname='.rawurlencode($favname).'&linkadd='.rawurlencode($arguments['favcheck']).'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'>';
   echo ' ☆</span></td>';
  } else {
   echo ' <td><span class=\'star\' id=\'bookmarkstar'.$i.'\' alt=\'ブックマーク: 「'.htmlspecialchars($favname, ENT_QUOTES).'」から解除します\' title=\'ブックマーク: 「'.htmlspecialchars($favname, ENT_QUOTES).'」から解除します\' onClick=\'if(window.confirm("'.htmlspecialchars($title, ENT_QUOTES).'をブックマーク: 「'.htmlspecialchars($favname, ENT_QUOTES).'」から解除してよろしいですか？")){ $(function(){ $.get("?id='.$id.'&mode=favdel&favname='.rawurlencode($favname).'&linkdel='.rawurlencode($arguments['favcheck']).'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'>';
   echo ' ★</span></td><td> </td>';
  }
   echo ' </tr>';
 }
?>
   <tr><td colspan='3'>　</td></tr>
   <tr>
    <td colspan='2'>
      <input type='text' id='favname' name='favname' pattern='^[a-zA-Z0-9][-_a-zA-Z0-9]*$' title='名前(半角英数)'>
    </td>
    <td>
<?php
 echo '<a href=\'#\' onClick=\'$(function(){ $.get("?id='.$id.'&mode=favfadd&favname="+encodeURIComponent($("input#favname").val()), function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); });\'>作成</a>';
?>
    </td>
   </tr>
   <tr>
    <td colspan='2'>
     <select id='favname' name='favname'>
      <option value=''>-</option>
      <?php foreach ($favnamearr2 as $val) { echo '<option value=\''.htmlspecialchars($val, ENT_QUOTES).'\'>'.$val.'</option>'; } ?>
     </select>
    </td>
    <td>
<?php
 echo '<a href=\'#\' onClick=\'if(window.confirm(htmlspecialcharsEntQuotes($("select#favname").val())+"を削除してよろしいですか？")){ $(function(){ $.get("?id='.$id.'&mode=favfdel&favname="+encodeURIComponent($("select#favname").val()), function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'>削除</a>';
?>
    </td>
   </tr>
  </table>
 </body>
</html>
