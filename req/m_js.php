<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<?php if ( $arguments["mode"] == "music" ) { ?>
<script type="text/javascript" src="js/audiojs/audio.js"></script>
<script type="text/javascript" src="js/kirinlyric/kirinlyric.js"></script>
<?php } ?>

<script type="text/javascript">
 $(function () {

  // ヘッダメニュー用 終わり
  document.getElementById("audio").loop = jQuery("#checkbox_auto #enable_loop").prop("checked");
  document.getElementById("audio").muted = jQuery("#checkbox_auto #enable_muted").prop("checked");
  if(jQuery("#checkbox_auto #enable_lyric").prop("checked")){
   jQuery("#lyrics").show();
  } else {
   jQuery("#lyrics").text("");
   jQuery("#lyrics").hide();
  }

  jQuery("#checkbox_auto #enable_loop").change(function() {
   document.getElementById("audio").loop = jQuery("#checkbox_auto #enable_loop").prop("checked");
  });
  jQuery("#checkbox_auto #enable_muted").change(function() {
   document.getElementById("audio").muted = jQuery("#checkbox_auto #enable_muted").prop("checked");
  });
  jQuery("#checkbox_auto #enable_lyric").change(function() {
   if(jQuery("#checkbox_auto #enable_lyric").prop("checked")){
    // jQuery("#lyrics").show();
   } else {
    jQuery("#lyrics").text("");
    jQuery("#lyrics").hide();
   }
  });

  $("input").blur( function (e){
<?php require("req/lib_menu_autocomplete.php"); ?>
  });
  // ヘッダメニュー用 終わり

  // フィルタリング用
  jQuery("#pageq").keyup(function(e) {
   jQuery("#wrapper_list ol li").each(function(){
    if( !new String( jQuery( jQuery("#pagesearchtype").val() , this).text() ).match( jQuery("#pageq").val() ) ){
     jQuery(this).hide();
    }else{
     jQuery(this).show();
    }
   });
  });
  // フィルタリング用 終わり

  // ソート用
  jQuery("#pagesort").change(function(e) {
   switch ( jQuery("#pagesort").val() ){
    case "filename_u":
     filename_u();
     break;
    case "filename_d":
     filename_d();
     break;
    case "title_u":
     title_u();
     break;
    case "title_d":
     title_d();
     break;
    case "artist_u":
     artist_u();
     break;
    case "artist_d":
     artist_d();
     break;
    case "trackinfo_u":
     trackinfo_u();
     break;
    case "trackinfo_d":
     trackinfo_d();
     break;
    case "random":
     random();
     break;
   }
  });
  // ソート用 終わり

  // SNS用
  jQuery("#screen_name").click(function(e) {
   setscreenname();
  });
  jQuery("#tweettext").dblclick(function(e) {
   settweetstr(1);
  });
  jQuery("#control_twtr").click(function(e) {
   settweetstr(1);
  });
  // SNS用 終わり

  // 認証用
  jQuery("#id").blur(function(e) {
   if(jQuery("#id").val()!=""){
    jQuery.cookie("id", jQuery("#id").val());
   }
  });
  jQuery("#pw").blur(function(e) {
   if(jQuery("#pw").val()!=""){
    jQuery.cookie("pw", jQuery("#pw").val());
   }
  });
  // 認証用 終わり

<?php if ( $arguments["mode"] == "music" ) { ?>

  if(jQuery("#checkbox_auto #enable_autotweet").prop("checked")){
   window.open("tweet/index.php", "sns");
  }

  jQuery("#checkbox_auto #enable_notification").click(function(e) {
   if(jQuery("#checkbox_auto #enable_notification").prop("checked")){
    if(window.webkitNotifications){
     if (window.webkitNotifications.checkPermission() != 0) {
      window.webkitNotifications.requestPermission();
     }
    }
   }
  });

  // audio.js用
  // Setup the player to autoplay the next track
  var a = audiojs.createAll({
   trackEnded: function() {
    if(jQuery("#checkbox_auto #enable_autotweet").prop("checked")){
     settweetstr(2);
    }

    if(jQuery("#checkbox_auto #enable_recently_played").prop("checked")){
     jQuery.ajax({
      type: "POST",
      url : <?php echo basename($_SERVER["SCRIPT_NAME"]); ?>,
      data: "id="+jQuery("#id").val()+"&pw="+jQuery("#pw").val()+"&mode=rpadd&linkadd="+jQuery("ol#sort_list li.playing a[data-src]").attr("data-src").replace("<?php echo $baseuri; ?>/",""),
      beforeSend: function(xhr) {
       var credentials = $.base64.encode( jQuery("#id").val()+":"+ jQuery("#pw").val());
       xhr.setRequestHeader("Authorization", "Basic " + credentials);
      }
     });
    }

    var next = jQuery("ol#sort_list li.playing").next();
    if(jQuery("#checkbox_auto #enable_allloop").prop("checked")){
     if (!next.length) next = jQuery("ol#sort_list li").first();
    } else {
     if (!next.length) return;
    }

    next.addClass("playing").siblings().removeClass("playing");
    if (jQuery("a", next).attr("data-src") !== void 0) {
     audio.load(jQuery("a", next).attr("data-src"));
     kirinload();
     audio.play();
    }

    if(jQuery("#checkbox_auto #enable_notification").prop("checked")){
     if(window.webkitNotifications){
      var message =
         jQuery(".artist", next).text() + " > " +
         jQuery(".trackinfo", next).text();
      if (window.webkitNotifications.checkPermission() == 0) {
       var notification = window.webkitNotifications.createNotification(
        "icon/kotta_s.png", jQuery("a[data-src]", next).text(), message
       );
       notification.ondisplay = function() {
        setTimeout(function() { notification.cancel(); }, 2000);
       };
       notification.show();
      } else {
       window.webkitNotifications.requestPermission();
      }
     }
    }
   }
  });

  // Load in a track on click
  jQuery("ol#sort_list li a[data-src]").click(function(e) {
   e.preventDefault();
   jQuery(this).parent().addClass("playing").siblings().removeClass("playing");
   if (jQuery(this).attr("data-src") !== void 0) {
    audio.load(jQuery(this).attr("data-src"));
    kirinload();
    audio.play();
   }
   if(jQuery("#checkbox_auto #enable_lyric").prop("checked") == false){
    var position = jQuery("ol#sort_list li.playing").offset().top;
    jQuery("html,body").animate({scrollTop:position}, 400, "swing");
   }
  });
  $(document).on("click","ol#sort_list li.appended a[data-src]",function(e){
   e.preventDefault();
   jQuery(this).parent().addClass("playing").siblings().removeClass("playing");
   if (jQuery(this).attr("data-src") !== void 0) {
    audio.load(jQuery(this).attr("data-src"));
    kirinload();
    audio.play();
   }
   if(jQuery("#checkbox_auto #enable_lyric").prop("checked") == false){
    var position = jQuery("ol#sort_list li.playing").offset().top;
    jQuery("html,body").animate({scrollTop:position}, 400, "swing");
   }
  });

  // Shortcut keys
  jQuery(document).keydown(function(e) {
   var unicode = e.charCode ? e.charCode : e.keyCode;
   if (e.shiftKey+e.ctrlKey != 0) {
    if ( unicode == 39 ) {
     var next = jQuery("ol#sort_list li.playing").next().children("a[data-src]");
     if (!next.length) next = jQuery("ol#sort_list li a[data-src]").first();
     next.click();
    } else if ( unicode == 37 ) {
     var prev = jQuery("ol#sort_list li.playing").prev().children("a[data-src]");
     if (!prev.length) prev = jQuery("ol#sort_list li a[data-src]").last();
     prev.click();
    } else if ( unicode == 32 ) {
     e.preventDefault();
     audio.playPause();
    }
   } else {
    if ( unicode == 176 ) {
     var next = jQuery("ol#sort_list li.playing").next().children("a[data-src]");
     if (!next.length) next = jQuery("ol#sort_list li a[data-src]").first();
     next.click();
    } else if ( unicode == 177 ) {
     var prev = jQuery("ol#sort_list li.playing").prev().children("a[data-src]");
     if (!prev.length) prev = jQuery("ol#sort_list li a[data-src]").last();
     prev.click();
    } else if ( unicode == 179 ) {
     e.preventDefault();
     audio.playPause();
    }
   }
  });
  jQuery("#control_prev").click(function(e) {
     var prev = jQuery("ol#sort_list li.playing").prev().children("a[data-src]");
     if (!prev.length) prev = jQuery("ol#sort_list li a[data-src]").last();
     prev.click();
  });
  jQuery("#control_play").click(function(e) {
     e.preventDefault();
     audio.playPause();
  });
  jQuery("#control_next").click(function(e) {
     var next = jQuery("ol#sort_list li.playing").next().children("a[data-src]");
     if (!next.length) next = jQuery("ol#sort_list li a[data-src]").first();
     next.click();
  });

  // Load in the first track
  var audio = a[0];
  first = jQuery("ol#sort_list li a").first().attr("data-src");
  jQuery("ol#sort_list li").first().addClass("playing").siblings().removeClass("playing");
   if (first !== void 0) {
    audio.load(first);
    kirinload();
    audio.play();
   }
  // audio.js用 終わり
<?php } ?>

  // Sort用
  var arr      = new Array();
  var sortAsc  = function(a, b) { return a.key.localeCompare(b.key); } // 昇順
  var sortDesc = function(a, b) { return b.key.localeCompare(a.key); } // 降順

<?php
if ( ($arguments["sort"] != "") && ($arguments["sort"] != "none") ) {
 echo $arguments["sort"]."();";
}
?>

  function filename_u() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = basename( jQuery("a[data-src]", this).attr("data-src") );
    arr[i].value = jQuery(this);
   });
   arr.sort(sortAsc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function filename_d() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = basename( jQuery("a[data-src]", this).attr("data-src") );
    arr[i].value = jQuery(this);
   });
   arr.sort(sortDesc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function title_u() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = jQuery("a[data-src]", this).text();
    arr[i].value = jQuery(this);
   });
   arr.sort(sortAsc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function title_d() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = jQuery("a[data-src]", this).text();
    arr[i].value = jQuery(this);
   });
   arr.sort(sortDesc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function artist_u() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = jQuery(".artist", this).text();
    arr[i].value = jQuery(this);
   });
   arr.sort(sortAsc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function artist_d() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = jQuery(".artist", this).text();
    arr[i].value = jQuery(this);
   });
   arr.sort(sortDesc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function trackinfo_u() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = jQuery(".trackinfo", this).text();
    arr[i].value = jQuery(this);
   });
   arr.sort(sortAsc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function trackinfo_d() {
   jQuery("ol#sort_list li").each(function(i){
    arr[i] = new Object();
    arr[i].key = jQuery(".trackinfo", this).text();
    arr[i].value = jQuery(this);
   });
   arr.sort(sortDesc);
   for(i = 0; i < arr.length; i++){ jQuery("ol#sort_list").append(arr[i].value); }
  }
  function random() {
   jQuery("ol#sort_list li").shuffle();
  }
  // Sort用 終わり

<?php if ( $arguments["mode"] == "music" ) { ?>
  // 音量調節スライダー用
  jQuery("#volume_control #slider").slider({
   value:100,
   range:"min",
   min:0,
   max:100,
   slide:function(event,ui){
    jQuery("#volume_control #num").val(ui.value);
   }
  });
  jQuery("#volume_control #num").val(jQuery("#volume_control #slider").slider("value"));
  jQuery("#volume_control").mouseup(function(e) {
   audio.setVolume( jQuery("#volume_control #num").val()*0.01 );
   jQuery("#volume_control #slider").attr("title", jQuery("#volume_control #num").val());
  });
  // 音量調節スライダー用 終わり

  // 再生速度調節スライダー用
  jQuery("#speed_control #slider").slider({
   value:100,
   range:"min",
   min:50,
   // max:500,
   max:150,
   slide:function(event,ui){
    jQuery("#speed_control #num").val(ui.value);
   }
  });
  jQuery("#speed_control #num").val(jQuery("#speed_control #slider").slider("value"));
  jQuery("#speed_control").mouseup(function(e) {
   document.getElementById("audio").playbackRate = jQuery("#speed_control #num").val()*0.01;
   jQuery("#speed_control #slider").attr("title", ( jQuery("#speed_control #num").val()*0.01 ).toFixed(1) );
  });
  // 再生速度調節スライダー用 終わり
<?php } ?>

  if(jQuery("#id").val()!=""){
   jQuery.cookie("id", jQuery("#id").val());
  }
  if(jQuery("#pw").val()!=""){
   jQuery.cookie("pw", jQuery("#pw").val());
  }
 });

  // Sort用
