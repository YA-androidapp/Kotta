<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<?php if ( $arguments['mode'] == 'music' ) { ?>
    </ol>
   </div>
  </div>
<?php } else { ?>
  </ol>
<?php } ?>

<?php  if ( $folders != '' ) { ?>
  <div id='wrapper_footerlist'>
   <ol>
    <?php echo $folders; ?>
   </ol>
  </div>
  <br />
<?php  } ?>

<?php
 $flag = ($_SERVER['HTTPS']!='') ? 's' : '';
 $permalink = 'http'.$flag.'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'?'.http_build_query($arguments);
 $permalink = str_replace('dirname='.rawurlencode($base_dir.'/'),'dirname=' , $permalink);
 $permalink = str_replace('dirname='.rawurlencode($base_dir),'dirname=' , $permalink);
?>
  <div id='permalink' align='right'>
   Permanent Link: 
   <a href='<?php echo $permalink; ?>'>
<?php echo mb_substr($permalink, 0, 40); ?>...<?php echo mb_substr($permalink, mb_strlen($permalink)-20, 20); ?>
   </a>
  </div>
