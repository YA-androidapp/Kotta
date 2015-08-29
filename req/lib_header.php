<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
  <img height='128px' width='128px' src='icon/kotta.png' />
  <div id='wrapper_headerlist'>
   ||
   [
   User:<input type='text' id='id' name='id' title='User' value='<?php echo $id; ?>' size='6' maxlength='6'>
   Password:<input type='password' id='pw' name='pw' title='Password' value='<?php echo $pw; ?>' size='6' maxlength='6'>
   <input type='password' id='pw2' name='pw2' title='OTP Password' size='6' maxlength='6'>
   ]
   <br>
   ||
   <a href='<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?menu=1'>Menu</a> ||
   <small><a target='sns' href='tweet/index.php'>Authentication in Twitter</a></small> ||
   <a href='<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?logout=1'>Logout</a> ||
<?php if ( $arguments['mode'] == 'music' ) { ?>
   <div id='controls'>
    <div class='toggle' onclick='jQuery("#wrapper_headerlist #playcontrol").toggle()'>Control</div>
    <form id='playcontrol' style='background-color:transparent;'>
     <input type='button' id='control_prev' value='Prev' title='Ctrl+←/Shift+←'>
     <input type='button' id='control_play' value='' title='Ctrl+Space/Shift+Space'>
     <input type='button' id='control_twtr' class='half' value='t' title='Tweet'>
     <input type='button' id='control_pulldirname' class='half' value='d' title='Reload Directories list'>
     <input type='button' id='control_pullfavname' class='half' value='f' title='Reload Favorites list'>
     <input type='button' id='control_next' value='Next' title='Ctrl+→/Shift+→'>
     <div id='volume_control' title='100'>
      Volume<br />
      <input type='text' name='slide' value='' id='num' readonly='readonly' />
      <div id='slider'></div>
     </div>
     <div id='speed_control' title='1.0'>
      Speed<br />
      <input type='text' name='slide' value='' id='num' readonly='readonly' />
      <div id='slider'></div>
     </div>
    </form>
   </div>
   <div id='confs'>
    <div class='toggle' onclick='jQuery("#wrapper_headerlist #checkbox_auto").toggle()'>Confs</div>
    <form id='checkbox_auto' style='background-color:transparent;'>
     <input type='checkbox' accesskey='o' id='enable_loop'<?php if($arguments['enable_loop']==1){echo ' checked="checked"';} ?>>１曲ループ(<u title='Alt+Shift+O'>O</u>)<br>
     <input type='checkbox' accesskey='a' id='enable_allloop'<?php if($arguments['enable_allloop']!=0){echo ' checked="checked"';} ?>>全曲ループ(<u title='Alt+Shift+A'>A</u>)<br>
     <input type='checkbox' accesskey='r' id='enable_recently_played'<?php if($arguments['enable_recently_played']!=0){echo ' checked="checked"';} ?>>「最近聞いた曲」を自動更新(<u title='Alt+Shift+R'>R</u>)<br>
     <input type='checkbox' accesskey='p' id='enable_autotweet'<?php if($arguments['enable_autotweet']==1){echo ' checked="checked"';} ?>>#nowplayingを自動投稿(<u title='Alt+Shift+P'>P</u>)<br>
     <input type='checkbox' accesskey='n' id='enable_notification'<?php if($arguments['enable_notification']==1){echo ' checked="checked"';} ?>>次に再生する曲を通知(<u title='Alt+Shift+N'>N</u>)<br>
     <input type='checkbox' accesskey='m' id='enable_muted'<?php if($arguments['enable_muted']==1){echo ' checked="checked"';} ?>>ミュート(<u title='Alt+Shift+M'>M</u>)<br>
     <input type='checkbox' accesskey='l' id='enable_lyric'<?php if($arguments['enable_lyric']==1){echo ' checked="checked"';} ?>>歌詞表示(<u title='Alt+Shift+L'>L</u>)
    </form>
   </div>
   <div id='filtersort'>
    <div class='toggle' onclick='jQuery("#wrapper_headerlist #pagesearch").toggle()'>Filtering and Sorting</div>
    <form id='pagesearch' style='background-color:transparent;'>
     <table id='header_tweet'>
      <tr>
       <td>
        Filter:
       </td>
       <td>
        <input type='text' id='pageq' value='' title='フィルタリング'>
       </td>
       <td>
        <select id='pagesearchtype' title='Filter'>
         <option value='.title'>title</option>
         <option value='.artist'>artist</option>
         <option value='.album'>album</option>
         <option value='.genre'>genre</option>
         <option value='.number'>number</option>
         <option value='.time_m'>time_m</option>
         <option value='.time_s'>time_s</option>
        </select>
       </td>
      </tr>
      <tr>
       <td colspan='3'>
        <select id='pagesort' title='Sort'>
         <option value='filename_u'<?php echo ( ($_REQUEST['sort']=='filename_u') || ($_SESSION['sort']=='filename_u') ) ? ' selected="selected"' : ''; ?>>ファイル名 - 昇順</option>
         <option value='filename_d'<?php echo ( ($_REQUEST['sort']=='filename_d') || ($_SESSION['sort']=='filename_d') ) ? ' selected="selected"' : ''; ?>>ファイル名 - 降順</option>
         <option value='title_u'<?php echo ( ($_REQUEST['sort']=='title_u') || ($_SESSION['sort']=='title_u') ) ? ' selected="selected"' : ''; ?>>曲名 - 昇順</option>
         <option value='title_d'<?php echo ( ($_REQUEST['sort']=='title_d') || ($_SESSION['sort']=='title_d') ) ? ' selected="selected"' : ''; ?>>曲名 - 降順</option>
         <option value='artist_u'<?php echo ( ($_REQUEST['sort']=='artist_u') || ($_SESSION['sort']=='artist_u') ) ? ' selected="selected"' : ''; ?>>アーティスト名 - 昇順</option>
         <option value='artist_d'<?php echo ( ($_REQUEST['sort']=='artist_d') || ($_SESSION['sort']=='artist_d') ) ? ' selected="selected"' : ''; ?>>アーティスト名 - 降順</option>
         <option value='trackinfo_u'<?php echo ( (($_REQUEST['favname']=='')&&($_REQUEST['sort']=='')) || ($_REQUEST['sort']=='trackinfo_u') || ($_SESSION['sort']=='trackinfo_u') ) ? ' selected="selected"' : ''; ?>>曲情報 - 昇順</option>
         <option value='trackinfo_d'<?php echo ( ($_REQUEST['sort']=='trackinfo_d') || ($_SESSION['sort']=='trackinfo_d') ) ? ' selected="selected"' : ''; ?>>曲情報 - 降順</option>
         <option value='random'<?php echo ( ($_REQUEST['sort']=='random') || ($_SESSION['sort']=='random') ) ? ' selected="selected"' : ''; ?>>ランダム</option>
         <option value='none'<?php echo ( (($_REQUEST['favname']!='')&&($_REQUEST['sort']=='')) || ($_REQUEST['sort']=='none') || ($_SESSION['sort']=='none') ) ? ' selected="selected"' : ''; ?>>なし</option>
        </select>
       </td>
      </tr>
     </table>
    </form>
   </div>
<?php } ?>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #tweet").toggle();'>Tweet</div>
   <div id='tweet'>
    <table id='header_tweet'>
     <tr>
      <td colspan='2'>
       Screenname:<span id='screen_name'><?php echo ($_SESSION['oa_screen_name']!='') ? '@'.$_SESSION['oa_screen_name'] : '---'; ?></span>
      </td>
     </tr>
     <tr>
      <td>
       <textarea id='tweettext'></textarea>
      </td>
      <td>
       <img height='20px' src='icon/twtr2.png' alt='twitterに投稿する' title='twitterに投稿する' onClick='window.open("<?php echo str_replace(basename($_SERVER['SCRIPT_NAME']), 'tweet/tweet.php', $_SERVER['SCRIPT_NAME']); ?>?pass_autotweet=1&tweettext="+encodeURIComponent(jQuery("#tweettext").val()), "sns");return false;'>
      </td>
     </tr>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #favs").toggle();'>My Favorites</div>
   <div id='favs'>
    <ul id='favslist'></ul>
    <table id='header_favmenu'>
     <tr>
      <td>
       <input type='text' id='favname' name='favname' title='名前' style='width:100px;'>
       <a href='#' id='favfadd'>Create</a>
      </td>
      <td>
       <select id='favname' name='favname' style='width:100px;'>
        <option value=''>-</option>
