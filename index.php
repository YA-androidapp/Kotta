<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(E_ALL^E_NOTICE);

require_once(realpath(__DIR__).DIRECTORY_SEPARATOR.'req'.DIRECTORY_SEPARATOR.'lib_io.php');
require_once(arsep(__DIR__,'conf').DSEP.'index.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_envcheck.php');

if ( $_REQUEST['logout'] == '1' ) { require_once(arsep(__DIR__,'req').DSEP.'lib_logout.php');die(''); }

$throughAuth = true;
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_idpw.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_auth_otp.php');
$throughAuth = false;

if ( ( isset($_REQUEST['output_path']) ) && ( $_REQUEST['output_path'] !== '' ) ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_output.php');die('');
}

require_once(arsep(__DIR__,'req').DSEP.'lib_getdirtree.php');
require_once(arsep(__DIR__,'req').DSEP.'mp3tag_getid3.php');
require_once(arsep(__DIR__,'req').DSEP.'lib_get_new_files.php');

$folders = '';

require_once(arsep(__DIR__,'req').DSEP.'lib_getarg.php');
if ( $arguments['mode'] == 'favmenu' ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_favmenu.php');die('');
} elseif ( $arguments['mode'] == 'favadd' ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_favadd.php');die('');
} elseif ( $arguments['mode'] == 'favdel' ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_favdel.php');die('');
} elseif ( $arguments['mode'] == 'favfadd' ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_favfadd.php');die('');
} elseif ( $arguments['mode'] == 'favfdel' ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_favfdel.php');die('');
} elseif ( $_REQUEST['mode'] == 'rpadd' ) {
 $arguments['favname'] = '_recently_played';
 require_once(arsep(__DIR__,'req').DSEP.'lib_favadd.php');die('');
} elseif ( ($arguments['mode'] == 'upload') && ($enable_upload == 1) ) {
 require_once(arsep(__DIR__,'req').DSEP.'lib_upload.php');die('');
}

$dirarr = array();
$depth1 = 0;
$depth2 = 0;
if ( $arguments['favname'] === '_recently_added' ) {
 $url = 'ls_fav.php?favname=_recently_added'.(( $arguments['dirname'] !== '' )?('&dirname='.rawurlencode($arguments['dirname'])):(''));
} elseif ( $arguments['favname'] !== '' ) {
 $url = 'ls_fav.php?favname='.rawurlencode($arguments['favname']);
} elseif ( $arguments['dirname'] !== '' ) {
 $url = 'ls_dir.php?dirname='.rawurlencode($arguments['dirname']);
}
?>
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='utf-8'>
  <title>Kotta</title>
  <!-- style -->
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel='stylesheet' type='text/css' href='https://code.jquery.com/ui/1.10.3/themes/ui-darkness/jquery-ui.css' />
  <link rel='stylesheet' type='text/css' href='js/jQuery-Notify-bar/jquery.notifyBar.css' />
  <link rel='stylesheet' type='text/css' href='css/kirinlyric.css'>
  <link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload.css'>
  <link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-ui.css'>
  <noscript>
    <link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-noscript.css'>
  </noscript>
  <noscript>
    <link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-ui-noscript.css'>
  </noscript>
  <link rel='stylesheet' type='text/css' href='css/kotta.css'>
  <link rel='stylesheet' type='text/css' href='css/tgl.css'>
  <!-- Style -->
  <?php
  require_once(arsep(__DIR__,'req').DSEP.'lib_js.php');
  ob_end_flush();
  ob_start();
  flush();
  ?>
</head>

