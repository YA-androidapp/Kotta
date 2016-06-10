// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function pullfavmenu() {
 var mytimer = null;
 var isJSON = function(arg) {
  arg = (typeof arg === 'function') ? arg() : arg;
  if (typeof arg  !== 'string') {
   return false;
 }
 try {
   arg = (!JSON) ? eval('(' + arg + ')') : JSON.parse(arg);
   return true;
 } catch (e) {
   return false;
 }
};
$.ajax({
  type: 'post',
  url:  'ls_fav.php?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&pw2='+jQuery('input#pw2').val(),
  cache: false,
  data: 'onlyname=1&relapath='+jQuery('input#relapath').val()+'&_='+Math.random(),
  xhrFields: {
    onloadstart: function() {
      var xhr = this;
      var textlength = 0;
      mytimer = setInterval(function() {
        var text = xhr.responseText;
        var newText = text.substring(textlength);
        var lines = newText.split("\n");
        if( text.length > textlength ) {
          textlength  = text.length;
          lines.forEach(function(line){
            if( isJSON(line) ){
              var json = JSON.parse(line);
              if(typeof json.favname !== 'undefined'){
               $('table#favmenu tbody').append(
                '<tr><td><a href=\'?mode=simple&favname='+htmlspecialcharsEntQuotes(json.favname)+'\'>'+htmlspecialcharsEntQuotes(json.favname)+'</a></td>'
                +(
                  (json.hassong)
                  ?
                  ( ' <td><span class=\'star\' id=\'bookmarkstar'+json.id+'\' alt=\'ブックマーク: 「'+htmlspecialcharsEntQuotes(json.favname)+'」から解除します\' title=\'ブックマーク: 「'+htmlspecialcharsEntQuotes(json.favname)+'」から解除します\' onClick=\'if(window.confirm("'+htmlspecialcharsEntQuotes(json.title)+'をブックマーク: 「'+htmlspecialcharsEntQuotes(json.favname)+'」から解除してよろしいですか？")){ $(function(){ $.get("?id='+jQuery("input#id").val()+'&mode=favdel&favname='+htmlspecialcharsEntQuotes(json.favname)+'&linkdel='+htmlspecialcharsEntQuotes(json.relapath)+'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'> ★</span></td><td> </td>')
                  :
                  ( ' <td> </td><td><span class=\'starw\' id=\'bookmarkstar'+json.id+'\' alt=\'ブックマーク: 「'+htmlspecialcharsEntQuotes(json.favname)+'」に追加します\' title=\'ブックマーク: 「'+htmlspecialcharsEntQuotes(json.favname)+'」に追加します\' onClick=\'if(window.confirm("'+htmlspecialcharsEntQuotes(json.title)+'をブックマーク: 「'+htmlspecialcharsEntQuotes(json.favname)+'」に追加してよろしいですか？")){ $(function(){ $.get("?id='+jQuery("input#id").val()+'&mode=favadd&favname='+htmlspecialcharsEntQuotes(json.favname)+'&linkadd='+htmlspecialcharsEntQuotes(json.relapath)+'", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'> ☆</span></td>')
                  )
                );
             }
           }
         });
        }
      }, 100);
    }
  },
  success: function(msg) {
   if (msg.indexOf('PW認証できません')>-1) {
    $("input#id").css("background","#ffcccc");
    $("input#pw").css("background","#ffcccc");
    $.notifyBar({ html: msg+' : '+((mode == 'fav')?'お気に入り':'ディレクトリ')+'一覧の読み込みに失敗しました: ', delay: 10000, cls: 'error' });
  } else if (msg.indexOf('OTP認証できません')>-1) {
    $("input#id").css("background","#eeffee");
    $("input#pw").css("background","#eeffee");
    $("input#pw2").css("background","#ffcccc");
    $.notifyBar({ html: msg+' : '+((mode == 'fav')?'お気に入り':'ディレクトリ')+'一覧の読み込みに失敗しました: ', delay: 10000, cls: 'error' });
  } else {
    $("input#id").css("background","#eeffee");
    $("input#pw").css("background","#eeffee");
    $("input#pw2").css("background","#eeffee");
    setTimeout(function(){
     clearInterval(mytimer);
   }, 100);
    setTimeout(function(){
     $.notifyBar({ html: 'お気に入り一覧を読み込みました', delay: 10000, cls: 'success' });
   }, 100);
  }
},
error: function(XMLHttpRequest, textStatus, errorThrown) {
 console.log('error');
 console.log('textStatus: '+textStatus);
 console.log('errorThrown: '+errorThrown);
 clearInterval(mytimer);
 $.notifyBar({ html: ((mode == 'fav')?'お気に入り':'ディレクトリ')+'一覧の読み込みに失敗しました: '+textStatus, delay: 10000, cls: 'error' });
}
});
}

jQuery(function() {
 if ( (jQuery("input#id").val()!='') && (jQuery("input#pw").val()!='') && ( (Cookies.get('otppwauthed')=='otppwauthed') || (Cookies.get('otppwauthed')=='otppwdisabled') || (jQuery("input#pw2").val()!='') ) ) {
  setTimeout(function(){
   pullfavmenu('fav');
 }, 2000);
}
});