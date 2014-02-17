<?php
	require_once("core/_global.php");
	require_once("seccion/menu.php"); 
	require_once("seccion/top-new.php");
	
	
	$g = new _global();
	$menu = new Menu();	
	$i = new GaleriaTop();	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Tu Foto Con el Güero.com</title>
		<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
		
		<!-- CSS del sitio -->
		<link href="<?php echo $g->PATH_CSS; ?>site.css" rel="stylesheet" />   
		<link href="<?php echo $g->PATH_CSS; ?>navigation.css" rel="stylesheet" />
        <link href="<?php echo $g->PATH_CSS; ?>menu-vertical.css" rel="stylesheet" />   
        		
		<!-- bootstrap -->
		<link href="<?php echo $g->BOOTSTRAP_CSS; ?>" rel="stylesheet" />   
        
        <!-- jQuery --> 
        <script type="text/javascript" src="<?php echo $g->JQUERY; ?>"></script>
        
        <!-- Plugins jQuery -->
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.backstretch.min.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery-resize.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.cycle.all.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.flip.js"></script>
        
        <!-- JavaScripts -->        
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>js-index.js"></script>
        
		<!--link rel="stylesheet" href="css/font-awesome-4.0.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="css/toastr.css">	 	 
		<link href="css/style.css" rel="stylesheet" type="text/css" /-->
    
	</head>
	<body>
    	<!-- Inicio del cotenedor principal -->
    	<div class="contenedor">              
            
        	<!-- Columna izquierda (logotipo, buscador, menú scroll y pie) -->
        	<div class="contenedor-izquierda">
            	<div class="contenedor-logotipo">
            		<div class="logotipo"></div>
                </div>
                
                <div class="contenedor-buscador">
                    <div class="buscador">
                        <input type="text" id="buscar" name="buscar" placeholder="Buscar..." class="form-controls">
                    </div>
                </div>
                
                <div class="menu-lateral">
                	<div id='cssmenu'>
                        <ul>
                           <li class='active'><a href='#'><span>Inicio</span></a></li>                           
                           <li class='has-sub'><a href='#'><span>Eventos</span></a>
                                <div id="csssubmenu">                        
                                    <?php 													
                                        $menu->PrintMenu();													
                                    ?>                                   
                                </div>
                              
                           </li>                           
                           <li><a href='#'><span>Contactos</span></a></li>
                        </ul>
                    </div>
                	
                </div>
                
                <div class="pie">
                	<span>© 2013 TUFOTOCONELGÜERO.COM,</span>	
                    <span>TODOS LOS DERECHOS RESERVADOS</span>		
					<a href="#">POLITICAS DE PRIVACIDAD</a>
                </div>
            </div>
            
            <!-- Columna derecha (dashboard) -->            
            <div class="contenedor-panel"> <!-- capa del lado derecho -->
            	<div class="fondo-panel"> <!-- Capa que contiene la sombra con el shadow -->
                	<div class="panel-galeria"> <!-- Capa que cotiene las imagenes, Ancho 935 y alto de 460 pixeles -->
                    	<?php 
							//include("seccion/top.php"); 
							$fotos = $i->MostrarGaleria();
							//echo count($fotos);
						?>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Fin del contenedor principal -->
	</body>
</html>
<script type="text/javascript" >
	var fotos = <?php echo json_encode($fotos); ?>;
	var items =  <?php echo count($fotos); ?>;
	
	setTimeout("AnimarFoto()", 1000);
	//cambiaFoto();
	
	function AnimarFoto(){		
		var x = Math.floor(Math.random() * 4);
		var y = Math.floor(Math.random() * 3);
		var a = Math.floor(Math.random() * 4);
		
		 
		var imgPrev = $("#img-" + y + '' + x );
		
		$(".pie").html(a);
		
		switch(a){
			case 0 : 
				/*$(imgPrev).cycle({ 
					fx:     'scrollDown'
				 });*/
				$(imgPrev).flip({ 	
					direction:'rl',
					onBefore: function(){
							//console.log('before starting the animation');
							CambiaFoto(imgPrev);					
					},
					onAnimation: function(){						
							//console.log('in the middle of the animation');
							//CambiaFoto(imgPrev);
					},
					onEnd: function(){
							//console.log('when the animation has already ended');							
					}
				});
				
				break;
			case 1:
				//$(imgPrev).fadeOut(1500).delay(500).slideUp(100 );
				$(imgPrev).slideUp(500, function(){
					CambiaFoto(this);
						 //this.attr("src", imgNew);
						 //if (this.complete) $(this).fadeIn(500);
						 });
				//$(imgPrev).attr("src", imgNew);
				//$(imgPrev).slideDown(100).delay(100).fadeIn(100);
				$(imgPrev).slideDown(500, function(){
										//CambiaFoto(this);//this.attr("src", imgNew);
									});
				break;
			case 2:
				$(imgPrev).fadeOut(500, function(){
					CambiaFoto(this);						 
						 });
				$(imgPrev).fadeIn(500, function(){
										//CambiaFoto(this);//this.attr("src", imgNew);
									});
				break;
			case 3:
				$(imgPrev).flip({ 	
					direction:'tb',
					onBefore: function(){
							//console.log('before starting the animation');
							CambiaFoto(imgPrev);					
					},
					onAnimation: function(){						
							//console.log('in the middle of the animation');
							//CambiaFoto(imgPrev);
					},
					onEnd: function(){
							//console.log('when the animation has already ended');							
					}
				});
				
				
				break;
		}	
		
					
		setTimeout('AnimarFoto()', 1000);
	}
	 
	 
	 function CambiaFoto( ctl ){
		 var index =  Math.floor(Math.random() * items); //indice de la imagen a mostrar
		 var imgNew= "imagenes/" + fotos[index]['directorio']+"/thumb" + fotos[index]['archivo'];
		 
		 $(ctl).attr("src", imgNew);
		 
		 //$(".pie").append( $(ctl).attr("id") + "-" +$(ctl).attr("src") + " : " + imgNew);
	}
	
	function onBefore(){
	}
	function onAfter() {     
	}
</script>
<?php
	$g=null;
	$menu = null;
	$i=null;
?>