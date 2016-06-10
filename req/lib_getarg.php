<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

$arguments = array();

if ($_REQUEST['dirname']=='') {
  $arguments['dirname'] = '';
  $real_path = '';
} else {
  $arguments['dirname'] = $_REQUEST['dirname'];
  $real_path = realpath(arsep($base_dir,$arguments['dirname']));
  if (!file_exists($real_path)) {
      die('引数が不正です getarg-1');
  } elseif (stripos(asep($real_path,''),$base_dir)!==0) {
      die('引数が不正です getarg-2');
  }
}

if ( $_REQUEST['favname'] !== NULL ) {
 $arguments['favname'] = $_REQUEST['favname'];
} else {
 $arguments['favname'] = '';
}

if ( $_REQUEST['mode'] == 'simple' ) {
   $_REQUEST['mode'] = '';
}
if ( $_REQUEST['mode'] != '' ) {
   $arguments['mode'] = $_REQUEST['mode'];
} else {
   $arguments['mode'] = 'music';
}

if ( $arguments['favname'] != '' ) {
  if ( !file_exists(asep('fav',$id.'_'.$arguments['favname'].'.cgi')) ) {
   if ( ($arguments['mode'] != 'favfadd') && ($arguments['favname'] != '_recently_played') && ($arguments['favname'] != '_recently_added') ) {
      die('引数が不正です getarg-3 '.$arguments['mode']);
   }
  }
}

if ( $_REQUEST['enable_loop'] == '1' ) {
   $arguments['enable_loop'] = ( $_SESSION['enable_loop'] = '1' );
} elseif ( $_REQUEST['enable_loop'] == '0' ) {
   $arguments['enable_loop'] = ( $_SESSION['enable_loop'] = '0' );
} elseif ( $_COOKIE['enable_loop']  == '1' ) {
   $arguments['enable_loop'] = ( $_SESSION['enable_loop'] = '1' );
} elseif ( $_COOKIE['enable_loop']  == '0' ) {
   $arguments['enable_loop'] = ( $_SESSION['enable_loop'] = '0' );
} elseif ( $_SESSION['enable_loop'] == '1' ) {
   $arguments['enable_loop'] = '1';
} else {
   $arguments['enable_loop'] = '0';
}
if ( $_REQUEST['enable_allloop'] == '0' ) {
   $arguments['enable_allloop'] = ( $_SESSION['enable_allloop'] = '0' );
} elseif ( $_REQUEST['enable_allloop'] == '1' ) {
   $arguments['enable_allloop'] = ( $_SESSION['enable_allloop'] = '1' );
} elseif ( $_COOKIE['enable_allloop']  == '0' ) {
   $arguments['enable_allloop'] = ( $_SESSION['enable_allloop'] = '0' );
} elseif ( $_COOKIE['enable_allloop']  == '1' ) {
   $arguments['enable_allloop'] = ( $_SESSION['enable_allloop'] = '1' );
} elseif ( $_SESSION['enable_allloop'] == '0' ) {
   $arguments['enable_allloop'] = '0';
} else {
   $arguments['enable_allloop'] = '1';
}
if ( $_REQUEST['enable_autotweet'] == '1' ) {
   $arguments['enable_autotweet'] = ( $_SESSION['enable_autotweet'] = '1' );
} elseif ( $_REQUEST['enable_autotweet'] == '0' ) {
   $arguments['enable_autotweet'] = ( $_SESSION['enable_autotweet'] = '0' );
} elseif ( $_COOKIE['enable_autotweet']  == '1' ) {
   $arguments['enable_autotweet'] = ( $_SESSION['enable_autotweet'] = '1' );
} elseif ( $_COOKIE['enable_autotweet']  == '0' ) {
   $arguments['enable_autotweet'] = ( $_SESSION['enable_autotweet'] = '0' );
} elseif ( $_SESSION['enable_autotweet'] == '1' ) {
   $arguments['enable_autotweet'] = '1';
} else {
   $arguments['enable_autotweet'] = '0';
}
if ( $_REQUEST['pass_autotweet'] == '1' ) {
   $arguments['pass_autotweet'] = '1';
} else {
   $arguments['pass_autotweet'] = '0';
}
if ( $_REQUEST['enable_notification'] == '1' ) {
   $arguments['enable_notification'] = ( $_SESSION['enable_notification'] = '1' );
} elseif ( $_REQUEST['enable_notification'] == '0' ) {
   $arguments['enable_notification'] = ( $_SESSION['enable_notification'] = '0' );
} elseif ( $_COOKIE['enable_notification']  == '1' ) {
   $arguments['enable_notification'] = ( $_SESSION['enable_notification'] = '1' );
} elseif ( $_COOKIE['enable_notification']  == '0' ) {
   $arguments['enable_notification'] = ( $_SESSION['enable_notification'] = '0' );
} elseif ( $_SESSION['enable_notification'] == '1' ) {
   $arguments['enable_notification'] = '1';
} else {
   $arguments['enable_notification'] = '0';
}
if ( $_REQUEST['enable_recently_played'] == '1' ) {
   $arguments['enable_recently_played'] = ( $_SESSION['enable_recently_played'] = '1' );
} elseif ( $_REQUEST['enable_recently_played'] == '0' ) {
   $arguments['enable_recently_played'] = ( $_SESSION['enable_recently_played'] = '0' );
} elseif ( $_COOKIE['enable_recently_played']  == '1' ) {
   $arguments['enable_recently_played'] = ( $_SESSION['enable_recently_played'] = '1' );
} elseif ( $_COOKIE['enable_recently_played']  == '0' ) {
   $arguments['enable_recently_played'] = ( $_SESSION['enable_recently_played'] = '0' );
} elseif ( $_SESSION['enable_recently_played'] == '1' ) {
   $arguments['enable_recently_played'] = '1';
} else {
   $arguments['enable_recently_played'] = '0';
}
if ( $_REQUEST['enable_muted'] == '1' ) {
   $arguments['enable_muted'] = ( $_SESSION['enable_muted'] = '1' );
} elseif ( $_REQUEST['enable_muted'] == '0' ) {
   $arguments['enable_muted'] = ( $_SESSION['enable_muted'] = '0' );
} elseif ( $_COOKIE['enable_muted']  == '1' ) {
   $arguments['enable_muted'] = ( $_SESSION['enable_muted'] = '1' );
} elseif ( $_COOKIE['enable_muted']  == '0' ) {
   $arguments['enable_muted'] = ( $_SESSION['enable_muted'] = '0' );
} elseif ( $_SESSION['enable_muted'] == '1' ) {
   $arguments['enable_muted'] = '1';
} else {
   $arguments['enable_muted'] = '0';
}
if ( $_REQUEST['enable_lyric'] == '1' ) {
   $arguments['enable_lyric'] = ( $_SESSION['enable_lyric'] = '1' );
} elseif ( $_REQUEST['enable_lyric'] == '0' ) {
   $arguments['enable_lyric'] = ( $_SESSION['enable_lyric'] = '0' );
} elseif ( $_COOKIE['enable_lyric'] == '1' ) {
   $arguments['enable_lyric'] = ( $_SESSION['enable_lyric'] = '1' );
} elseif ( $_COOKIE['enable_lyric'] == '0' ) {
   $arguments['enable_lyric'] = ( $_SESSION['enable_lyric'] = '0' );
} elseif ( $_SESSION['enable_lyric'] == '1' ) {
   $arguments['enable_lyric'] = '1';
} else {
   $arguments['enable_lyric'] = '0';
}

