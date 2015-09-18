<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<script type='text/javascript' src='https://code.jquery.com/jquery-git2.min.js'></script>
<script type='text/javascript' src='https://code.jquery.com/ui/1.10.3/jquery-ui.min.js'></script>
<script type='text/javascript' src='js/jQuery-Notify-bar/jquery.notifyBar.js'></script>

<script type='text/javascript'>
 var sns_format = '<?php echo $arguments['sns_format']; ?>';
 var pass_autotweet = '<?php echo $arguments['pass_autotweet']; ?>';
</script>
<script type='text/javascript' src='js/common.js'></script>
<script type='text/javascript' src='js/jquery-base64/jquery.base64.js'></script>
<script type='text/javascript' src='js/js-cookie/js.cookie.js'></script>
<script type='text/javascript' src='js/noreferer/noreferer.js'></script>

<?php if ( $arguments['mode'] == 'music' ) { ?>
<script type='text/javascript'>
 var base_uri = '<?php echo $base_uri.((mb_substr($base_uri,-1)=='/')?'':'/'); ?>';
</script>
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
