// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(document).ready(function(){
 $('a').not('[href="#"]').attr({target:'_blank'}).addClass('ex_link');

 $('#favfadd').click(function(e) {
  $.get('?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&mode=favfadd&favname='+jQuery('input#favname').val(),
   function(data){
    var status = (data.indexOf('(!) ')==0) ? 'error' : 'success';
    $.notifyBar({ html: data, delay: 1000, cssClass: status });
    pullname('fav');
   }
  );
 });

 $('#favfdel').click(function(e) {
  if(window.confirm($('select#favname').val()+'を削除してよろしいですか？')){
   $.get('?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&mode=favfdel&favname='+jQuery('select#favname').val(),
    function(data){
     var status = (data.indexOf('(!) ')==0) ? 'error' : 'success';
     $.notifyBar({ html: data, delay: 1000, cssClass: status });
     pullname('fav');
    }
   );
   return false;
  }
 });

 jQuery('#wrapper_headerlist #playcontrol').hide()
 jQuery('#wrapper_headerlist #checkbox_auto').hide()
 jQuery('#wrapper_headerlist #pagesearch').hide()
 jQuery('#wrapper_headerlist #tweet').hide()
 jQuery('#wrapper_headerlist #dirs').hide()
 jQuery('#wrapper_headerlist #sql').hide()
 jQuery('#wrapper_headerlist #copyrights_list').hide();

});

$(function () {

 if(jQuery('#checkbox_auto #enable_lyric').prop('checked')){
  jQuery('#lyrics').show();
 } else {
  jQuery('#lyrics').text('');
  jQuery('#lyrics').hide();
 }

 jQuery('#checkbox_auto #enable_lyric').change(function() {
  if(jQuery('#checkbox_auto #enable_lyric').prop('checked')){
   // jQuery('#lyrics').show();
  } else {
   jQuery('#lyrics').text('');
   jQuery('#lyrics').hide();
  }
 });
 jQuery('#control_pulldirname').click(function(e) {
    pullname('dir');
 });
 jQuery('#control_pullfavname').click(function(e) {
    pullname('fav');
 });

 // フィルタリング用
 jQuery('#pageq').keyup(function(e) {
  jQuery('#wrapper_list ol li').each(function(){
   if( !new String( jQuery( jQuery('#pagesearchtype').val() , this).text() ).match( jQuery('#pageq').val() ) ){
    jQuery(this).hide();
   }else{
    jQuery(this).show();
   }
  });
 });
 // フィルタリング用 終わり

 // ソート用
 //jQuery('#pagesort').change(function(e) {
 // sortevent();
 //});
 jQuery('#pagesort').mouseup(function(e) {
  sortevent();
 });
 function sortevent(){
  switch ( jQuery('#pagesort').val() ){
   case 'filename_u':
    filename_u();
    break;
   case 'filename_d':
    filename_d();
    break;
   case 'title_u':
    title_u();
    break;
   case 'title_d':
    title_d();
    break;
   case 'artist_u':
    artist_u();
    break;
   case 'artist_d':
    artist_d();
    break;
   case 'trackinfo_u':
    trackinfo_u();
    break;
   case 'trackinfo_d':
    trackinfo_d();
    break;
   case 'random':
    random();
    break;
  }
 }
 // ソート用 終わり

 // SNS用
 jQuery('#screen_name').click(function(e) {
  setscreenname();
 });
 jQuery('#tweettext').dblclick(function(e) {
  settweetstr(1);
 });
 jQuery('#control_twtr').click(function(e) {
  settweetstr(1);
 });
 // SNS用 終わり

 // Cookie

 // 認証用
 jQuery('input#id').blur(function(e) {
  if(jQuery('input#id').val()!=''){
   Cookies.set('id', jQuery('input#id').val());
  }
 });
 jQuery('input#pw').blur(function(e) {
  if(jQuery('input#pw').val()!=''){
   Cookies.set('pw', jQuery('input#pw').val());
  }
 });
 if(jQuery('input#id').val()!=''){
  Cookies.set('id', jQuery('input#id').val());
 }
 if(jQuery('input#pw').val()!=''){
  Cookies.set('pw', jQuery('input#pw').val());
 }
 // 認証用 終わり

 jQuery('input#enable_loop').click(function(e) {
  Cookies.set('enable_loop', ((jQuery('input#enable_loop').prop('checked'))?'1':'0'));
 });
 jQuery('input#enable_allloop').click(function(e) {
  Cookies.set('enable_allloop', ((jQuery('input#enable_allloop').prop('checked'))?'1':'0'));
 });
 jQuery('input#enable_recently_played').click(function(e) {
  Cookies.set('enable_recently_played', ((jQuery('input#enable_recently_played').prop('checked'))?'1':'0'));
 });
 jQuery('input#enable_autotweet').click(function(e) {
  Cookies.set('enable_autotweet', ((jQuery('input#enable_autotweet').prop('checked'))?'1':'0'));
 });
 jQuery('input#enable_notification').click(function(e) {
  Cookies.set('enable_notification', ((jQuery('input#enable_notification').prop('checked'))?'1':'0'));
 });
 jQuery('input#enable_muted').click(function(e) {
  Cookies.set('enable_muted', ((jQuery('input#enable_muted').prop('checked'))?'1':'0'));
 });
 jQuery('input#enable_lyric').click(function(e) {
  Cookies.set('enable_lyric', ((jQuery('input#enable_lyric').prop('checked'))?'1':'0'));
 });

});

