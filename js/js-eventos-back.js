//-Se ejecuta cuando el documento esta listo para cargar el documento
$(document).ready(function(){
	ConfigurarDespliegueMenu();
	ConfigurarScroller();
	
	$("#morelnk").on("click" ,function(){			
			$(".contenedor-panel").animate({ scrollTop: 931});			
			$(".arriba").css("visibility", "visible");		 
			
			
	});
	
	$("#menoslnk").on("click" ,function(){			
			$(".contenedor-panel").animate({ scrollTop: -931},4000);			
			$(".arriba").css("visibility", "visible");			
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


	
//-Se ejecuta cuando el documento esta cargado o en la cache
/*$(window).load(function(){
	
});*/

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
	var total =0;
	var div = $(".contenedor-panel");
	
	top = Math.round((hScreen - $( ".fondo-panel" ).height() )/2);
	left = Math.round(( (wScreen-wBarraIzq) - $( ".fondo-panel" ).width() )/2);
	
	//-Solo parea el test de la resolucion
	sDatos= "<br/>";
	sDatos = sDatos + "hScreen:" + hScreen + "<br/>";
	sDatos = sDatos + "wScreen:" + wScreen + "<br/>";
		
	sDatos = sDatos + "wFull:" + (wScreen-wBarraIzq) + "<br/>";
	
	
	wDashboard = wScreen-wBarraIzq;
	hDashBoard = hBarraIzq;
	$(".contenedor-panel").css("width", wDashboard);
	$(".contenedor-panel").css("height", hScreen);
				
	//ocultamos los scroll
	$(".contenedor-panel").css("overflow", "hidden"); 
	//asignamos el alto para todas la paginas 
	$(".tabla-pagina" ).height( hScreen );
		
	
	//-Para testear resolucion
	//$(".buscador").html(sDatos);
	//$(".buscador").html($(".contenedor-panel").scrollTop());
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
	
	//- Solo para el test de resolucion
	sDatos ="hScreen:" + hScreen + "<br/>";
	sDatos = sDatos + "hLogo:" + hLogo + "<br/>";
	sDatos = sDatos + "hBuscador:" + hBuscador + "<br/>";
	sDatos = sDatos + "hMenuPrev:" + hMenuNav + "<br/>";
	sDatos = sDatos + "hMenu:" + $( ".menu-lateral" ).height() + "<br/>";
	sDatos = sDatos + "hPie:" + hPie + "<br/>";
	sDatos = sDatos + "hMenuResize"+ hMenu + "<br/>";
	sDatos = sDatos + "hComplete:"+ (hElementos + hMenuNav) + "<br/>";
	
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
	
	//-Para testear resolucion
	//$(".contenedor-derecha").html(sDatos);
}
