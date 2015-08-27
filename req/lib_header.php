<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<?php if ( $_REQUEST['header_menu'] != '1' ) { ?>
  <img height='128px' width='128px' src='icon/kotta.png' />
  <div id='wrapper_headerlist'>
<?php } ?>
   ||
   [
   User:<input type='text' id='id' name='id' title='User' value='<?php echo $id; ?>' style='width:100px;'>
   Password:<input type='password' id='pw' name='pw' title='Password' value='<?php echo $pw; ?>' style='width:100px;'>
   <input type='password' id='pw2' name='pw2' title='OTP Password' size='6' maxlength='6'>
   ]
   <br>
   ||
   <a href='<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?menu=1'>Menu</a> ||
   <small><a target='sns' href='tweet/index.php'>Authentication in Twitter</a></small> ||
   <a href='<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?logout=1'>Logout</a> ||
   <hr />
   <table id='header_tweet'>
    <tr>
     <td>
      <textarea id='tweettext'></textarea>
     </td>
     <td>
      <img height='20px' src='icon/twtr2.png' alt='twitterに投稿する' title='twitterに投稿する' onClick='window.open("<?php echo str_replace(basename($_SERVER['SCRIPT_NAME']), 'tweet/tweet.php', $_SERVER['SCRIPT_NAME']); ?>?pass_autotweet=1&tweettext="+encodeURIComponent(jQuery("#tweettext").val()), "sns");return false;'>
      Screenname:<span id='screen_name'><?php echo ($_SESSION['oa_screen_name']!='') ? '@'.$_SESSION['oa_screen_name'] : '---'; ?></span>
     </td>
    </tr>
   </table>
   <hr />
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #favslist").toggle();'>My Favorites</div>
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
   <div class='toggle' onclick='jQuery("#wrapper_headerlist #dirslist").toggle();'>Directories(autocomplete)</div>
   <ul id='dirslist'></ul>
   <input type='text' id='dir' name='dir' title='ディレクトリ名' style='width:250px;'>
   <a href='#' onClick='var url="ls_dir.php?dirname="+jQuery("input#dirname").val();pullls(url);'>[Add]</a>
   <a href='#' onClick='var url="db_write.php?dirname="+jQuery("input#dirname").val()+"&id="+jQuery("input#id").val()+"&pw="+jQuery("input#pw").val();window.open(url,"db");'>[AddDB]</a>
   <hr />
   SQL <small><small><a href='db_write.php'>DB-Rebuilding</a></small></small><br />
   <select id='sqlwhere' name='sqlwhere' title='SQL:Where' style='width:100px;'>
    <option value='album'>Album</option>
    <option value='artist'>Artist</option>
    <option value='basename'>Filename</option>
    <option value='genre'>Genre</option>
    <option value='number'>Number</option>
    <option value='title' selected='selected'>Title</option>
   </select>
   <input type='text' id='sqllike' name='sqllike' title='SQL:Like' style='width:150px;'>
   <a href='#' onClick='var url="ls_sql.php?sqlwhere="+jQuery("select#sqlwhere").val()+"&sqllike="+jQuery("input#sqllike").val();pullls(url);'>[Add]</a>
<?php if ( $_REQUEST['header_menu'] != '1' ) { ?>
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
<?php } ?>
