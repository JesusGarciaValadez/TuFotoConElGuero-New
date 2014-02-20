<?php
 //require_once("eventos.php");
 //redirect('eventos.php?municipio='.$municipio.'&fecha='.$fecha);
//}

$municipio = trim($_POST['location']);
$fecha = trim($_POST['date']);  
header("Location:eventos.php?municipio={$municipio}&fecha={$fecha}");

// if($_POST['submit_search'] == "Submit") 
//{
	
	// 	$municipio = $_POST['location1'];
 	//	$fecha = $_POST['date_search'];
 		//$eventos = new Eventos();
   
     
//}
 
    
 
 
 
?>