<?php
	//require_once("core/_global.php");	
	require_once("seccion/top-new.php");
	
	$i = new GaleriaTop();	
		
	$fotos = $i->MasImagenes();
	
	echo json_encode($fotos); 
	?>