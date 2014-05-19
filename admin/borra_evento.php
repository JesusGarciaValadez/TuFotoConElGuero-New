<?php
header('Content-Type: text/html; charset=UTF-8');
/*     
Descripcion:   Pantalla inicial que se muestra al usuario una vez que ha sido logueado correctamente. 
Author: XXX
Archivo:    eliminar_evento.php 
*/
 
//Inicializar una sesion de PHP
session_start();
 
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
    require "revisar/conectar_bd.php";
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
    			<link rel="stylesheet" href="css/admin.css" type="text/css" media="screen" />
    		
    	
    	<script type="text/javascript" src="../js/jquery.min.js"></script>
      <script type="text/javascript" src="../js/principal.js"></script>
    		
        
</head>
<body topmargin="0"  >

<div id="topControl">
	<ul>
		<li>Bienvenido <b><?php echo $nombreUsuario ?></b></li>
		<li><a href="cerrarSesion.php">Cerrar sesi&oacute;n</a></li>
	</ul>
</div>
<div id="topMenu">
<nav>
  <ul>
    <li><a href="listarusr.php">Administrar Usuarios</a></li>
    <li><a href="principal.php">Subir Archivos </a></li>
    <li class="active"><a href="main.php">Portafolio Eventos</a></li>
    <li><a href="#">Contacto</a></li>
  </ul>
</nav>
</div>

<div class="galeria">
            
            <?php
                require 'revisar/config.php';
                //require 'GestorArchivos.php';
                
                
$url_actual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];


                
                $conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);
                
                $consultaCategorias = "SELECT id , evento, descripcion , fecha  FROM evento where id = ". $_GET['id'] ." ";
                $resultadoCategorias = $conexion->query($consultaCategorias);
                while($filasCategorias = $resultadoCategorias->fetch_array(MYSQLI_ASSOC)) 
          			{  
          				echo "<h1>Borrar Evento:: <span class='evento'>". $filasCategorias['evento']  ." </span></h1>";
          				echo $filasCategorias['descripcion']  ." </p>";
          				echo "Publicado: ".$filasCategorias['fecha'] ;
          			}	
            	echo "<div class='compartir'>";            
            echo "<a href='eliminaEvento.php?id=".$_GET['id']."'> Confirme Borrar</a>";
            echo "|";            
            echo "<a href='main.php'> Regresar</a>";
   			echo '</div>';                        
   echo '</div>';   
   				echo "<div class='categoria'>";
   				echo "<label class='descripcion_evento'>". $filasCategorias['descripcion']."</label></br>" ;
                	$consulta = "SELECT archivo, directorio FROM galeriaimagenes where evento = ". $_GET['id'] ." ORDER BY id ";
                	$resultado = $conexion->query($consulta);
                	
					 	$clasecount=0;
                // Muestra las imagenes de la galeria.
                while($filas = $resultado->fetch_array(MYSQLI_ASSOC)) {                	                		
                    // Se comprueba que existan las imagenes
                    $ruta="../imagenes/".$filas["directorio"]."/".$filas["archivo"];
                    $rutaThumb="../imagenes/".$filas["directorio"]."/thumb".$filas["archivo"];                     
                    if (file_exists($ruta)){
                        echo'<a href="'.$ruta.'" ><img  src="'.$rutaThumb.'"/></a>';
                    }                    
						$clasecount=$clasecount+1;                
                } 
            echo "<div class='compartir'>";            
            echo "<a href='eliminaEvento.php?id=".$_GET['id']."'> Confirme Borrar</a>";
            echo "|";            
            echo "<a href='main.php'> Regresar</a>";
   			echo '</div>';                        
   echo '</div>';    

            ?>
            

</body>
</html>