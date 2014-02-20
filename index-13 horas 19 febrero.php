<?php
    error_reporting ( E_ALL | E_STRICT );
    ini_set ( "display_errors", 0 );
    
    require_once("core/_global.php");
    require_once("seccion/menu.php"); 
    require_once("seccion/top-new.php");
    
    $g = new _global();
    $menu = new Menu();
    $i = new GaleriaTop();
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
    <body id="home">
        <div class="contenedor"><!-- Contenedor principal -->
            <aside class="contenedor-izquierda"><!-- Columna izquierda (logotipo, menú scroll y pie) -->
                <div class="contenedor-logotipo">
                    <div class="logotipo"></div>
                </div>
                <div class="menu-lateral">
                    <nav id='cssmenu'>
                        <ul>
                            <li class='home active'>
                                <a href='index.php'>
                                    <span>Inicio</span>
                                </a>
                            </li>
                            <li class='events has-sub'>
                                <a href='#'>
                                    <span>Eventos</span>
                                </a>
                                <div class="csssubmenu">
                                    <div class="csssubmenu" style="display: block;">
                                        <ul id="nav-evento">
                                            <li class="has-sub">
                                                <a onclick="return false;" href="#" class="active">
                                                    <span>2014</span>
                                                </a>
                                                <ul style="display: block;">
                                                    <li class="noactive">
                                                        <a href="eventos.php?anio=2014&amp;mes=2">
                                                            <span>Febrero</span>
                                                        </a>
                                                    </li>
                                                    <li class="noactive">
                                                        <a href="eventos.php?anio=2014&amp;mes=1">
                                                            <span>Enero</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="has-sub">
                                                <a onclick="return false;" href="#">
                                                    <span>2013</span>
                                                </a>
                                                <ul style="">
                                                    <li class= "noactive">
                                                        <a href="eventos.php?anio=2013&amp;mes=12">
                                                            <span>Diciembre</span>
                                                        </a>
                                                    </li>
                                                    <li class="noactive">
                                                        <a href="eventos.php?anio=2013&amp;mes=11">
                                                            <span>Noviembre</span>
                                                        </a>
                                                    </li>
                                                    <li class="noactive">
                                                        <a href="eventos.php?anio=2013&amp;mes=10">
                                                            <span>Octubre</span>
                                                        </a>
                                                    </li>
                                                    <li class="noactive">
                                                        <a href="eventos.php?anio=2013&amp;mes=9">
                                                            <span>Septiembre</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php //$menu->PrintMenu(0,0); ?>
                                </div>
                            </li>
                            <li class="contact_form_trigger">
                                <a href='#' title="Contactos" rel="#contact_form_wrapper" class="overlay_trigger">
                                    <span>Contactos</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div id="test" style="color:#fff;"></div>
                </div>
                <div class="pie">
                    <p id="site_name">&copy; 2013 TUFOTOCONELGÜERO.COM,</p>
                    <p>Todos los Derechos Reservados</p>
                    <a href="contacto.html" title="Políticas de Privacidad" target="_blank" rel="Shadowbox;">Políticas de Privacidad</a>
                </div>
            </aside><!-- Columna izquierda (logotipo, buscador, menú scroll y pie) -->
            <div class="contenedor-panel"><!-- Columna derecha (dashboard) -->
                <div id="search_form">
                    <form action="evento.php" method="get" accept-charset="utf-8" name="images_search" id="images_search">
                        <fieldset>
                            <legend>Busca tu Foto por:</legend>
                            <div class="select_input">
                                <select name="location" id="location_search">
                                    <option value="">Selecciona tu Municipio</option>
                                </select>
                            </div>
                            <div class="text_input">
                                <input type="text" name="date" id="date_search" placeholder="Selecciona la Fecha" class="datepicker" />
                            </div>
                            <div class="submit_input">
                                <input id="submit_search" type="submit" name="submit_search" value="Buscar">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="fondo-panel"> <!-- Capa que contiene la sombra con el shadow -->
                    <div class="panel-galeria"> <!-- Capa que cotiene las imagenes, Ancho 935 y alto de 460 pixeles -->
                        <?php $fotos = $i->MostrarGaleria(); ?>
                    </div>
                </div>
            </div><!-- Columna derecha (dashboard) -->
            <div class="alert_background"></div>
            <div id="contact_form_wrapper" class="alert_box">
                <a title="Cerrar" class="close">Cerrar</a>
                <form action="contacto.php" method="post" accept-charset="utf-8" class="contact_form">
                    <fieldset>
                        <div class="contact_text_input" id="contact_name_wrapper">
                            <label for="contact_name">Nombre</label>
                            <input id="contact_name" type="text" name="contact_name" value="" placeholder="Nombre y Apellido">
                        </div>
                        <div class="contact_text_input" id="contact_mail_wrapper">
                            <label for="contact_mail">Correo</label>
                            <input id="contact_mail" type="mail" name="contact_mail" value="" placeholder="ejemplo@correo.com">
                        </div>
                        <div class="contact_text_input" id="contact_message_wrapper">
                            <label for="contact_message">Comentario</label>
                            <textarea id="contact_message" name="contact_message" value="" placeholder="Escribe tu Mensaje…"></textarea>
                        </div>
                        <div class="contact_controls_input">
                            <input id="contact_reset" type="reset" name="contact_reset" value="Borrar" placeholder="Borrar">
                            <input id="contact_submit" type="submit" name="contact_submit" value="Enviar" placeholder="Enviar">
                        </div>
                    </fieldset>
                </form>
                <div id="logo_holder">
                    <img src="css/img/Logo-Gris.png" alt="Logo Tu Foto con el Güero" width="163" height="76" />
                </div>
            </div>
        </div><!-- Contenedor principal -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
        <script type="text/javascript" src="js/plugins.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <!--script type="text/javascript">
            Shadowbox.init({
                handleOversize: "drag"
            });
        </script-->
        <script type="text/javascript">
            var fotos = <?php echo json_encode($fotos); ?>;
            var items = <?php echo count($fotos); ?>;
            
            window.TFG.ControlGaleria();
        </script>
    </body>
</html>
        <?php
    $g=null;
    $menu = null;
    $i=null;
?>