// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(function () {

 // audio.js用
 // Setup the player to autoplay the next track
 var a = audiojs.createAll({
  trackEnded: function() {
   if(jQuery('#checkbox_auto #enable_autotweet').prop('checked')){
    settweetstr(2);
   }

   if(jQuery('#checkbox_auto #enable_recently_played').prop('checked')){
    jQuery.ajax({
     type: 'POST',
     data: 'id='+jQuery('#id').val()+'&pw='+jQuery('#pw').val()+'&mode=rpadd&linkadd='+jQuery('ol#sort_list li.playing a[data-src]').attr('data-src').replace(base_uri,''),
     beforeSend: function(xhr) {
      var credentials = $.base64.encode( jQuery('#id').val()+':'+ jQuery('#pw').val());
      xhr.setRequestHeader('Authorization', 'Basic ' + credentials);
     }
    });
   }

   var next = jQuery('ol#sort_list li.playing').next();
   if(jQuery('#checkbox_auto #enable_allloop').prop('checked')){
    if (!next.length) next = jQuery('ol#sort_list li').first();
   } else {
    if (!next.length) return;
   }

   next.addClass('playing').siblings().removeClass('playing');
   if (jQuery('a', next).attr('data-src') !== void 0) {
    audio.load(jQuery('a', next).attr('data-src'));
    kirinload();
    audio.play();
   }

   document.getElementById('audio').loop = jQuery('#checkbox_auto #enable_loop').prop('checked');
   document.getElementById('audio').muted = jQuery('#checkbox_auto #enable_muted').prop('checked');
   jQuery('#checkbox_auto #enable_loop').change(function() {
    document.getElementById('audio').loop = jQuery('#checkbox_auto #enable_loop').prop('checked');
   });
   jQuery('#checkbox_auto #enable_muted').change(function() {
    document.getElementById('audio').muted = jQuery('#checkbox_auto #enable_muted').prop('checked');
   });

   if(jQuery('#checkbox_auto #enable_notification').prop('checked')){
    if(window.webkitNotifications){
     var message =
        jQuery('.artist', next).text() + ' > ' +
        jQuery('.trackinfo', next).text();
     if (window.webkitNotifications.checkPermission() == 0) {
      var notification = window.webkitNotifications.createNotification(
       'icon/kotta_s.png', jQuery('a[data-src]', next).text(), message
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

 // Load in the first track
 var audio = a[0];
 setTimeout(function(){
  first = jQuery('ol#sort_list li a').first().attr('data-src');
  jQuery('ol#sort_list li').first().addClass('playing').siblings().removeClass('playing');
  if (first !== void 0) {
   audio.load(first);
   kirinload();
   jQuery('#control_play').val( (audio.playing)?'Play':'Pause')
   audio.play();
  }
 }, 1000);
 // Load in a track on click
 jQuery('ol#sort_list li a[data-src]').click(function(e) {
  e.preventDefault();
  jQuery(this).parent().addClass('playing').siblings().removeClass('playing');
  if (jQuery(this).attr('data-src') !== void 0) {
   audio.load(jQuery(this).attr('data-src'));
   kirinload();
   audio.play();
  }
  if(jQuery('#checkbox_auto #enable_lyric').prop('checked') == false){
   var position = jQuery('ol#sort_list li.playing').offset().top;
   jQuery('html,body').animate({scrollTop:position}, 400, 'swing');
  }
 });
 $(document).on('click','ol#sort_list li.appended a[data-src]',function(e){
  e.preventDefault();
  jQuery(this).parent().addClass('playing').siblings().removeClass('playing');
  if (jQuery(this).attr('data-src') !== void 0) {
   audio.load(jQuery(this).attr('data-src'));
   kirinload();
   audio.play();
  }
  if(jQuery('#checkbox_auto #enable_lyric').prop('checked') == false){
   var position = jQuery('ol#sort_list li.playing').offset().top;
   jQuery('html,body').animate({scrollTop:position}, 400, 'swing');
  }
 });

 // Shortcut keys
 jQuery(document).keydown(function(e) {
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if (e.shiftKey+e.ctrlKey != 0) {
   if ( unicode == 39 ) {
    var next = jQuery('ol#sort_list li.playing').next().children('a[data-src]');
    if (!next.length) next = jQuery('ol#sort_list li a[data-src]').first();
    next.click();
   } else if ( unicode == 37 ) {
    var prev = jQuery('ol#sort_list li.playing').prev().children('a[data-src]');
    if (!prev.length) prev = jQuery('ol#sort_list li a[data-src]').last();
    prev.click();
   } else if ( unicode == 32 ) {
    e.preventDefault();
    audio.playPause();
   }
  } else {
   if ( unicode == 176 ) {
    var next = jQuery('ol#sort_list li.playing').next().children('a[data-src]');
    if (!next.length) next = jQuery('ol#sort_list li a[data-src]').first();
    next.click();
   } else if ( unicode == 177 ) {
    var prev = jQuery('ol#sort_list li.playing').prev().children('a[data-src]');
    if (!prev.length) prev = jQuery('ol#sort_list li a[data-src]').last();
    prev.click();
   } else if ( unicode == 179 ) {
    e.preventDefault();
    audio.playPause();
   }
  }
 });
 jQuery('#control_prev').click(function(e) {
  var prev = jQuery('ol#sort_list li.playing').prev().children('a[data-src]');
  if (!prev.length) prev = jQuery('ol#sort_list li a[data-src]').last();
  prev.click();
 });
 jQuery('#control_play').click(function(e) {
  e.preventDefault();
  jQuery('#control_play').val( (audio.playing)?'Play':'Pause')
  audio.playPause();
 });
 jQuery('#control_next').click(function(e) {
  var next = jQuery('ol#sort_list li.playing').next().children('a[data-src]');
  if (!next.length) next = jQuery('ol#sort_list li a[data-src]').first();
  next.click();
 });
 // 音量調節スライダー用
 jQuery('#volume_control #slider').slider({
  value:100,
  range:'min',
  min:0,
  max:100,
  slide:function(event,ui){
   jQuery('#volume_control #num').val(ui.value);
  }
 });
 jQuery('#volume_control #num').val(jQuery('#volume_control #slider').slider('value'));
 jQuery('#volume_control').mouseup(function(e) {
  audio.setVolume( jQuery('#volume_control #num').val()*0.01 );
  jQuery('#volume_control #slider').attr('title', jQuery('#volume_control #num').val());
 });

 if(jQuery('#checkbox_auto #enable_autotweet').prop('checked')){
  window.open('tweet/index.php', 'sns');
 }

 jQuery('#checkbox_auto #enable_notification').click(function(e) {
  if(jQuery('#checkbox_auto #enable_notification').prop('checked')){
   if(window.webkitNotifications){
    if (window.webkitNotifications.checkPermission() != 0) {
     window.webkitNotifications.requestPermission();
    }
   }
  }
 });

 // 再生速度調節スライダー用
 jQuery('#speed_control #slider').slider({
  value:100,
  range:'min',
  min:50,
  max:150,
  slide:function(event,ui){
   jQuery('#speed_control #num').val(ui.value);
  }
 });
 jQuery('#speed_control #num').val(jQuery('#speed_control #slider').slider('value'));
 jQuery('#speed_control').mouseup(function(e) {
  document.getElementById('audio').playbackRate = jQuery('#speed_control #num').val()*0.01;
  jQuery('#speed_control #slider').attr('title', ( jQuery('#speed_control #num').val()*0.01 ).toFixed(1) );
 });

});