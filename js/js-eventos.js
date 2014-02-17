
var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"; //FF doesn't recognize mousewheel as of FF3.x
//-Se ejecuta cuando el documento esta listo para cargar el documento
$(document).ready(function(){
	
	ConfigurarDespliegueMenu();
	ConfigurarScroller();

   $("#msg").fadeOut(2000 ); 
	$(".arriba").fadeOut(1000 );
	$(".span_overlay").fadeOut(20 );

 
	$(document).keydown(operaEvento);
				
$(".tabla-col").mouseenter(function(e){
	 	$a = $(this).find('.span_overlay');
  		$a.fadeIn(200 );
  		e.preventDefault();
});
$(".tabla-col").mouseleave(function(e){
  	//$(".overlay").fadeOut(200 );
  	$a = $(this).find('.span_overlay');
  	$a.fadeOut(200 );
  	e.preventDefault();
});
	


$( ".a-fblightbox" ).click(function(e) { 					
	
		var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";      	
      				var url="http://www.facebook.com/sharer.php?u=" + plugin.settings.imageUrl;
					
					nueva=window.open(url, 'Comparte en Fb', caracteristicas);
					
					e.preventDefault();
					
});	

		 

$( "#morelnk" ).click(function(e) {  					
	subir();
  	e.preventDefault();
});
	 
$( "#menoslnk" ).click(function(e) {  					
	bajar();
  	e.preventDefault();
});
	 	

	
	//-Control menu vertical
	$('#cssmenu > ul > li > a').click(function() {
		$('#cssmenu li').removeClass('active');
		$(this).closest('li').addClass('active');	
		
		var checkElement = $(this).next();
		
				
		//-Para un elemento div
		if((checkElement.is('div')) && (checkElement.is(':visible'))) {
			$(this).closest('li').removeClass('active');
			checkElement.slideUp('normal');		
		}
		
				
		//-Para un elemento div
		if((checkElement.is('div')) && (!checkElement.is(':visible'))) {
			$('#cssmenu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');		
		}
		
		//alert($(this).closest('li').find('div').children().length);
		
		if($(this).closest('li').find('div').children().length == 0) {
			return true;
		} else {
			return false;	
		}	  	
	});
	
	//-Control submenu vertical
	$('#csssubmenu > ul > li > a').click(function() {
		$('#csssubmenu li').removeClass('active');
		$(this).closest('li').addClass('active');	
		var checkElement = $(this).next();
		
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(this).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
		
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#csssubmenu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		}
		
		if($(this).closest('li').find('ul').children().length == 0) {
			return true;
		} else {
			return false;	
		}		
	});
	
//marcar anio y mes activo
var anio = getURLParam("anio");
var mes = getURLParam("mes");



var $link = $("#csssmenu ul > li > a:contains('"+ anio +"')");


var $linkMes = $("#csssmenu ul > li > a:contains('"+ get_mes(mes) +"')");

$span = $link.find('span');
$spanMenu = $linkMes.find('span');

 	
	$link.css( "font-weight", "700" );
	$link.css( "text-shadow", "0 1px 1px #000" );	
	$link.css( "background", "url(css/img/icon_arrow_right.png) 70% center no-repeat" );
	$span.css( "text-decoration", "underline" );
	
	
	$linkMes.css( "color" , "#73E264" );
	$linkMes.css( "font-weight" , "500" );
	$linkMes.css( "text-shadow", "0 1px 1px #000" );
	$spanMenu.css( "text-decoration", "underline" );
	
//fin amrcado

$(".mes_activoo").mouseenter(function(e){
		var $link = $(this);
		$link.css( "font-weight", "100" );
		$linkMes.css( "color" , "#73E264" );
		$link.css( "text-shadow", "none" );
				
		$span = $link.find('span');				    
		$span.css( "text-decoration", "none" );
		 		
});
$(".mes_activoo").mouseleave(function(e){
		var $link = $(this);		
  		$(this).css( "font-weight", "500" );
  		$(this).css( "text-shadow", "0 1px 1px #000");
  		$linkMes.css( "color" , "#73E264" );
  		$span = $link.find('span');		
		$span.css( "text-decoration", "underline" );
  		
});

$(".anio_activoo").mouseenter(function(e){
		var $link = $(this);
		$link.css( "font-weight", "100" );
		$link.css( "text-shadow", "none" );
		$link.css( "background", "url(css/img/icon_arrow_right.png) 70% center no-repeat" );
		
		$span = $link.find('span');				    
		$span.css( "text-decoration", "none" );
		
		 		
});
$(".anio_activoo").mouseleave(function(e){
		var $link = $(this);		
  		$(this).css( "font-weight", "700" );
  		$(this).css( "text-shadow", "0 1px 1px #000");
  		
  		$span = $link.find('span');		
		$span.css( "text-decoration", "underline" );
  		
});
	
});

function ExpandirMenu(anio){
	
	if(anio!=0 ){
		var strMenu = "submenu-"+anio;	
		var menu = $("#"+strMenu);	
		$('#csssubmenu li').removeClass('active');
		$(menu).closest('li').addClass('active');	
		var checkElement = $(menu).next();
		
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(menu).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
		
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#csssubmenu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		}
		//alert(menu);
	}
}
	
$(document).bind(mousewheelevt, function(e)  {
	
		if (lightbox ) { return; }
	
	
	
        var evt = window.event || e //equalize event object     
        evt = evt.originalEvent ? evt.originalEvent : evt; //convert to originalEvent if possible               
        var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta //check for detail first, because it is used by Opera and FF
        if(delta > 0) 
            {            
            if ( paginas <= 1)	{		return;	}
            bajar();
            e.preventDefault();
            }
        else
            {
            	if ( paginas >= $(".tabla-pagina").length)	{		return;	}	
            	subir();
            	e.preventDefault();
            }   
    }
);




