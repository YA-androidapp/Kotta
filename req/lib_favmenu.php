<!DOCTYPE html>
<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<html lang='ja'>
 <head>
  <meta charset='utf-8'>
  <title>Kotta Menu</title>
   <?php require_once(realpath(__DIR__).'/common_js.php'); ?>
   <?php require_once(realpath(__DIR__).'/lib_style.php'); ?>
 </head>
 <body>
  <table border='1' style='text-align:center;'>
   <tr>
    <td colspan='3'>
     <a href='<?php echo str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $baseuri, realpath($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck'])); ?>'>
      <?php echo str_replace($base_dir.'/', '', realpath($base_dir.'/'.$arguments['favcheck'])); ?>
     </a>
    </td>
   </tr>
   <tr><td colspan='3'>　</td></tr>
   <tr><td>ブックマーク名</td><td>登録済</td><td>未登録</td></tr>
<?php
 $favnamearr = array();
 $favnamearr2 = array();
 $favnamearr = glob($base_dirfav.$id.'_*.cgi');
 foreach ($favnamearr as $val) {
  $val2 = basename($val);
  $val2 = str_replace($id.'_', '', $val2);
  $favname = str_replace('.cgi', '', $val2);
  $favnamearr2[] = $favname;
  echo '<tr><td><a href=\''.basename($_SERVER['SCRIPT_NAME']).'?mode=simple&favname='.$favname.'\'>'.$favname.'</a></td>';
  $dirarr = array();
  $dirarr = file($val, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
  if ( !in_array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['favcheck'], $dirarr) ) {
   echo ' <td> </td><td><span onClick=\'if(window.confirm("'.$arguments['favcheck'].'をブックマーク: 「'.$favname.'」に追加してよろしいですか？")){ $(function(){ $.get("'.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&mode=favadd&favname='.$favname.'&linkadd='.urlencode($arguments['favcheck']).'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); }); return false; }\'>';
   echo '  <img id=\'bookmarkstar'.$i.'\' height=\'10px\' src=\'icon/fava.png\' alt=\'ブックマーク: 「'.$favname.'」に追加します\' title=\'ブックマーク: 「'.$favname.'」に追加します\'>';
   echo ' </span></td>';
  } else {
   echo ' <td><span onClick=\'if(window.confirm("'.$arguments['favcheck'].'をブックマーク: 「'.$favname.'」から解除してよろしいですか？")){ $(function(){ $.get("'.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&mode=favdel&favname='.$favname.'&linkdel='.urlencode($arguments['favcheck']).'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); }); return false; }\'>';
   echo '  <img id=\'bookmarkstar'.$i.'\' height=\'10px\' src=\'icon/favr.png\' alt=\'ブックマーク: 「'.$favname.'」から解除します\' title=\'ブックマーク: 「'.$favname.'」から解除します\'>';
   echo ' </span></td><td> </td>';
  }
   echo ' </tr>';
 }
?>
   <tr><td colspan='3'>　</td></tr>
   <tr>
    <td colspan='3' style='text-align:right;'>
      <input type='text' id='favname' name='favname' title='名前' style='width:100px;'>
<?php
 echo '<a href=\'#\' onClick=\'$(function(){ $.get("'.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&mode=favfadd&favname="+$("input#favname").val(), function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); });\'>作成</a>';
?>
     　
     <select id='favname' name='favname' style='width:100px;'>
      <option value=''>-</option>
      <?php foreach ($favnamearr2 as $val) { echo '<option value=\''.$val.'\'>'.$val.'</option>'; } ?>
     </select>
<?php
 echo '<a href=\'#\' onClick=\'if(window.confirm($("select#favname").val()+"を削除してよろしいですか？")){ $(function(){ $.get("'.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&mode=favfdel&favname="+$("select#favname").val(), function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cls: status }); location.reload(); }); }); return false; }\'>削除</a>';
?>
    </td>
   </tr>
  </table>
 </body>
</html>
