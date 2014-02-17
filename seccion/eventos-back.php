<?php
//define('__ROOT__', dirname(dirname(__FILE__))); 
if (!defined('__ROOT__')) 	define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__."/core/Model.php");
require_once(__ROOT__."/core/Mysql.php");
require_once(__ROOT__.'/seccion/thumb.php');

class Eventos extends Model
{
	private $fields;
    private $table;
    private $db;
    private $where;
	
	function __construct()
	{		
		$this->table[] ="View_ResumenEventos";
		$this->table[] ="View_EventoReciente";
		$this->table[] ="View_Lista_Imagenes";
			
		$this->fields[] ="*"; //todos los campos de la vista View_ResumenEventos
		$this->fields[] ="*"; //todos los campos de la vista View_EventoReciente
		$this->fields[] ="*"; //todos los campos de la vista View_Lista_Imagenes
			
		
		$this->db = new MySQL();
		
		if($this->db->error)
		{
			//header("Location: ".$this->PATH_ERROR."1");
			echo "No se puede establecer conexión con la base de datos";
			exit;
		}		
	}
	
	function __destruct()	{	}


function PrintEvento( $id, $foto)
	{		
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
	
		$rsEvento = $this->get_rows(0," evento = " .$id);		
		if($rsEvento)
		{
			
		$rowEvento = $rsEvento[0];
		
		
		$parse_date = date_parse($rowEvento->fecha);
				 		echo '<div class="mes">'.$meses[ $parse_date["month"]- 1].'</div>';				 		
				 			echo '<div class="tabla-pagina tabla-evento-reciente">';
				 			echo "<span> <h1>".$rowEvento->fecha."</h1></span>";				 	
				 			$this->get_FullEventoReciente ($rowEvento->evento,$rowEvento->fecha);				 			
				 		echo '</div>';
				 		echo '<div class="more"> <a id="morelnk" href="#">+EVENTOS</a></div>';
				 		echo '<div class="arriba"> <a id="menoslnk" href="#">+ARRIBA</a></div>';			
		$this->PrintEventoReciente( $parse_date["year"],$parse_date["month"],1);  
		}
	}
	
