<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<script type='text/javascript' src='https://code.jquery.com/jquery-git2.min.js'></script>
<script type='text/javascript' src='https://code.jquery.com/ui/1.10.3/jquery-ui.min.js'></script>
<script type='text/javascript' src='js/jQuery-Notify-bar/jquery.notifyBar.js'></script>

<?php if ( ( $_REQUEST['menu'] != '1' ) && ( $_REQUEST['mode'] != 'favmenu' ) && ( ( $arguments['mode'] == 'simple' ) || ( $arguments['mode'] == 'music' ) ) ) { ?>
<script type='text/javascript' src='js/pull.js'></script>
<?php } ?>
<script type='text/javascript' src='js/common.js'></script>

<script type='text/javascript' src='js/jquery-base64/jquery.base64.js'></script>
<script type='text/javascript' src='js/js-cookie/js.cookie.js'></script>
<script type='text/javascript' src='js/noreferer/noreferer.js'></script>

<?php if ( $arguments['mode'] == 'music' ) { ?>
<?php require_once(realpath(__DIR__).'/m_js.php'); ?>
<script type='text/javascript' src='js/m.js'></script>

<script type='text/javascript' src='js/audiojs/audio.js'></script>
<script type='text/javascript' src='js/kirinlyric/kirinlyric.js'></script>
<?php } ?>

<?php if ( $enable_autocomplete_dirname == 1 ) { ?>
<script type='text/javascript' src='js/ac_dir.js'></script>
<?php } ?>

<?php if ( $enable_autocomplete_favname == 1 ) { ?>
<script type='text/javascript' src='js/ac_fav.js'></script>
<?php } ?>

<script type='text/javascript'>
 function settweetstr(mode) {
  tstr = '<?php echo $arguments['sns_format']; ?>';
  tstr = tstr.replace('%a', jQuery('ol#sort_list li.playing .artist').text() );
  tstr = tstr.replace('%g', jQuery('ol#sort_list li.playing .genre').text() );
  tstr = tstr.replace('%l', jQuery('ol#sort_list li.playing .album').text() );
  tstr = tstr.replace('%m', jQuery('ol#sort_list li.playing .time_m').text() );
  tstr = tstr.replace('%n', jQuery('ol#sort_list li.playing .number').text() );
  tstr = tstr.replace('%s', jQuery('ol#sort_list li.playing .time_s').text() );
  tstr = tstr.replace('%t', jQuery('ol#sort_list li.playing .title').text() );
  if ( tstr.indexOf('%u', 0) > -1 ) {
   jQuery.ajax({
    type: 'POST',
    url: 'req/shortenuri.php',
    data: 'uri='+jQuery('ol#sort_list li.playing .title').attr('data-src'),
    success: function(data, dataType){
     tstr = tstr.replace('%u', data);
     if ( mode == 1 ) {
      jQuery('textarea#tweettext').val( tstr );
     } else if ( mode == 2 ) {
      window.open('tweet/tweet.php?pass_autotweet=<?php echo $arguments['pass_autotweet']; ?>&tweettext='+encodeURIComponent(tstr), 'sns');
     }
    }
   });
  } else {
   if ( mode == 1 ) {
    jQuery('textarea#tweettext').val( tstr );
   } else if ( mode == 2 ) {
    window.open('tweet/tweet.php?pass_autotweet=<?php echo $arguments['pass_autotweet']; ?>&tweettext='+encodeURIComponent(tstr), 'sns');
   }
  }
 }

 // ソート用
 var arr      = new Array();
 var sortAsc  = function(a, b) { return a.key.localeCompare(b.key); } // 昇順
 var sortDesc = function(a, b) { return b.key.localeCompare(a.key); } // 降順
 function filename_u() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = basename( jQuery('a[data-src]', this).attr('data-src') );
   arr[i].value = jQuery(this);
  });
  arr.sort(sortAsc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function filename_d() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = basename( jQuery('a[data-src]', this).attr('data-src') );
   arr[i].value = jQuery(this);
  });
  arr.sort(sortDesc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function title_u() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = jQuery('a[data-src]', this).text();
   arr[i].value = jQuery(this);
  });
  arr.sort(sortAsc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function title_d() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = jQuery('a[data-src]', this).text();
   arr[i].value = jQuery(this);
  });
  arr.sort(sortDesc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function artist_u() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = jQuery('.artist', this).text();
   arr[i].value = jQuery(this);
  });
  arr.sort(sortAsc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function artist_d() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = jQuery('.artist', this).text();
   arr[i].value = jQuery(this);
  });
  arr.sort(sortDesc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function trackinfo_u() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = jQuery('.trackinfo', this).text();
   arr[i].value = jQuery(this);
  });
  arr.sort(sortAsc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function trackinfo_d() {
  jQuery('ol#sort_list li').each(function(i){
   arr[i] = new Object();
   arr[i].key = jQuery('.trackinfo', this).text();
   arr[i].value = jQuery(this);
  });
  arr.sort(sortDesc);
  for(i = 0; i < arr.length; i++){ jQuery('ol#sort_list').append(arr[i].value); }
 }
 function random() {
  jQuery('ol#sort_list li').shuffle();
 }
 (function(d){
  d.fn.shuffle=function(c){
   c=[];return this.each(function(){
    c.push(d(this).clone(true))
   }).each(function(a,b){
    d(b).replaceWith(c[a=Math.floor(Math.random()*c.length)]);c.splice(a,1)
   })
  };d.shuffle=function(a){
   return d(a).shuffle()
  }
 })(jQuery);
<?php
if ( ($arguments['sort'] != '') && ($arguments['sort'] != 'none') ) {
 echo 'setTimeout(function(){ '.$arguments['sort'].'(); }, 3000);';
}
?>
 // ソート用 終わり

</script>
