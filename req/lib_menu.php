<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
if ( (stristr($_REQUEST['mode'], 'fav') !== FALSE)
  && (stristr($_SESSION['mode'], 'fav') !== FALSE)
  && ($_REQUEST['favnum'] == '')
  && ($_SESSION['favnum'] == '') ) {
 $_SESSION['favnum'] = '1';
}
$flag = ($_SERVER['HTTPS']!='') ? 's' : '';
$permalink = 'http'.$flag.'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?';
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>Kotta Menu</title>
<?php require_once(realpath(__DIR__).'/common_js.php'); ?>
<script type="text/javascript">
 $(function () {

  $("input").blur( function (e){
<?php require(realpath(__DIR__).'/lib_menu_autocomplete.php'); ?>
  });

 });

</script>

<?php require_once(realpath(__DIR__).'/lib_style.php'); ?>
  <style type="text/css">
   th { text-align:right;background-color:rgb(136, 170, 255); }
  </style>
 </head>
 <body>
  <form action="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>" method="POST">
   <table style="font-size:x-small;">
    <tr>
     <td>ID</td>
     <td><input type="text" id="id" name="id" value="<?php echo ($_REQUEST['id']!='') ? $_REQUEST['id'] : @$_SESSION['id']; ?>" style="width:200px;" /></td>
    </tr>
    <tr>
     <td>PW</td>
     <td><input type="password" id="pw" name="pw" value="<?php echo ($_REQUEST['pw']!='') ? $_REQUEST['pw'] : @$_SESSION['pw']; ?>" style="width:200px;" /></td>
    </tr>
    <tr>
     <td>twitter</td>
     <td><a href="tweet/index.php" target="tweet">twitterでKottaを認証する</a></td>
    </tr>