if ( $_REQUEST['relapath'] !== NULL ) {
   $arguments['relapath'] = str_replace('/',DSEP,$_REQUEST['relapath']);
} else {
   $arguments['relapath'] = '';
}

if ( $_REQUEST['depth'] != '' ) {
   $arguments['depth'] = ( $_SESSION['depth'] = $_REQUEST['depth'] );
} elseif ( $_SESSION['depth'] != '' ) {
   $arguments['depth'] = $_SESSION['depth'];
} else {
   $arguments['depth'] = '1';
}

$arguments['filter_album'] = ($_REQUEST['filter_album'] != '')  ? $_REQUEST['filter_album']  : NULL;
$arguments['filter_artist'] = ($_REQUEST['filter_artist'] != '') ? $_REQUEST['filter_artist'] : NULL;
$arguments['filter_dir'] = ($_REQUEST['filter_dir'] != '')    ? $_REQUEST['filter_dir']    : NULL;
$arguments['filter_file'] = ($_REQUEST['filter_file'] != '')   ? $_REQUEST['filter_file']   : NULL;
$arguments['filter_genre'] = ($_REQUEST['filter_genre'] != '')  ? $_REQUEST['filter_genre']  : NULL;
$arguments['filter_title'] = ($_REQUEST['filter_title'] != '')  ? $_REQUEST['filter_title']  : NULL;
$arguments['filter_track'] = ($_REQUEST['filter_track'] != '')  ? $_REQUEST['filter_track']  : NULL;

$arguments['linkadd'] = ($_REQUEST['linkadd'] != '') ? str_replace('/',DSEP,$_REQUEST['linkadd']) : NULL;
$arguments['linkdel'] = ($_REQUEST['linkdel'] != '') ? str_replace('/',DSEP,$_REQUEST['linkdel']) : NULL;

$arguments['sns_format'] = ($_REQUEST['sns_format'] != '')  ? $_REQUEST['sns_format'] : $confs['sns_format'];

$arguments['numlast'] = ( ctype_digit($_REQUEST['numsince']) && ctype_digit($_REQUEST['numlast']) ) ? $_REQUEST['numlast'] : NULL;
$arguments['numsince'] = ( ctype_digit($_REQUEST['numsince']) && ctype_digit($_REQUEST['numlast']) ) ? $_REQUEST['numsince'] : NULL;