<?php if ($arguments["sort"] == "random") { ?>
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
<?php } ?>
  // Sort用 終わり



 function setscreenname() {
  jQuery.ajax({
   type: "POST",
   url: "tweet/index.php",
   data: "short=1",
   success: function(data, dataType){
    if ( data != "" ) {
     jQuery("span#screen_name").text( data );
    } else {
     jQuery("span#screen_name").text( "---" );
    }
   }
  });
 }
 function settweetstr(mode) {
  tstr = "<?php echo $arguments["sns_format"]; ?>";
  tstr = tstr.replace("%a", jQuery("ol#sort_list li.playing .artist").text() );
  tstr = tstr.replace("%g", jQuery("ol#sort_list li.playing .genre").text() );
  tstr = tstr.replace("%l", jQuery("ol#sort_list li.playing .album").text() );
  tstr = tstr.replace("%m", jQuery("ol#sort_list li.playing .time_m").text() );
  tstr = tstr.replace("%n", jQuery("ol#sort_list li.playing .number").text() );
  tstr = tstr.replace("%s", jQuery("ol#sort_list li.playing .time_s").text() );
  tstr = tstr.replace("%t", jQuery("ol#sort_list li.playing .title").text() );
  if ( tstr.indexOf("%u", 0) > -1 ) {
   jQuery.ajax({
    type: "POST",
    url: "req/shortenuri.php",
    data: "uri="+jQuery("ol#sort_list li.playing .title").attr("data-src"),
    success: function(data, dataType){
     tstr = tstr.replace("%u", data);
     if ( mode == 1 ) {
      jQuery("textarea#tweettext").val( tstr );
     } else if ( mode == 2 ) {
      window.open("tweet/tweet.php?pass_autotweet=<?php echo $arguments["pass_autotweet"]; ?>&tweettext="+encodeURIComponent(tstr), "sns");
     }
    }
   });
  } else {
   if ( mode == 1 ) {
    jQuery("textarea#tweettext").val( tstr );
   } else if ( mode == 2 ) {
    window.open("tweet/tweet.php?pass_autotweet=<?php echo $arguments["pass_autotweet"]; ?>&tweettext="+encodeURIComponent(tstr), "sns");
   }
  }
 }

 function isHankaku(str){
  if(str.match(/[^0-9A-Za-z]+/) == null){
    return true;
  }else{
    return false;
  }
 }

 // basename(for sort)
 function basename(path, suffix) {
  var b = path.replace(/^.*[\/\\]/g, "");
  if (typeof(suffix) == "string" && b.substr(b.length-suffix.length) == suffix) {
   b = b.substr(0, b.length-suffix.length);
  }
  return b;
 }

 function kirinload(){
  if(jQuery("#checkbox_auto #enable_lyric").prop("checked")){
   if(jQuery("ol#sort_list li.playing a[data-src]").attr("data-src") !== void 0){
    jQuery(function() {
     jQuery.ajax({
      type: "POST",
      url : (jQuery("ol#sort_list li.playing a[data-src]").attr("data-src")).replace(".mp3",".lrc"),
      success: function(result) {
       jQuery("#lyrics").text("");
       jQuery("#lyrics").show();
       var position = jQuery("#lyrics").offset().top - 20;
       jQuery("html,body").animate({scrollTop:position}, 100, "swing");
       jQuery("#audio").kirinlyric({
        target : "#lyrics",
        lrc : result
       });
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
       jQuery("#lyrics").text("");
       jQuery("#lyrics").hide();
      },
      beforeSend: function(xhr) {
       var credentials = $.base64.encode( jQuery("#id").val()+":"+ jQuery("#pw").val());
       xhr.setRequestHeader("Authorization", "Basic " + credentials);
      }
     });
    });
   }else{
    jQuery("#lyrics").text("");
    jQuery("#lyrics").hide();
   }
  }else{
   jQuery("#lyrics").text("");
   jQuery("#lyrics").hide();
  }
 }

</script>
