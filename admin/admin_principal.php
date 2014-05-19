<?php
    error_reporting ( E_ALL | E_STRICT );
    ini_set ( "display_errors", 0 );
    session_start();
    header('Content-Type: text/html; charset=UTF-8');
    if ( ! ($_SESSION['autenticado'] == 'SI' && isset($_SESSION['uid'])) )
{
    //En caso de que el usuario no este autenticado, crear un formulario y redireccionar a la 
    //pantalla de login, enviando un codigo de error
?>
        <form name="formulario" method="post" action="admin.php">
            <input type="hidden" name="msg_error" value="2">
        </form>
        <script type="text/javascript"> 
            document.formulario.submit();
        </script>
<?php
}
 
    //Conectar BD
    require_once("revisar/conectar_bd.php");
    require_once("revisar/comunes.php");
        conectar_bd();
 
    //Sacar datos del usuario que ha iniciado sesion
    $sql = "SELECT  tx_nombre,tx_apellidoPaterno,tx_TipoUsuario,id_usuario
            FROM tbl_users
            LEFT JOIN ctg_tiposusuario
            ON tbl_users.id_TipoUsuario = ctg_tiposusuario.id_TipoUsuario
            WHERE id_usuario = '".$_SESSION['uid']."'";         
    $result     =mysql_query($sql); 
 
    $nombreUsuario = "";
 
    //Formar el nombre completo del usuario
    if( $fila = mysql_fetch_array($result) )
        $nombreUsuario = $fila['tx_nombre']." ".$fila['tx_apellidoPaterno'];
     
//Cerrrar conexion a la BD
mysql_close($conexio);
if ( isset( $_GET['id_evento'] ))  {
echo "
<div 'eventoAgregado'> 
Se ha agregado el evento con clave= ". $_GET['id_evento']." Si desea editar o agregar mas fotos puede hacerlo desde aqui
<a href='admin_edita.php?id_evento=".$_GET['id_evento']."'> Editar Evento</a>||
<a href='admin_principal.php' id='close'> Cerrar Esta nota</a>
</div>

";	
}
    
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="es" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="es" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="es" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es" class="no-js"> <!--<![endif]-->
    <head>
        <title>Tu Foto Con el G&uuml;ero.com</title>
        
        <meta http-equiv="X-UA-Compatible" content="IE=11,IE=edge,chrome=1" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="description" content="" />
        <meta name="robots" content="all" />
        <meta name="author" content="Leonides Zavala Vidal" >        
        
        <meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=yes" />
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png" type="image/png" />
        
        <link rel="stylesheet" href="css/admin.css" type="text/css" media="screen" />
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        
    </head>
    <body id="home">
    <div id="topControl">
	<ul>
		<li>Bienvenido <b><?php echo $nombreUsuario ?></b></li>
		<li><a href="cerrarSesion.php">Cerrar sesi&oacute;n</a></li>
	</ul>
</div>
<div id="topMenu">
<nav>
  <ul>
    <li><a href="#">Administrar Usuarios</a></li>
    <li class="active"><a href="admin_principal.php">Agregar Evento </a></li>
    <li><a href="main.php">Portafolio Eventos</a></li>
    <li><a href="admin_edita.php">Contacto</a></li>
  </ul>
</nav>
</div>



