var mousewheelevt               = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"; //FF doesn't recognize mousewheel as of FF3.x

var ExpandirMenu                = function( anio ) {
    if ( anio != 0 ) {
        
        var strMenu         = "submenu-" + anio;
        var menu            = $( "#" + strMenu );
        $( '#csssubmenu li' ).removeClass( 'active' );
        $( menu ).closest( 'li' ).addClass( 'active' );
        var checkElement    = $( menu ).next();
        if ( ( checkElement.is( 'ul' ) ) && ( checkElement.is( ':visible' ) ) ) {
            $( menu ).closest( 'li' ).removeClass('active');
            checkElement.slideUp('normal');
        }
        if ( ( checkElement.is( 'ul' ) ) && ( !checkElement.is( ':visible' ) ) ) {
            $( '#csssubmenu ul ul:visible' ).slideUp( 'normal' );
            checkElement.slideDown( 'normal' );
        }
        //alert( menu );
    }
};

var subir                       = function() {
    
    ++paginas;
    scrolled    = scrolled + hScreen;
    if ( paginas >= $( ".tabla-pagina" ).length ) {
        
        paginas     = $( ".tabla-pagina" ).length;
        scrolled    = ( hScreen ) * ( paginas - 1 );
        $( ".more" ).fadeOut( 200 );
    }
    $( ".contenedor-panel" ).animate( {
        scrollTop: scrolled
    }, 700, function () {
        
        $("#morelnk").fadeIn( 130 ).delay( 700 );
        //$(".more").html("<a href='#' id='morelnk'  >+EVENTOS</a>").delay(100);
    } );
    //sDatos= sDatos + "pagina  " + paginas + "de " + $(".tabla-pagina").length + " <br>";
    $( ".arriba" ).fadeIn( 200 );
};

var bajar                       = function() {
    //verifico si el de mas evento esta activo
    if ( paginas >= $( ".tabla-pagina" ).length ) {
        
        $( ".more" ).fadeIn( 200 );
    }
    if ( paginas > 1 ) {
        
        --paginas;
        scrolled = scrolled - hScreen;
    } else {
        
        paginas = 1;
        scrolled = 0;
    }
    if ( paginas == 1 ) {
        
        $( ".arriba" ).fadeOut( 200 );
    }
    $( ".contenedor-panel" ).animate( {
        scrollTop: scrolled
    }, 700, function () {
        
        $( "#menoslnk" ).fadeIn( 130 ).delay( 700 );
        //$(".arriba").html("<a href='#' id='menoslnk'  >ARRIBA</span>").delay(100);
    } );
};

var operaEvento                 = function( evento ){
    
    evento.preventDefault();
    if (lightbox) {
        return;
    }
    if (evento.which == 38) { //baja
        bajar();
    }
    if (evento.which == 40) { //sube
        subir();
    }
};

//- Funcion que se encarga de configurar el alto y ancho del panel de imagenes
var ConfigurarScroller          = function() {
    var sDatos = "";
    var hDashboard = 0;
    var wDashboard = 0;
    var top = 0;
    var left = 0;
    hScreen = $(window)
        .height();
    var wScreen = $(window)
        .width();
    var hBarraIzq = $(".contenedor-izquierda")
        .height();
    var wBarraIzq = $(".contenedor-izquierda")
        .width();
    //console.log("ajustando"+hScreen);
    var div = $(".contenedor-panel");
    top = Math.round((hScreen - 585) / 2);
    top2 = Math.round((hScreen - 638 - 86) / 2);
    left = Math.round(((wScreen - wBarraIzq) - 726) / 2);
    wDashboard = wScreen - wBarraIzq;
    hDashBoard = hBarraIzq;
    $(".contenedor-panel")
        .css("width", wDashboard);
    $(".contenedor-panel")
        .css("height", hScreen);
    //ocultamos los scroll
    $(".contenedor-panel")
        .css("overflow", "hidden");
    //asignamos el alto para todas la paginas 
    $(".tabla-pagina")
        .height(hScreen);
    //$(".tabla-pagina").css("line-height", hScreen);
    //$(".tabla-pagina").css("padding-top", top2 );
    $(".fondo-eventos")
        .css("padding-top", top2);
    $(".regresarXdia")
        .css("top", top2 * -1);
};
//- Funcion para configurar la barra lateral de acuerdo a la resolución del navegador
var ConfigurarDespliegueMenu    = function() {
    
    var sDatos = "";
    var hMenu = 0;
    var hScreen = $(window)
        .height();
    var hLogo = $(".contenedor-logotipo")
        .height();
    var hBuscador = $(".contenedor-buscador")
        .height();
    var hMenuNav = $("#cssmenu")
        .height();
    var hPie = $(".pie")
        .height();
    var hElementos = (hLogo + hBuscador + hPie); //-  Margen de error a considerar +1
    var div = $(".menu-lateral");
    hMenu = hScreen - hElementos;
    hMenuNav = hMenuNav + hElementos;
    /*Falta considerar el tamaño del panel de fotos*/
    if (hScreen > hMenuNav)
    {
        $(div)
            .css("height", hMenu);
    }
    else
    {
        if (hScreen < $(".fondo-panel")
            .height())
        {
            $(div)
                .css("height", $(".fondo-panel")
                    .height());
        }
        else
        {
            $(div)
                .css("height", $(".fondo-panel")
                    .height());
        }
    }
    //marcar  anio 
};

