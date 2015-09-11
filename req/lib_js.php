<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<script type='text/javascript' src='https://code.jquery.com/jquery-git2.min.js'></script>
<script type='text/javascript' src='https://code.jquery.com/ui/1.10.3/jquery-ui.min.js'></script>
<script type='text/javascript' src='js/jQuery-Notify-bar/jquery.notifyBar.js'></script>

<script type='text/javascript' src='js/pull.js'></script>
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
</script>