	function dibujaCelda($evento,$id,$fecha,$rutaimg) {
		echo "<div class='tabla-col' >";
			
			echo "<img class='galeria-lightbox' src='".$rutaimg."' alt='".$fecha."' rel='evento.php?id=".$evento."&foto=".$id."' title = '".$fecha."'>";
		echo "</div>";
	}
	
	
	function get_FullEventoReciente ($evento,$fecha) {
		$rsEvento = $this->get_rows(1 ," evento =".$evento);
		
		if($rsEvento)
		{			
			foreach ($rsEvento as $row) 
          {
			 	echo "<span><h2>".$row->descripcion."</h2></span>";
			 	//Obtener todas la miniaturas y paginar			 	
			 	
				if($row->Total<=0) 
				{ 
			   	echo "<span >"; 
			   		echo "No se encontraron imágenes en este evento"; 
			   	echo "</span>"; 
				}else
				{ 
					$numeroRegistros=$row->Total;
					$tamPag=9;
				 
					if(!isset($_GET["pagina"])) 
		   		{ 
		      	 $pagina=1; 
		      	 $inicio=1; 
		      	 $final=$tamPag; 
		   		}else{ 
		      	 $pagina = $_GET["pagina"]; 
		   		}
		   		 
		   		//calculo del limite inferior 
		   		$limitInf=($pagina-1)*$tamPag; 
		
		   		//calculo del numero de paginas 
		   		$numPags=ceil($numeroRegistros/$tamPag); 
		   	
		   		if(!isset($pagina)) 
			   	{ 
			      	 $pagina=1; 
			      	 $inicio=1; 
			      	 $final=$tamPag; 
			   	}
			   	else{ 
			      	 $seccionActual=intval(($pagina-1)/$tamPag); 
			      	 $inicio=($seccionActual*$tamPag)+1; 
			
			      	 if($pagina<$numPags) 
			      	 { 
			         	 $final=$inicio+$tamPag-1; 
			      	 }else{ 
			         	 $final=$numPags; 
			      	 } 
			
			       if ($final>$numPags){ 
			          $final=$numPags; 
			      	 } 
			   	} 
					//Aki se rellenan las imagenes 
					
					
					$rsListaImagenes = $this->get_rows(2 ," evento =".$evento, " id   LIMIT ".$limitInf.", ".$tamPag);
					//print_r($rsListaImagenes);
					$aux=0;
					$openrow=false;
					if($rsListaImagenes) //Vrificamos que la consulta se haya ejecutado 
					{			
					echo "<div class='tabla-galeria'>";
						foreach ($rsListaImagenes as $rowImg) 
          			{
							         				
          				$rutaimg= "imagenes/".$rowImg->directorio."/".$rowImg->archivo;
          				$rutathumb="imagenes/".$rowImg->directorio."/thumb".$rowImg->archivo;
          				
          				$size = GetImageSize($rutaimg);  
							$anchura=$size[0];
							$altura=$size[1];
														
							if ( $altura > $anchura ) { 
								$estilo="height";
								$ajustar=306;							
							} 
							else { 
								$estilo="width";
								$ajustar=464; 	
							}
														
          				if (file_exists($rutathumb) ) 
							{
								$rutaimg=$rutathumb;
							}
							else 
							{															  	
								$mythumb = new thumb();
								$mythumb->loadImage($rutaimg);				
								$mythumb->resize($ajustar,  $estilo);
								$mythumb->crop (232,153,  'center');									
								$mythumb->save($rutathumb, 90);
								$rutaimg=$rutathumb;											
							}
							
						 switch($aux) {
							case 0:								
									echo "<div class='tabla-row' >";	
										$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
										$openrow=true;
										break;
							case 1:
									$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
									break;
							case 2:
									$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
									$openrow=false;
									echo "</div >";
									break;
							case 3:								
									echo "<div class='tabla-row' >";	
										$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
										$openrow=true;
										break;
							case 4:
									$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
									break;
							case 5:								
									$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
									echo "</div >";
									$openrow=false;
									break;
							case 6:								
									echo "<div class='tabla-row' >";	
										$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
										$openrow=true;
										break;
							case 7:
									$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
									break;
							case 8:								
									$this->dibujaCelda($rowImg->evento,$rowImg->id, $fecha, $rutaimg);
									$openrow=false;
									echo "</div >";
									break;
							default: 	
									
									break;
						 }										
          				
						$aux+=1; 		
          			} //fin cargar todas las imagenes
          			
          			if ($openrow) echo "</div >"; // cierra row  
          			   
          			echo "</div >";// cierro tabla galeria 
          			 
          			//dibujar la paginacion
          			echo "<div class='footer-paginar'>";
          			if($pagina>1) 
				   	{ 
				   		if(isset($_GET['id'])){ //Id del evento en caso de que se pase
								 echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&id=".$_GET['id'] ."&mes=".$_GET['foto']."'>"; 
							}
							else{
							 echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&anio=".$_GET['anio'] ."&mes=".$_GET['mes']."'>";
							}
						
				      	 
				      	 echo "<"; 
				      	 echo "</a> "; 
				   	} 
				
				   	for($i=$inicio;$i<=$final;$i++) 
				   	{ 
				      	 if($i==$pagina) 
				      	 { 
				         	 echo "<b>".$i."</b> "; 
				      	 }else{
				      	 	if(isset($_GET['id'])){ //Id del evento en caso de que se pase
									echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&id=".$_GET['id'] ."&foto=".$_GET['foto']."'>"; 
								}
								else{
									echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&anio=".$_GET['anio'] ."&mes=".$_GET['mes']."'>";
								}
						 
				         	  
				         	 echo "".$i."</a> "; 
				      	 } 
				   	} 
				   	if($pagina<$numPags) 
				   	{ 
				   		if(isset($_GET['id'])){ //Id del evento en caso de que se pase
								echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&id=".$_GET['id'] ."&foto=".$_GET['foto']."'>"; 
							}
							else{
								echo " <a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&anio=".$_GET['anio'] ."&mes=".$_GET['mes']."'>";
							}
							
				      	 
				      	echo "></a>"; 
				   	}
				   	
    					//Fin paginacion 
          			//compartir social
          			echo "<div class='footer-compartir'>";				
         			echo "	<a class='lnk_eventofb' rel='pop-upfb' href=''> <img class='social' src='img/fb.png' alt='' > </a>";
         			echo "	<a class='lnk_eventotw' rel='pop-uptw' href=''> <img class='social' src='img/tw.png' alt='' > </a>";
         			echo "	<a class='lnk_eventog+' rel='pop-upg+' href=''> <img class='social' src='img/g+.png' alt='' > </a>";
         			echo "</div>"; //compartir
         			echo "</div>"; //fin div paginar   
          			     			          
		         } //Fin evaluacion contulta ejecutada 
				} //end if row->total				 	
		    }//End for 
		}//end datos 
		
	
	}

