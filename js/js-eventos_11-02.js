

var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
//-Se ejecuta cuando el documento esta listo para cargar el documento
$(document).ready(function(){
	
	ConfigurarDespliegueMenu();
	ConfigurarScroller();

   $("#msg").fadeOut(2000 ); 
	$(".arriba").fadeOut(1000 );
	 $(document).keydown(operaEvento);
	 	
	$("#morelnk").on("click" ,function(e){
		e.preventDefault();
		subir();			
	});
	
	$("#menoslnk").on("click" ,function(e){	
		e.preventDefault();
		bajar();			
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
});


	
$(document).bind(mousewheelevt, function(e)  {
        var evt = window.event || e //equalize event object     
        evt = evt.originalEvent ? evt.originalEvent : evt; //convert to originalEvent if possible               
        var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta //check for detail first, because it is used by Opera and FF
        if(delta > 0) 
            {
            bajar();
            }
        else
            {
            subir();
            }   
    }
);

function  subir() {

	paginas=paginas+1;
	scrolled = scrolled + hScreen ;
		
	if ( paginas >= $(".tabla-pagina").length)	{
		$(".more").fadeOut(2000 );
	}	
	$(".contenedor-panel").animate({ scrollTop: scrolled},700);	
	
	//sDatos= sDatos + "pagina  " + paginas + "de " + $(".tabla-pagina").length + " <br>";
	$(".arriba").fadeIn(2000 );
		
}


  
function  bajar() {
		
	//verifico si el de mas evento esta activo
	if ( paginas >= $(".tabla-pagina").length)	{
		$(".more").fadeIn(2000 );
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
		$(".arriba").fadeOut(2000);
	}	
	$(".contenedor-panel").animate({ scrollTop: scrolled },700);		
	
		
}
	
	
function operaEvento(evento){
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
	
	top = Math.round((hScreen - 492 )/2);
	top2 = Math.round((hScreen - 492 -54)/2);
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
	
	
}