<?php if (count($favnamearr2)>0) { foreach ($favnamearr2 as $val3) { echo '<option value="'.$val3.'" id="favmenu_'.$val3.'">'.$val3.'</option>'; } } ?>
       </select>
        <a href='#' id='favfdel'>Delete</a>
      </td>
     </tr>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #dirs").toggle();'>Directories(autocomplete)</div>
   <div id='dirs'>
    <ul id='dirslist'></ul>
    <table id='header_dirmenu'>
     <tr>
      <td>
       <input type='text' id='dir' name='dir' title='ディレクトリ名' style='width:250px;'>
      </td>
      <td>
       <a href='#' onClick='var url="ls_dir.php?dirname="+jQuery("input#dirname").val();pullls(url);'>[Add]</a>
      </td>
      <td>
       <a href='#' onClick='var url="db_write.php?dirname="+jQuery("input#dirname").val()+"&id="+jQuery("input#id").val()+"&pw="+jQuery("input#pw").val();window.open(url,"db");'>[AddDB]</a>
      </td>
     </tr>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #sql").toggle();'>SQL</div>
   <div id='sql'>
    <table id='header_dirmenu'>
     <tr>
      <td colspan='3'>
       <small><small><a href='db_write.php'>DB-Rebuilding</a></small></small>
      </td>
     </tr>
     <tr>
      <td>
       <select id='sqlwhere' name='sqlwhere' title='SQL:Where' style='width:100px;'>
        <option value='album'>Album</option>
        <option value='artist'>Artist</option>
        <option value='basename'>Filename</option>
        <option value='genre'>Genre</option>
        <option value='number'>Number</option>
        <option value='title' selected='selected'>Title</option>
       </select>
      </td>
      <td>
       <input type='text' id='sqllike' name='sqllike' title='SQL:Like' style='width:150px;'>
      </td>
      <td>
       <a href='#' onClick='var url="ls_sql.php?sqlwhere="+jQuery("select#sqlwhere").val()+"&sqllike="+jQuery("input#sqllike").val();pullls(url);'>[Add]</a>
      </td>
     </tr>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #copyrights").toggle()'>About</div>
   <div id='copyrights'>
    <?php require_once(realpath(__DIR__).'/copyrights.php'); ?>
   </div>
  </div>
  <div style='clear:both;'></div>

<?php if ( ($arguments['mode'] == '') || ($arguments['mode'] == 'music') ) { ?>
  <div id='wrapper'>
   <audio preload='auto' autoplay='autoplay' id='audio'></audio>
  <div id='lyrics'></div>
   <div id='wrapper_list'>
    <ol id='sort_list'>
<?php } else { ?>
  <ol id='sort_list'>
<?php } ?>
