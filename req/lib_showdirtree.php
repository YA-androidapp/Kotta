<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function showdirtree($tree){
 global $arguments, $base_dir, $base_uri, $confs, $depth1, $folders;

 if (!is_array($tree)) { return false; }

 $depth1++;
 $i = 0;
 foreach ($tree as $key => $value) {
  if (is_array($value)) {
   $args = 'favname=&';
   $folders .= '<li><span class=\'artist\' onClick=\'location.href="?'.$args.'mode='.$arguments['mode'].'&dirname='.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath(urldecode($key))).'";return false;\'>'.basename(urldecode($key)).'/</span>';
   if ($depth1 < $arguments['depth']) {
    $folders .= '<ol>';
    showdirtree($value);
    flush();
    $folders .= '</ol>';
   }
   $folders .= '</li>';
  } else {
   if ($arguments['mode'] == 'music') {
    if (stripos(realpath($value), '.mp3') !== FALSE) {
     $getmp3info_parts = array();
     $getmp3info_parts = getmp3info(realpath($value));
     if (     ($arguments['filter_title']=='')  || (($arguments['filter_title']!='') &&(fnmatch($arguments['filter_title'], $getmp3info_parts[0])==1)) ) {
      if (    ($arguments['filter_artist']=='') || (($arguments['filter_artist']!='')&&(fnmatch($arguments['filter_artist'],$getmp3info_parts[1])==1)) ) {
       if (   ($arguments['filter_album']=='')  || (($arguments['filter_album']!='') &&(fnmatch($arguments['filter_album'], $getmp3info_parts[2])==1)) ) {
        if (  ($arguments['filter_track']=='')  || (($arguments['filter_track']!='') &&(fnmatch($arguments['filter_track'], $getmp3info_parts[3])==1)) ) {
         if ( ($arguments['filter_genre']=='')  || (($arguments['filter_genre']!='') &&(fnmatch($arguments['filter_genre'], $getmp3info_parts[4])==1)) ) {
          if (    ($confs['filter_album']=='')  || (    ($confs['filter_album']!='') &&    (fnmatch($confs['filter_album'], $getmp3info_parts[2])==1)) ) {
           if (   ($confs['filter_genre']=='')  || (    ($confs['filter_genre']!='') &&    (fnmatch($confs['filter_genre'], $getmp3info_parts[4])==1)) ) { 
            echo '<li id=\'track'.$i.'\'><a class=\'title\' href=\'#\' data-src=\''.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($value))
                                                                .'\' title=\''.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($value)).'\'>';
            echo htmlspecialchars($getmp3info_parts[0], ENT_QUOTES);
            echo '</a><br>';
            echo ' <span class=\'starw\' id="bookmarkstar'.$i.'" alt="お気に入りの管理" title="お気に入りの管理" onClick=\'window.open("?mode=favmenu&favcheck='.rawurlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))).'", "favmenu");return false;\'>';
            echo ' ☆</span>';
            if ( $arguments['favname'] != '' ) {
             echo ' <span class=\'star\' id=\'bookmarkstar'.$i.'\' alt=\'お気に入りから外します\' title=\'お気に入りから外します\' onClick=\'if(window.confirm("'.htmlspecialchars($getmp3info_parts[0], ENT_QUOTES).' ('.basename($value).')をお気に入りから外してよろしいですか？")){ $(function(){$("#track'.$i.'").remove()}); $.get("?id='.$arguments['id'].'&pw='.$arguments['pw'].'&mode=favdel&favname='.rawurlencode($arguments['favname']).'&linkdel='.rawurlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))).'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 1000, cssClass: status }); });return false; }\'>';
             echo ' ★</span>';
            }
            echo ' <span class=\'del\' id=\'delicon'.$i.'\' alt=\'プレイビューから外します\' title=\'プレイビューから外します\' onClick=\'if(window.confirm("'.htmlspecialchars($getmp3info_parts[0], ENT_QUOTES).' ('.basename($value).')をプレイビューから外してよろしいですか？")){ $(function(){$("#track'.$i.'").remove()});return false; }\'>';
            echo ' ×</span>';
            echo '<br>';
            flush();
            $dirtmp = str_replace(array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '/'.basename($value)), array('', ''), realpath($value));
            $args = 'favname=&';
            echo '　<a class=\'artist\' href=\'?'.$args.'mode=music&dirname='.rawurlencode($dirtmp).'\'>';
            echo htmlspecialchars($getmp3info_parts[1], ENT_QUOTES);
            echo '</a> &gt; <span class=\'trackinfo\'>';
            echo '<a class=\'album\' href=\'?'.$args.'mode=music&dirname='.rawurlencode($dirtmp).'&filter_album='.rawurlencode($getmp3info_parts[2]).'\'>';
            echo htmlspecialchars($getmp3info_parts[2], ENT_QUOTES);
            echo '</a>';
            echo ' (No.<span class=\'number\'>';
            echo htmlspecialchars(str_pad($getmp3info_parts[3], 2, 0, STR_PAD_LEFT), ENT_QUOTES);
            echo '</span>) [<span class=\'genre\'>';
            echo htmlspecialchars($getmp3info_parts[4], ENT_QUOTES);
            echo '</span>] <span class=\'time\'><span class=\'time_m\'>';
            echo htmlspecialchars(str_pad($getmp3info_parts[5], 2, 0, STR_PAD_LEFT), ENT_QUOTES);
            echo '</span>:<span class=\'time_s\'>';
            echo htmlspecialchars(str_pad($getmp3info_parts[6], 2, 0, STR_PAD_LEFT), ENT_QUOTES);
            echo '</span></span>';
            echo '</span><br>';
            flush();
            echo '</li>';
            flush();
           }
          }
         }
        }
       }
      }
     }
    }
   } else {
    echo '<li><a class=\'artist\' href=\''.htmlspecialchars(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($value)), ENT_QUOTES).'\' class=\'title\' title=\''.htmlspecialchars(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri, realpath($value)), ENT_QUOTES).'\'>'.basename($value);
    echo '</a><br>';
    echo '<span class=\'starw\' id=\'bookmarkstar'.$i.'\' alt=\'お気に入りの管理\' title=\'お気に入りの管理\' onClick=\'window.open("?mode=favmenu&favcheck='.rawurlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))).'", "favmenu");return false;\'>';
    echo '☆</span>';
    echo ' ('.filesize(realpath($value)).'byte)</li>';
    flush();
   }
  }
  $i++;
 }
 $depth1--;
 return true;
}
