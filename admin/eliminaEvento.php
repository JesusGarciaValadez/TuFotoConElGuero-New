<?php 


if (!isset($_GET['id'])) {
    echo "ParÃ¡metros incorrectos ".$_GET['id'];
}
else {
	require 'revisar/config.php'; 
	$conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);                 
	$borraEvento = "UPDATE evento SET  activo ='0' WHERE  id =".$_GET['id'].";";	
   $resultado = $conexion->query($borraEvento);
   
   //echo $resultado ;  
   //Redireccionar a la pagina de login
   if ( $resultado ) { 
		header ("Location: main.php");   
		echo "<a href='main.php'> Regresar</a>";
   }
   else {
   	echo $borraEvento; 
   	echo "No se ha confirmado la operación, vuelva a intentarlo, Si las fallas continuan contacte a Administrador</br>";
   	echo "<a href='main.php'> Regresar</a>";
   }
	
}
	
 
?>