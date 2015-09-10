<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<meta name="viewport" content="width=device-width,initial-scale=1">

<link rel='stylesheet' type='text/css' href='https://code.jquery.com/ui/1.10.3/themes/ui-darkness/jquery-ui.css' />

<link rel='stylesheet' type='text/css' href='js/jQuery-Notify-bar/jquery.notifyBar.css' />

<?php if ( $arguments['mode'] == 'music' ) { ?>
<link rel='stylesheet' type='text/css' href='css/kirinlyric.css'>
<?php } ?>

<?php if ( ($enable_upload==1) && ($arguments['favname']=='') ) { ?>
<link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload.css'>
<link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-ui.css'>
<noscript><link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-noscript.css'></noscript>
<noscript><link rel='stylesheet' href='css/jQuery-File-Upload/jquery.fileupload-ui-noscript.css'></noscript>
<?php } ?>

<link rel='stylesheet' type='text/css' href='css/kotta.css'>
