<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(E_ALL^E_NOTICE);

require_once(realpath(__DIR__).'/conf/index.php');

require_once(realpath(__DIR__).'/req/lib_envcheck.php');

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
 $url = 'ls_fav.php?favname=_recently_added'.(( $arguments['dirname'] !== '' )?('&dirname='.rawurlencode($arguments['dirname'])):(''));
} elseif ( $arguments['favname'] !== '' ) {
 $url = 'ls_fav.php?favname='.rawurlencode($arguments['favname']);
} elseif ( $arguments['dirname'] !== '' ) {
 $url = 'ls_dir.php?dirname='.rawurlencode($arguments['dirname']);
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
require_once(realpath(__DIR__).'/req/lib_style.php');
require_once(realpath(__DIR__).'/req/lib_js.php');
ob_end_flush();
ob_start();
flush();
?>
 </head>
 <body>
<?php
require_once(realpath(__DIR__).'/req/lib_header.php');
require_once(realpath(__DIR__).'/req/lib_footer.php');
ob_end_flush();
ob_start();
flush();
?>
  <script type='text/javascript' src='js/pull.js'></script>
  <script type='text/javascript'>
   var url='<?php echo $url; ?>';
   pullls(url);
<?php if ( ($arguments['sort'] != '') && ($arguments['sort'] != 'none') ) { echo 'setTimeout(function(){ '.$arguments['sort'].'(); }, 500);'; } ?>
  </script>
 </body>
</html>
<?php
flush();
