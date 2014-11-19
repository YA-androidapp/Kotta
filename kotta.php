<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
require_once(realpath(__DIR__).'/conf/index.php');

if ( $_REQUEST['logout'] == '1' ) {
 require_once(realpath(__DIR__).'/req/lib_logout.php');
 die(' kotta-0');
}

if ( (isset($_SERVER['PHP_AUTH_USER'])) && ($_SERVER['PHP_AUTH_USER'] != '') ) {
 $id = $_SERVER['PHP_AUTH_USER']; $_SESSION['id'] = $id;
} elseif ( (isset($_REQUEST['id'])) && ($_REQUEST['id'] != '') ) {
 $id = $_REQUEST['id']; $_SESSION['id'] = $id;
} elseif ( (isset($_SESSION['id'])) && ($_SESSION['id'] != '') ) {
 $id = $_SESSION['id'];
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-1');
}
if ( (isset($_SERVER['PHP_AUTH_PW'])) && ($_SERVER['PHP_AUTH_PW'] != '') ) {
 $pw = $_SERVER['PHP_AUTH_PW']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_REQUEST['pw'])) && ($_REQUEST['pw'] != '') ) {
 $pw = $_REQUEST['pw']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_SESSION['pw'])) && ($_SESSION['pw'] != '') ) {
 $pw = $_SESSION['pw'];
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-2');
}
if ( (isset($_REQUEST['pw2'])) && ($_REQUEST['pw2'] != '') ) {
 $pw2 = $_REQUEST['pw2']; $_SESSION['pw2'] = $pw2;
} elseif ( (isset($_SESSION['pw2'])) && ($_SESSION['pw2'] != '') ) {
 $pw2 = $_SESSION['pw2'];
}

$pwdfile = 'pwd/'.$id.'.cgi';

if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);

 if ( $pw === $tpassword ) {
  $pw2 = sha1($pw);
 } elseif ( $pw2 === sha1($tpassword) ) {

 } else {
  require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-3');
 }
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-4');
}

if ( $_REQUEST['output_path'] != '' ) {
 require_once(realpath(__DIR__).'/req/lib_output.php');
 die('');
}

if ( $_REQUEST['menu'] == '1' ) {
 $flag_authed = 1;
 require_once(realpath(__DIR__).'/req/lib_menu.php');
 die(' kotta-6');
} elseif ( $_REQUEST['header_menu'] == '1' ) {
 require_once(realpath(__DIR__).'/req/lib_header.php');
 die(' kotta-7');
}

require_once(realpath(__DIR__).'/req/lib_getdirtree.php');
require_once(realpath(__DIR__).'/req/mp3tag_getid3.php');
require_once(realpath(__DIR__).'/req/lib_showdirtree.php');

$folders = '';

require_once(realpath(__DIR__).'/req/lib_getarg.php');
if ( $arguments['mode'] == 'favmenu' ) {
 require_once(realpath(__DIR__).'/req/lib_favmenu.php');
 die(' kotta-8');
} elseif ( $arguments['mode'] == 'favadd' ) {
 require_once(realpath(__DIR__).'/req/lib_favadd.php');
 die(' kotta-9');
} elseif ( $arguments['mode'] == 'favdel' ) {
 require_once(realpath(__DIR__).'/req/lib_favdel.php');
 die(' kotta-a');
} elseif ( $arguments['mode'] == 'favfadd' ) {
 require_once(realpath(__DIR__).'/req/lib_favfadd.php');
 die(' kotta-b');
} elseif ( $arguments['mode'] == 'favfdel' ) {
 require_once(realpath(__DIR__).'/req/lib_favfdel.php');
 die(' kotta-c');
} elseif ( $_REQUEST['mode'] == 'rpadd' ) {
 $arguments['favnum'] = '_recently_played';
 require_once(realpath(__DIR__).'/req/lib_favadd.php');
 die(' kotta-d');
} elseif ( ($arguments['mode'] == 'upload') && ($enable_upload == 1) ) {
 require_once(realpath(__DIR__).'/req/lib_upload.php');
 die('');
}

$dirarr = array();
$depth1 = 0;
$depth2 = 0;
if ( $arguments['favnum'] != '' ) {
 $line = file('fav/'.$id.'_'.$arguments['favnum'].'.cgi', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
 foreach ($line as $val) {
  $dirarr[basename($val)] = $val;
 }
} elseif( $arguments['dir'] != '' ) {
 $dirarr = getdirtree($base_dir.'/'.$arguments['dir']);
}

if ( $arguments['mode'] == 'makem3u' ) {
 require_once(realpath(__DIR__).'/req/lib_makem3u.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>Kotta <?php echo $arguments['mode']; ?></title>
<?php
require_once(realpath(__DIR__).'/req/common_js.php');
require_once(realpath(__DIR__).'/req/m_js.php');
require_once(realpath(__DIR__).'/req/pull_js.php');
require_once(realpath(__DIR__).'/req/lib_style.php');
?>
 </head>
 <body>
<?php
require_once(realpath(__DIR__).'/req/lib_header.php');
ob_end_flush();
ob_start();
flush();
if(!empty($dirarr)) {
 $depth1 = 0;
 showdirtree($dirarr);
}
require_once(realpath(__DIR__).'/req/lib_footer.php'); ?>
 </body>
</html>
<?php
flush();
