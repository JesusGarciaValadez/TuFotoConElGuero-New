<?php

error_reporting ( E_ALL | E_STRICT );
ini_set ( "display_errors", 1 );
header('Content-Type: text/html; charset=UTF-8');               	

//require "revisar/GestorArchivos.php";
require "revisar/config.php"; 
require_once("revisar/comunes.php");
                      	
 $idEvento=0; 
 $conexion = new mysqli($servidor, $usuarioBD, $passwordBD, $baseDatos);
 	             	
               
if(isset($_POST['submit_add'])){
    	
    	
 	$evento = $_POST["evento"];
 	echo "evento->" .$evento."<br>";
 	
 	
 	$descripcion = $_POST["descripcion"];
 	echo "descripcion->" .$descripcion ."<br>";
 	
 	$fecha = $_POST["date"];
 	echo "fecha->" .$fecha ."<br>";
 	
 	$municipio = $_POST["location"];
 	echo "municipio->" .$municipio ."<br>";
	
	$tags = $_POST["tags"];
 	echo "tags->" .$tags."<br>";
 	
 	$folder = $_POST["folder"];
 	echo "folder->" .$folder ."<br>";
 										 
 	$SonValidos=validadatosAlta($evento , $descripcion, $fecha,$municipio,$tags,$folder);
 	echo "Resultado de SonValidos".$SonValidos."<br>";
 	
 	if ( $SonValidos == 1 ){ 		
 		$procesa=ProcesaAlta( $evento, $descripcion, $fecha,$municipio, $tags,$folder,$conexion,0);
 		//echo "<br>Resultado de ProcesaAlta-> ".$procesa."<br>";
 		//return;
 		if ($procesa > 0 )  
 			header ("Location:admin_principal.php?id_evento=".$procesa);
 		else 
 			echo "<br>No se confirmo el proceso, revise la pila de msgs en la pagina <br><a href='admin_principal.php'> Regresar</a>";   
 	}
 	else { 
		echo "No se ha confirmado la operación(DATOS INCOMPLETOS), vuelva a intentarlo".$SonValidos."</br>";
		echo "<a href='admin_principal.php'> Regresar</a>";                	
 	}
}
?>