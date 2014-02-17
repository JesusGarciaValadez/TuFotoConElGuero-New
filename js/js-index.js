var opacidad        = 0,
    verde           = new Array(),
    gris            = new Array(),
    boxes           = new Array('11', '21', '31', '41',
                      '12', '22', '32', '42', 
                      '13', '23', '33', '43'),
    crossv          = false,
    crossg          = false,
    imgv            = false,
    imgg            = false,
    ScrollableMenu  = false,
    counter         = 0,
    icounter        = 0;
    
    ConfigurarPantalla();
    
    //- Efectos hover
    //$('tabla-col a img').animate({"opacity" : 1});
    $('.tabla-col a img').hover( function( ) {
            $( this ).animate( { "opacity" : 0.5 } );
        }, function( ) {
            $( this ).animate( { "opacity" : 1 } );
        }
    );
    
    //-Control menu vertical
    $('#cssmenu > ul > li > a').on( 'click', function( e ){
        
        $('#cssmenu li').removeClass('active');
        $( e.currentTarget ).closest('li').addClass('active');
        
        var checkElement = $( e.currentTarget ).next();
        
        //-Para un elemento div
        if( ( checkElement.is( 'div' ) ) && ( checkElement.is( ':visible' ) ) ) {
            $( e.currentTarget ).closest( 'li' ).removeClass( 'active' );
            checkElement.slideUp( 'normal' );
            //Si contiene un div solo debe de cerrar y no perder el foco (mantener estado activo)
            ConfiguraScrollMenu( checkElement );
        }
        
        //-Para un elemento div
        if( ( checkElement.is( 'div' ) ) && ( !checkElement.is( ':visible' ) ) ) {
            
            $( '#cssmenu ul ul:visible' ).slideUp( 'normal' );
            checkElement.slideDown( 'normal', function( ) { ConfiguraScrollMenu( e.currentTarget ); } );
        }
        
        if( $( e.currentTarget ).closest('li').find('div').children().length == 0) {
            
            return true;
        } else {
            
            return false;
        }
    } );
    
    //-Control submenu vertical
    $( '#nav-evento > li > a' ).on( 'click', function ( e ) {
        
        if ( $( e.currentTarget ).attr( 'class' ) != 'active' ) {
            
            $( '#nav-evento li ul' ).slideUp( );
            $( e.currentTarget ).next().slideToggle( );
            $( '#nav-evento li a' ).removeClass( 'active' );
            $( e.currentTarget ).addClass( 'active' );
            //-Verificar el scroll
            ConfiguraScrollMenu( $( "#submenu-evento" ) );
        }
    } );
    
var OpenContacto    = function ( ) {
    
    //gallery to launch
    var id = "contato.html";
    //get the first item out of the cache
    //var content = Shadowbox.cache[1].content;
    //default options object
    var options = {}; 
    //now we can open it
    Shadowbox.open( {
        content:    "contacto.html",
        title:      "Contactanos",player:"html"
    } );
    
    return false;
};

//-Se ejecuta cuando se redimensiona la ventana del navegador
$( window ).resize( function( ) {
    
    ConfigurarPantalla();
} );

var ConfigurarPantalla  = function ( ) {
    ConfigurarPanel();
    ConfigurarDespliegueMenu();
    //-Verificar el scroll
    ConfiguraScrollMenu( $( "#submenu-evento" ) );
    
    //-jquery-resize
    //$(".contenedor").smartBackgroundResize({  image: 'img/dashboard/bg_dashboard.png' });//No aplica bien el estilo
                
    //- jquery-backstretch
    $( ".contenedor" ).backstretch( "img/dashboard/bg_dashboard.png" );
};

var ConfiguraScrollMenu = function ( div ) {
    
    var s               = "";
    var hScroll         = 0;
    var hMenuLateral    = $( ".menu-lateral" ).height();
    var hMenu           = $( "#cssmenu" ).height();
    var hMenuEvento     = $( div ).height();
    
    if( hMenu > hMenuLateral ) {
        
        $( "#cssmenu" ).css( "height", hMenuLateral - 1 );
        hScroll = hMenu - hMenuLateral;
        hScroll = hScroll + ( hMenuEvento - hMenuLateral );
        $( div ).css( "height", hScroll * - 1 );
        $( div ).css( "overflow", "hidden" );
        $( div ).perfectScrollbar( { suppressScrollX: true } );
    }
    
    //hScroll =  hMenuLateral - hMenu;
    
    //$(div).css("height", hMenuEvento + hScroll);
    
    //$("#nav-evento").css("height", hMenuEvento + hScroll);
    //$("#cssmenu").css("height", $(".menu-lateral").height());
    
    if( hMenu > hMenuLateral ) {
        //-Activar scroll
        //$(div).mCustomScrollbar({horizontalScroll:true, theme:"light"});
        //$(div).scroll();
        //$("#submenu-evento").scroll();
        /*$("#nav-evento").css("overflow", "hidden");
        $("#nav-evento").perfectScrollbar({suppressScrollX: true});*/
        //$('#nav-evento').perfectScrollbar('update');
    }
    
    s   = s + "MenuLateral:" + hMenuLateral + "<br/>";
    s   = s + "hMenu:" + hMenu + "<br/>";
    s   = s + $( div ).attr( 'id' ) + ":" + hMenuEvento +"<br/>";
    s   = s + "hScroll:" + hScroll +"<br/>";
    s   = s + "Scroll:" + ( hMenu > hMenuLateral ) +"<br/>";
    //$(".pie").html(s);
};

