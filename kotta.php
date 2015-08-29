<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

// require_once(realpath(__DIR__).'/conf/kotta.php');

$errcode = 0;

if ( $_REQUEST['logout'] == '1' ) { require_once(realpath(__DIR__).'/req/lib_logout.php');die(''); }

$showMenu='1';
require_once(realpath(__DIR__).'/req/lib_auth_idpw.php');
require_once(realpath(__DIR__).'/req/lib_auth_otp.php');

if ( ( isset($_REQUEST['output_path']) ) && ( $_REQUEST['output_path'] !== '' ) ) {
 require_once(realpath(__DIR__).'/req/lib_output.php');die('');
}

if ( $_REQUEST['menu'] == '1' ) {
 $flag_authed = 1;
 require_once(realpath(__DIR__).'/req/lib_menu.php');die('');
}

require_once(realpath(__DIR__).'/req/lib_getdirtree.php');
require_once(realpath(__DIR__).'/req/mp3tag_getid3.php');
require_once(realpath(__DIR__).'/req/lib_showdirtree.php');
require_once(realpath(__DIR__).'/req/lib_get_new_files.php');

$folders = '';

require_once(realpath(__DIR__).'/req/lib_getarg.php');
if ( $arguments['mode'] == 'favmenu' ) {
 require_once(realpath(__DIR__).'/req/lib_favmenu.php');die('');
} elseif ( $arguments['mode'] == 'favadd' ) {
 require_once(realpath(__DIR__).'/req/lib_favadd.php');die('');
} elseif ( $arguments['mode'] == 'favdel' ) {
 require_once(realpath(__DIR__).'/req/lib_favdel.php');die('');
} elseif ( $arguments['mode'] == 'favfadd' ) {
 require_once(realpath(__DIR__).'/req/lib_favfadd.php');die('');
} elseif ( $arguments['mode'] == 'favfdel' ) {
 require_once(realpath(__DIR__).'/req/lib_favfdel.php');die('');
} elseif ( $_REQUEST['mode'] == 'rpadd' ) {
 $arguments['favname'] = '_recently_played';
 require_once(realpath(__DIR__).'/req/lib_favadd.php');die('');
} elseif ( ($arguments['mode'] == 'upload') && ($enable_upload == 1) ) {
 require_once(realpath(__DIR__).'/req/lib_upload.php');die('');
}

$dirarr = array();
$depth1 = 0;
$depth2 = 0;
if ( $arguments['favname'] === '_recently_added' ) {
 $line = getNewFiles(( $arguments['dirname'] !== '' )?($base_dir.'/'.$arguments['dirname']):($base_dir));
 foreach ($line as $val) {
  $dirarr[basename($val)] = $val;
 }
} elseif ( $arguments['favname'] !== '' ) {
 $line = file('fav/'.$id.'_'.$arguments['favname'].'.cgi', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
 foreach ($line as $val) {
  $dirarr[basename($val)] = $val;
 }
} elseif ( $arguments['dirname'] !== '' ) {
 $dirarr = getdirtree($base_dir.'/'.$arguments['dirname']);
}

if ( $arguments['mode'] === 'makem3u' ) {
 require_once(realpath(__DIR__).'/req/lib_makem3u.php');
}
?>
<!DOCTYPE html>
<html lang='ja'>
 <head>
  <meta charset='utf-8'>
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
