<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
  <img id='kotta' src='icon/kotta_s.png' />
  <div id='wrapper_headerlist'>
   ||
   [
   User:<input type='text' id='id' name='id' title='User' value='<?php echo $id; ?>'>
   Password:<input type='password' id='pw' name='pw' title='Password' value='<?php echo $pw; ?>'>
   OTP Password:<input type='number' id='pw2' name='pw2' title='OTP Password' max='999999' />
   ]
   <br>
   ||
   <a href='<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?menu=1'>Menu</a> ||
   <small><a target='sns' href='tweet/index.php'>Authentication in Twitter</a></small> ||
   <a href='<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?logout=1'>Logout</a> ||
<?php if ( $arguments['mode'] == 'music' ) { ?>
   <div id='controls'>
    <div class='toggle' onclick='jQuery("#wrapper_headerlist #playcontrol").toggle()'>Control</div>
    <form id='playcontrol'>
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
    <form id='checkbox_auto'>
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
    <form id='pagesearch'>
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
       <img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfcBAgLLBS2oqjpAAACWklEQVQ4T6VUv2/TQBh9d86PpnaApkKIgdIJspUFsbEwM3ZgYEFILEiwsSIWxAD/AHP/DhYkSlVUVAmEBEIVQi1CSVOROKnt2Mf7znFxXAeE+qLns+7ue/e97z5HPd8emPOehjE4GRTwo59ArX0dmvjEaikUfzqkVpQojM1xzpovY2RHir78PDCJvExOESTkMAY0xxoflfziDIhH2a9T5fQEYSgjM3t42cWDtguv4iDgCdn6LGYaFEz48od+nOCS50BNslo546BDxSHnMwaFmDwpKDWUDFKG9B9JDSaYp99lHrA0r3GBvOg6tiOkJFlMnurpx76toUCSGsUGV09XcXNpLp2cgReffJutzqwQ8qbDJMF4wsjSgJr/RKuqWVtzFJvF20sJKCCUFgroJ+cYAdX3/Bg/6VHYHcV4vRfiTSe0KWWxGdWj7QNjeKuyKCn7bKbrrRpWlxtW8NVugGcfBlisy6rsUWjUFBZZz9y5R6BlyczYyxALkmH+w2kvVFBvKDRdDY90XYUaxWWvxBSp7m9JhoyUBCgU83HO0Xi8csoKCnZoebMXwuF7VSt8GYzx/lcEj/uKUPfe7Zt8RqK76ydYu9ZCc2KzDE9Yhp1RhGphS2o5Rylsq6FxZ72H3qGkXo5wLLc6HStUtze6aYaFk2Tu+0GCG2fruMI68tux8xW63OiO8dYPsEAHOXMW6tbGvmH7HBMUSM+GvPU++ykriwzNGjBH5aKYQK2ud6ZqWAbewxR4mTOh2af8MtRfGbJP8yzbI/82UnJ1d7Nnvh1GdFzi+T8gLtteFb8BfXnMH2QhvcwAAAAASUVORK5CYII=' alt='twitterに投稿する' id='twtr' title='twitterに投稿する' onClick='window.open("<?php echo str_replace(basename($_SERVER['SCRIPT_NAME']), 'tweet/tweet.php', $_SERVER['SCRIPT_NAME']); ?>?pass_autotweet=1&tweettext="+encodeURIComponent(jQuery("#tweettext").val()), "sns");return false;'>
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
       <input type='text' id='favname' name='favname' pattern='^[a-zA-Z0-9][-_a-zA-Z0-9]*$' title='名前'>(半角英数)
       <a href='#' id='favfadd'>Create</a>
      </td>
      <td>
       <select id='favname' name='favname'>
        <option value=''>-</option>
<?php if (count($favnamearr2)>0) { foreach ($favnamearr2 as $val3) { echo '<option value="'.htmlspecialchars($val3, ENT_QUOTES).'" id="favmenu_'.htmlspecialchars($val3, ENT_QUOTES).'">'.$val3.'</option>'; } } ?>
       </select>
        <a href='#' id='favfdel'>Delete</a>
      </td>
     </tr>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #dirs").toggle();'>Directories</div>
   <div id='dirs'>
    <ul id='dirslist'></ul>
    <table id='header_dirmenu'>
     <tr>
      <td class='dir'>
       <input type='text' id='dirname' name='dirname' title='ディレクトリ名'>
      </td>
      <td>
       <a href='#' onClick='var url="ls_dir.php?dirname="+encodeURIComponent(jQuery("input#dirname").val());pullls(url);'>[Add]</a>
      </td>
      <td>
       <a href='#' onClick='var url="db_write.php?dirname="+encodeURIComponent(jQuery("input#dirname").val())+"&id="+jQuery("input#id").val()+"&pw="+jQuery("input#pw").val();window.open(url,"db");'>[AddDB]</a>
      </td>
     </tr>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #sql").toggle();'>SQL</div>
   <div id='sql'>
    <table id='header_sqlmenu'>
     <tr>
      <td>
       <select id='sqlwhere' name='sqlwhere' title='SQL:Where'>
        <option value='album'>Album</option>
        <option value='artist'>Artist</option>
        <option value='basename'>Filename</option>
        <option value='genre'>Genre</option>
        <option value='number'>Number</option>
        <option value='title' selected='selected'>Title</option>
       </select>
      </td>
      <td>
       <input type='text' id='sqllike' name='sqllike' title='SQL:Like'>
      </td>
      <td>
       <a href='#' onClick='var url="ls_sql.php?sqlwhere="+encodeURIComponent(jQuery("select#sqlwhere").val())+"&sqllike="+encodeURIComponent(jQuery("input#sqllike").val());pullls(url);'>[Add]</a>
      </td>
     </tr>
<?php if (file_exists('conf/musics.sqlite3')) { ?>
<?php if ( (time() - filemtime('conf/musics.sqlite3')) > (0) ) { ?>
     <tr>
      <td colspan='3'>
       <iframe src='db_write.php?check=0' id='dbwrite' name='dbwrite'></iframe>
      </td>
     </tr>
<?php } ?>
<?php } ?>
    </table>
   </div>
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #copyrights_list").toggle()'>About</div>
   <?php require_once(realpath(__DIR__).'/copyrights.php'); ?>
  </div>
  <div class='clearboth'></div>

<?php if ( ($arguments['mode'] == '') || ($arguments['mode'] == 'music') ) { ?>
  <div id='wrapper'>
   <audio preload='auto' autoplay='autoplay' id='audio'></audio>
  <div id='lyrics'></div>
   <div id='wrapper_list'>
    <ol id='sort_list'>
<?php } else { ?>
  <ol id='sort_list'>
<?php } ?>
