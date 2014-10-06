<!DOCTYPE html>
<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>Kotta Menu</title>
   <?php require_once('req/common_js.php'); ?>
   <?php require_once('req/lib_style.php'); ?>
 </head>
 <body>
  <table border="1" style="text-align:center;">
   <tr>
    <td colspan="3">
     <a href="<?php echo str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $baseuri, realpath($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck'])); ?>">
      <?php echo str_replace($base_dir.'/', '', realpath($base_dir.'/'.$arguments['favcheck'])); ?>
     </a>
    </td>
   </tr>
   <tr><td colspan="3">　</td></tr>
   <tr><td>ブックマーク名</td><td>登録済</td><td>未登録</td></tr>
<?php
 $favnumarr = array();
 $favnumarr2 = array();
 $favnumarr = glob($base_dirfav.'/'.$id.'_*.cgi');
 foreach ($favnumarr as $val) {
  $val2 = basename($val);
  $val2 = str_replace($id.'_', '', $val2);
  $favnum = str_replace('.cgi', '', $val2);
  $favnumarr2[] = $favnum;
  echo '<tr><td><a href="'.basename($_SERVER['SCRIPT_NAME']).'?mode=simple&favnum='.$favnum.'">'.$favnum.'</a></td>';
  $dirarr = array();
  $dirarr = file($val, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
  if ( !in_array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck'], $dirarr) ) {
   echo ' <td> </td><td><span onClick="if(window.confirm(\''.$arguments['favcheck'].'をブックマーク: 「'.$favnum.'」に追加してよろしいですか？\')){ $(function(){ $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&pw2='.$pw2.'&mode=favadd&favnum='.$favnum.'&linkadd='.urlencode($arguments['favcheck']).'\', function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); }); return false; }">';
   echo '  <img id="bookmarkstar'.$i.'" height="10px" src="icon/fava.png" alt="ブックマーク: 「'.$favnum.'」に追加します" title="ブックマーク: 「'.$favnum.'」に追加します">';
   echo ' </span></td>';
  } else {
   echo ' <td><span onClick="if(window.confirm(\''.$arguments['favcheck'].'をブックマーク: 「'.$favnum.'」から解除してよろしいですか？\')){ $(function(){ $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&pw2='.$pw2.'&mode=favdel&favnum='.$favnum.'&linkdel='.urlencode($arguments['favcheck']).'\', function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); }); return false; }">';
   echo '  <img id="bookmarkstar'.$i.'" height="10px" src="icon/favr.png" alt="ブックマーク: 「'.$favnum.'」から解除します" title="ブックマーク: 「'.$favnum.'」から解除します">';
   echo ' </span></td><td> </td>';
  }
   echo ' </tr>'."\n";
 }
?>
   <tr><td colspan="3">　</td></tr>
   <tr>
    <td colspan="3" style="text-align:right;">
      <input type="text" id="favnum" name="favnum" title="名前" style="width:100px;">
<?php
 echo '<a href="#" onClick="$(function(){ $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&pw2='.$pw2.'&mode=favfadd&favnum=\'+$(\'input#favnum\').val(), function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); });">作成</a>';
?>
     　
     <select id="favnum" name="favnum" style="width:100px;">
      <option value="">-</option>
      <?php foreach ($favnumarr2 as $val) { echo '<option value="'.$val.'">'.$val.'</option>'; } ?>
     </select>
<?php
 echo '<a href="#" onClick="if(window.confirm($(\'select#favnum\').val()+\'を削除してよろしいですか？\')){ $(function(){ $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&pw2='.$pw2.'&mode=favfdel&favnum=\'+$(\'select#favnum\').val(), function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); }); return false; }">削除</a>';
?>
    </td>
   </tr>
  </table>
 </body>
</html>
