<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
require_once(realpath(__DIR__).'/conf/index.php');

$errcode = 0;

if ( $_REQUEST['logout'] == '1' ) { require_once(realpath(__DIR__).'/req/lib_logout.php');die(''); }

if ( (isset($_SERVER['PHP_AUTH_USER'])) && ($_SERVER['PHP_AUTH_USER'] != '') ) {
 $id = $_SERVER['PHP_AUTH_USER']; $_SESSION['id'] = $id;
} elseif ( (isset($_SESSION['id'])) && ($_SESSION['id'] != '') ) {
 $id = $_SESSION['id'];
} elseif ( (isset($_COOKIE['id'])) && ($_COOKIE['id'] != '') ) {
 $id = $_COOKIE['id']; $_SESSION['id'] = $id;
} elseif ( (isset($_REQUEST['id'])) && ($_REQUEST['id'] != '') ) {
 $id = $_REQUEST['id']; $_SESSION['id'] = $id;
} else {
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-01');
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
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-02');
}
if ( (isset($_REQUEST['pw2'])) && ($_REQUEST['pw2'] != '') ) {
 $pw2 = $_REQUEST['pw2']; $_SESSION['pw2'] = $pw2;
// } elseif ( (isset($_SESSION['pw2'])) && ($_SESSION['pw2'] != '') ) {
//  $pw2 = $_SESSION['pw2'];
// } elseif ( (isset($_COOKIE['pw2'])) && ($_COOKIE['pw2'] != '') ) {
//  $pw2 = $_COOKIE['pw2']; $_SESSION['pw2'] = $pw2;
} else {
 $pw2 = '';
}
if ( (isset($_REQUEST['otppwauthed'])) && ($_REQUEST['otppwauthed'] != '') ) {
 $_SESSION['otppwauthed'] = '';
}

$pwdfile = 'pwd/'.$id.'.cgi';
$otpfile = 'pwd/'.$id.'_otp.cgi';

if ( file_exists($pwdfile) ) {
 // echo "ID+PW認証が有効\n";
 $tpassword = file_get_contents($pwdfile);
 $tpassword = str_replace(array("\r\n","\n","\r"," "), '', $tpassword);
 if ( $tpassword === '' ) { require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-03'); }

 if ( file_exists($otpfile) ) {
  // echo "OTP認証が有効\n";

  if ( ( $pw === $tpassword ) || ( substr($pw, 0, strlen($pw) - 6) === $tpassword ) ) {
   // echo "ID+PW認証に成功\n";

   $totpkey = file_get_contents($otpfile);
   $totpkey = str_replace(array("\r\n","\n","\r"," "), '', $totpkey);
   require_once(realpath(__DIR__).'/req/ga.php');
   $otp = Google2FA::oath_hotp(Google2FA::base32_decode($totpkey), Google2FA::get_timestamp());
   // echo "otp: $otp\ttotpkey: $totpkey\ttime: ".Google2FA::get_timestamp()."\n";

   if ( $_SESSION['otppwauthed'] === 'otppwauthed' ) {
    // echo "OTP認証に成功(再)\n";
    ;
   } elseif ( Google2FA::verify_key($totpkey, $pw2) ) {
    // echo "OTP認証に成功\n";
    $_SESSION['otppwauthed'] = 'otppwauthed';
    ;
   } else {
    // echo "OTP認証に失敗\n";
    require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-04');
   }
  } else {
   // echo "ID+PW認証に失敗\n";
   require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-05');
  }



 } else {
  // echo "OTP認証が無効\n";
  if ( $pw === $tpassword ) {
   // echo "ID+PW認証に成功\n";
   ;
  } else {
   // echo "ID+PW認証に失敗\n";
   require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-06');
  }
 }

} else {
 // echo "ID+PW認証が無効\n";
 require_once(realpath(__DIR__).'/req/lib_menu.php');die(' kotta-07');
}

if ( ( isset($_REQUEST['output_path']) ) && ( $_REQUEST['output_path'] !== '' ) ) {
 require_once(realpath(__DIR__).'/req/lib_output.php');die('');
}

if ( $_REQUEST['menu'] == '1' ) {
 $flag_authed = 1;
 require_once(realpath(__DIR__).'/req/lib_menu.php');die('');
} elseif ( $_REQUEST['header_menu'] == '1' ) {
 require_once(realpath(__DIR__).'/req/lib_header.php');die('');
}

require_once(realpath(__DIR__).'/req/lib_getdirtree.php');
require_once(realpath(__DIR__).'/req/mp3tag_getid3.php');
require_once(realpath(__DIR__).'/req/lib_showdirtree.php');
require_once(realpath(__DIR__).'/req/get_new_files.php');

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
 $arguments['favnum'] = '_recently_played';
 require_once(realpath(__DIR__).'/req/lib_favadd.php');die('');
} elseif ( ($arguments['mode'] == 'upload') && ($enable_upload == 1) ) {
 require_once(realpath(__DIR__).'/req/lib_upload.php');die('');
}

$dirarr = array();
$depth1 = 0;
$depth2 = 0;
if ( $arguments['favnum'] === '_recently_added' ) {
 $line = getNewFiles(( $arguments['dir'] !== '' )?($base_dir.'/'.$arguments['dir']):($base_dir));
 foreach ($line as $val) {
  $dirarr[basename($val)] = $val;
 }
} elseif ( $arguments['favnum'] !== '' ) {
 $line = file('fav/'.$id.'_'.$arguments['favnum'].'.cgi', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
 foreach ($line as $val) {
  $dirarr[basename($val)] = $val;
 }
} elseif ( $arguments['dir'] !== '' ) {
 $dirarr = getdirtree($base_dir.'/'.$arguments['dir']);
}

if ( $arguments['mode'] === 'makem3u' ) {
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
