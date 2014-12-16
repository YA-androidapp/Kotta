<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
<script type="text/javascript">
function pullfavnum() {
 var mytimer = null;
 var url = "ls_favnum.php";
 var isJSON = function(arg) {
  arg = (typeof arg === "function") ? arg() : arg;
  if (typeof arg  !== "string") {
   return false;
  }
  try {
   arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
   return true;
  } catch (e) {
   return false;
  }
 };
   $.ajax({
    type: 'post',
    url:  url,
    cache: false,
    data: "_="+Math.random(),
    xhrFields: {
      onloadstart: function() {
        $("ul#favoriteslist").text("");
        $("select#favnum").text("");
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
                var url = 'ls_fav.php?favnum='+json.favnum;
                $("ul#favoriteslist").append(

"<li id=\"favmenu_"
+json.favnum
+"\"><a href=\"?id=<?php echo $id; ?>&mode=simple&favnum="
+json.favnum+"\">"
+json.favnum
+"</a><a href=\"?id=<?php echo $id; ?>&mode=music&favnum="
+json.favnum
+"\">[music]</a>"
+"<a href=\"#\" onClick=\"pullls('"+url+"');\">[Add]</a>"
+"<a href=\"?id=<?php echo $id; ?>&mode=makem3u&favnum="
+json.favnum
+"\">[m3u]</a></li>"

                );
                $("select#favnum").append($('<option>').html(json.favnum).val(json.favnum));
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
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.log("error");
      console.log("textStatus: "+textStatus);
      console.log("errorThrown: "+errorThrown);
      clearInterval(mytimer);
    }
  });
}

function pullls(url) {
 var i = jQuery('#sort_list li').length;
 var mytimer = null;
 var isJSON = function(arg) {
  arg = (typeof arg === "function") ? arg() : arg;
  if (typeof arg  !== "string") {
   return false;
  }
  try {
   arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
   return true;
  } catch (e) {
   return false;
  }
 };
   $.ajax({
    type: 'post',
    url:  url,
    cache: false,
    data: "_="+Math.random(),
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
                $("ol#sort_list").append(

 '<li class="appended" id="track'
+i
+'"><a class="title" href="#" data-src="'
+json.datasrc
+'" title="'+json.datasrc+'">'
+json.title
+'</a>　　<span onClick="window.open(\'?mode=favmenu&favcheck='
+json.favcheck
+'\', \'favmenu\');return false;">'
+'<img id="bookmarkstar'
+i
+'" class="fava" src="icon/fava.png" alt="お気に入りの管理" title="お気に入りの管理"></span>　'
+(( json.favnum == '' )?"":(
'<span onClick="if(window.confirm(\''
+json.title
+' ('
+json.basename
+')をお気に入りから外してよろしいですか？\')){ $(function(){$(\'#track'
+i
+'\').remove()}); $.get(\'?id='
+json.id
+'&pw='
+json.pw
+'&mode=favdel&favnum='
+json.favnum
+'&linkdel='
+json.favcheck
+'\', function(data){ var status = (data.indexOf(\'(!) \')==0) ? \'error\' : \'success\'; $.notifyBar({ html: data, delay: 1000, cls: status }); });return false; }"><img id="bookmarkstar'
+i
+'" class="favr" src="icon/favr.png" alt="お気に入りから外します" title="お気に入りから外します"></span>'
))
+'<span onClick="if(window.confirm(\''
+json.title
+' ('
+json.basename
+')をプレイビューから外してよろしいですか？\')){ $(function(){$(\'#track'
+i
+'\').remove()}); return false; }"><img id="delicon'
+i
+'" class="delicon" src="icon/del.png" alt="プレイビューから外します" title="プレイビューから外します"></span>'
+'<br>　<a class="artist" href="?favnum=&mode=music&dir='
+json.artistdirtmp+'">'
+json.artist
+'</a> &gt; <span class="trackinfo">'
+'<a class="album" href="?favnum=&mode=music&dir='
+json.artistdirtmp
+'&filter_album='
+json.album
+'">'
+json.album
+'</a> (No.<span class="number">'
+json.number
+'</span>) [<span class="genre">'
+json.genre
+'</span>] <span class="time"><span class="time_m">'
+json.time_m
+'</span>:<span class="time_s">'
+json.time_s
+'</span></span></span><br></li>'

                );
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
      console.log("error");
      console.log("textStatus: "+textStatus);
      console.log("errorThrown: "+errorThrown);
      clearInterval(mytimer);
    }
  });
}

jQuery(function() {
  pullfavnum();
});
</script>
