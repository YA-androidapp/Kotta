<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<?php if ( $arguments['mode'] == 'music' ) { ?>
    </ol>
   </div>
  </div>
<?php } else { ?>
  </ol>
<?php } ?>

<?php  if ( $folders != '' ) { ?>
  <div id="wrapper_footerlist">
   <ol>
    <?php echo $folders; ?>
   </ol>
  </div>
  <br />
<?php  } ?>

<?php
 $flag = ($_SERVER['HTTPS']!='') ? 's' : '';
 $permalink = 'http'.$flag.'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?'.http_build_query($arguments);
 $permalink = str_replace('dir='.urlencode($base_dir.'/'),'dir=' , $permalink);
 $permalink = str_replace('dir='.urlencode($base_dir),'dir=' , $permalink);
?>
  <div id="permalink" align="right">
   Permanent Link: 
   <a href="<?php echo $permalink; ?>">
<?php echo mb_substr($permalink, 0, 40); ?>...<?php echo mb_substr($permalink, mb_strlen($permalink)-20, 20); ?>
   </a>
  </div>

<div id="footer_space">
</div>

<?php if ( $arguments['mode'] == 'music' ) { ?>
 <div id="control">
  <div id="control1">
   <div class="toggle" onclick="jQuery('#control #playcontrol').toggle()">Control</div>
   <form id="playcontrol" style="background-color:transparent;">
    <input type="button" id="control_prev" value="Prev" title="Ctrl+←/Shift+←">
    <input type="button" id="control_play" value="P/P" title="Ctrl+Space/Shift+Space">
    <input type="button" id="control_twtr" value="t">
    <input type="button" id="control_pullfavnum" value="f">
    <input type="button" id="control_next" value="Next" title="Ctrl+→/Shift+→">
    <div id="volume_control" title="100">
     Volume<br />
     <input type="text" name="slide" value="" id="num" readonly="readonly" />
     <div id="slider"></div>
    </div>
    <div id="speed_control" title="1.0">
     Speed<br />
     <input type="text" name="slide" value="" id="num" readonly="readonly" />
     <div id="slider"></div>
    </div>
   </form>
  </div>
  <div id="control2">
   <div class="toggle" onclick="jQuery('#control #checkbox_auto').toggle()">Confs</div>
   <form id="checkbox_auto" style="background-color:transparent;">
    <input type="checkbox" accesskey="o" id="enable_loop"<?php if($arguments['enable_loop']==1){echo ' checked="checked"';} ?>>１曲ループ(<u title="Alt+Shift+O">O</u>)<br>
    <input type="checkbox" accesskey="a" id="enable_allloop"<?php if($arguments['enable_allloop']!=0){echo ' checked="checked"';} ?>>全曲ループ(<u title="Alt+Shift+A">A</u>)<br>
    <input type="checkbox" accesskey="r" id="enable_recently_played"<?php if($arguments['enable_recently_played']!=0){echo ' checked="checked"';} ?>>「最近聞いた曲」を自動更新(<u title="Alt+Shift+R">R</u>)<br>
    <input type="checkbox" accesskey="p" id="enable_autotweet"<?php if($arguments['enable_autotweet']==1){echo ' checked="checked"';} ?>>#nowplayingを自動投稿(<u title="Alt+Shift+P">P</u>)<br>
    <input type="checkbox" accesskey="n" id="enable_notification"<?php if($arguments['enable_notification']==1){echo ' checked="checked"';} ?>>次に再生する曲を通知(<u title="Alt+Shift+N">N</u>)<br>
    <input type="checkbox" accesskey="m" id="enable_muted"<?php if($arguments['enable_muted']==1){echo ' checked="checked"';} ?>>ミュート(<u title="Alt+Shift+M">M</u>)<br>
    <input type="checkbox" accesskey="l" id="enable_lyric"<?php if($arguments['enable_lyric']==1){echo ' checked="checked"';} ?>>歌詞表示(<u title="Alt+Shift+L">L</u>)
   </form>
  </div>
  <div id="control3">
   <div class="toggle" onclick="jQuery('#control #pagesearch').toggle()">Filtering and Sorting</div>
   <form id="pagesearch" style="background-color:transparent;">
    Filter:<input type="text" id="pageq" value="" title="フィルタリング">
    <select id="pagesearchtype" title="Filter">
     <option value=".title">title</option>
     <option value=".artist">artist</option>
     <option value=".album">album</option>
     <option value=".genre">genre</option>
     <option value=".number">number</option>
     <option value=".time_m">time_m</option>
     <option value=".time_s">time_s</option>
    </select>
    <select id="pagesort" title="Sort">
     <option value="filename_u"<?php echo ( ($_REQUEST['sort']=='filename_u') || ($_SESSION['sort']=='filename_u') ) ? ' selected="selected"' : ''; ?>>ファイル名 - 昇順</option>
     <option value="filename_d"<?php echo ( ($_REQUEST['sort']=='filename_d') || ($_SESSION['sort']=='filename_d') ) ? ' selected="selected"' : ''; ?>>ファイル名 - 降順</option>
     <option value="title_u"<?php echo ( ($_REQUEST['sort']=='title_u') || ($_SESSION['sort']=='title_u') ) ? ' selected="selected"' : ''; ?>>曲名 - 昇順</option>
     <option value="title_d"<?php echo ( ($_REQUEST['sort']=='title_d') || ($_SESSION['sort']=='title_d') ) ? ' selected="selected"' : ''; ?>>曲名 - 降順</option>
     <option value="artist_u"<?php echo ( ($_REQUEST['sort']=='artist_u') || ($_SESSION['sort']=='artist_u') ) ? ' selected="selected"' : ''; ?>>アーティスト名 - 昇順</option>
     <option value="artist_d"<?php echo ( ($_REQUEST['sort']=='artist_d') || ($_SESSION['sort']=='artist_d') ) ? ' selected="selected"' : ''; ?>>アーティスト名 - 降順</option>
     <option value="trackinfo_u"<?php echo ( (($_REQUEST['favnum']=='')&&($_REQUEST['sort']=='')) || ($_REQUEST['sort']=='trackinfo_u') || ($_SESSION['sort']=='trackinfo_u') ) ? ' selected="selected"' : ''; ?>>曲情報 - 昇順</option>
     <option value="trackinfo_d"<?php echo ( ($_REQUEST['sort']=='trackinfo_d') || ($_SESSION['sort']=='trackinfo_d') ) ? ' selected="selected"' : ''; ?>>曲情報 - 降順</option>
     <option value="random"<?php echo ( ($_REQUEST['sort']=='random') || ($_SESSION['sort']=='random') ) ? ' selected="selected"' : ''; ?>>ランダム</option>
     <option value="none"<?php echo ( (($_REQUEST['favnum']!='')&&($_REQUEST['sort']=='')) || ($_REQUEST['sort']=='none') || ($_SESSION['sort']=='none') ) ? ' selected="selected"' : ''; ?>>なし</option>
    </select>
   </form>
  </div>
  <div id="control4">
   <div class="toggle" onclick="jQuery('#control #copyrights_list').toggle()">About</div>
   <?php require_once(realpath(__DIR__).'/copyrights.php'); ?>
  </div>
 </div>
<?php } ?>