if ( $_REQUEST['sort'] == 'filename_u' ) {
   $arguments['sort'] = 'filename_u';  $_SESSION['sort'] = 'filename_u';
} elseif ( $_REQUEST['sort'] == 'filename_d' ) {
   $arguments['sort'] = 'filename_d';  $_SESSION['sort'] = 'filename_d';
} elseif ( $_REQUEST['sort'] == 'artist_u' ) {
   $arguments['sort'] = 'artist_u';    $_SESSION['sort'] = 'artist_u';
} elseif ( $_REQUEST['sort'] == 'artist_d' ) {
   $arguments['sort'] = 'artist_d';    $_SESSION['sort'] = 'artist_d';
} elseif ( $_REQUEST['sort'] == 'title_u' ) {
   $arguments['sort'] = 'title_u';     $_SESSION['sort'] = 'title_u';
} elseif ( $_REQUEST['sort'] == 'title_d' ) {
   $arguments['sort'] = 'title_d';     $_SESSION['sort'] = 'title_d';
} elseif ( $_REQUEST['sort'] == 'trackinfo_u' ) {
   $arguments['sort'] = 'trackinfo_u'; $_SESSION['sort'] = 'trackinfo_u';
} elseif ( $_REQUEST['sort'] == 'trackinfo_d' ) {
   $arguments['sort'] = 'trackinfo_d'; $_SESSION['sort'] = 'trackinfo_d';
} elseif ( $_REQUEST['sort'] == 'random' ) {
   $arguments['sort'] = 'random';      $_SESSION['sort'] = 'random';
} elseif ( $_REQUEST['sort'] == 'none' ) {
   $arguments['sort'] = 'none';  $_SESSION['sort'] = 'none';
} elseif ( $_COOKIE['sort']  == 'filename_u' ) {
   $arguments['sort'] = 'filename_u';  $_SESSION['sort'] = 'filename_u';
} elseif ( $_COOKIE['sort']  == 'filename_d' ) {
   $arguments['sort'] = 'filename_d';  $_SESSION['sort'] = 'filename_d';
} elseif ( $_COOKIE['sort']  == 'artist_u' ) {
   $arguments['sort'] = 'artist_u';    $_SESSION['sort'] = 'artist_u';
} elseif ( $_COOKIE['sort']  == 'artist_d' ) {
   $arguments['sort'] = 'artist_d';    $_SESSION['sort'] = 'artist_d';
} elseif ( $_COOKIE['sort']  == 'title_u' ) {
   $arguments['sort'] = 'title_u';     $_SESSION['sort'] = 'title_u';
} elseif ( $_COOKIE['sort']  == 'title_d' ) {
   $arguments['sort'] = 'title_d';     $_SESSION['sort'] = 'title_d';
} elseif ( $_COOKIE['sort']  == 'trackinfo_u' ) {
   $arguments['sort'] = 'trackinfo_u'; $_SESSION['sort'] = 'trackinfo_u';
} elseif ( $_COOKIE['sort']  == 'trackinfo_d' ) {
   $arguments['sort'] = 'trackinfo_d'; $_SESSION['sort'] = 'trackinfo_d';
} elseif ( $_COOKIE['sort']  == 'random' ) {
   $arguments['sort'] = 'random';      $_SESSION['sort'] = 'random';
} elseif ( $_COOKIE['sort']  == 'none' ) {
   $arguments['sort'] = 'none';  $_SESSION['sort'] = 'none';
} elseif ( $_SESSION['sort'] == 'filename_u' ) {
   $arguments['sort'] = 'filename_u';
} elseif ( $_SESSION['sort'] == 'filename_d' ) {
   $arguments['sort'] = 'filename_d';
} elseif ( $_SESSION['sort'] == 'artist_u' ) {
   $arguments['sort'] = 'artist_u';
} elseif ( $_SESSION['sort'] == 'artist_d' ) {
   $arguments['sort'] = 'artist_d';
} elseif ( $_SESSION['sort'] == 'title_u' ) {
   $arguments['sort'] = 'title_u';
} elseif ( $_SESSION['sort'] == 'title_d' ) {
   $arguments['sort'] = 'title_d';
} elseif ( $_SESSION['sort'] == 'trackinfo_u' ) {
   $arguments['sort'] = 'trackinfo_u';
} elseif ( $_SESSION['sort'] == 'trackinfo_d' ) {
   $arguments['sort'] = 'trackinfo_d';
} elseif ( $_SESSION['sort'] == 'random' ) {
   $arguments['sort'] = 'random';
} elseif ( $_SESSION['sort'] == 'none' ) {
   $arguments['sort'] = 'none';
} else {
   $arguments['sort'] = 'trackinfo_u';
}