<?php if ( $flag_authed != 1 ) { ?>
    <tr>
     <td>Menu</td>
     <td><input type="checkbox" name="menu" value="1" <?php echo ($_REQUEST['menu']=='1') ? 'checked ' : ''; ?>/></td>
    </tr>
<?php } ?>
    <tr>
     <td>
      Mode
     </td>
     <td>
      <select name="mode" style="width:200px;">
       <option value=""<?php echo (stripos(basename($_SERVER['SCRIPT_NAME']), 'index.php')!==FALSE) ? ' selected="selected"' : ''; ?>>シンプル</option>
       <option value="music"<?php echo ( ($_REQUEST['mode'] == 'music') || ($_SESSION['mode'] == 'music') || ( stripos(basename($_SERVER['SCRIPT_NAME']), 'music.php')!==FALSE) ) ? ' selected="selected"' : ''; ?>>MP3プレーヤ</option>
       <option value="makem3u"<?php echo ( ($_REQUEST['mode'] == 'makem3u') || ($_SESSION['mode'] == 'makem3u') ) ? ' selected="selected"' : ''; ?>>M3Uプレイリストを生成</option>
      </select>
     </td>
    </tr>
    <tr>
     <th border="1" colspan="2" onclick="jQuery('.source').toggle()">ソース</td>
    </tr>
    <tr class="source">
     <td>ディレクトリ(autocomplete)</td>
     <td>
      <input type="text" id="dir" name="dir" onclick="jQuery('#dir').css('background-color','#fff');jQuery('#favnum,#m3uuri').css('background-color','#ccc')" value="<?php echo @str_replace($base_dir, '', @str_replace($base_dir.'/', '', $_REQUEST['dir'])); ?>" style="width:200px;" />
     </td>
    </tr>
    <tr class="source">
     <td>お気に入り</td>
     <td>
      <input type="text" id="favnum" name="favnum" onclick="jQuery('#favnum').css('background-color','#fff');jQuery('#dir,#m3uuri').css('background-color','#ccc')" value="<?php echo ($_REQUEST['favnum']!='') ? $_REQUEST['favnum'] : @$_SESSION['favnum']; ?>" style="width:200px;" />
     </td>
    </tr>
    <tr class="source">
     <td>M3UプレイリストのURL</td>
     <td><input type="text" id="m3uuri" name="m3uuri" onclick="jQuery('#m3uuri').css('background-color','#fff');jQuery('#dir,#favnum').css('background-color','#ccc')" value="<?php echo ($_REQUEST['m3uuri']!='') ? $_REQUEST['m3uuri'] : @$_SESSION['m3uuri']; ?>" style="width:200px;" /></td>
    </tr>
    <tr class="source">
     <td>読み込む階層の深さ</td>
     <td>
      <input type="text" name="depth" value="<?php echo ($_REQUEST['depth']!='') ? $_REQUEST['depth'] : @$_SESSION['depth']; ?>" style="width:50px;" />
     </td>
    </tr>
    <tr class="source">
     <td>並び順</td>
     <td>
      <select name="sort" style="width:200px;">
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
     </td>
    </tr>
    <tr class="source">
     <td>
      ループ
     </td>
     <td>
      <select name="enable_loop" style="width:200px;">
       <option value="1">１曲ループを有効にする</option>
       <option value="0" selected="selected">１曲ループを無効にする</option>
      </select>
      <br />
      <select name="enable_allloop" style="width:200px;">
       <option value="1" selected="selected">全曲ループを有効にする</option>
       <option value="0">全曲ループを無効にする</option>
      </select>
     </td>
    </tr>
    <tr class="source">
     <td>
      「最近聞いた曲」プレイリスト
     </td>
     <td>
      <select name="enable_recently_played" style="width:200px;">
       <option value="1">自動更新を有効にする</option>
       <option value="0" selected="selected">自動更新を無効にする</option>
      </select>
     </td>
    </tr>
    <tr class="source">
     <td>
      通知<span style="font-size:xx-small;"> (Chrome/Firefox Only)</span>
     </td>
     <td>
      <select name="enable_notification" style="width:200px;">
       <option value="1">次に再生する曲を通知する</option>
       <option value="0" selected="selected">次に再生する曲を通知しない</option>
      </select>
     </td>
    </tr>
    <!-- tr class="source">
     <td>
      ミュート
     </td>
     <td>
      <select name="enable_muted" style="width:200px;">
       <option value="1">ミュートを有効にする</option>
       <option value="0" selected="selected">ミュートを無効にする</option>
      </select>
     </td>
    </tr -->
     <td>
      歌詞表示
     </td>
     <td>
      <select name="enable_lyric" style="width:200px;">
       <option value="1">歌詞表示を有効にする</option>
       <option value="0" selected="selected">歌詞表示を無効にする</option>
      </select>
     </td>
    <tr>
     <th border="1" colspan="2" onclick="jQuery('.nowplaying').toggle()">#nowplaying</td>
    </tr>
    <tr style="display:none;" class="nowplaying">
     <td>書式</td>
     <td>
      <input type="text" id="sns_format" name="sns_format" value="<?php echo $confs['sns_format']; ?>" style="width:200px;" title="書式： %a:アーティスト名, %g:ジャンル, %l:アルバム名, %m:再生時間(分), %n:トラック番号, %s:再生時間(秒), %t:曲名, %u:URI" />
     </td>
    </tr>
    <tr style="display:none;" class="nowplaying">
     <td rowspan="2">
     </td>
     <td>
      <select name="enable_autotweet" style="width:200px;">
       <option value="1">自動的にツイートする</option>
       <option value="0" selected="selected">自動的にツイートしない</option>
      </select>
     </td>
    </tr>
    <tr style="display:none;" class="nowplaying">
     <td>
      <select name="pass_autotweet" style="width:200px;">
       <option value="0">ツイート時に確認する</option>
       <option value="1" selected="selected">ツイート時に確認しない</option>
      </select>
     </td>
    </tr>
    <tr>
     <th border="1" colspan="2" onclick="jQuery('.filtering').toggle()">フィルタリング</td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">ファイル名</td>
     <td>
      <input type="text" name="filter_file" value="<?php echo ($_REQUEST['filter_file']!='') ? $_REQUEST['filter_file'] : @$_SESSION['filter_file']; ?>" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">フォルダ名</td>
     <td>
      <input type="text" name="filter_dir" value="<?php echo ($_REQUEST['filter_dir']!='') ? $_REQUEST['filter_dir'] : @$_SESSION['filter_dir']; ?>" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">アルバム名</td>
     <td>
      <input type="text" name="filter_album" value="" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">アーティスト名</td>
     <td>
      <input type="text" name="filter_artist" value="" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">ジャンル名</td>
     <td>
      <input type="text" name="filter_genre" value="" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">曲名</td>
     <td>
      <input type="text" name="filter_title" value="" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td align="right">トラック番号</td>
     <td>
      <input type="text" name="filter_track" value="" style="width:200px;" />
     </td>
    </tr>
    <tr style="display:none;" class="filtering">
     <td>インデックス指定</td>
     <td>
      <input type="text" name="numsince" value="" style="width:95px;" />-<input type="text" name="numlast" value="" style="width:95px;" />
     </td>
    </tr>
    <tr>
     <td colspan="2">
      <input type="submit" value="送信">
      <a href="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?logout=1">Logout</a>
     </td>
    </tr>
   </table>
  </form>
 </body>
</html>