var blurElement                 = function( element, size ) {
    
    var filterVal = 'blur(' + size + 'px)';
    $(element)
        .css('filter', filterVal)
        .css('webkitFilter', filterVal)
        .css('mozFilter', filterVal)
        .css('oFilter', filterVal)
        .css('msFilter', filterVal);
};

var getURLParam                 = function( strParamName ) {
    var strReturn = "";
    var strHref = window.location.href;
    var bFound = false;
    var cmpstring = strParamName + "=";
    var cmplen = cmpstring.length;
    if (strHref.indexOf("?") > -1)
    {
        var strQueryString = strHref.substr(strHref.indexOf("?") + 1);
        var aQueryString = strQueryString.split("&");
        for (var iParam = 0; iParam < aQueryString.length; iParam++)
        {
            if (aQueryString[iParam].substr(0, cmplen) == cmpstring)
            {
                var aParam = aQueryString[iParam].split("=");
                strReturn = aParam[1];
                bFound = true;
                break;
            }
        }
    }
    if (bFound == false) return null;
    return strReturn;
};

var get_mes                     = function( $number ) {
    
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    return meses[$number - 1];
};

//-Se ejecuta cuando el documento esta listo para cargar el documento
$( document ).ready( function () {
    
    ConfigurarScroller();
    $( "#msg" ).fadeOut( 2000 );
    $( ".arriba" ).fadeOut( 1000 );
    $( ".span_overlay" ).fadeOut( 20 );
    $( document ).keydown( operaEvento );
    $( "#morelnk" ).click( function ( e ) {
        subir();
        e.preventDefault();
    } );
    $( "#menoslnk" ).click( function ( e ) {
        bajar();
        e.preventDefault();
    } );
} );

//  Controla el evento mousewheel para hacer el scroll de la pantalla
//$( document ).bind( mousewheelevt, function ( e ) {
var delta       = 0,
    prevDelta   = 0,
    paginas     = 1,
    tool        = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

/*$( document ).on( mousewheelevt, function ( e ) {
    e.preventDefault();
    e.stopPropagation();

    if ( lightbox ) {
        return;
    }
    var evt     = window.event || e //equalize event object
    evt         = evt.originalEvent ? evt.originalEvent : evt; //convert to originalEvent if possible
    if ( delta === 0 ) {
        delta   = evt.detail ? evt.detail * ( -40 ) : evt.wheelDelta //check for detail first, because it is used by Opera and FF
    }
    console.log( tool );
    
    setTimeout( function () {
        
        console.log( 'begin' );
        if ( delta > 0 && delta >= prevDelta ) {
            
            if ( paginas < 1 ) {
                return;
            }
            bajar();
            if ( delta != prevDelta ) {
                prevDelta   = tool;
            } else {
                prevDelta++;
            }
        }
        if ( delta > 0 && delta <= prevDelta ) {
            
            if ( paginas >= $( ".tabla-pagina" ).length ) {
                return;
            }
            subir();
            if ( delta != prevDelta ) {
                prevDelta   = tool;
            } else {
                prevDelta--;
            }
        }
    }, 400 );

} );*/

//-Se ejecuta cuando el documento esta cargado o en la cache
$( window ).load( function () {} );

//-Se ejecuta cuando se redimensiona la ventana del navegador
$( window ).resize( function () {
    ConfigurarScroller();
} );