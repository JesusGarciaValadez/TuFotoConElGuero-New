
<?php
/*     
Descripcion:   Pantalla inicial que se muestra al usuario una vez que ha sido logueado correctamente. 
Author: XXX
Archivo:    principal.php 
*/

 
//Inicializar una sesion de PHP
session_start();
	require_once("core/_global.php");	
	$g = new _global();
//Validar que el usuario este logueado y exista un UID
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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    		<title>.:: Inicio ::. Sistema de Control De eventos Chiapas</title>
    			<link rel="stylesheet" href="css/estilos.css" type="text/css">
    		<script type="text/javascript" src="<?php echo $g->JQUERY; ?>"></script>
    		<script type="text/javascript" src="js/funciones.js"></script>
</head>
<body topmargin="0" >
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
    <li class="active"><a href="principal.php">Subir Archivos </a></li>
    <li><a href="main.php">Portafolio Eventos</a></li>
    <li><a href="#">Contacto</a></li>
  </ul>
</nav>
</div>

<h2 align="center">Pantalla Principal</h2>
 
        <!-- Contenido inicial del sitio web --> 
        
        
        <div id="subirImagenes">
                    
            <!-- Para poder subir archivos con PHP hay que poner enctype="multipart/form-data" para que no se encripte ningun caracter y el archivo no se modifique/estropee -->
            <form action="#" method="POST" enctype="multipart/form-data" name="formulario" id="formulario" >
            	<table id="formularioEvento" border="0"> 
            		<thead>
                        <th>Datos del Evento</th>                        
                  </thead>
                  	<tr>
                  		<td>
                  			Evento:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  			<input id="evento" name="evento" type="text" name="evento" maxlength="150" width="60"  value="<?php echo date("m/d/Y"); ?>" />
                  		</td>
                  	</tr>
                  	<tr> 
                  		<td>
                  			Descripción:&nbsp;<textarea id="descripcion" name="descripcion" rows="4" cols="50"  maxlength="150" >-</textarea>
                  		</td>
                  	</tr>
                  	<tr> 
                  		<td>
                  			Fecha:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="bdate" id="bdate" > 
                  		</td>
                  	</tr>
                  	<tr> 
                  		<td>
                  			Folder de Trabajo:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="folder" value="default"> 
                  		</td>
                  	</tr>
            	</table>
            
                <table id="formularioSubida" border="0">
                    <thead>
                        <th>Elige los archivos que quieras subir</th>
                    </thead>
                    <tr>
                        <td>
                            <div class="inputImagenModificado">
                                <input class="inputImagenOculto" name="imagen1" type="file">
                                <div class="inputParaMostrar">
                                    <input>
                                    <img src="img/button_select2.gif">
                                </div>
                            </div>
                        </td>                        
                    </tr>
                    <tr>
                        <td> 
                            <input type="button" id="botonAnnadir" onClick="agregarFila('formularioSubida','botonAnnadir')" value="Añadir archivo" style="width:138px;">        
                            <input type="submit" name="botonSubir" value="Subir"> 
                        </td>                        
                    </tr>
                </table>
            </form>
            
            <?php            	
					require "revisar/GestorArchivos.php";
					require "revisar/config.php"; 
                            	
             	$idEvento=0; 
			    	$conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);
			    	             	
               // Subir todas las imagenes
                if(isset($_POST['botonSubir'])){
                	$folder = $_POST["folder"];
                	$evento = $_POST["evento"];
                	$descripcion = $_POST["descripcion"];
                	$fecha = $_POST["bdate"];
                	 
                	
                	  
                  //subirImagenes($folder,$conexion);                    
                    subirImagenesConEvento($folder,$conexion,$evento , $descripcion, $fecha, $idEvento);
                }
            ?>
            <br />
        </div>  
               
        
          <body onLoad="mostrarInputFileModificado('imagen1'); cambiarOpacidadImagenes(1); ">
<body>
</html>