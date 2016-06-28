// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$( function() {

    jQuery( '#playcontrol' ).hide();
    jQuery( '#checkbox_auto' ).hide();
    jQuery( '#pagesearch' ).hide();
    jQuery( '#tweet' ).hide();
    jQuery( '#favs' ).hide();
    jQuery( '#favmanage' ).hide();
    jQuery( '#dirs' ).hide();
    jQuery( '#sql' ).hide();
    jQuery( '#copyrights_list' ).hide();

    jQuery( 'input#dirname' ).autocomplete( {
        source: function (request, response) {
            jQuery.ajax({
                type: "POST",
                url:"autocomplete_name.php",
                data: 'mode=dir&id=' + jQuery( '#id' ).val() + '&pw=' + jQuery( '#pw' ).val(),
                success: response,
                dataType: 'json',
                beforeSend: function( xhr ) {
                    var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                    xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
                }
            });
        },
        delay: 100,
        minLength: 2
    } );

    $( 'input#favname' ).autocomplete( {
        source: function (request, response) {
            jQuery.ajax({
                type: "POST",
                url:"autocomplete_name.php",
                data: 'mode=fav&id=' + jQuery( '#id' ).val() + '&pw=' + jQuery( '#pw' ).val(),
                success: response,
                dataType: 'json',
                beforeSend: function( xhr ) {
                    var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                    xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
                }
            });
        },
        delay: 100,
        minLength: 1
    } );

    if ( jQuery( 'input#id' ).val() !== '' ) {
        Cookies.set( 'id', jQuery( 'input#id' ).val() );
    }

    jQuery( 'a' ).not( '[href="#"]' ).attr( {
        target: '_blank'
    } ).addClass( 'ex_link' );

    jQuery( '#id' ).blur( function( e ) {
        if ( jQuery( '#id' ).val() !== '' ) {
            Cookies.set( 'id', jQuery( 'input#id' ).val() );
        }
    } );

    if ( jQuery( "input#id" ).val() === '' ) {
        $( "input#id" ).css( "background", "#ffeeee" );
    } else {
        $( "input#id" ).css( "background", "#eeffee" );
    }
    $( "input#id" ).focus( function() {
        if ( jQuery( "input#id" ).val() === '' ) {
            $( this ).css( "background", "#ffeeee" );
        }
    } ).blur( function() {
        if ( jQuery( "input#id" ).val() !== '' ) {
            $( this ).css( "background", "#eeffee" );
        }
    } );

    if ( jQuery( "input#pw" ).val() === '' ) {
        $( "input#pw" ).css( "background", "#ffeeee" );
    } else {
        $( "input#pw" ).css( "background", "#eeffee" );
    }
    $( "input#pw" ).focus( function() {
        if ( jQuery( "input#pw" ).val() === '' ) {
            $( this ).css( "background", "#ffeeee" );
        }
    } ).blur( function() {
        if ( jQuery( "input#pw" ).val() !== '' ) {
            $( this ).css( "background", "#eeffee" );

            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' ) ) {
                    pullname( 'fav' );
                }
            }, 2000 );
            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' ) ) {
                    pullname( 'dir' );
                }
            }, 2500 );
        }
    } );

    if ( jQuery( "input#pw2" ).val() === '' ) {
        $( "input#pw2" ).css( "background", "#ffeeee" );
    } else {
        $( "input#pw2" ).css( "background", "#eeffee" );
    }
    $( "input#pw2" ).focus( function() {
        if ( jQuery( "input#pw2" ).val() === '' ) {
            $( this ).css( "background", "#ffeeee" );
        }
    } ).blur( function() {
        if ( jQuery( "input#pw2" ).val() !== '' ) {
            $( this ).css( "background", "#eeffee" );

            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' ) ) {
                    pullname( 'fav' );
                }
            }, 2000 );
            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' ) ) {
                    pullname( 'dir' );
                }
            }, 2500 );
        }
    } );

    if (( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' )) {
        setTimeout( function() {
            if ( ( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' ) ) {
                pullname( 'fav' );
            }
        }, 2000 );
        setTimeout( function() {
            if ( ( jQuery( "input#id" ).val() !== '' ) && ( jQuery( "input#pw" ).val() !== '' ) ) {
                pullname( 'dir' );
            }
        }, 2500 );
    }

    jQuery( '#control_pullfavname' ).click( function( e ) {
        pullname( 'fav' );
    } );

    jQuery( '#control_pulldirname' ).click( function( e ) {
        pullname( 'dir' );
    } );

    jQuery( '#control_twtr' ).click( function( e ) {
        settweetstr( 1 );
    } );

    jQuery( '#enable_loop' ).click( function( e ) {
        Cookies.set( 'enable_loop', ( ( jQuery( '#enable_loop' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#enable_allloop' ).click( function( e ) {
        Cookies.set( 'enable_allloop', ( ( jQuery( '#enable_allloop' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#enable_recently_played' ).click( function( e ) {
        Cookies.set( 'enable_recently_played', ( ( jQuery( '#enable_recently_played' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#enable_autotweet' ).click( function( e ) {
        Cookies.set( 'enable_autotweet', ( ( jQuery( '#enable_autotweet' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#enable_notification' ).click( function( e ) {
        Cookies.set( 'enable_notification', ( ( jQuery( '#enable_notification' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#enable_muted' ).click( function( e ) {
        Cookies.set( 'enable_muted', ( ( jQuery( '#enable_muted' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#enable_lyric' ).click( function( e ) {
        Cookies.set( 'enable_lyric', ( ( jQuery( '#enable_lyric' ).prop( 'checked' ) ) ? '1' : '0' ) );
    } );

    jQuery( '#favfadd' ).click( function( e ) {
        jQuery.ajax( {
            type: 'POST',
            url: 'index.php',
            data: 'id=' + jQuery( '#id' ).val() + '&pw=' + jQuery( '#pw' ).val() + '&mode=favfadd&favname=' + jQuery( '#favname' ).val(),
            beforeSend: function( xhr ) {
                var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
            },
            success: function( data ) {
                var status = ( data.indexOf( '(!) ' ) === 0 ) ? 'error' : 'success';
                jQuery.notifyBar( {
                    html: data,
                    delay: 10000,
                    cssClass: status
                } );
                pullname( 'fav' );
            }
        } );
    } );

    jQuery( '#favfdel' ).click( function( e ) {
        if ( window.confirm( $( '#favname' ).val() + 'を削除してよろしいですか？' ) ) {
            jQuery.ajax({
                type: 'POST',
                url: 'index.php',
                data: 'id=' + jQuery( '#id' ).val() + '&pw=' + jQuery( '#pw' ).val() + '&mode=favfdel&favname=' + jQuery( '#favname' ).val(),
                beforeSend: function( xhr ) {
                    var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                    xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
                },
                success: function( data ) {
                    var status = ( data.indexOf( '(!) ' ) === 0 ) ? 'error' : 'success';
                    jQuery.notifyBar( {
                        html: data,
                        delay: 10000,
                        cssClass: status
                    } );
                    pullname( 'fav' );
                }
            });
        }
    } );

    jQuery( '#screen_name' ).click( function( e ) {
        setscreenname();
    } );

    jQuery( '#tweettext' ).dblclick( function( e ) {
        settweetstr( 1 );
    } );

    if ( jQuery( '#enable_lyric' ).prop( 'checked' ) ) {
        jQuery( '#lyrics' ).show();
    } else {
        jQuery( '#lyrics' ).text( '' );
        jQuery( '#lyrics' ).hide();
    }

    jQuery( '#enable_lyric' ).change( function() {
        if ( jQuery( '#enable_lyric' ).prop( 'checked' ) ) {
                // jQuery('#lyrics').show();
            } else {
                jQuery( '#lyrics' ).text( '' );
                jQuery( '#lyrics' ).hide();
            }
        } );

    jQuery( '#pagesort' ).change( function( e ) {
            // .mouseup(function(e) {
                sortevent();
            } );

    jQuery( '#pageq' ).keyup( function( e ) {
        jQuery( '#wrapper_list ol li' ).each( function() {
            var pst = jQuery( jQuery( '#pagesearchtype' ).val(), this ).text();
            if ( !pst.match( jQuery( '#pageq' ).val() ) ) {
                jQuery( this ).hide();
            } else {
                jQuery( this ).show();
            }
        } );
    } );

    // audio.js

    var a = audiojs.createAll( {
        trackEnded: function() {
            if ( jQuery( '#checkbox_auto #enable_autotweet' ).prop( 'checked' ) ) {
                settweetstr( 2 );
            }

            if ( jQuery( '#checkbox_auto #enable_recently_played' ).prop( 'checked' ) ) {
                jQuery.ajax( {
                    type: 'POST',
                    url: 'index.php',
                    data: 'id=' + jQuery( '#id' ).val() + '&pw=' + jQuery( '#pw' ).val() + '&mode=rpadd&linkadd=' + jQuery( 'ol#sort_list li.playing a[data-src]' ).attr( 'data-src' ).replace( base_uri, '' ),
                    beforeSend: function( xhr ) {
                        var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                        xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
                    }
                } );
            }

            var next = jQuery( 'ol#sort_list li.playing' ).next();
            if ( jQuery( '#checkbox_auto #enable_allloop' ).prop( 'checked' ) ) {
                if ( !next.length ) next = jQuery( 'ol#sort_list li' ).first();
            } else {
                if ( !next.length ) return;
            }

            next.addClass( 'playing' ).siblings().removeClass( 'playing' );
            if ( jQuery( 'a', next ).attr( 'data-src' ) !== void 0 ) {
                audio.load( jQuery( 'a', next ).attr( 'data-src' ) );
                kirinload();
                audio.play();
            }

            document.getElementById( 'audio' ).loop = jQuery( '#checkbox_auto #enable_loop' ).prop( 'checked' );
            document.getElementById( 'audio' ).muted = jQuery( '#checkbox_auto #enable_muted' ).prop( 'checked' );
            jQuery( '#checkbox_auto #enable_loop' ).change( function() {
                document.getElementById( 'audio' ).loop = jQuery( '#checkbox_auto #enable_loop' ).prop( 'checked' );
            } );
            jQuery( '#checkbox_auto #enable_muted' ).change( function() {
                document.getElementById( 'audio' ).muted = jQuery( '#checkbox_auto #enable_muted' ).prop( 'checked' );
            } );

            if ( jQuery( '#checkbox_auto #enable_notification' ).prop( 'checked' ) ) {
                if ( window.webkitNotifications ) {
                    var message =
                    jQuery( '.artist', next ).text() + ' > ' +
                    jQuery( '.trackinfo', next ).text();
                    if ( window.webkitNotifications.checkPermission() === 0 ) {
                        var notification = window.webkitNotifications.createNotification(
                            'icon/kotta_s.png', jQuery( 'a[data-src]', next ).text(), message
                            );
                        notification.ondisplay = function() {
                            setTimeout( function() {
                                notification.cancel();
                            }, 2000 );
                        };
                        notification.show();
                    } else {
                        window.webkitNotifications.requestPermission();
                    }
                }
            }
        }
    } );

    // Load in the first track
    var audio = a[ 0 ];
    setTimeout( function() {
        first = jQuery( 'ol#sort_list li a' ).first().attr( 'data-src' );
        jQuery( 'ol#sort_list li' ).first().addClass( 'playing' ).siblings().removeClass( 'playing' );
        if ( first !== void 0 ) {
            audio.load( first );
            kirinload();
            jQuery( '#control_play' ).val( ( audio.playing ) ? 'Play' : 'Pause' );
            audio.play();
        }
    }, 1000 );
    // Load in a track on click
    jQuery( 'ol#sort_list li a[data-src]' ).click( function( e ) {
        e.preventDefault();
        jQuery( this ).parent().addClass( 'playing' ).siblings().removeClass( 'playing' );
        if ( jQuery( this ).attr( 'data-src' ) !== void 0 ) {
            audio.load( jQuery( this ).attr( 'data-src' ) );
            kirinload();
            audio.play();
        }
        if ( jQuery( '#checkbox_auto #enable_lyric' ).prop( 'checked' ) === false ) {
            var position = jQuery( 'ol#sort_list li.playing' ).offset().top;
            jQuery( 'html,body' ).animate( {
                scrollTop: position
            }, 400, 'swing' );
        }
    } );
    $( document ).on( 'click', 'ol#sort_list li.appended a[data-src]', function( e ) {
        e.preventDefault();
        jQuery( this ).parent().addClass( 'playing' ).siblings().removeClass( 'playing' );
        if ( jQuery( this ).attr( 'data-src' ) !== void 0 ) {
            audio.load( jQuery( this ).attr( 'data-src' ) );
            kirinload();
            audio.play();
        }
        if ( jQuery( '#checkbox_auto #enable_lyric' ).prop( 'checked' ) === false ) {
            var position = jQuery( 'ol#sort_list li.playing' ).offset().top;
            jQuery( 'html,body' ).animate( {
                scrollTop: position
            }, 400, 'swing' );
        }
    } );

    // Shortcut keys
    jQuery( document ).keydown( function( e ) {
        var next = '',
        prev = '';
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ( e.shiftKey + e.ctrlKey !== 0 ) {
            if ( unicode == 39 ) {
                next = jQuery( 'ol#sort_list li.playing' ).next().children( 'a[data-src]' );
                if ( !next.length ) next = jQuery( 'ol#sort_list li a[data-src]' ).first();
                next.click();
            } else if ( unicode == 37 ) {
                prev = jQuery( 'ol#sort_list li.playing' ).prev().children( 'a[data-src]' );
                if ( !prev.length ) prev = jQuery( 'ol#sort_list li a[data-src]' ).last();
                prev.click();
            } else if ( unicode == 32 ) {
                e.preventDefault();
                audio.playPause();
            }
        } else {
            if ( unicode == 176 ) {
                next = jQuery( 'ol#sort_list li.playing' ).next().children( 'a[data-src]' );
                if ( !next.length ) next = jQuery( 'ol#sort_list li a[data-src]' ).first();
                next.click();
            } else if ( unicode == 177 ) {
                prev = jQuery( 'ol#sort_list li.playing' ).prev().children( 'a[data-src]' );
                if ( !prev.length ) prev = jQuery( 'ol#sort_list li a[data-src]' ).last();
                prev.click();
            } else if ( unicode == 179 ) {
                e.preventDefault();
                audio.playPause();
            }
        }
    } );
    jQuery( '#control_prev' ).click( function( e ) {
        var prev = jQuery( 'ol#sort_list li.playing' ).prev().children( 'a[data-src]' );
        if ( !prev.length ) prev = jQuery( 'ol#sort_list li a[data-src]' ).last();
        prev.click();
    } );
    jQuery( '#control_play' ).click( function( e ) {
        e.preventDefault();
        jQuery( '#control_play' ).val( ( audio.playing ) ? 'Play' : 'Pause' );
        audio.playPause();
    } );
    jQuery( '#control_next' ).click( function( e ) {
        var next = jQuery( 'ol#sort_list li.playing' ).next().children( 'a[data-src]' );
        if ( !next.length ) next = jQuery( 'ol#sort_list li a[data-src]' ).first();
        next.click();
    } );
    // 音量調節スライダー用
    jQuery( '#volume_control #slider' ).slider( {
        value: 100,
        range: 'min',
        min: 0,
        max: 100,
        slide: function( event, ui ) {
            jQuery( '#volume_control #num' ).val( ui.value );
        }
    } );
    jQuery( '#volume_control #num' ).val( jQuery( '#volume_control #slider' ).slider( 'value' ) );
    jQuery( '#volume_control' ).mouseup( function( e ) {
        audio.setVolume( jQuery( '#volume_control #num' ).val() * 0.01 );
        jQuery( '#volume_control #slider' ).attr( 'title', jQuery( '#volume_control #num' ).val() );
    } );

    if ( jQuery( '#checkbox_auto #enable_autotweet' ).prop( 'checked' ) ) {
        window.open( 'tweet/index.php', 'sns' );
    }

    jQuery( '#checkbox_auto #enable_notification' ).click( function( e ) {
        if ( jQuery( '#checkbox_auto #enable_notification' ).prop( 'checked' ) ) {
            if ( window.webkitNotifications ) {
                if ( window.webkitNotifications.checkPermission() !== 0 ) {
                    window.webkitNotifications.requestPermission();
                }
            }
        }
    } );

    // 再生速度調節スライダー用
    jQuery( '#speed_control #slider' ).slider( {
        value: 100,
        range: 'min',
        min: 50,
        max: 150,
        slide: function( event, ui ) {
            jQuery( '#speed_control #num' ).val( ui.value );
        }
    } );
    jQuery( '#speed_control #num' ).val( jQuery( '#speed_control #slider' ).slider( 'value' ) );
    jQuery( '#speed_control' ).mouseup( function( e ) {
        document.getElementById( 'audio' ).playbackRate = jQuery( '#speed_control #num' ).val() * 0.01;
        jQuery( '#speed_control #slider' ).attr( 'title', ( jQuery( '#speed_control #num' ).val() * 0.01 ).toFixed( 1 ) );
    } );
    // audio.js

} );

function basename( path, suffix ) {
    var b = path.replace( /^.*[\/\\]/g, '' );
    if ( typeof( suffix ) == 'string' && b.substr( b.length - suffix.length ) == suffix ) {
        b = b.substr( 0, b.length - suffix.length );
    }
    return b;
}

// TODO
function favadd(json) {
    if(window.confirm(htmlspecialcharsEntQuotes( json.title ) + 'をお気に入り「' + htmlspecialcharsEntQuotes( json.favname ) + '」に追加してよろしいですか？')){
       $(function(){
          jQuery.post('index.php',
            'id=' + jQuery( "input#id" ).val() + '&mode=favadd&favname=' + htmlspecialcharsEntQuotes( json.favname ) + '&linkadd=' + htmlspecialcharsEntQuotes( json.relapath ),
            function(data){
              var status = (data.indexOf('(!) ')===0) ? 'error' : 'success';
              $.notifyBar({ html: data, delay: 10000, cssClass: status });
          });
          jQuery('#favmanage').hide();
          pullfavmenu(pre_pullfavmenu_id);
      });
       return false;
   }
}

// TODO
function favdel(json) {
    if(window.confirm(htmlspecialcharsEntQuotes( json.title ) + 'をお気に入り「' + htmlspecialcharsEntQuotes( json.favname ) + '」を解除してよろしいですか？')){
       $(function(){
          jQuery.post('index.php',
            'id=' + jQuery( 'input#id' ).val() + '&mode=favdel&favname=' + htmlspecialcharsEntQuotes( json.favname ) + '&linkdel=' + htmlspecialcharsEntQuotes( json.relapath ),
            function(data){
              var status = (data.indexOf('(!) ')===0) ? 'error' : 'success';
              $.notifyBar({ html: data, delay: 10000, cssClass: status }); });
          jQuery('#favmanage').hide();
          pullfavmenu(pre_pullfavmenu_id);
      });
       return false;
   }
}

function htmlspecialchars( str ) {
    str = str.replace( /&/g, "&amp;" );
    str = str.replace( /"/g, "&quot;" );
    str = str.replace( /</g, "&lt;" );
    str = str.replace( />/g, "&gt;" );
    return str;
}

function htmlspecialcharsEntQuotes( str ) {
    str = str.replace( /&/g, "&amp;" );
    str = str.replace( /"/g, "&quot;" );
    str = str.replace( /'/g, "&#039;" );
    str = str.replace( /</g, "&lt;" );
    str = str.replace( />/g, "&gt;" );
    return str;
}

function isHankaku( str ) {
    if ( str.match( /[^0-9A-Za-z]+/ ) === null ) {
        return true;
    } else {
        return false;
    }
}

function kirinload() {
    if ( jQuery( '#checkbox_auto #enable_lyric' ).prop( 'checked' ) ) {
        if ( jQuery( 'ol#sort_list li.playing a[data-src]' ).attr( 'data-src' ) !== void 0 ) {
            jQuery( function() {
                jQuery.ajax( {
                    type: 'POST',
                    url: ( jQuery( 'ol#sort_list li.playing a[data-src]' ).attr( 'data-src' ) ).replace( '.mp3', '.lrc' ),
                    beforeSend: function( xhr ) {
                        var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                        xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
                    },
                    success: function( result ) {
                        jQuery( '#lyrics' ).text( '' );
                        jQuery( '#lyrics' ).show();
                        var position = jQuery( '#lyrics' ).offset().top - 20;
                        jQuery( 'html,body' ).animate( {
                            scrollTop: position
                        }, 100, 'swing' );
                        jQuery( '#audio' ).kirinlyric( {
                            target: '#lyrics',
                            lrc: result
                        } );
                    },
                    error: function( XMLHttpRequest, textStatus, errorThrown ) {
                        jQuery( '#lyrics' ).text( '' );
                        jQuery( '#lyrics' ).hide();
                    }
                } );
            } );
        } else {
            jQuery( '#lyrics' ).text( '' );
            jQuery( '#lyrics' ).hide();
        }
    } else {
        jQuery( '#lyrics' ).text( '' );
        jQuery( '#lyrics' ).hide();
    }
}

function setscreenname() {
    jQuery.ajax( {
        type: 'POST',
        url: 'tweet/index.php',
        data: 'short=1',
        beforeSend: function( xhr ) {
            var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
            xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
        },
        success: function( data, dataType ) {
            if ( data !== '' ) {
                jQuery( 'span#screen_name' ).text( data );
            } else {
                jQuery( 'span#screen_name' ).text( '---' );
            }
        }
    } );
}

// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
function pullname( mode ) {
    mode = ( mode == 'fav' ) ? 'fav' : 'dir';
    var mytimer = null;
    var isJSON = function( arg ) {
        arg = ( typeof arg === 'function' ) ? arg() : arg;
        if ( typeof arg !== 'string' ) {
            return false;
        }
        try {
            arg = ( !JSON ) ? eval( '(' + arg + ')' ) : JSON.parse( arg );
            return true;
        } catch ( e ) {
            return false;
        }
    };
    $.ajax( {
        type: 'post',
        url: 'ls_' + mode + '.php',
        cache: false,
        data: 'onlyname=1&id=' + jQuery( 'input#id' ).val() + '&pw=' + jQuery( 'input#pw' ).val() + '&pw2=' + jQuery( 'input#pw2' ).val()+'&_=' + Math.random(),
        xhrFields: {
            onloadstart: function() {
                $( 'ul#' + mode + 'slist' ).text( '' );
                if ( mode == 'fav' ) {
                    $( 'select#favname' ).text( '' );
                }
                var xhr = this;
                var textlength = 0;
                mytimer = setInterval( function() {
                    var text = xhr.responseText;
                    var newText = text.substring( textlength );
                    var lines = newText.split( "\n" );
                    if ( text.length > textlength ) {
                        textlength = text.length;
                        lines.forEach( function( line ) {
                            if ( isJSON( line ) ) {
                                var json = JSON.parse( line );
                                var nam = ( mode == 'fav' ) ? json.favname : json.dirname;
                                if ( typeof nam !== 'undefined' ) {
                                    $( 'ul#' + mode + 'slist' ).append(
                                        '<li id=\'' + mode + 'menu_' + htmlspecialcharsEntQuotes( nam ) + '\'><a href=\'?mode=simple&' + mode + 'name=' + htmlspecialcharsEntQuotes( nam ) + '\'>' + nam + '</a>' +
                                        '<a href=\'?mode=music&' + mode + 'name=' + htmlspecialcharsEntQuotes( nam ) + '\'>[music]</a>' +
                                        '<a href=\'#\' onClick=\'pullls("' + htmlspecialcharsEntQuotes( mode ) +'","' + htmlspecialcharsEntQuotes( nam ) + '");\'>[Add]</a>' +
                                        '<a href=\'#\' onClick=\'var url="db_write.php?dirname="+encodeURIComponent(jQuery("input#dirname").val())+"&id="+jQuery("input#id").val();window.open(url,"db");\'>[AddDB]</a>' +
                                        '<a href=\'ls_' + mode + '.php?makem3u=1&' + mode + 'name=' + htmlspecialcharsEntQuotes( nam ) + '\'>[m3u]</a></li>'
                                        );
                                    if ( mode == 'fav' ) {
                                        $( 'select#favname' ).append( $( '<option>' ).html( nam ).val( nam ) );
                                    }
                                }
                            }
                        } );
                    }
                }, 100 );
            }
        },
        success: function( msg ) {
            if ( msg.indexOf( 'PW認証できません' ) > -1 ) {
                $( "input#id" ).css( "background", "#ffcccc" );
                $( "input#pw" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + ' : ' + ( ( mode == 'fav' ) ? 'お気に入り' : 'ディレクトリ' ) + '一覧の読み込みに失敗しました: ',
                    delay: 10000,
                    cls: 'error'
                } );
            } else if ( msg.indexOf( 'OTP認証できません' ) > -1 ) {
                $( "input#id" ).css( "background", "#eeffee" );
                $( "input#pw" ).css( "background", "#eeffee" );
                $( "input#pw2" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + ' : ' + ( ( mode == 'fav' ) ? 'お気に入り' : 'ディレクトリ' ) + '一覧の読み込みに失敗しました: ',
                    delay: 10000,
                    cls: 'error'
                } );
            } else {
                $( "input#id" ).css( "background", "#eeffee" );
                $( "input#pw" ).css( "background", "#eeffee" );
                $( "input#pw2" ).css( "background", "#eeffee" );
                setTimeout( function() {
                    clearInterval( mytimer );
                }, 100 );
                setTimeout( function() {
                    $( 'ul#' + mode + 'slist' ).html(
                        $( 'ul#' + mode + 'slist li' ).sort( function( a, b ) {
                            return ( $( a ).text() > $( b ).text() ) ? 1 : -1;
                        } )
                        );
                    $.notifyBar( {
                        html: ( ( mode == 'fav' ) ? 'お気に入り' : 'ディレクトリ' ) + '一覧を読み込みました',
                        delay: 10000,
                        cls: 'success'
                    } );
                }, 100 );
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ) {
            console.log( 'error' );
            console.log( 'textStatus: ' + textStatus );
            console.log( 'errorThrown: ' + errorThrown );
            clearInterval( mytimer );
            $.notifyBar( {
                html: ( ( mode == 'fav' ) ? 'お気に入り' : 'ディレクトリ' ) + '一覧の読み込みに失敗しました: ' + textStatus,
                delay: 10000,
                cls: 'error'
            } );
        }
    } );
}

var pre_pullfavmenu_id = 'track1';

function pullfavmenu( id ) {
    pre_pullfavmenu_id = id;

    $( 'table#favmenu tbody' ).text( '' );

    var d = jQuery( 'li#' + id + ' a' ).attr( 'data-src' );
    var r = jQuery( 'li#' + id + ' a' ).attr( 'relapath' );
    var t = jQuery( 'li#' + id + ' a' ).text();
    jQuery( "a#mp3info" ).attr( "href", d );
    jQuery( "a#mp3info" ).text( t );

    jQuery( "#favmanage" ).show();
    var target = jQuery( 'table#favmenu' ).scrollTop();
    jQuery( "html,body" ).animate( {
        scrollTop: target
    } );

    var mytimer = null;
    var isJSON = function( arg ) {
        arg = ( typeof arg === 'function' ) ? arg() : arg;
        if ( typeof arg !== 'string' ) {
            return false;
        }
        try {
            arg = ( !JSON ) ? eval( '(' + arg + ')' ) : JSON.parse( arg );
            return true;
        } catch ( e ) {
            return false;
        }
    };
    $.ajax( {
        type: 'post',
        url: 'ls_fav.php',
        cache: false,
        data: 'onlyname=1&id=' + jQuery( 'input#id' ).val() + '&pw=' + jQuery( 'input#pw' ).val() + '&pw2=' + jQuery( 'input#pw2' ).val() + '&relapath=' + r + '&_=' + Math.random(),
        xhrFields: {
            onloadstart: function() {
                var xhr = this;
                var textlength = 0;
                mytimer = setInterval( function() {
                    var text = xhr.responseText;
                    var newText = text.substring( textlength );
                    var lines = newText.split( "\n" );
                    if ( text.length > textlength ) {
                        textlength = text.length;
                        lines.forEach( function( line ) {
                            if ( isJSON( line ) ) {
                                var json = JSON.parse( line );
                                if ( typeof json.favname !== 'undefined' ) {
                                    $( 'table#favmenu tbody' ).append(
                                        '<tr><td><a href=\'?mode=simple&favname=' + htmlspecialcharsEntQuotes( json.favname ) + '\'>' + htmlspecialcharsEntQuotes( json.favname ) + '</a></td>' +
                                        (
                                            ( json.hassong ) ?
                                            ( ' <td><span class=\'star\' id=\'bookmarkstar' + json.id + '\' title=\'お気に入り「' + htmlspecialcharsEntQuotes( json.favname ) + '」を解除します\' onClick=\'favdel(json);\'> ★</span></td><td> </td>' ) :
                                            ( ' <td> </td><td><span class=\'starw\' id=\'bookmarkstar' + json.id + '\' title=\'お気に入り「' + htmlspecialcharsEntQuotes( json.favname ) + '」に追加します\' onClick=\'favadd(json);\'> ☆</span></td>' )
                                            )
                                        );
                                }
                            }
                        } );
                    }
                }, 100 );
            }
        },
        success: function( msg ) {
            if ( msg.indexOf( 'PW認証できません' ) > -1 ) {
                $( "input#id" ).css( "background", "#ffcccc" );
                $( "input#pw" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + ' : ' + ( ( mode == 'fav' ) ? 'お気に入り' : 'ディレクトリ' ) + '一覧の読み込みに失敗しました: ',
                    delay: 10000,
                    cls: 'error'
                } );
            } else if ( msg.indexOf( 'OTP認証できません' ) > -1 ) {
                $( "input#id" ).css( "background", "#eeffee" );
                $( "input#pw" ).css( "background", "#eeffee" );
                $( "input#pw2" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + ' : お気に入り一覧の読み込みに失敗しました: ',
                    delay: 10000,
                    cls: 'error'
                } );
            } else {
                $( "input#id" ).css( "background", "#eeffee" );
                $( "input#pw" ).css( "background", "#eeffee" );
                $( "input#pw2" ).css( "background", "#eeffee" );
                setTimeout( function() {
                    clearInterval( mytimer );
                }, 100 );
                setTimeout( function() {
                    $.notifyBar( {
                        html: 'お気に入り一覧を読み込みました',
                        delay: 10000,
                        cls: 'success'
                    } );
                }, 100 );
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ) {
            console.log( 'error' );
            console.log( 'textStatus: ' + textStatus );
            console.log( 'errorThrown: ' + errorThrown );
            clearInterval( mytimer );
            $.notifyBar( {
                html: 'お気に入り一覧の読み込みに失敗しました: ' + textStatus,
                delay: 10000,
                cls: 'error'
            } );
        }
    } );
}

function pullls( mode , name ) {
    var i = jQuery( '#sort_list li' ).length;
    var mytimer = null;
    var isJSON = function( arg ) {
        arg = ( typeof arg === 'function' ) ? arg() : arg;
        if ( typeof arg !== 'string' ) {
            return false;
        }
        try {
            arg = ( !JSON ) ? eval( '(' + arg + ')' ) : JSON.parse( arg );
            return true;
        } catch ( e ) {
            return false;
        }
    };
    $.ajax( {
        type: 'post',
        url: 'ls_' + ((mode=='fav')?'fav':'dir') + '.php',
        cache: false,
        data: ((mode=='fav')?'fav':'dir') + 'name=' + name + '&id=' + jQuery( 'input#id' ).val() + '&pw=' + jQuery( 'input#pw' ).val() + '&pw2=' + jQuery( 'input#pw2' ).val() + '_=' + Math.random(),
        xhrFields: {
            onloadstart: function() {
                var xhr = this;
                var textlength = 0;
                mytimer = setInterval( function() {
                    var text = xhr.responseText;
                    var newText = text.substring( textlength );
                    var lines = newText.split( "\n" );
                    if ( text.length > textlength ) {
                        textlength = text.length;
                        lines.forEach( function( line ) {
                            if ( isJSON( line ) ) {
                                var json = JSON.parse( line );
                                if ( typeof json.title !== 'undefined' ) {
                                    $( 'ol#sort_list' ).append(

                                        '<li class=\'appended\' id=\'track' + i + '\'>' +
                                        '<a class=\'title\' href=\'#\' data-src=\'' + json.datasrc + '\' relapath=\'' + json.relapath + '\'>' + json.title + '</a><br>' +
                                        '<span class=\'starw\' id=\'bookmarkstar' + i + '\' title=\'お気に入りの管理\' onClick=\'pullfavmenu("track' + i + '");return false;\'>' +
                                        '☆</span>　' +
                                        ( ( typeof json.favname === 'undefined' ) ? ''
                                           : ( '<span class=\'star\' id=\'bookmarkstar' + i + '\' title=\'お気に入り「' + htmlspecialcharsEntQuotes( json.favname ) + '」を解除します\'' +
                                            ' onClick=\'favdel(json);\'>★</span>'
                                            ) ) +
                                        '<span class=\'del\' id=\'delicon' + i + '\' title=\'プレイビューから外します\' onClick=\'if(window.confirm("' + htmlspecialcharsEntQuotes( json.title ) + ' (' + htmlspecialcharsEntQuotes( json.basename ) + ')をプレイビューから外してよろしいですか？")){ $(function(){$("#track' + i + '").remove()}); return false; }\'>' +
                                        '×</span>' +
                                        '<br>　<a class=\'artist\' href=\'?favname=&mode=music&dirname=' + encodeURIComponent( json.artistdirtmp ) + '\'>' + json.artist + '</a> &gt; ' +
                                        '<span class=\'trackinfo\'><a class=\'album\' href=\'?favname=&mode=music&dirname=' + encodeURIComponent( json.artistdirtmp ) + '&filter_album=' + encodeURIComponent( json.album ) + '\'>' + json.album +
                                        '</a> (No.<span class=\'number\'>' + ( ( json.number < 10 ) ? "0" + json.number : json.number ) + '</span>) [<span class=\'genre\'>' + json.genre + '</span>] ' +
                                        '<span class=\'time\'><span class=\'time_m\'>' + json.time_m + '</span>:<span class=\'time_s\'>' + json.time_s + '</span></span></span><br></li>'

                                    );
                                }
                            }
                            i++;
                        } );
                    }
                }, 100 );
            }
        },
        success: function( msg ) {
            if ( msg.indexOf( 'PW認証できません' ) > -1 ) {
                $( "input#id" ).css( "background", "#ffcccc" );
                $( "input#pw" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + ' : ' + ( ( mode == 'fav' ) ? 'お気に入り' : 'ファイル' ) + '一覧の読み込みに失敗しました: ',
                    delay: 10000,
                    cls: 'error'
                } );
            } else if ( msg.indexOf( 'OTP認証できません' ) > -1 ) {
                $( "input#id" ).css( "background", "#eeffee" );
                $( "input#pw" ).css( "background", "#eeffee" );
                $( "input#pw2" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + ' : ' + ( ( mode == 'fav' ) ? 'お気に入り' : 'ファイル' ) + '一覧の読み込みに失敗しました: ',
                    delay: 10000,
                    cls: 'error'
                } );
            } else {
                $( "input#id" ).css( "background", "#eeffee" );
                $( "input#pw" ).css( "background", "#eeffee" );
                $( "input#pw2" ).css( "background", "#eeffee" );
                setTimeout( function() {
                    clearInterval( mytimer );
                }, 100 );
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ) {
            console.log( 'error' );
            console.log( 'textStatus: ' + textStatus );
            console.log( 'errorThrown: ' + errorThrown );
            clearInterval( mytimer );
            $.notifyBar( {
                html: textStatus,
                delay: 10000,
                cls: 'error'
            } );
        }
    } );
}

function settweetstr( mode ) {
    var sns_format = jQuery( 'input#sns_format' ).val();
    var tstr = sns_format.replace( '%a', jQuery( 'ol#sort_list li.playing .artist' ).text() );
    tstr = tstr.replace( '%g', jQuery( 'ol#sort_list li.playing .genre' ).text() );
    tstr = tstr.replace( '%l', jQuery( 'ol#sort_list li.playing .album' ).text() );
    tstr = tstr.replace( '%m', jQuery( 'ol#sort_list li.playing .time_m' ).text() );
    tstr = tstr.replace( '%n', jQuery( 'ol#sort_list li.playing .number' ).text() );
    tstr = tstr.replace( '%s', jQuery( 'ol#sort_list li.playing .time_s' ).text() );
    tstr = tstr.replace( '%t', jQuery( 'ol#sort_list li.playing .title' ).text() );
    if ( tstr.indexOf( '%u', 0 ) > -1 ) {
        jQuery.ajax( {
            type: 'POST',
            url: 'req/shortenuri.php',
            data: 'uri=' + jQuery( 'ol#sort_list li.playing .title' ).attr( 'data-src' ),
            beforeSend: function( xhr ) {
                var credentials = $.base64.encode( jQuery( '#id' ).val() + ':' + jQuery( '#pw' ).val() );
                xhr.setRequestHeader( 'Authorization', 'Basic ' + credentials );
            },
            success: function( data, dataType ) {
                tstr = tstr.replace( '%u', data );
                if ( mode == 1 ) {
                    jQuery( 'textarea#tweettext' ).val( tstr );
                } else if ( mode == 2 ) {
                    window.open( 'tweet/tweet.php?pass_autotweet=' + jQuery( 'select#pass_autotweet' ).val() + '&tweettext=' + encodeURIComponent( tstr ), 'sns' );
                }
            }
        } );
    } else {
        if ( mode == 1 ) {
            jQuery( 'textarea#tweettext' ).val( tstr );
        } else if ( mode == 2 ) {
            window.open( 'tweet/tweet.php?pass_autotweet=' + jQuery( 'select#pass_autotweet' ).val() + '&tweettext=' + encodeURIComponent( tstr ), 'sns' );
        }
    }
}

function sortevent() {
    switch ( jQuery( '#pagesort' ).val() ) {
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

var arr = new Array();
var sortAsc = function( a, b ) {
    return a.key.localeCompare( b.key );
}; // 昇順
var sortDesc = function( a, b ) {
    return b.key.localeCompare( a.key );
}; // 降順
function filename_u() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = basename( jQuery( 'a[data-src]', this ).attr( 'data-src' ) );
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function filename_d() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = basename( jQuery( 'a[data-src]', this ).attr( 'data-src' ) );
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function title_u() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = jQuery( 'a[data-src]', this ).text();
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function title_d() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = jQuery( 'a[data-src]', this ).text();
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function artist_u() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = jQuery( '.artist', this ).text();
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function artist_d() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = jQuery( '.artist', this ).text();
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function trackinfo_u() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = jQuery( '.trackinfo', this ).text();
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function trackinfo_d() {
    jQuery( 'ol#sort_list li' ).each( function( i ) {
        arr[ i ] = {};
        arr[ i ].key = jQuery( '.trackinfo', this ).text();
        arr[ i ].value = jQuery( this );
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( 'ol#sort_list' ).append( arr[ i ].value );
    }
}

function random() {
    jQuery( 'ol#sort_list li' ).shuffle();
}
( function( d ) {
    d.fn.shuffle = function( c ) {
        c = [];
        return this.each( function() {
            c.push( d( this ).clone( true ) );
        } ).each( function( a, b ) {
            d( b ).replaceWith( c[ a = Math.floor( Math.random() * c.length ) ] );
            c.splice( a, 1 );
        } );
    };
    d.shuffle = function( a ) {
        return d( a ).shuffle();
    };
} )( jQuery );
