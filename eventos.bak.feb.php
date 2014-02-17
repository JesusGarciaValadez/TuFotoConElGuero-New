<?php
	require_once("core/_global.php");
	require_once("seccion/menu.php");
	require_once("seccion/eventos.php");	 
	
	$g = new _global();
	$menu = new Menu();
	$eventos = new Eventos();		
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="lap" >
		<title>Tu Foto Con el Güero.com</title>
		<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
		
		<!-- CSS del sitio -->
		<link href="<?php echo $g->PATH_CSS; ?>site.css" rel="stylesheet" />   
		<link href="<?php echo $g->PATH_CSS; ?>navigation.css" rel="stylesheet" />
      	<link href="<?php echo $g->PATH_CSS; ?>menu-vertical.css" rel="stylesheet" />
        <link href="<?php echo $g->PATH_CSS; ?>eventos.css" rel="stylesheet" />
      	<link href="<?php echo $g->PATH_CSS; ?>magnific-popup.css" rel="stylesheet" />   
        		
		<!-- bootstrap -->
		<link href="<?php echo $g->BOOTSTRAP_CSS; ?>" rel="stylesheet" />   
        
        <!-- jQuery --> 
        <script type="text/javascript" src="<?php echo $g->JQUERY; ?>"></script>
        
        <!-- Plugins jQuery -->
        <!--script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery-resize.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.flip.js"></script-->
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.backstretch.min.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>perfect-scrollbar.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>jquery.magnific-popup.js"></script>
        
        <!-- JavaScripts -->        
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>js-eventos.js"></script>
        <script type="text/javascript" src="<?php echo $g->PATH_JS; ?>js-galeria.js"></script>
        
		<script type="text/javascript" >
			var hScreen = $( window ).height();
			var scrolled =0;
			var paginas = 0;
		</script>
    
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
                           <li class='active'><a href='index.php'><span>Inicio</span></a></li>                           
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
            		<?php
							
							if (empty($_GET["anio"]))
							{       						
       						$anio=date("Y");
							}
							else {
								$anio=$_GET['anio'];	
							}
							
							if (empty($_GET["mes"]))
							{
							       $mes=date("m");
							}
							else {
								$mes=$_GET['mes'];
							}
							
							if(isset($_GET['id'])){ //Id del evento en caso de que se pase
								$id = $_GET['id']; 
							}
							else{
								$id=0;
							}
							
							
							if(isset($_GET['foto'])){ //Id de la foto en caso de que se pase
								$foto=$_GET['foto']; 
							}
							else{
								$foto=0;
							}
							
							if($id!= 0){
								//Este llama el evento reciente, es decir cuando no se le pasa un evento (id) o foto  
								$eventos->PrintEventoReciente($anio,$mes);  
							}
							else{
								//Cuando  se le pasa el año (anio), mes y un evento (id) en especifico, se lanza desde mas eventos
								// leer parametro $id y cargar el evento que se ha seleccionado
								$eventos->PrintEventoReciente($anio,$mes);
							}
							
							//Cuando se le pasa una foto, este solo se lanza desde el index.
							if($id != 0 && $foto != 0)   
							{
							?>
                     		<script type="text/javascript"  language="javascript">		
							$(window).load(function(){
								DeafultLightbox(<?php echo $id;?>, <?php echo $foto; ?>);	
							});						
								
							</script>
                     		<?php	
							}
            		?>               	
                    	               
            </div>
            
        </div>
        <!-- Fin del contenedor principal -->
	</body>
</html>
<?php
	$g=null;
	$menu = null;
?>