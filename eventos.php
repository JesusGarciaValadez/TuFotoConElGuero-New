<?php
    require_once("core/_global.php");
    require_once("seccion/menu.php");
    require_once("seccion/eventos.php");
    
    $g = new _global();
    $menu = new Menu();
    $eventos = new Eventos();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="es" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="es" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="es" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
    <head>
        <title>Tu Foto Con el Güero.com</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=edge,chrome=1" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="description" content="" />
        <meta name="robots" content="all" />
        <meta name="author" content="Jesús Antonio García Valadez" >
        <meta name="author" content="Leonides Zavala Vidal" >
        
        <meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=yes" />
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png" type="image/png" />
        
        <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
        
        <script type="text/javascript" src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!-- Inicio del cotenedor principal -->
        <div class="contenedor" id="events">
            
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
                           <li><a href='index.php'><span>Inicio</span></a></li>                           
                           <li class='has-sub active'><a href='#'><span>Eventos</span></a>
                                <div id="csssubmenu" style="display:block;">                        
                                    <?php       
                                        if (empty($_GET["anio"]))
                                        {                               
                                        $anio=date("Y");
                                        }
                                        else {
                                            $anio=$_GET['anio'];    
                                        }
                                                                        
                                        $menu->PrintMenu($anio);    
                                                                                    
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
                                //$eventos->PrintEventoReciente($anio,$mes,0); 
                                $eventos->PrintEvento($id,$foto); 
                            }
                            else{
                                //Cuando  se le pasa el año (anio), mes y un evento (id) en especifico, se lanza desde mas eventos
                                // leer parametro $id y cargar el evento que se ha seleccionado
                                //$eventos->PrintEventoReciente($anio,$mes);
                                $eventos->PrintEventos($anio,$mes); 
                            }
                            
                            //Cuando se le pasa una foto, este solo se lanza desde el index.
                            
                    ?>                  
                                       
            </div>
            
        </div>
        <!-- Fin del contenedor principal -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
        <script type="text/javascript" src="js/plugins.min.js"></script>
        <script type="text/javascript" src="js/main.min.js"></script>
        <script type="text/javascript" >
            var hScreen = $( window ).height();
            var scrolled =0;
            var paginas = 1;
            var sDatos = "" ;   
            var lightbox = false;
            
            Shadowbox.init({
                handleOversize: "resize",
                overlayColor: "#fff",
                onOpen:function(){
                    $( ".a-fblightbox" ).on('click',function(e) {
                        var imagen = $('#sb-player').attr('src');
                        var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                        var url="http://www.facebook.com/sharer.php?u=" + imagen; //plugin.settings.imageUrl;
                                    
                        nueva=window.open(url, 'Comparte en Fb', caracteristicas);
                        e.preventDefault();
                    }); 
                    
                    $('.a-twlightbox').on('click', function () {
                        var imagen = $('#sb-player').attr('src');
                        var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                        //nueva=window.open( "http://twitter.com/share", 'Comparte en twiter', caracteristicas);
                        
                        var dir = imagen;//plugin.settings.imageUrl;//window.document.URL;
                        var dir2 = encodeURIComponent(dir);
                        var tit = window.document.title;
                        var tit2 = encodeURIComponent(tit);
                        
                        nueva = window.open('http://twitter.com/?status='+tit2+',%20'+dir2+'', 'Comparte en twiter', caracteristicas);  
                        e.preventDefault();
                    });
                    
                    $('.a-gPluslightbox').on('click', function () {
                        var imagen = $('#sb-player').attr('src');
                        var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                        
                        nueva=window.open("https://plus.google.com/share?url=" + imagen, 'Comparte en g+', caracteristicas);                        
                        e.preventDefault();
                    });
                }
            });
            
            function blurElement(element, size){
               var filterVal = 'blur('+size+'px)';
                $(element)
                .css('filter',filterVal)
                .css('webkitFilter',filterVal)
                .css('mozFilter',filterVal)
                .css('oFilter',filterVal)
                .css('msFilter',filterVal);
            }
        </script>
        <script type="text/javascript">
            var anio = <?php echo $anio; ?>;
            ExpandirMenu(anio);
        </script>
    </body>
</html>
<?php
    $g=null;
    $menu = null;
?>