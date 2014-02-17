/**
 * Cambia la opacidad de las imagenes de la galeria cuando no se esta sobre ellas al valor pasado como parametro.
 * 
 * @param opacidad Valor entre 0 y 1 que determinara la opacidad de la imagen.
 *  
 */
var numeroFila=2;
function cambiarOpacidadImagenes(opacidad){
    $(document).ready(function(){    
    
    var consulta;
    var d = new Date();
                                                                          
         //hacemos focus al campo de búsqueda
        
        $("#resultado").hide(1000);        
        $("#inputDate").val(d.getDate()+ '/'+(d.getMonth()+1)+'/'+d.getFullYear());
        
                                                                                   
        //comprobamos si se pulsa una tecla
        $("#busqueda").keyup(function(e){                                     
              //obtenemos el texto introducido en el campo de búsqueda
              consulta =$.trim(  $("#busqueda").val());

			if ( consulta.length ) {                                                             
			              //hace la búsqueda
			              var n = consulta.match('delete') ;
			              
			              if ( n == -1) { 
			              
			              		$("#resultado").empty();
			                  $("#resultado").show(1000);
			                  $("#resultado").append("No se permite la injeccion de codigo SQL [delete]" + n );
			                          
			              }
			              else {                                                                     
				              $.ajax({
				                    type: "POST",
				                    url: "buscar.php",
				                    data: "b="+consulta,
				                    dataType: "html",
				                    beforeSend: function(){
				                          //imagen de carga
				                          $("#resultado").html("<p align='center'><img src='imagenes/ajax-loader.gif' /></p>");
				                    },
				                    error: function(){
				                          alert("error petición ajax");
				                    },
				                    success: function(data){                                                    
				                          $("#resultado").empty();
				                          $("#resultado").show(1000);
				                          $("#resultado").append(data);
				                                                             
				                    }
				              });
			           		}
			}
			else {
			               	$("#resultado").hide(1000);
			}              
              
              
                                                                   
        });
    
	 
     
	    
	    
    $(".a-borrar").click(function () {
      	 $("#busqueda").val("");
      	 $("#resultado").hide(1000);
      	return false;
	 });
	    
   // Inicio funciones de Compartir albunes  
    $("a[rel='pop-upg+']").click(function () {
      	var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open("https://plus.google.com/share?url=" + $(location).attr('href'), 'Comparte en g+', caracteristicas);
      	return false;
	 });
	  
    $("a[rel='pop-uptw']").click(function () {
      	var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open( "http://twitter.com/share", 'Comparte en twiter', caracteristicas);
      	return false;
	 });
 
 
    $("a[rel='pop-upfb']").click(function () {
      	var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	
      	var url="http://www.facebook.com/sharer.php?u=" + $(location).attr('href');
      	//var titulo=		"&p[title]=" +	$('meta[property="og:title"]').attr('content');
      	//var sumary=		"&p[summary]="+	$('meta[property="og:description"]').attr('content');
      	//var imagen1= 	"&p[images][0]=" +	$('meta[property="og:image"]').attr('content');
      	//var imagen2=	"&p[images][1]=" +$('meta[property="og:image1"]').attr('content');
      	
      	
      	//var lnk= url +  titulo + sumary + imagen1 + imagen2;
      	nueva=window.open(url, 'Comparte en Fb', caracteristicas);
      	
      	return false;
	 });
 
 //Termina Funciones de compartir albunes 
 //Inicia funciones de socilaes pro fotos 
    $(".a-fblightbox").click(function () {
      	var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	
      	var url="http://www.facebook.com/sharer.php?s=100&p[url]=" + $(location).attr('href');
      	var titulo=		"&p[title]=" +	$('meta[property="og:title"]').attr('content');
      	var sumary=		"&p[summary]="+	$('meta[property="og:description"]').attr('content');
      	var imagen1= 	"&p[images][0]=" +	$('meta[property="og:image"]').attr('content');
      	var imagen2=	"&p[images][1]=" +$('meta[property="og:image1"]').attr('content');
      	
      	
      	var lnk= url +  titulo + sumary + imagen1 + imagen2;
      	aleret( lnk);
      	//nueva=window.open(lnk, 'Comparte en Fb', caracteristicas);
      	
      	//var lnk ="http://www.facebook.com/sharer.php?s=100&p[url]=http://tufotoconelguero.com/sitio/" + $('#sb-player').attr('src')+ "&p[title]=" + $('meta[property="og:title"]').attr('content') + "&p[summary]=" + $('meta[property="og:description"]').attr('content') + "&p[images][0]=" + $('#sb-player').attr('src') ;      	
      	//nueva=window.open(lnk , "Popup", caracteristicas);
      	return false;
	 });
	 
     $(".a-twlightbox").click(function () {
      	var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open( "http://twitter.com/share", 'Comparte en twiter', caracteristicas);
      	return false;
	 });
	 
	  $(".a-gPluslightbox").click(function () {
      	var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open("https://plus.google.com/share?url=" + $(location).attr('href'), 'Comparte en g+', caracteristicas);
      	return false;
	 });
	 

	 
	 

        // Pone la opacidad de las imagenes al porcentaje indicado en opacidad.
        $('.galeria img').animate({"opacity" : opacidad});

        // Al pasar el raton sobre la imagen (over) se ejecuta la primera funcion y al salirse la segunda (out).
        $('.galeria img').hover(
            function(){
                $(this).animate({"opacity" : 0.5});
            },
            function(){
                $(this).animate({"opacity" : opacidad});
            }
        );
        
        
     		$('#right  img').animate({"opacity" : opacidad});
        

        // Al pasar el raton sobre la imagen (over) se ejecuta la primera funcion y al salirse la segunda (out).
        $('#right  img').hover(
            function(){
                $(this).animate({"opacity" : 0.5});
            },
            function(){
                $(this).animate({"opacity" : opacidad});
            }
        );
        
        $('#head img').animate({"opacity" : opacidad});
        

        // Al pasar el raton sobre la imagen (over) se ejecuta la primera funcion y al salirse la segunda (out).
        $('#head img').hover(
            function(){
                $(this).animate({"opacity" : 0.5});
            },
            function(){
                $(this).animate({"opacity" : opacidad});
            }
        );              
        
        $("#formulario").submit(function () {
				if($("#evento").val().length < 1) {
					alert("El nombre del evento no debe ser vacio");
					return false;
				}
				if($("#descripcion").val().length < 1) {
					alert("La descripciÃ³n del evento no deberÃ­a estar vacÃ­o");
					return false;
				}		
				if($("#folder").val().length < 1) {
					$("#folder").val()="default";			
				}		
			return false;
			});
			
				
    });
}