function setscreenname() {
 jQuery.ajax({
  type: 'POST',
  url: 'tweet/index.php',
  data: 'short=1',
  success: function(data, dataType){
   if ( data != '' ) {
    jQuery('span#screen_name').text( data );
   } else {
    jQuery('span#screen_name').text( '---' );
   }
  }
 });
}

function isHankaku(str){
 if(str.match(/[^0-9A-Za-z]+/) == null){
   return true;
 }else{
   return false;
 }
}

function htmlspecialchars(str){
 str = str.replace(/&/g,"&amp;") ;
 str = str.replace(/"/g,"&quot;") ;
 str = str.replace(/</g,"&lt;") ;
 str = str.replace(/>/g,"&gt;") ;
 return str ;
}

function htmlspecialcharsEntQuotes(str){
 str = str.replace(/&/g,"&amp;") ;
 str = str.replace(/"/g,"&quot;") ;
 str = str.replace(/'/g,"&#039;") ;
 str = str.replace(/</g,"&lt;") ;
 str = str.replace(/>/g,"&gt;") ;
 return str ;
}

// basename(for sort)
function basename(path, suffix) {
 var b = path.replace(/^.*[\/\\]/g, '');
 if (typeof(suffix) == 'string' && b.substr(b.length-suffix.length) == suffix) {
  b = b.substr(0, b.length-suffix.length);
 }
 return b;
}

function kirinload(){
 if(jQuery('#checkbox_auto #enable_lyric').prop('checked')){
  if(jQuery('ol#sort_list li.playing a[data-src]').attr('data-src') !== void 0){
   jQuery(function() {
    jQuery.ajax({
     type: 'POST',
     url : (jQuery('ol#sort_list li.playing a[data-src]').attr('data-src')).replace('.mp3','.lrc'),
     success: function(result) {
      jQuery('#lyrics').text('');
      jQuery('#lyrics').show();
      var position = jQuery('#lyrics').offset().top - 20;
      jQuery('html,body').animate({scrollTop:position}, 100, 'swing');
      jQuery('#audio').kirinlyric({
       target : '#lyrics',
       lrc : result
      });
     },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
      jQuery('#lyrics').text('');
      jQuery('#lyrics').hide();
     },
     beforeSend: function(xhr) {
      var credentials = $.base64.encode( jQuery('#id').val()+':'+ jQuery('#pw').val());
      xhr.setRequestHeader('Authorization', 'Basic ' + credentials);
     }
    });
   });
  }else{
   jQuery('#lyrics').text('');
   jQuery('#lyrics').hide();
  }
 }else{
  jQuery('#lyrics').text('');
  jQuery('#lyrics').hide();
 }
}
