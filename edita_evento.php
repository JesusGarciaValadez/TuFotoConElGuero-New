<?php
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
     require_once("revisar/conectar_bd.php");
    //require "conectar_bd.php";
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
    		<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
    		<script type="text/javascript" src="js/funciones.js"></script>
        
</head>
<body topmargin="0"  onLoad="cambiarOpacidadImagenes(1);" >

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

<div class="edita_galeria">            
            <?php
                
                require_once("revisar/config.php");
                require 'revisar/GestorArchivos.php';
                
                
						$url_actual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

						// Subir todas las imagenes
						
						if(isset($_POST['upload'])){
							$conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);
							//$folder = $_POST["folder"];
							//$dir, $conexion ,  $idEvento

$no = count($_FILES['files']['name']);

for ($i = 0; $i < $no; $i++) {
    // handle upload
    
    addImagenEvento ( $i,null,$conexion, $_GET['id']);
   /*echo $_FILES['files']['name'][$i]; echo "<br/>";
	echo $_FILES['files']['type'][$i];echo "<br/>";
	echo $_FILES['files']['tmp_name'][$i];echo "<br/>";
	echo $_FILES['files']['error'][$i] ;echo "<br/>";
	echo "<br/>";*/  
}

      				
						}
					
                if(isset($_POST['update'])){
                	$evento = $_POST["evento"];
                	$descripcion = $_POST["descripcion"];
                	$fecha = $_POST["fecha"];
                	$activo = $_POST["activo"];
                	
               			require 'revisar/config.php'; 
								$conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);                 
								$update = "UPDATE evento SET evento='".$evento."', descripcion='".$descripcion."', fecha = '".$fecha."',  activo =  '".$activo."' WHERE  id =".$_GET['id'].";";
								//echo $update;  	
   							$resultado = $conexion->query($update);
   							   							  
   						
   						if ( $resultado ) { 
								echo "<label class='error'>Se ha actualizado</label>";   
   						}
   						else { 
   							echo "<label class='error'>No se ha confirmado la operación, vuelva a intentarlo, Si las fallas continuan contacte a Administrador</label>";  
   						}

                 	  
               	}
                
                $conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);                
                $consultaCategorias = "SELECT id , evento, descripcion , fecha, activo  FROM evento where id = ". $_GET['id'] ." ";
                $resultadoCategorias = $conexion->query($consultaCategorias);
                echo "<div id='datos'>";
                while($filasCategorias = $resultadoCategorias->fetch_array(MYSQLI_ASSOC)) 
          			{  
          			
          				echo "<h1>Edita Evento</h1>";
          				echo "<form  method='post' class='edita'>";
          				echo "<input  class ='input-evento' type='text' name='evento' value='".$filasCategorias['evento']."' />";
          				echo "<textarea  class= 'input-descripcion'  name='descripcion'  rows='4' cols='50'  maxlength='600'>".$filasCategorias['descripcion']."</textarea>";
          				echo "<input  class ='input-fecha' type='text' name='fecha' value='".$filasCategorias['fecha']."' />";          				
          				echo "<input  class ='input-activo' type='text' name='activo' value='".$filasCategorias['activo']."' />";          				
							echo "<input class ='input-update' type='submit' name='update' value='Actualizar'>";          				
          				echo "<div style='clear:both;'></div>";          				
          				echo "</form>";

          			}
       			echo "</div>";
       			
       			echo "<div id='subirFiles'>";
       				echo "<form  enctype='multipart/form-data'  method='POST'>";
       				echo "<input type='file' name='files[]' multiple />";
       				echo "<input class ='input-upload' type='submit' name='upload' value='Subir Archivos'>";
       				echo "</form>";
       			echo "</div>";
       			echo "<div id='separador'>";
       			echo "</div>";
					$conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);

   				echo "<div class='categoria'>";
   				echo "<label class='descripcion_evento'>". $filasCategorias['descripcion']."</label><br>" ;
                	$consulta = "SELECT id, archivo, directorio FROM galeriaimagenes where evento = ". $_GET['id'] ." ORDER BY id ";
                	$resultado = $conexion->query($consulta);
					 	$clasecount=0;
                // Muestra las imagenes de la galeria.
                while($filas = $resultado->fetch_array(MYSQLI_ASSOC)) {
                	if ( $clasecount==0) {                
                		$folder =$filas["directorio"];                		
                	}
                	                		
                    // Se comprueba que existan las imagenes
                    if (file_exists("imagenes/".$filas["directorio"]."/".$filas["archivo"])){
                    		echo "<div >";
                        echo "<a href='#' ><img  src='imagenes/".$filas['directorio']."/".$filas['archivo']."'/></a>";
                        echo "<a href='revisar/eliminaImagen.php?id=".$filas["id"]."&evento=".$_GET['id']."'>Elimina Imagen</a>";
                        echo "</div>"; 
                    }
                	                    
						$clasecount=$clasecount+1;						                 
                } 
            echo "<p class='compartir'>";            
            echo "|";            
            echo "<a href='main.php'> Regresar</a>";
   			echo '</p>';                        
   echo '</div>';    

            ?>
            
        <!-- Muestra el estilo modificado para el input file y cambia la opacidad de las imagenes de la galeria     -->

<body>
</html>