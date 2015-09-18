// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(function () {

 jQuery('#playcontrol').hide();
 jQuery('#checkbox_auto').hide();
 jQuery('#pagesearch').hide();
 jQuery('#tweet').hide();
 jQuery('#favs').hide();
 jQuery('#dirs').hide();
 jQuery('#sql').hide();
 jQuery('#copyrights_list').hide();

 if(jQuery('input#id').val()!=''){
  Cookies.set('id', jQuery('input#id').val());
 }

 if(jQuery('input#pw').val()!=''){
  Cookies.set('pw', jQuery('input#pw').val());
 }

 jQuery('a').not('[href="#"]').attr({target:'_blank'}).addClass('ex_link');

 jQuery('#id').blur(function(e) {
  if(jQuery('#id').val()!=''){
   Cookies.set('id', jQuery('input#id').val());
  }
 });

 jQuery('#pw').blur(function(e) {
  if(jQuery('#pw').val()!=''){
   Cookies.set('pw', jQuery('input#pw').val());
  }
 });

 jQuery('#control_pullfavname').click(function(e) {
    pullname('fav');
 });

 jQuery('#control_pulldirname').click(function(e) {
    pullname('dir');
 });

 jQuery('#control_twtr').click(function(e) {
  settweetstr(1);
 });

 jQuery('#enable_loop').click(function(e) {
  Cookies.set('enable_loop', ((jQuery('#enable_loop').prop('checked'))?'1':'0'));
 });

 jQuery('#enable_allloop').click(function(e) {
  Cookies.set('enable_allloop', ((jQuery('#enable_allloop').prop('checked'))?'1':'0'));
 });

 jQuery('#enable_recently_played').click(function(e) {
  Cookies.set('enable_recently_played', ((jQuery('#enable_recently_played').prop('checked'))?'1':'0'));
 });

 jQuery('#enable_autotweet').click(function(e) {
  Cookies.set('enable_autotweet', ((jQuery('#enable_autotweet').prop('checked'))?'1':'0'));
 });

 jQuery('#enable_notification').click(function(e) {
  Cookies.set('enable_notification', ((jQuery('#enable_notification').prop('checked'))?'1':'0'));
 });

 jQuery('#enable_muted').click(function(e) {
  Cookies.set('enable_muted', ((jQuery('#enable_muted').prop('checked'))?'1':'0'));
 });

 jQuery('#enable_lyric').click(function(e) {
  Cookies.set('enable_lyric', ((jQuery('#enable_lyric').prop('checked'))?'1':'0'));
 });

 jQuery('#favfadd').click(function(e) {
  jQuery.get('?id='+jQuery('#id').val()+'&pw='+jQuery('#pw').val()+'&mode=favfadd&favname='+jQuery('#favname').val(),
   function(data){
    var status = (data.indexOf('(!) ')==0) ? 'error' : 'success';
    jQuery.notifyBar({ html: data, delay: 1000, cssClass: status });
    pullname('fav');
   }
  );
 });

 jQuery('#favfdel').click(function(e) {
  if(window.confirm($('#favname').val()+'を削除してよろしいですか？')){
   jQuery.get('?id='+jQuery('#id').val()+'&pw='+jQuery('#pw').val()+'&mode=favfdel&favname='+jQuery('#favname').val(),
    function(data){
     var status = (data.indexOf('(!) ')==0) ? 'error' : 'success';
     jQuery.notifyBar({ html: data, delay: 1000, cssClass: status });
     pullname('fav');
    }
   );
   return false;
  }
 });

 jQuery('#screen_name').click(function(e) {
  setscreenname();
 });

 jQuery('#tweettext').dblclick(function(e) {
  settweetstr(1);
 });

 if(jQuery('#enable_lyric').prop('checked')){
  jQuery('#lyrics').show();
 } else {
  jQuery('#lyrics').text('');
  jQuery('#lyrics').hide();
 }

 jQuery('#enable_lyric').change(function() {
  if(jQuery('#enable_lyric').prop('checked')){
   // jQuery('#lyrics').show();
  } else {
   jQuery('#lyrics').text('');
   jQuery('#lyrics').hide();
  }
 });

 jQuery('#pagesort').change(function(e) {
  //                .mouseup(function(e) {
  sortevent();
 });

 jQuery('#pageq').keyup(function(e) {
  jQuery('#wrapper_list ol li').each(function(){
   if( !new String( jQuery( jQuery('#pagesearchtype').val() , this).text() ).match( jQuery('#pageq').val() ) ){
    jQuery(this).hide();
   }else{
    jQuery(this).show();
   }
  });
 });

});

function basename(path, suffix) {
 var b = path.replace(/^.*[\/\\]/g, '');
 if (typeof(suffix) == 'string' && b.substr(b.length-suffix.length) == suffix) {
  b = b.substr(0, b.length-suffix.length);
 }
 return b;
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

function isHankaku(str){
 if(str.match(/[^0-9A-Za-z]+/) == null){
   return true;
 }else{
   return false;
 }
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

function settweetstr(mode) {
 var tstr = sns_format.replace('%a', jQuery('ol#sort_list li.playing .artist').text() );
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
     window.open('tweet/tweet.php?pass_autotweet='+pass_autotweet+'&tweettext='+encodeURIComponent(tstr), 'sns');
    }
   }
  });
 } else {
  if ( mode == 1 ) {
   jQuery('textarea#tweettext').val( tstr );
  } else if ( mode == 2 ) {
   window.open('tweet/tweet.php?pass_autotweet='+pass_autotweet+'&tweettext='+encodeURIComponent(tstr), 'sns');
  }
 }
}

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