<h2 align="center">Pantalla Principal</h2>
        <div class="contenedor"><!-- Contenedor principal -->        
            <div class="contenedor-panel"><!-- Columna derecha (dashboard) -->
                <div id="add_evento">
                    <form action="alta.php" method="post" accept-charset="utf-8" name="evento_alta" id="evento_alta" enctype="multipart/form-data">
                        <fieldset>                            
                            <legend>Formulario de Alta de Eventos:</legend>
                            
                            <label class="title">T&shy;&iacute;tulo-Nombre del Evento</label>                            
                            <input id="evento" name="evento" type="text" name="evento" maxlength="200" width="60"  value="T&iacute;tulo del Evento" >
                            
                            <label class="title">Descripci&oacute;n del Evento</label>                            
                            <textarea id="descripcion" name="descripcion" rows="4" cols="50"  maxlength="600" >Descripci&oacute;n del Evento</textarea>
                            
                            <label class="title">Etiqueta el evento, para facilitar y resaltar hangtag o topic trend</label>                            
                            <textarea id="tags" name="tags" rows="4" cols="50"  maxlength="150" >Etiqueta el Evento</textarea>
                            
                            <label class="title">Folder de trabajo, donde se almacenan las fotos en el servidor</label>
                            <input id="folder" name="folder" type="text" maxlength="250" readonly="true"  value="<?php echo fijaFolderBase(); ?>"> 
                            
                            <label class="title">Selecciona las im&aacute;genes del evento, por seguridad y rendimiento de nuestros servidores se recomienda un maximo de 15 fotos por carga en el evento</label>
                            <input class="file" type="file" name="files[]" multiple >

									<label class="title">Selecciona la ubicaci&oacute;n del Evento</label>                                   			
                            <div class="select_input">
                                <select name="location" >
                                    <option value="">Selecciona tu Municipio</option>
                                    <option value="">Selecciona tu Municipio</option>
                                    <option value="1">Acacoyagua</option>
                                    <option value="2">Acala</option>
                                    <option value="3">Acapetahua</option>
                                    <option value="4">Altamirano</option>
                                    <option value="5">Amat&aacute;n</option>
                                    <option value="6">Amatenango de la Frontera</option>
                                    <option value="7">Amatenango del Valle</option>
                                    <option value="8">&Aacute;ngel Albino Corzo</option>
                                    <option value="9">Arriaga</option>
                                    <option value="10">Bejucal de Ocampo</option>
                                    <option value="11">Bella Vista</option>
                                    <option value="12">Berrioz&aacute;bal</option>
                                    <option value="13">Bochil</option>
                                    <option value="14">El Bosque</option>
                                    <option value="15">Cacahoat&aacute;n</option>
                                    <option value="16">Catazaj&aacute;</option>
                                    <option value="17">Cintalapa</option>
                                    <option value="18">Coapilla</option>
                                    <option value="19">Comit&aacute;n de Dom&iacute;nguez</option>
                                    <option value="20">La Concordia</option>
                                    <option value="21">Copainal&aacute;</option>
                                    <option value="22">Chalchihuit&aacute;n</option>
                                    <option value="23">Chamula</option>
                                    <option value="24">Chanal</option>
                                    <option value="25">Chapultenango</option>
                                    <option value="26">Chenalh&oacute;</option>
                                    <option value="27">Chiapa de Corzo</option>
                                    <option value="28">Chiapilla</option>
                                    <option value="29">Chicoas&eacute;n</option>
                                    <option value="30">Chicomuselo</option>
                                    <option value="31">Chil&oacute;n</option>
                                    <option value="32">Escuintla</option>
                                    <option value="33">Francisco Le&oacute;n</option>
                                    <option value="34">Frontera Comalapa</option>
                                    <option value="35">Frontera Hidalgo</option>
                                    <option value="36">La Grandeza</option>
                                    <option value="37">Huehuet&aacute;n</option>
                                    <option value="38">Huixt&aacute;n</option>
                                    <option value="39">Huitiup&aacute;n</option>
                                    <option value="40">Huixtla</option>
                                    <option value="41">La Independencia</option>
                                    <option value="42">Ixhuat&aacute;n</option>
                                    <option value="43">Ixtacomit&aacute;n</option>
                                    <option value="44">Ixtapa</option>
                                    <option value="45">Ixtapangajoya</option>
                                    <option value="46">Jiquipilas</option>
                                    <option value="47">Jitotol</option>
                                    <option value="48">Ju&aacute;rez</option>
                                    <option value="49">Larr&aacute;inzar</option>
                                    <option value="50">La Libertad</option>
                                    <option value="51">Mapastepec</option>
                                    <option value="52">Las Margaritas</option>
                                    <option value="53">Mazapa de Madero</option>
                                    <option value="54">Mazat&aacute;n</option>
                                    <option value="55">Metapa</option>
                                    <option value="56">Mitontic</option>
                                    <option value="57">Motozintla</option>
                                    <option value="58">Nicol&aacute;s Ruiz</option>
                                    <option value="59">Ocosingo</option>
                                    <option value="60">Ocotepec</option>
                                    <option value="61">Ocozocoautla de Espinosa</option>
                                    <option value="63">Osumacinta</option>
                                    <option value="64">Oxchuc</option>
                                    <option value="65">Palenque</option>
                                    <option value="66">Pantelh&oacute;</option>
                                    <option value="67">Pantepec</option>
                                    <option value="68">Pichucalco</option>
                                    <option value="69">Pijijiapan</option>
                                    <option value="70">El Porvenir</option>
                                    <option value="71">Villa Comaltitl&aacute;n</option>
                                    <option value="72">Pueblo Nuevo Solistahuac&aacute;n</option>
                                    <option value="73">Ray&oacute;n</option>
                                    <option value="74">Reforma</option>
                                    <option value="75">Las Rosas</option>
                                    <option value="76">Sabanilla</option>
                                    <option value="77">Salto de Agua</option>
                                    <option value="78">San Crist&oacute;bal de las Casas</option>
                                    <option value="79">San Fernando</option>
                                    <option value="80">Siltepec</option>
                                    <option value="81">Simojovel</option>
                                    <option value="82">Sital&aacute;</option>
                                    <option value="83">Socoltenango</option>
                                    <option value="84">Solosuchiapa</option>
                                    <option value="85">Soyal&oacute;</option>
                                    <option value="86">Suchiapa</option>
                                    <option value="87">Suchiate</option>
                                    <option value="88">Sunuapa</option>
                                    <option value="89">Tapachula</option>
                                    <option value="90">Tapalapa</option>
                                    <option value="91">Tapilula</option>
                                    <option value="92">Tecpat&aacute;n</option>
                                    <option value="93">Tenejapa</option>
                                    <option value="94">Teopisca</option>
                                    <option value="96">Tila</option>
                                    <option value="97">Tonal&aacute;</option>
                                    <option value="98">Totolapa</option>
                                    <option value="99">La Trinitaria</option>
                                    <option value="100">Tumbal&aacute;</option>
                                    <option value="101">Tuxtla Guti&eacute;rrez</option>
                                    <option value="102">Tuxtla Chico</option>
                                    <option value="103">Tuzant&aacute;n</option>
                                    <option value="104">Tzimol</option>
                                    <option value="105">Uni&oacute;n Ju&aacute;rez</option>
                                    <option value="106">Venustiano Carranza</option>
                                    <option value="107">Villa Corzo</option>
                                    <option value="108">Villaflores</option>
                                    <option value="109">Yajal&oacute;n</option>
                                    <option value="110">San Lucas</option>
                                    <option value="111">Zinacant&aacute;n</option>
                                    <option value="112">San Juan Cancuc</option>
                                    <option value="113">Aldama</option>
                                    <option value="114">Benem&eacute;rito de las Am&eacute;ricas</option>
                                    <option value="115">Maravilla Tenejapa</option>
                                    <option value="116">Marqu&eacute;s de Comillas</option>
                                    <option value="117">Montecristo de Guerrero</option>
                                    <option value="118">San Andr&eacute;s Duraznal</option>
                                    <option value="119">Santiago el Pinar</option>
                                    <option value="120">Belisario Dom&iacute;nguez3</option>
                                    <option value="121">Emiliano Zapata3</option>
                                    <option value="122">El Parral3</option>
                                    <option value="123">Mezcalapa3</option>
                                </select>
                            </div>
                            <label class="title">Selecciona la fecha del Evento</label>
                            	<div  class="text_input">
                                <input type="text" name="date" id="date"  value="2014-03-04" />
                                
                            	</div>
                            <div class="submit_input">
                                <input id="submit_add" type="submit" name="submit_add" value="Dar de Alta">
                            </div>
                        </fieldset>
                    </form>
                </div><!-- Formulario de B&uacute;squeda -->
                <div class="fondo-panel"> <!-- Capa que contiene la sombra con el shadow -->
                    <div id="#errores" > 
                        
                    </div>
                </div>
            </div>
            <div class="alert_background"></div>            
        </div><!-- Contenedor principal -->        
        <link href="css/le-frog/jquery-ui-1.10.4.custom.css" rel="stylesheet">
			
        <script type="text/javascript" src="js/principal.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
        <script>
	$(function() {
		
		$( "#date").datepicker( {
                    dateFormat: "yy-mm-dd",
                    dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "S&aacute;bado" ],
                    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                    dayNamesShort: [ "Dom", "Lun", "Mar", "Mir", "Jue", "Vie", "Sab" ],
                    firstDay: 1,
                    gotoCurrent: true,
                    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                    monthNamesShort: [ "Enero", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
                    //changeMonth: true,
                    //changeYear: true
                } );
	
	});
	</script>
        
        
    </body>
</html>
