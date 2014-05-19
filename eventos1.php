<?php
    error_reporting ( E_ALL | E_STRICT );
    ini_set ( "display_errors", 0 );
    require_once( "core/_global.php");
    require_once( "seccion/menu.php");
    require_once( "seccion/eventos.php");
    $g          = new _global();
    $menu       = new Menu();
    $eventos    = new Eventos();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="es" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="es" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="es" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->
    <head>
        <title>Tu Foto Con el Güero.com - Eventos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=edge,chrome=1" />
        <!--meta http-equiv="pragma" content="no-cache" /-->
        <meta name="description" content="" />
        <meta name="robots" content="all" />
        <meta name="author" content="Leonides Zavala Vidal" >
        <meta name="author" content="Jesús Antonio García Valadez" >
        <meta name="canonical" content="http://www.tufotoconelguero.com/eventos.php" />
        
        <meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=yes" />
        
        <meta property="og:title"
        content="Tu Foto con el Güero" />
        
        <!-- A site name: -->
        
        <meta property="og:site_name" content="Tu Foto con el Güero"/>
        
        <meta property="og:image" content="http://www.tufotoconelguero.com/imagenes/default/7.jpg" />
        
        <!-- A URL with no session id or extraneous parameters. All shares on Facebook will use this as the identifying URL for this article. -->
        
        <meta property="og:url"
        content="http://www.tufotoconelguero.com/eventos.php" />
        
        <!-- A clear description, at least two sentences long. -->
        
        <meta property="og:description" content="Workday, a provider of cloud-based
        applications for human resources, said on Monday that it would seek to price
        its initial public offering at $21 to $24 a share.  At the midpoint of that
        range, the offering would value the company at $3.6 billion. Like many other
        technology start-ups, Workday, founded in 2005, will have a dual-class share
        structure, with each Class B share having 10 votes. Its co-chief executives,
        David Duffield, the founder of PeopleSoft, and Aneel Bhusri, who was chief
        strategist at PeopleSoft, will have 67 percent of the voting rights after
        the I.P.O., according to the prospectus." />
        
        <!-- Unique ID that identifies your domain to Facebook. -->
        
        <meta property="fb:app_id" content="[FB_APP_ID]" />
        
        <!-- The type of object: -->
        
        <meta property="og:type" content="website" />
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <!--link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png" type="image/png" /-->
        <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/event.css" type="text/css" media="screen" />
        <!--link href="css/eventos.css" rel="stylesheet" /-->
        
        <script type="text/javascript" src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript">
            window.jQuery || document.write('<script type="text/javascript" src="js/vendor/jquery-1.8.3.min.js"><\/script>')
        </script>
        <script type="text/javascript" src="js/plugins.min.js"></script>
        <script type="text/javascript" src="js/shadowbox.js"></script>
        <script type="text/javascript">
            var hScreen     = $( window ).height(),
                scrolled    = 0,
                paginas     = 1,
                sDatos      = "",
                lightbox    = false,
                path,regMatch,match;
            
            //  Obtiene parte de la ruta de la imagen
            var regExpImageSearch   = function () {
                path            = $( '#sb-player' ).attr( 'src' );
                regMatch        = /(\/)*imagenes\/(\S)*\/(\S)*\.(jpg|png)/gi;
                return match    = path.match( regMatch );
            };
            
            Shadowbox.init( {
                continuous:     true,
                handleOversize: "resize",
                overlayColor:   "#fff",
                enableKeys:     false,
                animSequence:   'sync',
                fadeDuration:   1.0,
                handleOversize: 'resize',
                resizeDuration: 0.1,
                onOpen:         function () {
                    
                    var interval    = setInterval( function () {
                        
                        //  Obtiene la url de la imagen y la pone el link de 
                        //  descarga
                        var imageResult     = regExpImageSearch();
                        $( '#sb-down' ).attr( 'href', 'download.php?file="http://www.tufotoconelguero.com/' + imageResult + '"');
                        $( '#sb-down' ).attr( 'download', imageResult );
                        
                        if ( $( '#sb-down' ).attr( 'href' ) != '#' || $( '#sb-down' ).attr( 'download' ) != '#' ) {
                            clearInterval( interval );
                        }
                        
                        //  Validación de formulario de envio de imagen
                        var rules   = {
                            mailing_image: {
                                required:   true,
                                email:      true
                            }
                        };
                        
                        var messages    = {
                                mailing_image:  "Por favor, escribe tu email",
                                required:       "Por favor, selecciona una opción",
                                minlength:      "Por favor, haga su respuesta más amplia.",
                                maxlength:      "Por favor, acorte su respuesta",
                                email:          "Escriba un email válido",
                                number:         "Escriba solo números",
                                digits:         "Escriba solo números",
                            }
                        
                        TFG.validateFormImage( rules, messages, match );
                    }, 2000 );
                    
                    //  Muestra el formulario de contacto
                    $( '.image_sended_by_email_trigger' ).on( 'click', function ( e ) {
                        
                        e.preventDefault();
                        e.stopPropagation();
                        
                        $( '#image_sended_by_email' ).dequeue().fadeToggle( 200 );
                    } );
                    
                    $( document ).keydown( function( e ){
                        if ( Shadowbox.isOpen() ) {
                            
                            if ( e.which === 37 ) {
                                console.log( 'previuos' );
                                Shadowbox.previous();
                            }
                            if ( Shadowbox.hasNext() ) {
                                
                                if ( e.which === 39 ) {
                                    console.log( 'next' );
                                    Shadowbox.next();
                                }
                            }
                        }
                    });
                },
                onChange:       function () {
                    $( '#sb-wrapper' ).fadeOut( 20 );
                    var interval    = setInterval( function () {
                        
                        //  Obtiene la url de la imagen y la pone el el link de 
                        //  descarga
                        var imageResult = regExpImageSearch();
                        $( '#sb-down' ).attr( 'href', 'download.php?file="http://www.tufotoconelguero.com' + imageResult + '"');
                        $( '#sb-down' ).attr( 'download', imageResult );
                        
                        if ( $( '#sb-down' ).attr( 'href' ) != '#' || $( '#sb-down' ).attr( 'download' ) != '#' ) {
                            clearInterval( interval );
                        }
                    }, 500 );
                    
                    $( '#image_sended_by_email' ).dequeue().fadeOut( 100 );
                    $( '#mailing_image' ).val( '' );
                },
                onClose:        function () {
                    //  Muestra los controles del shadowbox
                    $( '#sb-title,#lbl-cerrar,#sb-logo,#sb-nav,#sb-comp-foto,#lblsocial,#sb-social,#sb-descarga' ).fadeOut( 100 );
                    
                    $( '#image_sended_by_email' ).dequeue().fadeOut( 100 );
                    $( '#mailing_image' ).val( '' );
                    
                    $( '.image_sended_by_email_trigger' ).off( 'click' );
                },
                onFinish:       function () {
                    
                    var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                    var imagen          = $( '#sb-player' ).attr( 'src' );
                    
                    $( ".a-fblightbox" ).on( 'click', function ( e ) {
                        e.preventDefault();
                        e.stopPropagation();
                        var url = "http://www.facebook.com/sharer.php?u=http://www.tufotoconelguero.com/" + imagen; //plugin.settings.imageUrl;
                        
                        nueva   = window.open( url, 'Comparte en Fb', caracteristicas );
                    } );
                    
                    $( '.a-twlightbox' ).on( 'click', function ( e ) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var imagen          = $( '#sb-player' ).attr( 'src' );
                        var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                        //nueva=window.open( "http://twitter.com/share", 'Comparte en twiter', caracteristicas);
                        
                        var dir             = imagen; //plugin.settings.imageUrl;//window.document.URL;
                        var dir2            = encodeURIComponent( dir );
                        var tit             = window.document.title;
                        var tit2            = encodeURIComponent( tit );
                        
                        nueva               = window.open( 'http://twitter.com/?status=' + tit2 + ', http://www.tufotoconelguero.com/' + dir2 + '', 'Comparte en twiter', caracteristicas );
                    } );
                    
                    $( '.a-gPluslightbox' ).on( 'click', function ( e ) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var caracteristicas = "height=750,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                        
                        nueva               = window.open( "https://plus.google.com/share?url=http://www.tufotoconelguero.com/" + imagen, 'Comparte en g+', caracteristicas );
                    } );
                    
                    if ( $( '#sb-player' ).length >= 1 ) {
                        
                        //  Calcula el ancho del shadowbox y lo centra en la
                        //  pantalla
                        var leftPosition    = $( '#sb-wrapper' ).css( 'left' );
                        var newWidth        = Number( leftPosition.replace( /px$/, '', 'gi' ) );
                        newWidth           -= 40;
                        
                        //$( '#sb-wrapper' ).animate( { 'left': newWidth + 'px' }, 300 );
                    }
                    
                    var imageWidth  = $( '#sb-player' ).width() + 280;
                    
                    $( '#sb-wrapper' ).css( 'width', imageWidth + 'px' );
                    
                    $( '#sb-wrapper' ).centerWidth();
                    
                    $( '#sb-wrapper' ).fadeIn( 200, function () {
                        $( '#sb-title,#lbl-cerrar,#sb-logo,#sb-nav,#sb-comp-foto,#lblsocial,#sb-social,#sb-descarga' ).fadeIn( 300 );
                    } );
                }
            } );
            
            $( window ).on( 'resize', function ( e ) {
                
                $( '#sb-wrapper' ).centerWidth();
                $( '#sb-wrapper' ).centerHeight();
            } );
            
            var blurElement = function ( element, size ) {
                var filterVal = 'blur(' + size + 'px)';
                $( element ).css( {
                    'filter':       filterVal,
                    'webkitFilter': filterVal,
                    'mozFilter':    filterVal,
                    'oFilter':      filterVal,
                    'msFilter':     filterVal
                } );
            };
        </script>
    </head>
    
    <body id="home">
        <div class="contenedor"><!-- Contenedor principal -->
            <aside class="contenedor-izquierda"><!-- Columna izquierda (logotipo, menú scroll y pie) -->
                <a href="http://www.tufotoconelguero.com/" class="contenedor-logotipo" target="_self" title="Tu Foto con el Güero.com">
                    <div class="logotipo"></div>
                </a>
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
                                        <?php $menu->PrintMenu(0,0); ?>
                                    </div>
                                    
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
                    <a href="contacto.html" title="Políticas de Privacidad" target="_blank" rel="#privacy_policy_wrapper" class="overlay_trigger">Políticas de Privacidad</a>
                </div>
            </aside><!-- Columna izquierda (logotipo, buscador, menú scroll y pie) -->
            <div class="contenedor-panel"><!-- Columna derecha (dashboard) -->
                <div id="search_form"><!-- Formulario de Búsqueda -->
                    <form action="buscar.php" method="post" accept-charset="utf-8" name="images_search" id="images_search">
                        <fieldset>
                            <legend>Busca tu Foto por:</legend>
                            <div class="select_input">
                                <select name="location" id="location_search">
                                    <option value="">Selecciona tu Municipio</option>
                                    <option value="1">Acacoyagua</option>
                                    <option value="2">Acala</option>
                                    <option value="3">Acapetahua</option>
                                    <option value="4">Altamirano</option>
                                    <option value="5">Amatán</option>
                                    <option value="6">Amatenango de la Frontera</option>
                                    <option value="7">Amatenango del Valle</option>
                                    <option value="8">Ángel Albino Corzo</option>
                                    <option value="9">Arriaga</option>
                                    <option value="10">Bejucal de Ocampo</option>
                                    <option value="11">Bella Vista</option>
                                    <option value="12">Berriozábal</option>
                                    <option value="13">Bochil</option>
                                    <option value="14">El Bosque</option>
                                    <option value="15">Cacahoatán</option>
                                    <option value="16">Catazajá</option>
                                    <option value="17">Cintalapa</option>
                                    <option value="18">Coapilla</option>
                                    <option value="19">Comitán de Domínguez</option>
                                    <option value="20">La Concordia</option>
                                    <option value="21">Copainalá</option>
                                    <option value="22">Chalchihuitán</option>
                                    <option value="23">Chamula</option>
                                    <option value="24">Chanal</option>
                                    <option value="25">Chapultenango</option>
                                    <option value="26">Chenalhó</option>
                                    <option value="27">Chiapa de Corzo</option>
                                    <option value="28">Chiapilla</option>
                                    <option value="29">Chicoasén</option>
                                    <option value="30">Chicomuselo</option>
                                    <option value="31">Chilón</option>
                                    <option value="32">Escuintla</option>
                                    <option value="33">Francisco León</option>
                                    <option value="34">Frontera Comalapa</option>
                                    <option value="35">Frontera Hidalgo</option>
                                    <option value="36">La Grandeza</option>
                                    <option value="37">Huehuetán</option>
                                    <option value="38">Huixtán</option>
                                    <option value="39">Huitiupán</option>
                                    <option value="40">Huixtla</option>
                                    <option value="41">La Independencia</option>
                                    <option value="42">Ixhuatán</option>
                                    <option value="43">Ixtacomitán</option>
                                    <option value="44">Ixtapa</option>
                                    <option value="45">Ixtapangajoya</option>
                                    <option value="46">Jiquipilas</option>
                                    <option value="47">Jitotol</option>
                                    <option value="48">Juárez</option>
                                    <option value="49">Larráinzar</option>
                                    <option value="50">La Libertad</option>
                                    <option value="51">Mapastepec</option>
                                    <option value="52">Las Margaritas</option>
                                    <option value="53">Mazapa de Madero</option>
                                    <option value="54">Mazatán</option>
                                    <option value="55">Metapa</option>
                                    <option value="56">Mitontic</option>
                                    <option value="57">Motozintla</option>
                                    <option value="58">Nicolás Ruiz</option>
                                    <option value="59">Ocosingo</option>
                                    <option value="60">Ocotepec</option>
                                    <option value="61">Ocozocoautla de Espinosa</option>
                                    <option value="63">Osumacinta</option>
                                    <option value="64">Oxchuc</option>
                                    <option value="65">Palenque</option>
                                    <option value="66">Pantelhó</option>
                                    <option value="67">Pantepec</option>
                                    <option value="68">Pichucalco</option>
                                    <option value="69">Pijijiapan</option>
                                    <option value="70">El Porvenir</option>
                                    <option value="71">Villa Comaltitlán</option>
                                    <option value="72">Pueblo Nuevo Solistahuacán</option>
                                    <option value="73">Rayón</option>
                                    <option value="74">Reforma</option>
                                    <option value="75">Las Rosas</option>
                                    <option value="76">Sabanilla</option>
                                    <option value="77">Salto de Agua</option>
                                    <option value="78">San Cristóbal de las Casas</option>
                                    <option value="79">San Fernando</option>
                                    <option value="80">Siltepec</option>
                                    <option value="81">Simojovel</option>
                                    <option value="82">Sitalá</option>
                                    <option value="83">Socoltenango</option>
                                    <option value="84">Solosuchiapa</option>
                                    <option value="85">Soyaló</option>
                                    <option value="86">Suchiapa</option>
                                    <option value="87">Suchiate</option>
                                    <option value="88">Sunuapa</option>
                                    <option value="89">Tapachula</option>
                                    <option value="90">Tapalapa</option>
                                    <option value="91">Tapilula</option>
                                    <option value="92">Tecpatán</option>
                                    <option value="93">Tenejapa</option>
                                    <option value="94">Teopisca</option>
                                    <option value="96">Tila</option>
                                    <option value="97">Tonalá</option>
                                    <option value="98">Totolapa</option>
                                    <option value="99">La Trinitaria</option>
                                    <option value="100">Tumbalá</option>
                                    <option value="101">Tuxtla Gutiérrez</option>
                                    <option value="102">Tuxtla Chico</option>
                                    <option value="103">Tuzantán</option>
                                    <option value="104">Tzimol</option>
                                    <option value="105">Unión Juárez</option>
                                    <option value="106">Venustiano Carranza</option>
                                    <option value="107">Villa Corzo</option>
                                    <option value="108">Villaflores</option>
                                    <option value="109">Yajalón</option>
                                    <option value="110">San Lucas</option>
                                    <option value="111">Zinacantán</option>
                                    <option value="112">San Juan Cancuc</option>
                                    <option value="113">Aldama</option>
                                    <option value="114">Benemérito de las Américas</option>
                                    <option value="115">Maravilla Tenejapa</option>
                                    <option value="116">Marqués de Comillas</option>
                                    <option value="117">Montecristo de Guerrero</option>
                                    <option value="118">San Andrés Duraznal</option>
                                    <option value="119">Santiago el Pinar</option>
                                    <option value="120">Belisario Domínguez3</option>
                                    <option value="121">Emiliano Zapata3</option>
                                    <option value="122">El Parral3</option>
                                    <option value="123">Mezcalapa3</option>
                                </select>
                            </div>
                            <div class="text_input">
                                <input type="text" name="date" id="date_search" placeholder="Selecciona la Fecha" class="datepicker" value="" />
                            </div>
                            <div class="submit_input">
                                <input id="submit_search" type="submit" name="submit_search" value="Buscar">
                                <?php
                                    if ( 
                                        ( isset( $_GET['anio'] ) && $_GET['anio'] != '' ) && 
                                        ( isset( $_GET['mes'] ) && $_GET['mes'] != '' ) && 
                                        ( isset( $_GET['id'] ) && $_GET['id'] != '' ) && 
                                        ( isset( $_GET['foto'] ) && $_GET['foto'] != '' ) /*&& 
                                        ( 
                                            ( stristr( $_SERVER['HTTP_REFERER'], 'index.php' ) ) || 
                                            ( stristr( $_SERVER['HTTP_REFERER'], '' ) ) 
                                        )*/
                                    ) { ?>
                                        <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . "eventos.php?anio={$_GET['anio']}&mes={$_GET['mes']}"; ?>" id="go_back_button" title="Regresar" target="_self">Regresar</a>
                                <?php
                                    }
                                ?>
                            </div>
                        </fieldset>
                    </form>
                </div><!-- Formulario de Búsqueda -->
                <div class="fondo-eventos scrollable"><!-- Capa que contiene la sombra con el shadow -->
                        <!-- Capa que cotiene las imagenes, Ancho 935 y alto de 460 pixeles -->
                        <?php $eventos->PrintEventos(); ?>
                </div><!-- Capa que contiene la sombra con el shadow -->
            </div><!-- Columna derecha (dashboard) -->
            <div class="alert_background opening">
                <img src="css/img/Logo-front.png" alt="Logo Tu Foto con el Güero" width="464" height="220">
            </div><!-- Background de Overlay -->
            <div id="contact_form_wrapper" class="alert_box"><!-- Formulario de Contacto -->
                <a title="Cerrar" class="close">Cerrar</a>
                <form action="enviamail.php" method="post" accept-charset="utf-8" class="contact_form">
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
            </div><!-- Formulario de Contacto -->
            <div id="privacy_policy_wrapper" class="alert_box"><!-- Política de privacidad -->
                <a title="Cerrar" class="close">Cerrar</a>
                <p>En construcción</p>
                <div id="logo_holder">
                    <img src="css/img/Logo-Gris.png" alt="Logo Tu Foto con el Güero" width="163" height="76" />
                </div>
            </div><!-- Política de privacidad -->
        </div><!-- Contenedor principal -->
        <script>
           (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
               (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
               m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
               })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
               
               ga('create', 'UA-49224938-1', 'tufotoconelguero.com');
               ga('send', 'pageview');
        </script>
        <script type="text/javascript" src="js/main.min.js"></script>
        <script type="text/javascript" src="js/js-eventos.min.js"></script>
<?php
        if( !isset( $_GET["pagina"] ) and isset( $_GET["id"] ) ) {
            echo "<script type='text/javascript'>";
            echo "  window.setTimeout( function() {";
            echo "      Shadowbox.open( { ";
            echo "          content: '".$eventos->primerFoto."',";
            echo "          player: 'img',";
            echo "          gallery: 'principal".(string)$_GET['id']."',";
            echo "          title: '',";
            echo "          enableKeys: false"; 
            echo "      } );";
            echo "  }, 200 );";
            echo "</script>";
        }
?>
    </body>
</html>
<?php
    $g          = null;
    $menu       = null;
    $eventos    = null;
?>