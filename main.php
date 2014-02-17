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

		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />		
    		<title>.:: Inicio ::. Sistema de Control De eventos Chiapas</title>
    			<link rel="stylesheet" href="css/estilo_admin.css" type="text/css">
    		
    		<link rel="stylesheet" href="css/estilo_admin.css" type="text/css">
    		<script type="text/javascript" src="<?php echo $g->JQUERY; ?>"></script>
    		<script type="text/javascript" src="js/funciones.js"></script>

        
</head>
<body topmargin="0" onLoad="cambiarOpacidadImagenes(1);  " >
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
    <li><a href="principal.php">Subir Archivos </a></li>
    <li class="active"><a href="main.php">Portafolio Eventos</a></li>
    <li><a href="#">Contacto</a></li>
  </ul>
</nav>
</div>

<div class="galeria">
            <h1>Chiapas - LIVE </h1>
            <?php
                require 'revisar/config.php';
                require 'revisar/GestorArchivos.php'; 
                
                $conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);
                 
                $consultaCategorias = "SELECT id , evento, descripcion , fecha  FROM evento  where activo = 1  order by fecha";
                $resultadoCategorias = $conexion->query($consultaCategorias);

                 
          while($filasCategorias = $resultadoCategorias->fetch_array(MYSQLI_ASSOC)) 
          {     
	$clasecount= 0;           	
   echo "<div class='categoria'>";
   				echo "<label class='lblevento'>". $filasCategorias['evento']."</label>" ;
   				echo "<label class='lbldescripcion'>". $filasCategorias['descripcion']."</label></br>" ;
                $consulta = "SELECT  archivo, directorio FROM galeriaimagenes where evento = ". $filasCategorias['id'] ." ORDER BY id LIMIT 3 ";
                $resultado = $conexion->query($consulta);

                // Muestra las imagenes de la galeria.
                while($filas = $resultado->fetch_array(MYSQLI_ASSOC)) {
                	
                	$rutaimg= "imagenes/".$filas["directorio"]."/".$filas["archivo"];                		
                    // Se comprueba que existan las imagenes
                    if (file_exists($rutaimg)){                    	
                    	$size = GetImageSize($rutaimg);
                    	$anchura=$size[0]; 
							$altura=$size[1]; 
							if ( $altura > $anchura ) { 
								$estilo="vertical";							
							} else { 
								$estilo="horizontal";
							}                    	
                        echo'<img class="'.$estilo.'estilo'. calculaclase ($clasecount) .'img" src="imagenes/'.$filas['directorio'].'/'.$filas['archivo'].'"/>';
                    }                    
						$clasecount=$clasecount+1;                
                } 
            echo "<div class='compartir'>";
            echo "<a href='borra_evento.php?id=".(string)$filasCategorias['id']."'> Eliminar </a>";
            echo "|";
            echo "<a href='edita_evento.php?id=".(string)$filasCategorias['id']."'> Editar </a>";
            echo "|";          
            echo "<a href='ver_evento.php?id=".(string)$filasCategorias['id']."'> Ver </a>";
   			echo '</div>';                        
   echo '</div>';    
         }
            ?>
        </div>  
        
        

<body>
</html>