//- Funcion que se encarga de configurar el alto y ancho del panel de imagenes
var ConfigurarPanel     = function ( ) { 
    var sDatos  = "";
    var top     = 0;
    var left    = 0;
    var temp    = 0;
    var margen  =0;
    var div     = $( ".contenedor-panel" );
    
    /****************** Variables ancho de elementos ************************/
    var wContent        = 0;
    var wScreen         = $( window ).width();
    var wBarraIzq       = $( ".contenedor-izquierda" ).width();
    var wContentPanel   = $( div ).width();
    var wFondoPanel     = $( ".fondo-panel" ).width();
    
    /****************** Variables alto de elementos ************************/
    var hContent        = 0;
    var hScreen         = $( window ).height();
    //var hBarraIzq = $( ".contenedor-izquierda" ).height(); // Valorar si es necesaro ya que la altura del panel es mayor al menu
    var hContentPanel   = $( div ).height();
    var hFondoPanel     = $( ".fondo-panel" ).height();
    
    /************** Cálcular ancho de elementos ***************************/
    left                = Math.round( ( ( wScreen - wBarraIzq ) - wFondoPanel ) / 2 );
    
    //-Controlar el espaciado horizontal
    if( left < 4 ) {
        
        left    = 4;
        margen  = left * 2;
    } else {
        margen  = wScreen - wBarraIzq - wFondoPanel;
    }
    
    wContent    = wFondoPanel + margen;
    $( ".fondo-panel" ).css( "marginLeft", left );
    $( div ).css( "width", wContent );
    $( ".contenedor" ).css( "width", wContent + wBarraIzq );
    
    /************** Cálcular alto de elementos ***************************/
    top = Math.round( ( hScreen - hFondoPanel ) / 2 );
    
    //-Controlar el espaciado vertical
    if( top < 20 ) {
        top     = 20;
        margen  = top * 2;
    } else {
        margen  = hScreen - hFondoPanel;
    }
    
    hContent    = hFondoPanel + margen;
    $( ".fondo-panel" ).css( "marginTop", top );
    $( div ).css( "height", hContent );
};

//- Funcion para configurar la barra lateral de acuerdo a la resolución del navegador
var ConfigurarDespliegueMenu    = function ( ) { 
    //var sDatos ="";
    //var hMenu = 0;
    //var hScreen = $( window ).height(); 
    //var hLogo = $( ".contenedor-logotipo" ).height();
    //var hBuscador = $( ".contenedor-buscador" ).height();
    var hMenuNav = $( "#cssmenu" ).height();    
    //var hPie = $( ".pie" ).height();  
    var hElementos = ($( ".contenedor-logotipo" ).height() + $( ".contenedor-buscador" ).height() + $( ".pie" ).height() ); 
    var hDashboard = $( ".contenedor-panel" ).height();
    var div = $(".menu-lateral");   
        
    hMenuNav = hDashboard - hElementos; 
    
    $(div).css("height", hMenuNav);
};