	function PrintEventoReciente( $anio, $mes,$aux)
	{		
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
	if ($aux) { 
		$rsResumenEventos = $this->get_rows(0," YEAR(  fecha ) = ".$anio. " and MONTH(fecha)=".$mes." and evento <> ".$_GET['id'], "fecha DESC");	
	}
	else {
		$rsResumenEventos = $this->get_rows(0," YEAR(  fecha ) = ".$anio. " and MONTH(fecha)=".$mes, "fecha DESC");
	}

				  	
		if($rsResumenEventos)
		{
			$indexCols = 0;
			$indexfilas =0;
			//$aux=0;
			$openrow=false;
			$openpagina=false;
			foreach ($rsResumenEventos as $rowEvento) 
          {
          	$rutathumb="imagenes/".$rowEvento->directorio."/thumb".$rowEvento->archivo;
				
				 if($aux == 0 ) {
				 						 		
				 		echo '<div class="mes">'.$meses[$mes-1].'</div>';				 		
				 			echo '<div class="tabla-pagina tabla-evento-reciente">';
				 			echo "<span> <h1>".date("d-m-Y",strtotime($rowEvento->fecha))."</h1></span>";				 	
				 			$this->get_FullEventoReciente ($rowEvento->evento,$rowEvento->fecha);				 			
				 		echo '</div>';
				 		echo '<div class="more"> <a id="morelnk" href="#">+EVENTOS</a></div>';
				 		echo '<div class="arriba"> <a id="menoslnk" href="#">+ARRIBA</a></div>';
				 	$indexCols=0;
				 }
				else {
					
					 		
							$rutaimg= "imagenes/".$rowEvento->directorio."/".$rowEvento->archivo;
          				$rutathumb="imagenes/".$rowEvento->directorio."/thumb".$rowEvento->archivo;
          	          				
          				$size = GetImageSize($rutaimg);  
							$anchura=$size[0];
							$altura=$size[1];
														
							if ( $altura > $anchura ) { 
								$estilo="height";
								$ajustar=306;							
							} 
							else { 
								$estilo="width";
								$ajustar=464; 	
							}
							
							
          				if (file_exists($rutathumb) ) 
							{
								$rutaimg=$rutathumb;
							}
							else 
							{															  	
								$mythumb = new thumb();
								$mythumb->loadImage($rutaimg);				
								$mythumb->resize($ajustar,  $estilo);
								$mythumb->crop (232,153,  'center');									
								$mythumb->save($rutathumb, 90);
								$rutaimg=$rutathumb;											
							}
						
						if ($openrow ) { 			//si esta bierta la fila 						
							if ($indexCols <= 3 ) { //agregamos una celda mas
							
									echo "<div class='tabla-celda' >";
									echo "<span>".$rowEvento->fecha."</span>";  
						 			$this->dibujaCelda($rowEvento->evento,$rowEvento->id, $rowEvento->fecha, $rutaimg);
						 			echo "</div >";
						 	}
						 	else { //cerramos la fila						 		
								echo "</div >";
								$indexCols=1;								
								$indexfilas+=1;
								if ( $indexfilas==3) {
									 echo "</div >"; // cierra pagina 
									 echo "<div class='tabla-pagina' >"; //abro nueva pagina 
									$indexfilas=1; 
								}

								
								echo "<div class='tabla-row' >";	
								echo "<div class='tabla-celda' >";
								echo "<span>".$rowEvento->fecha."</span>";
								$this->dibujaCelda($rowEvento->evento,$rowEvento->id, $rowEvento->fecha, $rutaimg);
								echo "</div >";
								$openrow=true;	
								
															
						 	}
						}					 		
						else {
							if (!$openpagina) echo "<div class='tabla-pagina' >";
						 	echo "<div class='tabla-row' >";
						 	echo "<div class='tabla-celda' >";	
							echo "<span>".$rowEvento->fecha."</span>";
							$this->dibujaCelda($rowEvento->evento,$rowEvento->id, $rowEvento->fecha, $rutaimg);
							echo "</div >";
							$openrow=true;	
							$openpagina=true;						
						}
						
						
				}
				$indexCols+=1;
				$aux+=1;
		    }
		    if ($openrow) echo "</div >"; // cierra row
		    if ($openpagina) echo "</div >"; // cierra row  
		}
	}
	
	private function get_rows($categoria, $where_str=false, $order_str=false)
	{
	   $where_str =$where_str ? "$where_str " : "";	
	   $order_str =$order_str ? "$order_str " : "";	   
	   	  
	   $rst = $this->getlist($this->db, $this->table[$categoria] ,$this->fields[$categoria], $where_str, $order_str );
       return $rst;
    } 
	
	
}
?>