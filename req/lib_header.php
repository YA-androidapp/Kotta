<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<?php if ( $_REQUEST['header_menu'] != '1' ) { ?>
  <img height="128px" width="128px" src="icon/kotta.png" />
  <div id="wrapper_headerlist">
<?php } ?>
   ||
   [
   User:<input type="text" id="id" name="id" title="User" value="<?php echo $id; ?>" style="width:100px;">
   Password:<input type="password" id="pw" name="pw" title="Password" value="<?php echo $pw; ?>" style="width:100px;">
   ]
   <br>
   ||
   <a href="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?menu=1">Menu</a> ||
   <small><a target="sns" href="tweet/index.php">Authentication in Twitter</a></small> ||
   <a href="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?logout=1">Logout</a> ||
   <hr />
   <table id="header_tweet">
    <tr>
     <td>
      <textarea id="tweettext"></textarea>
     </td>
     <td>
      <img height="20px" src="icon/twtr2.png" alt="twitterに投稿する" title="twitterに投稿する" onClick="window.open('<?php echo str_replace(basename($_SERVER['SCRIPT_NAME']), 'tweet/tweet.php', $_SERVER['SCRIPT_NAME']); ?>?pass_autotweet=1&tweettext='+encodeURIComponent(jQuery('#tweettext').val()), 'sns');return false;">
      Screenname:<span id="screen_name"><?php echo ($_SESSION['oa_screen_name']!='') ? '@'.$_SESSION['oa_screen_name'] : '---'; ?></span>
     </td>
    </tr>
   </table>
   <hr />
   Directory Name(autocomplete)<br />
   <input type="text" id="dir" name="dir" title="ディレクトリ名" style="width:250px;">
   <a href="#" onClick="var url='ls_dir.php?dir='+jQuery('input#dir').val();pullls(url);">[Add]</a>
   <hr />
   <ul>
    <li>My Favorites
     <ul id="favoriteslist">
     </ul>
    </li>
   </ul>
   <table id="header_favmenu">
    <tr>
     <td>
       <input type="text" id="favnum" name="favnum" title="名前" style="width:100px;">
<?php
 echo '<a href="#" onClick="$(function(){ $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&mode=favfadd&favnum=\'+$(\'input#favnum\').val(), function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 1000, cls: status }); $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&header_menu=1\', function(data){$(\'div#wrapper_headerlist\').html(data);}); }); });">Create</a>';
?>
     </td>
     <td>
      <select id="favnum" name="favnum" style="width:100px;">
       <option value="">-</option>
       <?php if (count($favnumarr2)>0) { foreach ($favnumarr2 as $val3) { echo '<option value="'.$val3.'" id="favmenu_'.$val3.'">'.$val3.'</option>'; } } ?>
      </select>
<?php
 echo '<a href="#" onClick="if(window.confirm($(\'select#favnum\').val()+\'を削除してよろしいですか？\')){ $(function(){ $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&mode=favfdel&favnum=\'+$(\'select#favnum\').val(), function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 1000, cls: status }); $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$id.'&header_menu=1\', function(data){$(\'div#wrapper_headerlist\').html(data);}); }); }); return false; }">Delete</a>';
?>
     </td>
    </tr>
   </table>
<?php if ( $_REQUEST['header_menu'] != '1' ) { ?>
  </div>
  <div style="clear:both;"></div>

<?php if ( ($arguments['mode'] == '') || ($arguments['mode'] == 'music') ) { ?>
  <div id="wrapper">
   <audio preload="auto" autoplay="autoplay" id="audio"></audio>
  <div id="lyrics"></div>
   <div id="wrapper_list">
    <ol id="sort_list">
<?php } else { ?>
  <ol id="sort_list">
<?php } ?>
<?php } ?>
