$( function() {
    jQuery( "#playcontrol" ).hide();
    jQuery( "#checkbox_auto" ).hide();
    jQuery( "#pagesearch" ).hide();
    jQuery( "#tweet" ).hide();
    jQuery( "#favs" ).hide();
    jQuery( "#dirs" ).hide();
    jQuery( "#sql" ).hide();
    jQuery( "#copyrights_list" ).hide();
    $( "input#dirname" ).autocomplete( {
        source: "autocomplete_name.php?mode=dir&id=" + $( "#id" ).val() + "&pw=" + $( "#pw" ).val(),
        delay: 100,
        minLength: 2
    } );
    $( "input#favname" ).autocomplete( {
        source: "autocomplete_name.php?mode=fav&id=" + $( "#id" ).val() + "&pw=" + $( "#pw" ).val(),
        delay: 100,
        minLength: 1
    } );
    if ( jQuery( "input#id" ).val() !== "" ) {
        Cookies.set( "id", jQuery( "input#id" ).val() )
    }
    if ( jQuery( "input#pw" ).val() !== "" ) {
        Cookies.set( "pw", jQuery( "input#pw" ).val() )
    }
    jQuery( "a" ).not( '[href="#"]' ).attr( {
        target: "_blank"
    } ).addClass( "ex_link" );
    jQuery( "#id" ).blur( function( a ) {
        if ( jQuery( "#id" ).val() !== "" ) {
            Cookies.set( "id", jQuery( "input#id" ).val() )
        }
    } );
    jQuery( "#pw" ).blur( function( a ) {
        if ( jQuery( "#pw" ).val() !== "" ) {
            Cookies.set( "pw", jQuery( "input#pw" ).val() )
        }
    } );
    if ( jQuery( "input#id" ).val() === "" ) {
        $( "input#id" ).css( "background", "#ffeeee" )
    } else {
        $( "input#id" ).css( "background", "#eeffee" )
    }
    $( "input#id" ).focus( function() {
        if ( jQuery( "input#id" ).val() === "" ) {
            $( this ).css( "background", "#ffeeee" )
        }
    } ).blur( function() {
        if ( jQuery( "input#id" ).val() !== "" ) {
            $( this ).css( "background", "#eeffee" )
        }
    } );
    if ( jQuery( "input#pw" ).val() === "" ) {
        $( "input#pw" ).css( "background", "#ffeeee" )
    } else {
        $( "input#pw" ).css( "background", "#eeffee" )
    }
    $( "input#pw" ).focus( function() {
        if ( jQuery( "input#pw" ).val() === "" ) {
            $( this ).css( "background", "#ffeeee" )
        }
    } ).blur( function() {
        if ( jQuery( "input#pw" ).val() !== "" ) {
            $( this ).css( "background", "#eeffee" );
            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== "" ) && ( jQuery( "input#pw" ).val() !== "" ) ) {
                    pullname( "fav" )
                }
            }, 2000 );
            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== "" ) && ( jQuery( "input#pw" ).val() !== "" ) ) {
                    pullname( "dir" )
                }
            }, 2500 )
        }
    } );
    if ( jQuery( "input#pw2" ).val() === "" ) {
        $( "input#pw2" ).css( "background", "#ffeeee" )
    } else {
        $( "input#pw2" ).css( "background", "#eeffee" )
    }
    $( "input#pw2" ).focus( function() {
        if ( jQuery( "input#pw2" ).val() === "" ) {
            $( this ).css( "background", "#ffeeee" )
        }
    } ).blur( function() {
        if ( jQuery( "input#pw2" ).val() !== "" ) {
            $( this ).css( "background", "#eeffee" );
            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== "" ) && ( jQuery( "input#pw" ).val() !== "" ) ) {
                    pullname( "fav" )
                }
            }, 2000 );
            setTimeout( function() {
                if ( ( jQuery( "input#id" ).val() !== "" ) && ( jQuery( "input#pw" ).val() !== "" ) ) {
                    pullname( "dir" )
                }
            }, 2500 )
        }
    } );
    jQuery( "#control_pullfavname" ).click( function( a ) {
        pullname( "fav" )
    } );
    jQuery( "#control_pulldirname" ).click( function( a ) {
        pullname( "dir" )
    } );
    jQuery( "#control_twtr" ).click( function( a ) {
        settweetstr( 1 )
    } );
    jQuery( "#enable_loop" ).click( function( a ) {
        Cookies.set( "enable_loop", ( ( jQuery( "#enable_loop" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#enable_allloop" ).click( function( a ) {
        Cookies.set( "enable_allloop", ( ( jQuery( "#enable_allloop" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#enable_recently_played" ).click( function( a ) {
        Cookies.set( "enable_recently_played", ( ( jQuery( "#enable_recently_played" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#enable_autotweet" ).click( function( a ) {
        Cookies.set( "enable_autotweet", ( ( jQuery( "#enable_autotweet" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#enable_notification" ).click( function( a ) {
        Cookies.set( "enable_notification", ( ( jQuery( "#enable_notification" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#enable_muted" ).click( function( a ) {
        Cookies.set( "enable_muted", ( ( jQuery( "#enable_muted" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#enable_lyric" ).click( function( a ) {
        Cookies.set( "enable_lyric", ( ( jQuery( "#enable_lyric" ).prop( "checked" ) ) ? "1" : "0" ) )
    } );
    jQuery( "#favfadd" ).click( function( a ) {
        jQuery.get( "?id=" + jQuery( "#id" ).val() + "&pw=" + jQuery( "#pw" ).val() + "&mode=favfadd&favname=" + jQuery( "#favname" ).val(), function( e ) {
            var d = ( e.indexOf( "(!) " ) === 0 ) ? "error" : "success";
            jQuery.notifyBar( {
                html: e,
                delay: 10000,
                cssClass: d
            } );
            pullname( "fav" )
        } )
    } );
    jQuery( "#favfdel" ).click( function( a ) {
        if ( window.confirm( $( "#favname" ).val() + "を削除してよろしいですか？" ) ) {
            jQuery.get( "?id=" + jQuery( "#id" ).val() + "&pw=" + jQuery( "#pw" ).val() + "&mode=favfdel&favname=" + jQuery( "#favname" ).val(), function( e ) {
                var d = ( e.indexOf( "(!) " ) === 0 ) ? "error" : "success";
                jQuery.notifyBar( {
                    html: e,
                    delay: 10000,
                    cssClass: d
                } );
                pullname( "fav" )
            } );
            return false
        }
    } );
    jQuery( "#screen_name" ).click( function( a ) {
        setscreenname()
    } );
    jQuery( "#tweettext" ).dblclick( function( a ) {
        settweetstr( 1 )
    } );
    if ( jQuery( "#enable_lyric" ).prop( "checked" ) ) {
        jQuery( "#lyrics" ).show()
    } else {
        jQuery( "#lyrics" ).text( "" );
        jQuery( "#lyrics" ).hide()
    }
    jQuery( "#enable_lyric" ).change( function() {
        if ( jQuery( "#enable_lyric" ).prop( "checked" ) ) {} else {
            jQuery( "#lyrics" ).text( "" );
            jQuery( "#lyrics" ).hide()
        }
    } );
    jQuery( "#pagesort" ).change( function( a ) {
        sortevent()
    } );
    jQuery( "#pageq" ).keyup( function( a ) {
        jQuery( "#wrapper_list ol li" ).each( function() {
            var d = jQuery( jQuery( "#pagesearchtype" ).val(), this ).text();
            if ( !d.match( jQuery( "#pageq" ).val() ) ) {
                jQuery( this ).hide()
            } else {
                jQuery( this ).show()
            }
        } )
    } );
    var b = audiojs.createAll( {
        trackEnded: function() {
            if ( jQuery( "#checkbox_auto #enable_autotweet" ).prop( "checked" ) ) {
                settweetstr( 2 )
            }
            if ( jQuery( "#checkbox_auto #enable_recently_played" ).prop( "checked" ) ) {
                jQuery.ajax( {
                    type: "POST",
                    data: "id=" + jQuery( "#id" ).val() + "&pw=" + jQuery( "#pw" ).val() + "&mode=rpadd&linkadd=" + jQuery( "ol#sort_list li.playing a[data-src]" ).attr( "data-src" ).replace( base_uri, "" ),
                    beforeSend: function( g ) {
                        var f = $.base64.encode( jQuery( "#id" ).val() + ":" + jQuery( "#pw" ).val() );
                        g.setRequestHeader( "Authorization", "Basic " + f )
                    }
                } )
            }
            var a = jQuery( "ol#sort_list li.playing" ).next();
            if ( jQuery( "#checkbox_auto #enable_allloop" ).prop( "checked" ) ) {
                if ( !a.length ) {
                    a = jQuery( "ol#sort_list li" ).first()
                }
            } else {
                if ( !a.length ) {
                    return
                }
            }
            a.addClass( "playing" ).siblings().removeClass( "playing" );
            if ( jQuery( "a", a ).attr( "data-src" ) !== void 0 ) {
                c.load( jQuery( "a", a ).attr( "data-src" ) );
                kirinload();
                c.play()
            }
            document.getElementById( "audio" ).loop = jQuery( "#checkbox_auto #enable_loop" ).prop( "checked" );
            document.getElementById( "audio" ).muted = jQuery( "#checkbox_auto #enable_muted" ).prop( "checked" );
            jQuery( "#checkbox_auto #enable_loop" ).change( function() {
                document.getElementById( "audio" ).loop = jQuery( "#checkbox_auto #enable_loop" ).prop( "checked" )
            } );
            jQuery( "#checkbox_auto #enable_muted" ).change( function() {
                document.getElementById( "audio" ).muted = jQuery( "#checkbox_auto #enable_muted" ).prop( "checked" )
            } );
            if ( jQuery( "#checkbox_auto #enable_notification" ).prop( "checked" ) ) {
                if ( window.webkitNotifications ) {
                    var d = jQuery( ".artist", a ).text() + " > " + jQuery( ".trackinfo", a ).text();
                    if ( window.webkitNotifications.checkPermission() === 0 ) {
                        var e = window.webkitNotifications.createNotification( "icon/kotta_s.png", jQuery( "a[data-src]", a ).text(), d );
                        e.ondisplay = function() {
                            setTimeout( function() {
                                e.cancel()
                            }, 2000 )
                        };
                        e.show()
                    } else {
                        window.webkitNotifications.requestPermission()
                    }
                }
            }
        }
    } );
    var c = b[ 0 ];
    setTimeout( function() {
        first = jQuery( "ol#sort_list li a" ).first().attr( "data-src" );
        jQuery( "ol#sort_list li" ).first().addClass( "playing" ).siblings().removeClass( "playing" );
        if ( first !== void 0 ) {
            c.load( first );
            kirinload();
            jQuery( "#control_play" ).val( ( c.playing ) ? "Play" : "Pause" );
            c.play()
        }
    }, 1000 );
    jQuery( "ol#sort_list li a[data-src]" ).click( function( d ) {
        d.preventDefault();
        jQuery( this ).parent().addClass( "playing" ).siblings().removeClass( "playing" );
        if ( jQuery( this ).attr( "data-src" ) !== void 0 ) {
            c.load( jQuery( this ).attr( "data-src" ) );
            kirinload();
            c.play()
        }
        if ( jQuery( "#checkbox_auto #enable_lyric" ).prop( "checked" ) === false ) {
            var a = jQuery( "ol#sort_list li.playing" ).offset().top;
            jQuery( "html,body" ).animate( {
                scrollTop: a
            }, 400, "swing" )
        }
    } );
    $( document ).on( "click", "ol#sort_list li.appended a[data-src]", function( d ) {
        d.preventDefault();
        jQuery( this ).parent().addClass( "playing" ).siblings().removeClass( "playing" );
        if ( jQuery( this ).attr( "data-src" ) !== void 0 ) {
            c.load( jQuery( this ).attr( "data-src" ) );
            kirinload();
            c.play()
        }
        if ( jQuery( "#checkbox_auto #enable_lyric" ).prop( "checked" ) === false ) {
            var a = jQuery( "ol#sort_list li.playing" ).offset().top;
            jQuery( "html,body" ).animate( {
                scrollTop: a
            }, 400, "swing" )
        }
    } );
    jQuery( document ).keydown( function( g ) {
        var d = "",
            f = "";
        var a = g.charCode ? g.charCode : g.keyCode;
        if ( g.shiftKey + g.ctrlKey !== 0 ) {
            if ( a == 39 ) {
                d = jQuery( "ol#sort_list li.playing" ).next().children( "a[data-src]" );
                if ( !d.length ) {
                    d = jQuery( "ol#sort_list li a[data-src]" ).first()
                }
                d.click()
            } else {
                if ( a == 37 ) {
                    f = jQuery( "ol#sort_list li.playing" ).prev().children( "a[data-src]" );
                    if ( !f.length ) {
                        f = jQuery( "ol#sort_list li a[data-src]" ).last()
                    }
                    f.click()
                } else {
                    if ( a == 32 ) {
                        g.preventDefault();
                        c.playPause()
                    }
                }
            }
        } else {
            if ( a == 176 ) {
                d = jQuery( "ol#sort_list li.playing" ).next().children( "a[data-src]" );
                if ( !d.length ) {
                    d = jQuery( "ol#sort_list li a[data-src]" ).first()
                }
                d.click()
            } else {
                if ( a == 177 ) {
                    f = jQuery( "ol#sort_list li.playing" ).prev().children( "a[data-src]" );
                    if ( !f.length ) {
                        f = jQuery( "ol#sort_list li a[data-src]" ).last()
                    }
                    f.click()
                } else {
                    if ( a == 179 ) {
                        g.preventDefault();
                        c.playPause()
                    }
                }
            }
        }
    } );
    jQuery( "#control_prev" ).click( function( d ) {
        var a = jQuery( "ol#sort_list li.playing" ).prev().children( "a[data-src]" );
        if ( !a.length ) {
            a = jQuery( "ol#sort_list li a[data-src]" ).last()
        }
        a.click()
    } );
    jQuery( "#control_play" ).click( function( a ) {
        a.preventDefault();
        jQuery( "#control_play" ).val( ( c.playing ) ? "Play" : "Pause" );
        c.playPause()
    } );
    jQuery( "#control_next" ).click( function( d ) {
        var a = jQuery( "ol#sort_list li.playing" ).next().children( "a[data-src]" );
        if ( !a.length ) {
            a = jQuery( "ol#sort_list li a[data-src]" ).first()
        }
        a.click()
    } );
    jQuery( "#volume_control #slider" ).slider( {
        value: 100,
        range: "min",
        min: 0,
        max: 100,
        slide: function( a, d ) {
            jQuery( "#volume_control #num" ).val( d.value )
        }
    } );
    jQuery( "#volume_control #num" ).val( jQuery( "#volume_control #slider" ).slider( "value" ) );
    jQuery( "#volume_control" ).mouseup( function( a ) {
        c.setVolume( jQuery( "#volume_control #num" ).val() * 0.01 );
        jQuery( "#volume_control #slider" ).attr( "title", jQuery( "#volume_control #num" ).val() )
    } );
    if ( jQuery( "#checkbox_auto #enable_autotweet" ).prop( "checked" ) ) {
        window.open( "tweet/index.php", "sns" )
    }
    jQuery( "#checkbox_auto #enable_notification" ).click( function( a ) {
        if ( jQuery( "#checkbox_auto #enable_notification" ).prop( "checked" ) ) {
            if ( window.webkitNotifications ) {
                if ( window.webkitNotifications.checkPermission() !== 0 ) {
                    window.webkitNotifications.requestPermission()
                }
            }
        }
    } );
    jQuery( "#speed_control #slider" ).slider( {
        value: 100,
        range: "min",
        min: 50,
        max: 150,
        slide: function( a, d ) {
            jQuery( "#speed_control #num" ).val( d.value )
        }
    } );
    jQuery( "#speed_control #num" ).val( jQuery( "#speed_control #slider" ).slider( "value" ) );
    jQuery( "#speed_control" ).mouseup( function( a ) {
        document.getElementById( "audio" ).playbackRate = jQuery( "#speed_control #num" ).val() * 0.01;
        jQuery( "#speed_control #slider" ).attr( "title", ( jQuery( "#speed_control #num" ).val() * 0.01 ).toFixed( 1 ) )
    } )
} );

function basename( d, c ) {
    var a = d.replace( /^.*[\/\\]/g, "" );
    if ( typeof( c ) == "string" && a.substr( a.length - c.length ) == c ) {
        a = a.substr( 0, a.length - c.length )
    }
    return a
}

function htmlspecialchars( a ) {
    a = a.replace( /&/g, "&amp;" );
    a = a.replace( /"/g, "&quot;" );
    a = a.replace( /</g, "&lt;" );
    a = a.replace( />/g, "&gt;" );
    return a
}

function htmlspecialcharsEntQuotes( a ) {
    a = a.replace( /&/g, "&amp;" );
    a = a.replace( /"/g, "&quot;" );
    a = a.replace( /'/g, "&#039;" );
    a = a.replace( /</g, "&lt;" );
    a = a.replace( />/g, "&gt;" );
    return a
}

function isHankaku( a ) {
    if ( a.match( /[^0-9A-Za-z]+/ ) === null ) {
        return true
    } else {
        return false
    }
}

function kirinload() {
    if ( jQuery( "#checkbox_auto #enable_lyric" ).prop( "checked" ) ) {
        if ( jQuery( "ol#sort_list li.playing a[data-src]" ).attr( "data-src" ) !== void 0 ) {
            jQuery( function() {
                jQuery.ajax( {
                    type: "POST",
                    url: ( jQuery( "ol#sort_list li.playing a[data-src]" ).attr( "data-src" ) ).replace( ".mp3", ".lrc" ),
                    success: function( b ) {
                        jQuery( "#lyrics" ).text( "" );
                        jQuery( "#lyrics" ).show();
                        var a = jQuery( "#lyrics" ).offset().top - 20;
                        jQuery( "html,body" ).animate( {
                            scrollTop: a
                        }, 100, "swing" );
                        jQuery( "#audio" ).kirinlyric( {
                            target: "#lyrics",
                            lrc: b
                        } )
                    },
                    error: function( a, c, b ) {
                        jQuery( "#lyrics" ).text( "" );
                        jQuery( "#lyrics" ).hide()
                    },
                    beforeSend: function( b ) {
                        var a = $.base64.encode( jQuery( "#id" ).val() + ":" + jQuery( "#pw" ).val() );
                        b.setRequestHeader( "Authorization", "Basic " + a )
                    }
                } )
            } )
        } else {
            jQuery( "#lyrics" ).text( "" );
            jQuery( "#lyrics" ).hide()
        }
    } else {
        jQuery( "#lyrics" ).text( "" );
        jQuery( "#lyrics" ).hide()
    }
}

function setscreenname() {
    jQuery.ajax( {
        type: "POST",
        url: "tweet/index.php",
        data: "short=1",
        success: function( b, a ) {
            if ( b !== "" ) {
                jQuery( "span#screen_name" ).text( b )
            } else {
                jQuery( "span#screen_name" ).text( "---" )
            }
        }
    } )
}

function pullname( mode ) {
    mode = ( mode == "fav" ) ? "fav" : "dir";
    var mytimer = null;
    var isJSON = function( arg ) {
        arg = ( typeof arg === "function" ) ? arg() : arg;
        if ( typeof arg !== "string" ) {
            return false
        }
        try {
            arg = ( !JSON ) ? eval( "(" + arg + ")" ) : JSON.parse( arg );
            return true
        } catch ( e ) {
            return false
        }
    };
    $.ajax( {
        type: "post",
        url: "ls_" + mode + ".php?id=" + jQuery( "input#id" ).val() + "&pw=" + jQuery( "input#pw" ).val() + "&pw2=" + jQuery( "input#pw2" ).val(),
        cache: false,
        data: "onlyname=1&_=" + Math.random(),
        xhrFields: {
            onloadstart: function() {
                $( "ul#" + mode + "slist" ).text( "" );
                if ( mode == "fav" ) {
                    $( "select#favname" ).text( "" )
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
                                var nam = ( mode == "fav" ) ? json.favname : json.dirname;
                                if ( typeof nam !== "undefined" ) {
                                    var url = "ls_" + mode + ".php?id=" + jQuery( "input#id" ).val() + "&pw=" + jQuery( "input#pw" ).val() + "&pw2=" + jQuery( "input#pw2" ).val() + "&" + mode + "name=" + nam;
                                    $( "ul#" + mode + "slist" ).append( "<li id='" + mode + "menu_" + htmlspecialcharsEntQuotes( nam ) + "'><a href='?mode=simple&" + mode + "name=" + htmlspecialcharsEntQuotes( nam ) + "'>" + nam + "</a><a href='?mode=music&" + mode + "name=" + htmlspecialcharsEntQuotes( nam ) + "'>[music]</a><a href='#' onClick='pullls(\"" + htmlspecialcharsEntQuotes( url ) + '");\'>[Add]</a><a href=\'#\' onClick=\'var url="db_write.php?dirname="+encodeURIComponent(jQuery("input#dirname").val())+"&id="+jQuery("input#id").val()+"&pw="+jQuery("input#pw").val()+"&pw2="+jQuery("input#pw2").val();window.open(url,"db");\'>[AddDB]</a><a href=\'ls_' + mode + ".php?makem3u=1&" + mode + "name=" + htmlspecialcharsEntQuotes( nam ) + "'>[m3u]</a></li>" );
                                    if ( mode == "fav" ) {
                                        $( "select#favname" ).append( $( "<option>" ).html( nam ).val( nam ) )
                                    }
                                }
                            }
                        } )
                    }
                }, 100 )
            }
        },
        success: function( msg ) {
            if ( msg.indexOf( "PW認証できません" ) > -1 ) {
                $( "input#id" ).css( "background", "#ffcccc" );
                $( "input#pw" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + " : " + ( ( mode == "fav" ) ? "お気に入り" : "ディレクトリ" ) + "一覧の読み込みに失敗しました: ",
                    delay: 10000,
                    cls: "error"
                } )
            } else {
                if ( msg.indexOf( "OTP認証できません" ) > -1 ) {
                    $( "input#id" ).css( "background", "#eeffee" );
                    $( "input#pw" ).css( "background", "#eeffee" );
                    $( "input#pw2" ).css( "background", "#ffcccc" );
                    $.notifyBar( {
                        html: msg + " : " + ( ( mode == "fav" ) ? "お気に入り" : "ディレクトリ" ) + "一覧の読み込みに失敗しました: ",
                        delay: 10000,
                        cls: "error"
                    } )
                } else {
                    $( "input#id" ).css( "background", "#eeffee" );
                    $( "input#pw" ).css( "background", "#eeffee" );
                    $( "input#pw2" ).css( "background", "#eeffee" );
                    setTimeout( function() {
                        clearInterval( mytimer )
                    }, 100 );
                    setTimeout( function() {
                        $( "ul#" + mode + "slist" ).html( $( "ul#" + mode + "slist li" ).sort( function( a, b ) {
                            return ( $( a ).text() > $( b ).text() ) ? 1 : -1
                        } ) );
                        $.notifyBar( {
                            html: ( ( mode == "fav" ) ? "お気に入り" : "ディレクトリ" ) + "一覧を読み込みました",
                            delay: 10000,
                            cls: "success"
                        } )
                    }, 100 )
                }
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ) {
            console.log( "error" );
            console.log( "textStatus: " + textStatus );
            console.log( "errorThrown: " + errorThrown );
            clearInterval( mytimer );
            $.notifyBar( {
                html: ( ( mode == "fav" ) ? "お気に入り" : "ディレクトリ" ) + "一覧の読み込みに失敗しました: " + textStatus,
                delay: 10000,
                cls: "error"
            } )
        }
    } )
}

function pullfavmenu() {
    var mytimer = null;
    var isJSON = function( arg ) {
        arg = ( typeof arg === "function" ) ? arg() : arg;
        if ( typeof arg !== "string" ) {
            return false
        }
        try {
            arg = ( !JSON ) ? eval( "(" + arg + ")" ) : JSON.parse( arg );
            return true
        } catch ( e ) {
            return false
        }
    };
    $.ajax( {
        type: "post",
        url: "ls_fav.php?id=" + jQuery( "input#id" ).val() + "&pw=" + jQuery( "input#pw" ).val() + "&pw2=" + jQuery( "input#pw2" ).val(),
        cache: false,
        data: "onlyname=1&relapath=" + jQuery( "input#relapath" ).val() + "&_=" + Math.random(),
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
                                if ( typeof json.favname !== "undefined" ) {
                                    $( "table#favmenu tbody" ).append( "<tr><td><a href='?mode=simple&favname=" + htmlspecialcharsEntQuotes( json.favname ) + "'>" + htmlspecialcharsEntQuotes( json.favname ) + "</a></td>" + ( ( json.hassong ) ? ( " <td><span class='star' id='bookmarkstar" + json.id + "' alt='ブックマーク: 「" + htmlspecialcharsEntQuotes( json.favname ) + "」から解除します' title='ブックマーク: 「" + htmlspecialcharsEntQuotes( json.favname ) + "」から解除します' onClick='if(window.confirm(\"" + htmlspecialcharsEntQuotes( json.title ) + "をブックマーク: 「" + htmlspecialcharsEntQuotes( json.favname ) + '」から解除してよろしいですか？")){ $(function(){ $.get("?id=' + jQuery( "input#id" ).val() + "&mode=favdel&favname=" + htmlspecialcharsEntQuotes( json.favname ) + "&linkdel=" + htmlspecialcharsEntQuotes( json.relapath ) + '", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'> ★</span></td><td> </td>' ) : ( " <td> </td><td><span class='starw' id='bookmarkstar" + json.id + "' alt='ブックマーク: 「" + htmlspecialcharsEntQuotes( json.favname ) + "」に追加します' title='ブックマーク: 「" + htmlspecialcharsEntQuotes( json.favname ) + "」に追加します' onClick='if(window.confirm(\"" + htmlspecialcharsEntQuotes( json.title ) + "をブックマーク: 「" + htmlspecialcharsEntQuotes( json.favname ) + '」に追加してよろしいですか？")){ $(function(){ $.get("?id=' + jQuery( "input#id" ).val() + "&mode=favadd&favname=" + htmlspecialcharsEntQuotes( json.favname ) + "&linkadd=" + htmlspecialcharsEntQuotes( json.relapath ) + '", function(data){ var status = (data.indexOf("(!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); location.reload(); }); }); return false; }\'> ☆</span></td>' ) ) )
                                }
                            }
                        } )
                    }
                }, 100 )
            }
        },
        success: function( msg ) {
            if ( msg.indexOf( "PW認証できません" ) > -1 ) {
                $( "input#id" ).css( "background", "#ffcccc" );
                $( "input#pw" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + " : " + ( ( mode == "fav" ) ? "お気に入り" : "ディレクトリ" ) + "一覧の読み込みに失敗しました: ",
                    delay: 10000,
                    cls: "error"
                } )
            } else {
                if ( msg.indexOf( "OTP認証できません" ) > -1 ) {
                    $( "input#id" ).css( "background", "#eeffee" );
                    $( "input#pw" ).css( "background", "#eeffee" );
                    $( "input#pw2" ).css( "background", "#ffcccc" );
                    $.notifyBar( {
                        html: msg + " : お気に入り一覧の読み込みに失敗しました: ",
                        delay: 10000,
                        cls: "error"
                    } )
                } else {
                    $( "input#id" ).css( "background", "#eeffee" );
                    $( "input#pw" ).css( "background", "#eeffee" );
                    $( "input#pw2" ).css( "background", "#eeffee" );
                    setTimeout( function() {
                        clearInterval( mytimer )
                    }, 100 );
                    setTimeout( function() {
                        $.notifyBar( {
                            html: "お気に入り一覧を読み込みました",
                            delay: 10000,
                            cls: "success"
                        } )
                    }, 100 )
                }
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ) {
            console.log( "error" );
            console.log( "textStatus: " + textStatus );
            console.log( "errorThrown: " + errorThrown );
            clearInterval( mytimer );
            $.notifyBar( {
                html: "お気に入り一覧の読み込みに失敗しました: " + textStatus,
                delay: 10000,
                cls: "error"
            } )
        }
    } )
}

function pullls( url ) {
    var i = jQuery( "#sort_list li" ).length;
    var mytimer = null;
    var isJSON = function( arg ) {
        arg = ( typeof arg === "function" ) ? arg() : arg;
        if ( typeof arg !== "string" ) {
            return false
        }
        try {
            arg = ( !JSON ) ? eval( "(" + arg + ")" ) : JSON.parse( arg );
            return true
        } catch ( e ) {
            return false
        }
    };
    $.ajax( {
        type: "post",
        url: url,
        cache: false,
        data: "_=" + Math.random(),
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
                                if ( typeof json.title !== "undefined" ) {
                                    $( "ol#sort_list" ).append( "<li class='appended' id='track" + i + "'><a class='title' href='#' data-src='" + json.datasrc + "' title='" + json.datasrc + "'>" + json.title + "</a><br><span class='starw' id='bookmarkstar" + i + "' alt='お気に入りの管理' title='お気に入りの管理' onClick='window.open(\"?mode=favmenu&relapath=" + json.relapath + '", "favmenu");return false;\'>☆</span>　' + ( ( typeof json.favname === "undefined" ) ? "" : ( "<span class='star' id='bookmarkstar" + i + "' alt='お気に入りから外します' title='お気に入りから外します' onClick='if(window.confirm(\"" + htmlspecialcharsEntQuotes( json.title ) + " (" + htmlspecialcharsEntQuotes( json.basename ) + ')をお気に入りから外してよろしいですか？")){ $(function(){$("#track' + i + '").remove()}); $.get("?id=' + json.id + "&pw=" + json.pw + "&mode=favdel&favname=" + encodeURIComponent( json.favname ) + "&linkdel=" + json.relapath + '", function(data){ var status = (data.indexOf("!) ")==0) ? "error" : "success"; $.notifyBar({ html: data, delay: 10000, cssClass: status }); });return false; }\'>★</span>' ) ) + "<span class='del' id='delicon" + i + "' alt='プレイビューから外します' title='プレイビューから外します' onClick='if(window.confirm(\"" + htmlspecialcharsEntQuotes( json.title ) + " (" + htmlspecialcharsEntQuotes( json.basename ) + ')をプレイビューから外してよろしいですか？")){ $(function(){$("#track' + i + "\").remove()}); return false; }'>×</span><br>　<a class='artist' href='?favname=&mode=music&dirname=" + encodeURIComponent( json.artistdirtmp ) + "'>" + json.artist + "</a> &gt; <span class='trackinfo'><a class='album' href='?favname=&mode=music&dirname=" + encodeURIComponent( json.artistdirtmp ) + "&filter_album=" + encodeURIComponent( json.album ) + "'>" + json.album + "</a> (No.<span class='number'>" + ( ( json.number < 10 ) ? "0" + json.number : json.number ) + "</span>) [<span class='genre'>" + json.genre + "</span>] <span class='time'><span class='time_m'>" + json.time_m + "</span>:<span class='time_s'>" + json.time_s + "</span></span></span><br></li>" )
                                }
                            }
                            i++
                        } )
                    }
                }, 100 )
            }
        },
        success: function( msg ) {
            if ( msg.indexOf( "PW認証できません" ) > -1 ) {
                $( "input#id" ).css( "background", "#ffcccc" );
                $( "input#pw" ).css( "background", "#ffcccc" );
                $.notifyBar( {
                    html: msg + " : " + ( ( mode == "fav" ) ? "お気に入り" : "ファイル" ) + "一覧の読み込みに失敗しました: ",
                    delay: 10000,
                    cls: "error"
                } )
            } else {
                if ( msg.indexOf( "OTP認証できません" ) > -1 ) {
                    $( "input#id" ).css( "background", "#eeffee" );
                    $( "input#pw" ).css( "background", "#eeffee" );
                    $( "input#pw2" ).css( "background", "#ffcccc" );
                    $.notifyBar( {
                        html: msg + " : " + ( ( mode == "fav" ) ? "お気に入り" : "ファイル" ) + "一覧の読み込みに失敗しました: ",
                        delay: 10000,
                        cls: "error"
                    } )
                } else {
                    $( "input#id" ).css( "background", "#eeffee" );
                    $( "input#pw" ).css( "background", "#eeffee" );
                    $( "input#pw2" ).css( "background", "#eeffee" );
                    setTimeout( function() {
                        clearInterval( mytimer )
                    }, 100 )
                }
            }
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ) {
            console.log( "error" );
            console.log( "textStatus: " + textStatus );
            console.log( "errorThrown: " + errorThrown );
            clearInterval( mytimer );
            $.notifyBar( {
                html: textStatus,
                delay: 10000,
                cls: "error"
            } )
        }
    } )
}

function settweetstr( c ) {
    var b = jQuery( "input#sns_format" ).val();
    var a = b.replace( "%a", jQuery( "ol#sort_list li.playing .artist" ).text() );
    a = a.replace( "%g", jQuery( "ol#sort_list li.playing .genre" ).text() );
    a = a.replace( "%l", jQuery( "ol#sort_list li.playing .album" ).text() );
    a = a.replace( "%m", jQuery( "ol#sort_list li.playing .time_m" ).text() );
    a = a.replace( "%n", jQuery( "ol#sort_list li.playing .number" ).text() );
    a = a.replace( "%s", jQuery( "ol#sort_list li.playing .time_s" ).text() );
    a = a.replace( "%t", jQuery( "ol#sort_list li.playing .title" ).text() );
    if ( a.indexOf( "%u", 0 ) > -1 ) {
        jQuery.ajax( {
            type: "POST",
            url: "req/shortenuri.php",
            data: "uri=" + jQuery( "ol#sort_list li.playing .title" ).attr( "data-src" ),
            success: function( e, d ) {
                a = a.replace( "%u", e );
                if ( c == 1 ) {
                    jQuery( "textarea#tweettext" ).val( a )
                } else {
                    if ( c == 2 ) {
                        window.open( "tweet/tweet.php?pass_autotweet=" + jQuery( "select#pass_autotweet" ).val() + "&tweettext=" + encodeURIComponent( a ), "sns" )
                    }
                }
            }
        } )
    } else {
        if ( c == 1 ) {
            jQuery( "textarea#tweettext" ).val( a )
        } else {
            if ( c == 2 ) {
                window.open( "tweet/tweet.php?pass_autotweet=" + jQuery( "select#pass_autotweet" ).val() + "&tweettext=" + encodeURIComponent( a ), "sns" )
            }
        }
    }
}

function sortevent() {
    switch ( jQuery( "#pagesort" ).val() ) {
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
            break
    }
}
var arr = new Array();
var sortAsc = function( d, c ) {
    return d.key.localeCompare( c.key )
};
var sortDesc = function( d, c ) {
    return c.key.localeCompare( d.key )
};

function filename_u() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = basename( jQuery( "a[data-src]", this ).attr( "data-src" ) );
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function filename_d() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = basename( jQuery( "a[data-src]", this ).attr( "data-src" ) );
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function title_u() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = jQuery( "a[data-src]", this ).text();
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function title_d() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = jQuery( "a[data-src]", this ).text();
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function artist_u() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = jQuery( ".artist", this ).text();
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function artist_d() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = jQuery( ".artist", this ).text();
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function trackinfo_u() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = jQuery( ".trackinfo", this ).text();
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortAsc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function trackinfo_d() {
    jQuery( "ol#sort_list li" ).each( function( a ) {
        arr[ a ] = {};
        arr[ a ].key = jQuery( ".trackinfo", this ).text();
        arr[ a ].value = jQuery( this )
    } );
    arr.sort( sortDesc );
    for ( i = 0; i < arr.length; i++ ) {
        jQuery( "ol#sort_list" ).append( arr[ i ].value )
    }
}

function random() {
    jQuery( "ol#sort_list li" ).shuffle()
}( function( a ) {
    a.fn.shuffle = function( b ) {
        b = [];
        return this.each( function() {
            b.push( a( this ).clone( true ) )
        } ).each( function( d, c ) {
            a( c ).replaceWith( b[ d = Math.floor( Math.random() * b.length ) ] );
            b.splice( d, 1 )
        } )
    };
    a.shuffle = function( b ) {
        return a( b ).shuffle()
    }
} )( jQuery );