/**
 * Permite que se muestre el contenido del input file en el que se ha modificado el estilo.
 * 
 * @param nombreInput Nombre del input file que se quiere ver con un estilo modificado
 */
function mostrarInputFileModificado(nombreInput) {
    // Creamos la divisiÃ³n para mostrar el input file con otro estilo.
    var nuevaDiv = document.createElement('div');
    nuevaDiv.className = 'inputParaMostrar';

    // Se aÃ±ade el campo en el que se mostrara el nombre del archivo selecionado.
    nuevaDiv.appendChild(document.createElement('input'));

    // Almacena en arrayInptuts todos los input de la 'pagina'.
    var arrayInputs = document.getElementsByTagName('input');

    
    for (var i=0; i<arrayInputs.length; i++) {
        // Si el input es de tipo file se modifica.
        if (arrayInputs[i].name == nombreInput){
            // Se clona la division creada y se agrega el input a la lista de inputs. ParentNode y [0]???? y ver si getElementsByTagName es lo mas adecuado
            var clonado = nuevaDiv.cloneNode(true);
            arrayInputs[i].parentNode.appendChild(clonado);

            // Se obtiene el input clonado y se reflejan en el los cambios producidos en el input file original.   
            arrayInputs[i].campoClonado = clonado.getElementsByTagName('input')[0];
            arrayInputs[i].onchange = function (){
                    this.campoClonado.value = this.value;
            }
            
            // Se sale del for porque ya se ha encontrado el input que se buscaba.
            break;
        }
    }
}


function agregarFila(idTabla,idBoton){
    
    // Limitamos el numero de filas a 10.
    if (numeroFila <= 10){
        // Inserta una nueva fila en la posicion numeroFila (la ultima).
        nuevaFila = document.getElementById(idTabla).insertRow(numeroFila);
        
        nuevaCelda = nuevaFila.insertCell(-1);
        nuevaCelda.innerHTML = '<td><div class="inputImagenModificado"><input class="inputImagenOculto" name="imagen'+numeroFila+'" type="file"><div class="inputParaMostrar"><input><img src="imagenes/button_select2.gif"></div></div></td>';

        // Funcion para modificar el estilo de los inputs
        mostrarInputFileModificado('imagen'+numeroFila);
        
        // Incrementa numeroFila
        numeroFila ++;
    }else{
        // Inserta una nueva fila en la posicion numeroFila (la ultima).
        nuevaFila = document.getElementById(idTabla).insertRow(numeroFila);

        // Inserta una nueva celda en la fila nueva, en la ultima posicion (por el -1). 
        nuevaCelda = nuevaFila.insertCell(-1);
        nuevaCelda.innerHTML = '<td>Solo se pueden subir 10 archivos a la vez.</td>';
        
        // Desactivamos el boton para agregar mas filas.
        document.getElementById(idBoton).disabled = true;
    }
}