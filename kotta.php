<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
require_once(realpath(__DIR__).'/conf/index.php');

$errcode = 0;

if ( $_REQUEST['logout'] == '1' ) {
 require_once(realpath(__DIR__).'/req/lib_logout.php');
 die(' kotta-'.$errcode++);
}

if ( (isset($_SERVER['PHP_AUTH_USER'])) && ($_SERVER['PHP_AUTH_USER'] != '') ) {
 $id = $_SERVER['PHP_AUTH_USER']; $_SESSION['id'] = $id;
} elseif ( (isset($_SESSION['id'])) && ($_SESSION['id'] != '') ) {
 $id = $_SESSION['id'];
} elseif ( (isset($_COOKIE['id'])) && ($_COOKIE['id'] != '') ) {
 $id = $_COOKIE['id']; $_SESSION['id'] = $id;
} elseif ( (isset($_REQUEST['id'])) && ($_REQUEST['id'] != '') ) {
 $id = $_REQUEST['id']; $_SESSION['id'] = $id;
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-'.$errcode++);
}
if ( (isset($_SERVER['PHP_AUTH_PW'])) && ($_SERVER['PHP_AUTH_PW'] != '') ) {
 $pw = $_SERVER['PHP_AUTH_PW']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_SESSION['pw'])) && ($_SESSION['pw'] != '') ) {
 $pw = $_SESSION['pw'];
} elseif ( (isset($_COOKIE['pw'])) && ($_COOKIE['pw'] != '') ) {
 $pw = $_COOKIE['pw']; $_SESSION['pw'] = $pw;
} elseif ( (isset($_REQUEST['pw'])) && ($_REQUEST['pw'] != '') ) {
 $pw = $_REQUEST['pw']; $_SESSION['pw'] = $pw;
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-'.$errcode++);
}

if ( (isset($_COOKIE['pw2'])) && ($_COOKIE['pw2'] != '') ) {
 $pw2 = $_COOKIE['pw2'];
} elseif ( (isset($_REQUEST['pw2'])) && ($_REQUEST['pw2'] != '') ) {
 $pw2 = $_REQUEST['pw2'];
}

$pwdfile = 'pwd/'.$id.'.cgi';

// OTP
$otpfile = 'pwd/'.$id.'_otp.cgi';

if ( file_exists($pwdfile) ) {
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);

 if ( $pw === $tpassword ) {
  ; // 認証成功
 } elseif ( file_exists($otpfile) ) {
  if ( $pw = substr($pw, 0, strlen($pw) - 6) ) {
   if ( $pw === $tpassword ) {
    $pw2 = substr($pw, -6); // 認証成功
   } else {
    require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-'.$errcode++);
   }
  }
 } else {
  require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-'.$errcode++);
 }
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-'.$errcode++);
}

if ( $_REQUEST['output_path'] != '' ) {
 require_once(realpath(__DIR__).'/req/lib_output.php');die(''); // die(' kotta-'.$errcode++);
}

if ( $_REQUEST['menu'] == '1' ) {
 $flag_authed = 1;
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( $_REQUEST['header_menu'] == '1' ) {
 require_once(realpath(__DIR__).'/req/lib_header.php');die(''); // die(' kotta-'.$errcode++);
}

// OTP
$otpfile = 'pwd/'.$id.'_otp.cgi';
if ( file_exists($otpfile) ) {
 if ( $_SESSION['otppwauthed'] !== 'otppwauthed' ) {
  $totpkey = file_get_contents($otpfile);
  $totpkey = str_replace(array("\r\n","\n","\r"," "), '', $totpkey);
  require_once(realpath(__DIR__).'/req/ga.php');
  $otp = Google2FA::oath_hotp(Google2FA::base32_decode($totpkey), Google2FA::get_timestamp());
  // echo("otp: $otp\ttotpkey: $totpkey\ttime: ".Google2FA::get_timestamp()."\n");
  if ( Google2FA::verify_key($totpkey, $pw2) ) {
   $_SESSION['otppwauthed'] = 'otppwauthed'; // 認証成功
  } else {
   require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-'.$errcode++);
  }
 }
} else {
 ; // 認証成功
}

require_once(realpath(__DIR__).'/req/lib_getdirtree.php');
require_once(realpath(__DIR__).'/req/mp3tag_getid3.php');
require_once(realpath(__DIR__).'/req/lib_showdirtree.php');

$folders = '';

require_once(realpath(__DIR__).'/req/lib_getarg.php');
if ( $arguments['mode'] == 'favmenu' ) {
 require_once(realpath(__DIR__).'/req/lib_favmenu.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( $arguments['mode'] == 'favadd' ) {
 require_once(realpath(__DIR__).'/req/lib_favadd.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( $arguments['mode'] == 'favdel' ) {
 require_once(realpath(__DIR__).'/req/lib_favdel.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( $arguments['mode'] == 'favfadd' ) {
 require_once(realpath(__DIR__).'/req/lib_favfadd.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( $arguments['mode'] == 'favfdel' ) {
 require_once(realpath(__DIR__).'/req/lib_favfdel.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( $_REQUEST['mode'] == 'rpadd' ) {
 $arguments['favnum'] = '_recently_played';
 require_once(realpath(__DIR__).'/req/lib_favadd.php');die(''); // die(' kotta-'.$errcode++);
} elseif ( ($arguments['mode'] == 'upload') && ($enable_upload == 1) ) {
 require_once(realpath(__DIR__).'/req/lib_upload.php');die(''); // die(' kotta-'.$errcode++);
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
