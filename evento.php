<?php
	//require_once("core/_global.php");	
	require_once("seccion/evento-galeria.php");
	
	//$g = new _global();
		


		if (isset($_GET["id"])){ 
			$galeria = new GaleriaEvento();
			
			$idevento=$_GET['id'];
			$idimagen=0;
			
			if( isset($_GET["foto"]) ){
				$idimagen = $_GET['foto'];
			}
			
			$fotos = $galeria->CargarSlider($idevento, $idimagen);
			
			echo json_encode($fotos); 
		}
	?>