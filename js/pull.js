// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function pullname(mode) {
 mode = (mode == 'fav')?'fav':'dir';
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
    url:  'ls_'+mode+'.php?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&pw2='+jQuery('input#pw2').val(),
    cache: false,
    data: 'onlyname=1&_='+Math.random(),
    xhrFields: {
      onloadstart: function() {
        $('ul#'+mode+'slist').text('');
        if(mode == 'fav'){$('select#favname').text('');}
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
                var nam = (mode == 'fav')?json.favname:json.dirname;
                if(typeof nam !== 'undefined'){
                 var url = 'ls_'+mode+'.php?id='+jQuery('input#id').val()+'&pw='+jQuery('input#pw').val()+'&pw2='+jQuery('input#pw2').val()+'&'+mode+'name='+nam;
                 $('ul#'+mode+'slist').append(
                  '<li id=\''+mode+'menu_'+htmlspecialcharsEntQuotes(nam)+'\'><a href=\'?mode=simple&'+mode+'name='+htmlspecialcharsEntQuotes(nam)+'\'>'+nam+'</a>'
                  +'<a href=\'?mode=music&'+mode+'name='+htmlspecialcharsEntQuotes(nam)+'\'>[music]</a>'
                  +'<a href=\'#\' onClick=\'pullls("'+htmlspecialcharsEntQuotes(url)+'");\'>[Add]</a>'
                  +'<a href=\'#\' onClick=\'var url="db_write.php?dirname="+encodeURIComponent(jQuery("input#dirname").val())+"&id="+jQuery("input#id").val()+"&pw="+jQuery("input#pw").val()+"&pw2="+jQuery("input#pw2").val();window.open(url,"db");\'>[AddDB]</a>'
                  +'<a href=\'ls_'+mode+'.php?makem3u=1&'+mode+'name='+htmlspecialcharsEntQuotes(nam)+'\'>[m3u]</a></li>'
                 );
                 if(mode == 'fav'){$('select#favname').append($('<option>').html(nam).val(nam));}
                }
              }
            });
          }
        }, 100);
      }
    },
    success: function() {
     setTimeout(function(){
      clearInterval(mytimer);
     }, 100);
     setTimeout(function(){
      $('ul#'+mode+'slist').html(
       $('ul#'+mode+'slist li').sort(function(a, b) {
        return ($(a).text() > $(b).text())?1:-1;
       })
      );
      $.notifyBar({ html: ((mode == 'fav')?'お気に入り':'ディレクトリ')+'一覧を読み込みました', delay: 1000, cls: 'success' });
     }, 100);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.log('error');
     console.log('textStatus: '+textStatus);
     console.log('errorThrown: '+errorThrown);
     clearInterval(mytimer);
     $.notifyBar({ html: ((mode == 'fav')?'お気に入り':'ディレクトリ')+'一覧の読み込みに失敗しました: '+textStatus, delay: 1000, cls: 'error' });
    }
  });
}

function pullls(url) {
 var i = jQuery('#sort_list li').length;
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
    url:  url,
    cache: false,
    data: '_='+Math.random(),
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
                if(typeof json.title !== 'undefined'){
                 $('ol#sort_list').append(

 '<li class=\'appended\' id=\'track'+i+'\'>'
+'<a class=\'title\' href=\'#\' data-src=\''+json.datasrc+'\' title=\''+json.datasrc+'\'>'+json.title+'</a><br>'
+'<span class=\'starw\' id=\'bookmarkstar'+i+'\' alt=\'お気に入りの管理\' title=\'お気に入りの管理\' onClick=\'window.open("?mode=favmenu&favcheck='+json.favcheck+'", "favmenu");return false;\'>'
+'☆</span>　'
+(( typeof json.favname === 'undefined' )?'':('<span class=\'star\' id=\'bookmarkstar'+i+'\' alt=\'お気に入りから外します\' title=\'お気に入りから外します\' onClick=\'if(window.confirm("'
+htmlspecialcharsEntQuotes(json.title)+' ('+htmlspecialcharsEntQuotes(json.basename)+')をお気に入りから外してよろしいですか？")){ $(function(){$("#track'+i+'").remove()}); $.get("?id='
+json.id+'&pw='+json.pw+'&mode=favdel&favname='+encodeURIComponent(json.favname)+'&linkdel='+json.favcheck
+'", function(data){ var status = (data.indexOf("!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 1000, cssClass: status }); });return false; }\'>'
+'★</span>'
))
+'<span class=\'del\' id=\'delicon'+i+'\' alt=\'プレイビューから外します\' title=\'プレイビューから外します\' onClick=\'if(window.confirm("'+htmlspecialcharsEntQuotes(json.title)+' ('+htmlspecialcharsEntQuotes(json.basename)+')をプレイビューから外してよろしいですか？")){ $(function(){$("#track'+i+'").remove()}); return false; }\'>'
+'×</span>'
+'<br>　<a class=\'artist\' href=\'?favname=&mode=music&dirname='+encodeURIComponent(json.artistdirtmp)+'\'>'+json.artist+'</a> &gt; '
+'<span class=\'trackinfo\'><a class=\'album\' href=\'?favname=&mode=music&dirname='+encodeURIComponent(json.artistdirtmp)+'&filter_album='+encodeURIComponent(json.album)+'\'>'+json.album
+'</a> (No.<span class=\'number\'>'+((json.number<10)?"0"+json.number:json.number)+'</span>) [<span class=\'genre\'>'+json.genre+'</span>] '
+'<span class=\'time\'><span class=\'time_m\'>'+json.time_m+'</span>:<span class=\'time_s\'>'+json.time_s+'</span></span></span><br></li>'

                 );
                }
              }
              i++;
            });
          }
        }, 100);
      }
    },
    success: function() {
      setTimeout(function(){
        clearInterval(mytimer);
      }, 100);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.log('error');
     console.log('textStatus: '+textStatus);
     console.log('errorThrown: '+errorThrown);
     clearInterval(mytimer);
     $.notifyBar({ html: textStatus, delay: 1000, cls: 'error' });
    }
  });
}

jQuery(function() {
 if ( (jQuery("input#id").val()!='') && (jQuery("input#pw").val()!='') && ( (Cookies.get('otppwauthed')=='otppwauthed') || (Cookies.get('otppwauthed')=='otppwdisabled') || (jQuery("input#pw2").val()!='') ) ) {
  setTimeout(function(){
   pullname('fav');
  }, 2000);
  setTimeout(function(){
   pullname('dir');
  }, 2500);
 }

 jQuery(document).keydown(function(e) {
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ( unicode == 70 ) {
   pullname('fav');
  } else if ( unicode == 68 ) {
   pullname('dir');
  }
 });
});
