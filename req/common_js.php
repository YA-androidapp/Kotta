<!-- Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<script type='text/javascript' src='https://code.jquery.com/jquery-git2.min.js'></script>
<!-- <script type='text/javascript' src='https://code.jquery.com/jquery-2.0.3.min.js'></script> -->

<script type='text/javascript' src='https://code.jquery.com/ui/1.10.3/jquery-ui.min.js'></script>

<script type='text/javascript' src='js/jQuery-Notify-bar/jquery.notifyBar.js'></script>

<script type='text/javascript' src='js/jquery-base64/jquery.base64.js'></script>

<script type='text/javascript' src='js/jquery-cookie/jquery.cookie.js'></script>

<script type='text/javascript' src='js/noreferer/noreferer.js'></script>

<script type='text/javascript'>
 $(document).ready(function(){
  $('a').not('[href="#"]').attr({target:'_blank'}).addClass('ex_link');

  $('#favfadd').click(function(e) {
   $.get('<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&mode=favfadd&favname='+jQuery('input#favname').val(),
    function(data){
     var status = (data.indexOf('(!) ')==0) ? 'error' : 'success';
     $.notifyBar({ html: data, delay: 1000, cls: status });
     $.get('<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&header_menu=1',
      function(data){
       $('div#wrapper_headerlist').html(data);
       jQuery('#wrapper_headerlist #dirslist').hide()
       pullname('dir');
       pullname('fav');
      }
     );
    }
   );
  });

  $('#favfdel').click(function(e) {
   if(window.confirm($('select#favname').val()+'を削除してよろしいですか？')){
    $.get('<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&mode=favfdel&favname='+jQuery('select#favname').val(),
     function(data){
      var status = (data.indexOf('(!) ')==0) ? 'error' : 'success';
      $.notifyBar({ html: data, delay: 1000, cls: status });
      $.get('<?php echo basename($_SERVER['SCRIPT_NAME']); ?>?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&header_menu=1',
       function(data){
        $('div#wrapper_headerlist').html(data);
        jQuery('#wrapper_headerlist #dirslist').hide()
        pullname('dir');
        pullname('fav');
       }
      );
     }
    );
    return false;
   }
  });

  jQuery('#wrapper_headerlist #dirslist').hide()
  jQuery('#control #playcontrol').hide()
  jQuery('#control #checkbox_auto').hide()
  jQuery('#control #pagesearch').hide()
  jQuery('#control #copyrights_list').hide();
 });
</script>