/************************************************************************************************/
/************************************* CONTROL DE ANIMACIONES ***********************************/
/************************************************************************************************/
var ControlGaleria  = function ( ) { 
    verde[ 0 ]  = 0;
    verde[ 1 ]  = 0;
    verde[ 2 ]  = 1;//Tipo de animacion
    gris[ 0 ]   = 0;
    gris[ 1 ]   = 0;
    gris[ 2 ]   = 1;//Tipo de animacion
    AnimarCuadro( 0 );
    AnimarCuadro( 1 );
    setTimeout( "CambiarImagen()", 3000 ); 
};
var CambiarImagen   = function ( ) {
    
    var s       = "";
    var a       = Math.floor( Math.random() * 2 );
    //var x     = Math.floor( Math.random() * 4 ) + 1;
    //var y     = Math.floor( Math.random() * 3 ) + 1;
    
    var i       = Math.floor( Math.random() * boxes.length );
    var nombre  = boxes[ i ].toString( );
    
    boxes.splice( i, 1 );
    
    if( boxes.length    == 0 ) {
        boxes   = new Array( '11', '21', '31', '41',
                          '12', '22', '32', '42', 
                          '13', '23', '33', '43');
    }
    /*fotos.splice(index, 1);
    items = fotos.length;*/
    
    //var imgPrev = $("#img-" + y + '' + x );
    counter = counter + 1;
    
    if( counter > items ) {
        
        counter = 0;
        
        $.ajax ( 'masimagenes.php', {
            beforeSend: function ( jqXHR, settings ) {
                
            },
            cache: false,
            complete: function ( jqXHR, textStatus ) {
                
            },
            contentType: "application/x-www-form-urlencoded",  
            converters: {
                "* text":       window.String,
                "text html":    true,
                "text json":    $.parseJSON,
                "text xml":     $.parseXML
            },
            data: {
                
            },
            error:  function ( jqXHR, textStatus, errorThrown ) {
                
            },
            success: function ( data, textStatus, jqXHR ) {
                
                //var obj = $.parseJSON(data);
                fotos   = $.parseJSON( data );
                items   = fotos.length;
                
                //alert(items );
            },
            type: "POST"
        } );
    }
    
    //$('.pie span').html(nombre );
    crossv  = Cross( nombre, verde );
    crossg  = Cross( nombre, gris );
    AnimarImagen( nombre, a );
};
var AnimarCuadro    = function ( i ) { 
    
    var s ="";
    if( i == 0 ) {// Animar cuadro verde
        imgv        = true;
        verde[0]    = Math.floor( Math.random() * 4 ) + 1;
        verde[1]    = Math.floor( Math.random() * 3 ) + 1;
        CambiaFoto( $( "#img-" + verde[ 0 ] + '' + verde[ 1 ] ) );
        
        crossg      = Cross( verde[ 0 ] + '' + verde[ 1 ], gris );
        
        if( crossg ) {
            
            imgg        = true;
            gris[ 0 ]   = Math.floor( Math.random( ) * 4 ) + 1;
            gris[ 1 ]   = Math.floor( Math.random( ) * 3 ) + 1;
            CambiaFoto( $("#img-" + gris[0] + '' + gris[1] ));
        }
    } else {
        imgg        = true;
        gris[ 0 ]   = Math.floor( Math.random() * 4 ) + 1;
        gris[ 1 ]   = Math.floor( Math.random() * 3 ) + 1;
        CambiaFoto( $( "#img-" + gris[ 0 ] + '' + gris[ 1 ] ) );
        crossv      = Cross( gris[ 0 ] +'' + gris[ 1 ], verde );
        
        if( crossv ) {
            
            imgv        = true;
            verde[ 0 ]  = Math.floor( Math.random() * 4 ) + 1;
            verde[ 1 ]  = Math.floor( Math.random() * 3 ) + 1;
            CambiaFoto( $( "#img-" + verde[ 0 ] + '' + verde[ 1 ] ) );
        }
    }
};
var AnimarImagen    = function ( name, animacion ) {
    
    var imgPrev = $( "#img-" + name + '' );//x + '' + y );
    var m       = $( imgPrev ).attr( "mouse" );
    
    opacidad    =0.5;
    
    //if(crossv) AnimarCuadro(0);
    //if(crossg) AnimarCuadro(1);
    
    if ( m  =="0" )//Verificar que no tenga el cursor sobre la imagen
        if( crossv ) AnimarCuadro(0);
        if( crossg ) AnimarCuadro(1);
        
        switch( animacion ) {
            case 0:
                FlipVertical( imgPrev );
                break;
            case 1:
                DesvanecerAparecer( imgPrev );
                break;
            case 2:
                FlipHorizontal( imgPrev );
                break;
            case 3:
                SlideDerecho( imgPrev );
                break;
            case 4:
                TogleUp( imgPrev );
                break;
        }   
    
    //--Tiempo para la siguiente animación
    setTimeout( 'CambiarImagen()', 3000 );
};
var Cross   = function ( idimg, obj ) {
    var result  = false;
    var st      = idimg.toString();
    var x       = parseInt(str.substring(0,1));//11
    var y       = parseInt(str.substring(1));
     
    if ( x == obj[ 0 ] ) {
        
        if ( y == obj[ 1 ] ) {
            
            result = true;
        }
    }
    //$('.pie a').html(boxes.length+' : ' +idimg +': '+ x +', ' + y + '<br/>');
    
    return result;
};
var CambiaFoto  = function ( ctl ) {
    
    var index   =  Math.floor( Math.random( ) * items ); //indice de la imagen a mostrar
    var imgNew;
    var refNew  ="#";
    var alink   = $(ctl).parent();
    
    if ( imgv ) {
        
        imgNew  = "img/dashboard/cuadro-verde.png";
        imgv    = false;
    }
    else if( imgg ) {
        
        imgNew  = "img/dashboard/cuadro-gris.png";
        imgg    = false;
    }
    else{
        
        imgNew  = "imagenes/" + fotos[ index ][ 'directorio' ] + "/thumb" + fotos[ index ][ 'archivo' ];
        refNew  = "eventos.php?anio=" + fotos[ index ][ 'anio' ] + "&mes=" + fotos[ index ][ 'mes' ] + "&id=" + fotos[ index ][ 'evento' ] +"&foto=" +fotos[ index ][ 'foto' ];
    }
    
    fotos.splice( index, 1 );
    items   = fotos.length;
    
    //$('.pie a').html(counter + ' ' + items);
    
    $( alink ).attr( "href", refNew );
    $( ctl ).attr( "src", imgNew );
};
var FlipHorizontal  = function ( imgPrev ) {
    var margin  = $( imgPrev ).width( ) / 2;
    var ancho   = $( imgPrev ).width( );
    var alto    = $( imgPrev ).height( );
    
    $( imgPrev ).animate( {
        width:      '0px',
        height:     ''+alto+'px',
        marginLeft: ''+margin+'px',
        opacity:    opacidad
    }, { 
        duration:   200
    } );
    
    setTimeout( function( ) {
        
        CambiaFoto(imgPrev);
        $( imgPrev ).animate( { 
            width:      ''+ancho+'px',
            height:     ''+alto+'px',
            marginLeft: '0px',
            opacity:    '1'
        }, { 
            duration:   200
        } );
    }, 200 );
};
var FlipVertical    = function ( imgPrev ) {
    var margin  = $( imgPrev ).height( ) / 2;
    var anch    = $( imgPrev ).width( );
    var alto    = $( imgPrev ).height( );
    
    $( imgPrev ).animate( {
        width:''+ancho+'px',
        height:'0px',
        marginTop:''+margin+'px',
        opacity:opacidad
    }, { duration:200 } );
    
    setTimeout( function() {
        
        CambiaFoto(imgPrev);
        $(imgPrev).animate({width:''+ancho+'px',height:''+alto+'px',marginTop:'0px',opacity:'1'},{duration:200});
    }, 200);
};
var DesvanecerAparecer  = function ( imgPrev ) {
    
    $(imgPrev).fadeOut( 600, function( ) {
        
        CambiaFoto(this);
    } );
    
    $(imgPrev).fadeIn(600).delay(300);
};
var SlideDerecho    = function ( imgPrev ) {
    
    var ancho   = $( imgPrev ).width();
    var alto    = $( imgPrev ).height();
    
    $( imgPrev ).animate( {
        width:          '0px', 
        height:         '' + alto + 'px',
        marginRight:    '' + ancho +'px',
        opacity:        opacidad
    }, {
        duration:700,
        complete: function( ) { 
            CambiaFoto(imgPrev);
        }
    } );
    
    $(imgPrev).animate( {
        width:      '' + ancho + 'px',
        height:     '' + alto + 'px',
        marginRight:'0px',
        opacity:    '1'
    }, {
        duration:   800
    } );
};
var TogleUp = function ( imgPrev ) {
    var ancho   = $( imgPrev ).width();
    var alto    = $( imgPrev ).height();
    
    $( imgPrev ).animate( {
        width:      '' + ancho + 'px',
        height:     '0px',
        marginTop:  '-' + alto + 'px',
        opacity:    opacidad
    }, {
        duration:   700,
        complete:   function( ) {
            CambiaFoto( imgPrev );
        }
    } );
    
    $(imgPrev).animate( {
        width:      '' + ancho + 'px',
        height:     '' + alto + 'px',
        marginTop:  '0px',
        opacity:    '1'
    }, {
        duration:   800
    } );
};
var onOver  = function ( obj ){
    
    $( obj ).attr( "mouse", "1" );
};
var onOut   = function ( obj ) {
    
    $( obj ).attr( "mouse", "0" );
};
var onBefore = function ( ) {};
var onAfter = function ( ) {};
var blurElement = function ( element, size ) {
    
    var filterVal   = 'blur(' + size + 'px)';
    $( element ).css( {
        'filter':       filterVal,
        'webkitFilter': filterVal,
        'mozFilter':    filterVal
        'oFilter':      filterVal,
        'msFilter':     filterVal
    } );
};