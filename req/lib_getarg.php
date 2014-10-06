<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

$arguments = array();

 if       ( $_REQUEST['dir'] != '' )             { $arguments['dir'] = $_REQUEST['dir'];
 } else                                          { $arguments['dir'] = ''; }

 $real_path = realpath($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/').$arguments['dir']);

 if (!file_exists($real_path))                                                         { die('引数が不正です getarg-2');
 } elseif (stripos($real_path.((mb_substr($real_path,-1)=='/')?'':'/'),$base_dir)!==0) { die('引数が不正です getarg-3');
 }

 if       ( $_REQUEST['favnum'] !== NULL )       { $arguments['favnum'] = $_REQUEST['favnum'];
 } else                                          { $arguments['favnum'] = ''; }

 if       ( $_REQUEST['mode'] == 'simple' )      { $_SESSION['mode']  = ( $_REQUEST['mode'] = '' ); }
 if       ( $_REQUEST['mode'] != '' )            { $arguments['mode'] = ( $_SESSION['mode'] = $_REQUEST['mode'] );
 } elseif ( $_SESSION['mode'] != '' )            { $arguments['mode'] = $_SESSION['mode'];
 } else                                          { $arguments['mode'] = ''; }

 if ( $arguments['favnum'] != '' ) {
  if ( !file_exists('fav/'.$pname.'/'.$id.'_'.$arguments['favnum'].'.cgi') ) {
   if ( ($arguments['mode'] != 'favfadd')
     && ($arguments['favnum'] != '_recently_played')
     && ($arguments['favnum'] != '_recently_transferred') ) {
    die('引数が不正です getarg-1 '.$arguments['mode']);
   }
  }
 }

 if       ( $_REQUEST['enable_loop'] == '1' )            { $arguments['enable_loop']            = ( $_SESSION['enable_loop'] = '1' );
 } elseif ( $_REQUEST['enable_loop'] == '0' )            { $arguments['enable_loop']            = ( $_SESSION['enable_loop'] = '0' );
 } elseif ( $_SESSION['enable_loop'] == '1' )            { $arguments['enable_loop']            = '1';
 } else                                                  { $arguments['enable_loop']            = '0'; }
 if       ( $_REQUEST['enable_allloop'] == '0' )         { $arguments['enable_allloop']         = ( $_SESSION['enable_allloop'] = '0' );
 } elseif ( $_REQUEST['enable_allloop'] == '1' )         { $arguments['enable_allloop']         = ( $_SESSION['enable_allloop'] = '1' );
 } elseif ( $_SESSION['enable_allloop'] == '0' )         { $arguments['enable_allloop']         = '0';
 } else                                                  { $arguments['enable_allloop']         = '1'; }
 if       ( $_REQUEST['enable_autotweet'] == '1' )       { $arguments['enable_autotweet']       = ( $_SESSION['enable_autotweet'] = '1' );
 } elseif ( $_REQUEST['enable_autotweet'] == '0' )       { $arguments['enable_autotweet']       = ( $_SESSION['enable_autotweet'] = '0' );
 } elseif ( $_SESSION['enable_autotweet'] == '1' )       { $arguments['enable_autotweet']       = '1';
 } else                                                  { $arguments['enable_autotweet']       = '0'; }
 $arguments['pass_autotweet'] = ($_REQUEST['pass_autotweet'] == '1')  ? '1' : '0';
 if       ( $_REQUEST['enable_notification'] == '1' )    { $arguments['enable_notification']    = ( $_SESSION['enable_notification'] = '1' );
 } elseif ( $_REQUEST['enable_notification'] == '0' )    { $arguments['enable_notification']    = ( $_SESSION['enable_notification'] = '0' );
 } elseif ( $_SESSION['enable_notification'] == '1' )    { $arguments['enable_notification']    = '1';
 } else                                                  { $arguments['enable_notification']    = '0'; }
 if       ( $_REQUEST['enable_recently_played'] == '1' ) { $arguments['enable_recently_played'] = ( $_SESSION['enable_recently_played'] = '1' );
 } elseif ( $_REQUEST['enable_recently_played'] == '0' ) { $arguments['enable_recently_played'] = ( $_SESSION['enable_recently_played'] = '0' );
 } elseif ( $_SESSION['enable_recently_played'] == '1' ) { $arguments['enable_recently_played'] = '1';
 } else                                                  { $arguments['enable_recently_played'] = '0'; }
 if       ( $_REQUEST['enable_muted'] == '1' )           { $arguments['enable_muted']           = ( $_SESSION['enable_muted'] = '1' );
 } elseif ( $_REQUEST['enable_muted'] == '0' )           { $arguments['enable_muted']           = ( $_SESSION['enable_muted'] = '0' );
 } elseif ( $_SESSION['enable_muted'] == '1' )           { $arguments['enable_muted']           = '1';
 } else                                                  { $arguments['enable_muted']           = '0'; }
 if       ( $_REQUEST['enable_lyric'] == '1' )           { $arguments['enable_lyric']           = ( $_SESSION['enable_lyric'] = '1' );
 } elseif ( $_REQUEST['enable_lyric'] == '0' )           { $arguments['enable_lyric']           = ( $_SESSION['enable_lyric'] = '0' );
 } elseif ( $_SESSION['enable_lyric'] == '1' )           { $arguments['enable_lyric']           = '1';
 } else                                                  { $arguments['enable_lyric']           = '0'; }

 if       ( $_REQUEST['favcheck'] !== NULL )     { $arguments['favcheck'] = $_REQUEST['favcheck'];
 } else                                          { $arguments['favcheck'] = ''; }

 if       ( $_REQUEST['depth'] != '' )           { $arguments['depth'] = ( $_SESSION['depth'] = $_REQUEST['depth'] );
 } elseif ( $_SESSION['depth'] != '' )           { $arguments['depth'] = $_SESSION['depth'];
 } else                                          { $arguments['depth'] = '1'; }

 $arguments['filter_album']                      = ($_REQUEST['filter_album'] != '')  ? $_REQUEST['filter_album']  : NULL;
 $arguments['filter_artist']                     = ($_REQUEST['filter_artist'] != '') ? $_REQUEST['filter_artist'] : NULL;
 $arguments['filter_dir']                        = ($_REQUEST['filter_dir'] != '')    ? $_REQUEST['filter_dir']    : NULL;
 $arguments['filter_file']                       = ($_REQUEST['filter_file'] != '')   ? $_REQUEST['filter_file']   : NULL;
 $arguments['filter_genre']                      = ($_REQUEST['filter_genre'] != '')  ? $_REQUEST['filter_genre']  : NULL;
 $arguments['filter_title']                      = ($_REQUEST['filter_title'] != '')  ? $_REQUEST['filter_title']  : NULL;
 $arguments['filter_track']                      = ($_REQUEST['filter_track'] != '')  ? $_REQUEST['filter_track']  : NULL;

 $arguments['linkadd']                           = ($_REQUEST['linkadd'] != '') ? $_REQUEST['linkadd'] : NULL;
 $arguments['linkdel']                           = ($_REQUEST['linkdel'] != '') ? $_REQUEST['linkdel'] : NULL;

 $arguments['m3uextended']                       = ($_REQUEST['m3uextended'] != '') ? $_REQUEST['m3uextended'] : '';
 $arguments['m3uuri']                            = ($_REQUEST['m3uuri'] != '')      ? $_REQUEST['m3uuri']      : '';

 $arguments['sns_format']                        = $confs['sns_format']; // ($_REQUEST['sns_format'] != '')  ? $_REQUEST['sns_format'] : $confs['sns_format'];

 $arguments['numlast']                           = ( ctype_digit($_REQUEST['numsince']) && ctype_digit($_REQUEST['numlast']) ) ? $_REQUEST['numlast'] : NULL;
 $arguments['numsince']                          = ( ctype_digit($_REQUEST['numsince']) && ctype_digit($_REQUEST['numlast']) ) ? $_REQUEST['numsince'] : NULL;

 if       ( $_REQUEST['sort'] == 'filename_u' )  { $arguments['sort'] = 'filename_u';  $_SESSION['sort'] = 'filename_u';
 } elseif ( $_REQUEST['sort'] == 'filename_d' )  { $arguments['sort'] = 'filename_d';  $_SESSION['sort'] = 'filename_d';
 } elseif ( $_REQUEST['sort'] == 'artist_u' )    { $arguments['sort'] = 'artist_u';    $_SESSION['sort'] = 'artist_u';
 } elseif ( $_REQUEST['sort'] == 'artist_d' )    { $arguments['sort'] = 'artist_d';    $_SESSION['sort'] = 'artist_d';
 } elseif ( $_REQUEST['sort'] == 'title_u' )     { $arguments['sort'] = 'title_u';     $_SESSION['sort'] = 'title_u';
 } elseif ( $_REQUEST['sort'] == 'title_d' )     { $arguments['sort'] = 'title_d';     $_SESSION['sort'] = 'title_d';
 } elseif ( $_REQUEST['sort'] == 'trackinfo_u' ) { $arguments['sort'] = 'trackinfo_u'; $_SESSION['sort'] = 'trackinfo_u';
 } elseif ( $_REQUEST['sort'] == 'trackinfo_d' ) { $arguments['sort'] = 'trackinfo_d'; $_SESSION['sort'] = 'trackinfo_d';
 } elseif ( $_REQUEST['sort'] == 'random' )      { $arguments['sort'] = 'random';      $_SESSION['sort'] = 'random';
 } elseif ( $_REQUEST['sort'] == 'none' )        { $arguments['sort'] = 'none';        $_SESSION['sort'] = 'none';
 } elseif ( $_SESSION['sort'] == 'filename_u' )  { $arguments['sort'] = 'filename_u';
 } elseif ( $_SESSION['sort'] == 'filename_d' )  { $arguments['sort'] = 'filename_d';
 } elseif ( $_SESSION['sort'] == 'artist_u' )    { $arguments['sort'] = 'artist_u';
 } elseif ( $_SESSION['sort'] == 'artist_d' )    { $arguments['sort'] = 'artist_d';
 } elseif ( $_SESSION['sort'] == 'title_u' )     { $arguments['sort'] = 'title_u';
 } elseif ( $_SESSION['sort'] == 'title_d' )     { $arguments['sort'] = 'title_d';
 } elseif ( $_SESSION['sort'] == 'trackinfo_u' ) { $arguments['sort'] = 'trackinfo_u';
 } elseif ( $_SESSION['sort'] == 'trackinfo_d' ) { $arguments['sort'] = 'trackinfo_d';
 } elseif ( $_SESSION['sort'] == 'random' )      { $arguments['sort'] = 'random';
 } elseif ( $_SESSION['sort'] == 'none' )        { $arguments['sort'] = 'none';
 } else                                          { $arguments['sort'] = 'trackinfo_u'; }