<body>
  <!-- header -->
  <img id='kotta' src='icon/kotta_s.png' />
  <div id='hlist'>
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
      <tr>
        <td>Permanent Link</td>
        <td colspan='2'>
          <div id='permalink' align='right'>
            <?php
            $flag = ($_SERVER['HTTPS']!='') ? 's' : '';
            $permalink = 'http'.$flag.'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?'.http_build_query($arguments);
            $permalink = str_replace('dirname='.rawurlencode(arsep($base_dir,'')),'dirname=' , $permalink);
            ?>
            <a href='<?php echo $permalink; ?>'>
              <?php echo mb_substr($permalink, 0, 40); ?>...
              <?php echo mb_substr($permalink, mb_strlen($permalink)-60, 60); ?>
            </a>
          </div>
        </td>
      </tr>
      <tr>
        <td><a href='<?php echo basename($_SERVER[' SCRIPT_NAME ']); ?>?menu=1'>Menu</a></td>
        <td></td>
        <td><a href='<?php echo basename($_SERVER[' SCRIPT_NAME ']); ?>?logout=1'>Logout</a></td>
      </tr>
    </table>
    <?php if ( $arguments['mode'] == 'music' ) { ?>
      <div class='toggle' onclick='jQuery("#playcontrol").toggle()'>Control</div>
      <form id='playcontrol'>
        <input type='button' id='control_prev' value='Prev' title='Ctrl+←/Shift+←'>
        <input type='button' id='control_play' value='' title='Ctrl+Space/Shift+Space'>
        <input type='button' id='control_twtr' value='Tweet'>
        <input type='button' id='control_next' value='Next' title='Ctrl+→/Shift+→'>
        <div id='volume_control' title='100'>
          Volume
          <br />
          <input type='text' name='slide' value='' id='num' readonly='readonly' />
          <div id='slider'></div>
        </div>
        <div id='speed_control' title='1.0'>
          Speed
          <br />
          <input type='text' name='slide' value='' id='num' readonly='readonly' />
          <div id='slider'></div>
        </div>
      </form>
      <div class='toggle' onclick='jQuery("#checkbox_auto").toggle()'>Confs</div>
      <form id='checkbox_auto'>
        <div>
          <span>１曲ループ(<u title='Alt+Shift+O'>O</u>)</span>
          <input type='checkbox' accesskey='o' id='enable_loop' class='tgl tgli' <?php if($arguments[ 'enable_loop']==1){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_loop' />
        </div>
        <div>
          <span>全曲ループ(<u title='Alt+Shift+A'>A</u>)</span>
          <input type='checkbox' accesskey='a' id='enable_allloop' class='tgl tgli' <?php if($arguments[ 'enable_allloop']!=0){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_allloop' />
        </div>
        <div>
          <span>「最近聞いた曲」を自動更新(<u title='Alt+Shift+R'>R</u>)</span>
          <input type='checkbox' accesskey='r' id='enable_recently_played' class='tgl tgli' <?php if($arguments[ 'enable_recently_played']!=0){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_recently_played' />
        </div>
        <div>
          <span>#nowplayingを自動投稿(<u title='Alt+Shift+P'>P</u>)</span>
          <input type='checkbox' accesskey='p' id='enable_autotweet' class='tgl tgli' <?php if($arguments[ 'enable_autotweet']==1){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_autotweet' />
        </div>
        <div>
          <span>次に再生する曲を通知(<u title='Alt+Shift+N'>N</u>)</span>
          <input type='checkbox' accesskey='n' id='enable_notification' class='tgl tgli' <?php if($arguments[ 'enable_notification']==1){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_notification' />
        </div>
        <div>
          <span>ミュート(<u title='Alt+Shift+M'>M</u>)</span>
          <input type='checkbox' accesskey='m' id='enable_muted' class='tgl tgli' <?php if($arguments[ 'enable_muted']==1){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_muted' />
        </div>
        <div>
          <span>歌詞表示(<u title='Alt+Shift+L'>L</u>)</span>
          <input type='checkbox' accesskey='l' id='enable_lyric' class='tgl tgli' <?php if($arguments[ 'enable_lyric']==1){echo ' checked="checked"';} ?>>
          <label class='tgl-btn' for='enable_lyric' />
        </div>
        <div>
          <select name='enable_autotweet' id='enable_autotweet'>
            <option value='1'>再生完了時に自動的にツイートする</option>
            <option value='0' selected='selected'>再生完了時に自動的にツイートしない</option>
          </select>
        </div>
        <div>
          <select name='pass_autotweet' id='pass_autotweet'>
            <option value='0'>ツイート時に確認する</option>
            <option value='1' selected='selected'>ツイート時に確認しない</option>
          </select>
        </div>
      </form>
      <div class='toggle' onclick='jQuery("#pagesearch").toggle()'>Filtering and Sorting</div>
      <form id='pagesearch'>
        <table>
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
                <option value='filename_u' <?php echo ( ($_REQUEST[ 'sort']=='filename_u' ) || ($_SESSION[ 'sort']=='filename_u' ) ) ? ' selected="selected"' : ''; ?>>ファイル名 - 昇順</option>
                <option value='filename_d' <?php echo ( ($_REQUEST[ 'sort']=='filename_d' ) || ($_SESSION[ 'sort']=='filename_d' ) ) ? ' selected="selected"' : ''; ?>>ファイル名 - 降順</option>
                <option value='title_u' <?php echo ( ($_REQUEST[ 'sort']=='title_u' ) || ($_SESSION[ 'sort']=='title_u' ) ) ? ' selected="selected"' : ''; ?>>曲名 - 昇順</option>
                <option value='title_d' <?php echo ( ($_REQUEST[ 'sort']=='title_d' ) || ($_SESSION[ 'sort']=='title_d' ) ) ? ' selected="selected"' : ''; ?>>曲名 - 降順</option>
                <option value='artist_u' <?php echo ( ($_REQUEST[ 'sort']=='artist_u' ) || ($_SESSION[ 'sort']=='artist_u' ) ) ? ' selected="selected"' : ''; ?>>アーティスト名 - 昇順</option>
                <option value='artist_d' <?php echo ( ($_REQUEST[ 'sort']=='artist_d' ) || ($_SESSION[ 'sort']=='artist_d' ) ) ? ' selected="selected"' : ''; ?>>アーティスト名 - 降順</option>
                <option value='trackinfo_u' <?php echo ( (($_REQUEST[ 'favname']=='' )&&($_REQUEST[ 'sort']=='' )) || ($_REQUEST[ 'sort']=='trackinfo_u' ) || ($_SESSION[ 'sort']=='trackinfo_u' ) ) ? ' selected="selected"' : ''; ?>>曲情報 - 昇順</option>
                <option value='trackinfo_d' <?php echo ( ($_REQUEST[ 'sort']=='trackinfo_d' ) || ($_SESSION[ 'sort']=='trackinfo_d' ) ) ? ' selected="selected"' : ''; ?>>曲情報 - 降順</option>
                <option value='random' <?php echo ( ($_REQUEST[ 'sort']=='random' ) || ($_SESSION[ 'sort']=='random' ) ) ? ' selected="selected"' : ''; ?>>ランダム</option>
                <option value='none' <?php echo ( (($_REQUEST[ 'favname']!='' )&&($_REQUEST[ 'sort']=='' )) || ($_REQUEST[ 'sort']=='none' ) || ($_SESSION[ 'sort']=='none' ) ) ? ' selected="selected"' : ''; ?>>なし</option>
              </select>
            </td>
          </tr>
        </table>
      </form>
      <?php } ?>
      <div class='toggle' onclick='jQuery("#tweet").toggle();'>Tweet</div>
      <div id='tweet'>
        <table>
          <tr>
            <td>
              Screenname:<span id='screen_name'><?php echo ($_SESSION['oa_screen_name']!='') ? '@'.$_SESSION['oa_screen_name'] : '---'; ?></span>
            </td>
            <td>
              <small><a target='sns' href='tweet/index.php'>Authentication in Twitter</a></small>
            </td>
          </tr>
          <tr class='nowplaying'>
            <td>書式</td>
            <td>
              <input type='text' id='sns_format' name='sns_format' value='<?php echo $confs[' sns_format ']; ?>' title='書式： %a:アーティスト名, %g:ジャンル, %l:アルバム名, %m:再生時間(分), %n:トラック番号, %s:再生時間(秒), %t:曲名, %u:URI' />
            </td>
          </tr>
          <tr>
            <td colspan='2'>
              <textarea id='tweettext'></textarea>
              <img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfcBAgLLBS2oqjpAAACWklEQVQ4T6VUv2/TQBh9d86PpnaApkKIgdIJspUFsbEwM3ZgYEFILEiwsSIWxAD/AHP/DhYkSlVUVAmEBEIVQi1CSVOROKnt2Mf7znFxXAeE+qLns+7ue/e97z5HPd8emPOehjE4GRTwo59ArX0dmvjEaikUfzqkVpQojM1xzpovY2RHir78PDCJvExOESTkMAY0xxoflfziDIhH2a9T5fQEYSgjM3t42cWDtguv4iDgCdn6LGYaFEz48od+nOCS50BNslo546BDxSHnMwaFmDwpKDWUDFKG9B9JDSaYp99lHrA0r3GBvOg6tiOkJFlMnurpx76toUCSGsUGV09XcXNpLp2cgReffJutzqwQ8qbDJMF4wsjSgJr/RKuqWVtzFJvF20sJKCCUFgroJ+cYAdX3/Bg/6VHYHcV4vRfiTSe0KWWxGdWj7QNjeKuyKCn7bKbrrRpWlxtW8NVugGcfBlisy6rsUWjUFBZZz9y5R6BlyczYyxALkmH+w2kvVFBvKDRdDY90XYUaxWWvxBSp7m9JhoyUBCgU83HO0Xi8csoKCnZoebMXwuF7VSt8GYzx/lcEj/uKUPfe7Zt8RqK76ydYu9ZCc2KzDE9Yhp1RhGphS2o5Rylsq6FxZ72H3qGkXo5wLLc6HStUtze6aYaFk2Tu+0GCG2fruMI68tux8xW63OiO8dYPsEAHOXMW6tbGvmH7HBMUSM+GvPU++ykriwzNGjBH5aKYQK2ud6ZqWAbewxR4mTOh2af8MtRfGbJP8yzbI/82UnJ1d7Nnvh1GdFzi+T8gLtteFb8BfXnMH2QhvcwAAAAASUVORK5CYII=' alt='twitterに投稿する' id='tweet_img' title='twitterに投稿する' onClick='window.open("<?php echo str_replace(basename($_SERVER[' SCRIPT_NAME ']), 'tweet/tweet.php ', $_SERVER['SCRIPT_NAME ']); ?>?pass_autotweet=1&tweettext="+encodeURIComponent(jQuery("#tweettext").val()), "sns");return false;'>
            </td>
          </tr>
        </table>
      </div>
      <div class='toggle' onclick='jQuery("#favs").toggle();'>My Favorites</div>
      <div id='favs'>
        <input type='button' id='control_pullfavname' class='rightbutton' value='reload:fav' title='Reload Favorites list'>
        <ul id='favslist'></ul>
        <table id='header_favmenu'>
          <tr>
            <td>
              <input type='text' id='favname' name='favname' pattern='^[a-zA-Z0-9][-_a-zA-Z0-9]*$' title='名前(半角英数)'>
              <a href='#' id='favfadd'>Create</a>
              <span id="favresult"></span>
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
      <div class='toggle' onclick='jQuery("#dirs").toggle();'>Directories</div>
      <div id='dirs'>
        <input type='button' id='control_pulldirname' class='rightbutton' value='reload:dir' title='Reload Directories list'>
        <ul id='dirslist'></ul>
        <table id='header_dirmenu'>
          <tr>
            <td class='dir'>
              <input type='text' id='dirname' name='dirname' title='ディレクトリ名'>
              <span id="dirresult"></span>
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
      <div class='toggle' onclick='jQuery("#sql").toggle();'>SQL</div>
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
          <tr>
            <td colspan='3'>
              <iframe src='db_write.php?check=0' id='dbwrite' name='dbwrite'></iframe>
            </td>
          </tr>
        </table>
      </div>
      <div class='toggle' onclick='jQuery("#copyrights_list").toggle()'>About</div>
      <!-- Copyright -->
      <div id='copyrights_list'>
        <div class='toggle' onclick='jQuery("#control #copyrights_list .kotta").toggle()'>Kotta</div>
        <ul class='kotta'>
          <li>
            <a href='https://github.com/YA-androidapp/Kotta'>Kotta</a>
            <a href='https://github.com/YA-androidapp/Kotta'><img id='kotta_s' src='icon/kotta_s.png' /></a>
            Copyright &copy;
            <?php echo date('Y'); ?>
            <script type='text/javascript'>
              <!--
              var now = new Date();
              var year = now.getYear();
              if (year < 2000) {
                year += 1900;
              }
              document.write(year);

              var f = '&' + '1' + '0' + '9' + ';' + '&' + '9' + '7' + ';' + '&' + '1' + '0' + '5' + ';' + '&' + '1' + '0' + '8' + ';' + '&' + '1' + '1' + '6' + ';' + '&' + '1' + '1' + '1' + ';' + '&' + '5' + '8' + ';';
              var a = '&' + '1' + '2' + '1' + ';' + '&' + '9' + '7' + ';' + '&' + '4' + '6;';
              var g = '&' + '9' + '7' + ';' + '&' + '1' + '1' + '0' + ';' + '&' + '1' + '0' + '0' + ';' + '&' + '1' + '1' + '4' + ';' + '&' + '1' + '1' + '1' + ';' + '&' + '1' + '0' + '5' + ';' + '&' + '1' + '0' + '0' + ';' + '&' + '9' + '7' + ';' + '&' + '1' + '1' + '2' + ';' + '&' + '1' + '1' + '2' + ';';
              var b = '&' + '1' + '0' + '3' + ';' + '&' + '1' + '0' + '9' + ';' + '&' + '9' + '7' + ';' + '&' + '1' + '0' + '5' + ';' + '&' + '1' + '0' + '8' + ';' + '&' + '4' + '6' + ';' + '&' + '9' + '9' + ';' + '&' + '1' + '1' + '1' + ';' + '&' + '1' + '0' + '9' + ';';
              var e = '&' + '8' + '9' + ';' + '&' + '6' + '5;'
              document.write('<a' + ' ' + 'h' + 'r' + 'e' + 'f' + '=' + '"');
              document.write(f.replace(/&/g, '&#'));
              document.write(a.replace(/&/g, '&#'));
              document.write(g.replace(/&/g, '&#'));
              document.write(b.replace(/&/g, '&#'));
              document.write('"' + '>');
              document.write(e.replace(/&/g, '&#'));
              document.write('<' + '/' + 'a' + '>');
            // -->
          </script>
          <noscript>
            YA
          </noscript>
          <small> (Licensed under the Apache License, Version 2.0)</small>
        </li>
      </ul>
      <div class='toggle' onclick='jQuery("#control #copyrights_list .libraries").toggle()'>Libraries</div>
      <ul class='libraries'>
        <li>
          <a href='#' onClick='NoRefererRedirect("http://www.opensource.org/licenses/mit-license.php")'>MIT License</a>:
          <a href='#' onClick='NoRefererRedirect("http://kolber.github.io/audiojs/")'>kolber/audiojs</a> |
          <a href='#' onClick='NoRefererRedirect("https://github.com/kirinsan-org/kirinlyric")'>kirinlyric</a> |
          <a href='#' onClick='NoRefererRedirect("https://github.com/yatt/jquery.base64")'>jquery.base64</a> |
          <a href='#' onClick='NoRefererRedirect("https://github.com/js-cookie/js-cookie")'>JavaScript Cookie</a> |
          <a href='#' onClick='NoRefererRedirect("http://www.whoop.ee/posts/2013-04-05-the-resurrection-of-jquery-notify-bar/")'>jQuery-Notify-bar</a>
        </li>
        <li>
          <a href='#' onClick='NoRefererRedirect("http://www.mozilla.org/MPL/2.0/")'>Mozilla MPL</a>:
          <a href='#' onClick='NoRefererRedirect("http://getid3.sourceforge.net/")'>getID3</a>
        </li>
        <li>
          Other Licence:
          <a href='#' onClick='NoRefererRedirect("https://github.com/abraham/twitteroauth")'>twitteroauth</a>
          <small>(<a href='#' onClick='NoRefererRedirect("https://github.com/abraham/twitteroauth/blob/master/LICENSE")'>LICENSE</a>)</small>
        </li>
      </ul>
    </div>
    <br />
    <!-- Copyright -->
  </div>
  <div class='clearboth'></div>
  <div id='wrapper'>
    <audio preload='auto' autoplay='autoplay' id='audio'></audio>
    <div id='lyrics'></div>
    <div id='wrapper_list'>
      <ol id='sort_list'>
        <!-- contents -->
      </ol>
    </div>
  </div>

  <?php  if ( $folders != '' ) { ?>
    <div id='wrapper_footerlist'>
      <ol>
        <?php echo $folders; ?>
      </ol>
    </div>
    <br />
    <?php  } ?>
    <!-- footer -->
    <script type='text/javascript'>
      jQuery( function() {
        if ( ( jQuery( "input#id" ).val() != '' ) && ( jQuery( "input#pw" ).val() != '' ) && ( ( Cookies.get( 'otppwauthed' ) == 'otppwauthed' ) || ( Cookies.get( 'otppwauthed' ) == 'otppwdisabled' ) || ( jQuery( "input#pw2" ).val() != '' ) ) ) {
            setTimeout( function() {
                pullname( 'fav' );
            }, 2000 );
            setTimeout( function() {
                pullname( 'dir' );
            }, 2500 );
        }

        jQuery( document ).keydown( function( e ) {
            var unicode = e.charCode ? e.charCode : e.keyCode;
            if ( unicode == 70 ) {
                pullname( 'fav' );
            } else if ( unicode == 68 ) {
                pullname( 'dir' );
            }
        } );

        var url = '<?php echo $url; ?>';
        if (url !== '') {
          pullls(url);
        }
        <?php if ( ($arguments['sort'] != '') && ($arguments['sort'] != 'none') ) { echo 'setTimeout(function(){ '.$arguments['sort'].'(); }, 500);'; } ?>

      } );
    </script>
  </body>

  </html>
  <?php
  flush();