function  subir() {
	
	
	paginas=paginas+1;
	scrolled = scrolled + hScreen ;
		
	if ( paginas >= $(".tabla-pagina").length)	{
		paginas=$(".tabla-pagina").length;
		scrolled= (hScreen)*(paginas-1); 
		$(".more").fadeOut(200 );		
	}	
	$(".contenedor-panel").animate({ scrollTop: scrolled},700,
		function  () { 
			$("#morelnk").fadeIn(130).delay(700);
			//$(".more").html("<a href='#' id='morelnk'  >+EVENTOS</a>").delay(100);
		}
	);	
	
	//sDatos= sDatos + "pagina  " + paginas + "de " + $(".tabla-pagina").length + " <br>";
	$(".arriba").fadeIn(200 );
		
}


  
function  bajar() {
		
	//verifico si el de mas evento esta activo
	if ( paginas >= $(".tabla-pagina").length)	{
		$(".more").fadeIn(200 );
	}

	if (paginas > 1 ) { 
		paginas=paginas-1; 
		scrolled = scrolled - hScreen ;
	}
	else  { 
		paginas = 1 ;		
		scrolled = 0 ; 
	}
	if ( paginas==1) {
		$(".arriba").fadeOut(200);
	}	
	$(".contenedor-panel").animate({ scrollTop: scrolled },700, 
		function () { 
			$("#menoslnk").fadeIn(130).delay(700);
			//$(".arriba").html("<a href='#' id='menoslnk'  >ARRIBA</span>").delay(100);
			}
	);		
	
		
}
	
	
function operaEvento(evento){
	evento.preventDefault();	
	
		if (lightbox ) { return; }
	
	
   if (evento.which ==38 ) { //baja
   	bajar();
   }
   if (evento.which ==40 ) {//sube
   subir();
   }
}
	
//-Se ejecuta cuando el documento esta cargado o en la cache
$(window).load(function(){
	
});

//-Se ejecuta cuando se redimensiona la ventana del navegador
$(window).resize(function() {
	ConfigurarScroller();
	ConfigurarDespliegueMenu();
	
});


//- Funcion que se encarga de configurar el alto y ancho del panel de imagenes
function ConfigurarScroller(){
	var sDatos="";
	var hDashboard=0;
	var wDashboard=0;
	var top=0;
	var left =0;
	var hScreen = $( window ).height();
	var wScreen = $( window ).width();
	var hBarraIzq = $( ".contenedor-izquierda" ).height();
	var wBarraIzq = $( ".contenedor-izquierda" ).width();
	
	var div = $(".contenedor-panel");
	
	top = Math.round((hScreen - 585 )/2);
	top2 = Math.round((hScreen - 585 -54)/2);
	left = Math.round(( (wScreen-wBarraIzq) - 726 )/2);


	
	wDashboard = wScreen-wBarraIzq;
	hDashBoard = hBarraIzq;
	$(".contenedor-panel").css("width", wDashboard);
	$(".contenedor-panel").css("height", hScreen);
				
	//ocultamos los scroll
	$(".contenedor-panel").css("overflow", "hidden");
	 
	//asignamos el alto para todas la paginas 
	$(".tabla-pagina" ).height( hScreen );
	//$(".tabla-pagina").css("line-height", hScreen);
	$(".tabla-pagina").css("padding-top", top2 );	
	
	
}
//- Funcion para configurar la barra lateral de acuerdo a la resolución del navegador
function ConfigurarDespliegueMenu(){
	var sDatos ="";
	var hMenu = 0;
	var hScreen = $( window ).height(); 
	var hLogo = $( ".contenedor-logotipo" ).height();
	var hBuscador = $( ".contenedor-buscador" ).height();
	var hMenuNav = $( "#cssmenu" ).height();	
	var hPie = $( ".pie" ).height();	
	var hElementos = (hLogo + hBuscador + hPie); //-  Margen de error a considerar +1
	var div = $(".menu-lateral");	
	
	hMenu = hScreen - hElementos;
	
	
	
	hMenuNav = hMenuNav + hElementos;
	
	/*Falta considerar el tamaño del panel de fotos*/
	if(hScreen > hMenuNav){
		$(div).css("height", hMenu);
	}
	else{
		if( hScreen < $( ".fondo-panel" ).height() ) {
			$(div).css("height", $( ".fondo-panel" ).height() );
		}
		else{
			$(div).css("height", $( ".fondo-panel" ).height() );
		}
	}	
	
//marcar  anio 
	
}



function blurElement(element, size){
var filterVal = 'blur('+size+'px)';
$(element)
.css('filter',filterVal)
.css('webkitFilter',filterVal)
.css('mozFilter',filterVal)
.css('oFilter',filterVal)
.css('msFilter',filterVal);
}


function getURLParam (strParamName){
	  var strReturn = "";
	  var strHref = window.location.href;
	  var bFound=false;
	  
	  var cmpstring = strParamName + "=";
	  var cmplen = cmpstring.length;

	  if ( strHref.indexOf("?") > -1 ){
	    var strQueryString = strHref.substr(strHref.indexOf("?")+1);
	    var aQueryString = strQueryString.split("&");
	    for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
	      if (aQueryString[iParam].substr(0,cmplen)==cmpstring){
	        var aParam = aQueryString[iParam].split("=");
	        strReturn = aParam[1];
	        bFound=true;
	        break;
	      }
	      
	    }
	  }
	  if (bFound==false) return null;
	  return strReturn;
	}


function get_mes ($number) {
	
	var meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	return meses[$number-1];
	}