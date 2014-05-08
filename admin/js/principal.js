
(function ( $, window, document, undefined ) {

 
  var document  = window.document,
      navigator = window.navigator,
      location  = window.location;
  var ControlFormPredefinidos =  [];
  
  var private = {
    toType : function(obj) {
      return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
    }
  }
 
  var jQuery = (function(){
 
  var core = {
 
      trim : function( subject ){
        if( private.toType( subject ) == 'string' )
          return subject.replace(/^\s+|\s+$/g, '');
        else
          return 'Formato de cadena inválida!';
      },
      alerta:function (obj) {
      	alert( obj);	
      },
      RecorrerForm: function (nameForm){
      	
      	
        
    	var frm = document.getElementById(nameForm);    				
			for (i=0;i<frm.elements.length;i++)
			{
				
				var nombre = frm.elements[i].name;
				var id_nombre = "#"+ nombre;
				
				var valor = frm.elements[i].value ;
				
				if (frm.elements[i].type=="textarea" || frm.elements[i].type=="text"  ){
					ControlFormPredefinidos[nombre]= valor;									
				}
								
				 
				sAux += "NOMBRE: " + frm.elements[i].name + " ";
				sAux += "TIPO :  " + frm.elements[i].type + " "; ;
				sAux += "VALOR: " + frm.elements[i].value + "\n" ;
			}			
			
		 },
		 
    };
 
    return core;    
  
  })();
 
  
  $(function(){
       $('#formInscripcion').validate({
           rules: {
           'eventos': 'required',
           'descripción': 'required',
           'tags': 'required',
			  'folder': 'required',           
           'location': 'required',
           'file[]': { required: true, minlength: 1 }
           },
       messages: {
           'Evento': 'Debe ingresar el nombre del evento, para registrarlo',
           'descripción': 'Ingrese una breve descripción del evento',
           'tags': 'Etiquete el evento, para identificarlo y asociarlo con los trendtopics del momento',
           'folder': 'Asegurese de que el sistema asigne una ubicación legible para sus archivos',
           'location': 'Asegurese indicar le municipio donde se realizó el evento',                      
           'file[]': 'Debe seleccionar mínimo una imagen'
       },
       debug: true,
       /*errorElement: 'div',*/
       errorContainer: $('#errores'),
       submitHandler: function(form){
           alert('El formulario ha sido validado correctamente!');
       }
    });
});

  
  
  $(document).on( 'ready', function ( e ) {
  		/*Esta funcion permite indicar un texto predfiniodo en los inputs */
  		
		$("#evento_altas").find(':input').each(function() {			
         	var elemento= this;
         	var title="";         	
         	if ( elemento.type == "text" || elemento.type == "textarea"  ) { 
         			
         			$(this).focus(function(){          		
  						$(this).addClass("active");
  						title=$(this).val();
  						$(this).val(""); 					
					}).focusout(function(){ 
							$(this).removeClass("active"); 
						  if($(this).val().length < 1) {        						  
        						$(this).val(title);  
    						} 							 
						});
         	}         	
       });

        
		
        
 } );
 
 
})( jQuery, window, document );