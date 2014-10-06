<?php
// Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function showdirtree($tree){
 global $arguments, $base_dir, $base_uri_s, $baseuri, $confs, $depth1, $folders;

 if (!is_array($tree)) { return false; }

 $depth1++;
 $i = 0;
 foreach ($tree as $key => $value) {
  if (is_array($value)) {
   $args = 'favnum=&';
   $folders .= '<li><span class="artist" onClick="location.href=\''.$_SERVER['SCRIPT_NAME'].'?'.$args.'mode='.$arguments['mode'].'&dir='.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath(urldecode($key))).'\';return false;">'.basename(urldecode($key)).'/</span>'."\n";
   if ($depth1 < $arguments['depth']) {
    $folders .= "<ol>\n";
    showdirtree($value);
    flush();
    $folders .= "</ol>\n";
   }
   $folders .= '</li>'."\n";
  } else {
   if ($arguments['mode'] == 'music') {
    if ($arguments['m3uuri'] != '') {
     if ( (stripos($value, 'http') === 0) && (stripos($value, '.mp3') !== FALSE) ) {
      echo '<li id="track'.$i.'"><a href="#" data-src="'.$value.'" title="'.$value.'">'.$value.'</a></li>'."\n";
      flush();
     }
    } else {
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

             echo '<li id="track'.$i.'"><a class="title" href="#" data-src="'.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $base_uri_s, realpath($value)).'" title="'.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $baseuri, realpath($value)).'">';
             echo htmlspecialchars($getmp3info_parts[0], ENT_QUOTES);
             echo '</a>'."\n";
             echo '　　';
             echo ' <span onClick="window.open(\''.$_SERVER['SCRIPT_NAME'].'?mode=favmenu&favcheck='.urlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))).'\', \'favmenu\');return false;">'."\n";
             echo '  　<img id="bookmarkstar'.$i.'" class="fava" src="icon/fava.png" alt="お気に入りの管理" title="お気に入りの管理">　'."\n";
             echo ' </span>';
             if ( $arguments['favnum'] != '' ) {
              echo ' <span onClick="if(window.confirm(\''.htmlspecialchars($getmp3info_parts[0], ENT_QUOTES).' ('.basename($value).')をお気に入りから外してよろしいですか？\')){ $(function(){$(\'#track'.$i.'\').remove()}); $.get(\''.$_SERVER['SCRIPT_NAME'].'?id='.$arguments['id'].'&pw='.$arguments['pw'].'&mode=favdel&favnum='.$arguments['favnum'].'&linkdel='.urlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))).'\', function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 1000, cls: status }); });return false; }">';
              echo '  <img id="bookmarkstar'.$i.'" class="favr" src="icon/favr.png" alt="お気に入りから外します" title="お気に入りから外します">'."\n";
              echo ' </span>';
             }
             echo '<br>'."\n";
             flush();
             $dirtmp = str_replace(array($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '/'.basename($value)), array('', ''), realpath($value));
             $args = 'favnum=&';
             echo '　<a class="artist" href="'.$_SERVER['SCRIPT_NAME'].'?'.$args.'mode=music&dir='.$dirtmp.'">';
             echo htmlspecialchars($getmp3info_parts[1], ENT_QUOTES);
             echo '</a> &gt; <span class="trackinfo">';
             echo '<a class="album" href="'.$_SERVER['SCRIPT_NAME'].'?'.$args.'mode=music&dir='.$dirtmp.'&filter_album='.urlencode($getmp3info_parts[2]).'">';
             echo htmlspecialchars($getmp3info_parts[2], ENT_QUOTES);
             echo '</a>';
             echo ' (No.<span class="number">';
             echo htmlspecialchars($getmp3info_parts[3], ENT_QUOTES);
             echo '</span>) [<span class="genre">';
             echo htmlspecialchars($getmp3info_parts[4], ENT_QUOTES);
             echo '</span>] <span class="time"><span class="time_m">';
             echo htmlspecialchars( (($getmp3info_parts[5]<10)?("0".$getmp3info_parts[5]):($getmp3info_parts[5])) , ENT_QUOTES);
             echo '</span>:<span class="time_s">';
             echo htmlspecialchars( (($getmp3info_parts[6]<10)?("0".$getmp3info_parts[6]):($getmp3info_parts[6])) , ENT_QUOTES);
             echo '</span></span>';
             echo '</span><br>'."\n";
             flush();
             echo '</li>'."\n";
             flush();

            }
           }
          }
         }
        }
       }
      }
     }
    }
   } else {
    echo '<li><a class="artist" href="'.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $baseuri, realpath($value)).'" class="title" title="'.str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), $baseuri, realpath($value)).'">'.basename($value);
    echo '</a>'."\n";
    echo '<span onClick="window.open(\''.$_SERVER['SCRIPT_NAME'].'?mode=favmenu&favcheck='.urlencode(str_replace($base_dir.((mb_substr($base_dir,-1)=='/')?'':'/'), '', realpath($value))).'\', \'favmenu\');return false;">'."\n";
    echo ' <img id="bookmarkstar'.$i.'" height="10px" src="icon/fava.png" alt="お気に入りの管理" title="お気に入りの管理">'."\n";
    echo '</span>'."\n";
    echo ' ('.filesize(realpath($value)).'byte)</li>'."\n";
    flush();
   }
  }
  $i++;
 }
 $depth1--;
 return true;
}
