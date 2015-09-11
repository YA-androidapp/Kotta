// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(function () {

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