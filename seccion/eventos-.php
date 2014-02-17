<?php
 
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
    private $primerFoto;
	
	function __construct()
	{		
		$this->table[] ="View_ResumenEventos";
		$this->table[] ="View_EventoReciente";
		$this->table[] ="View_Lista_Imagenes";
		$this->table[] ="View_DetalleEvento ";
		$this->table[] ="View_fotouser";
		
		
			
		$this->fields[] ="*"; //todos los campos de la vista View_ResumenEventos
		$this->fields[] ="*"; //todos los campos de la vista View_EventoReciente
		$this->fields[] ="*"; //todos los campos de la vista View_Lista_Imagenes
		$this->fields[] ="*"; //todos los campos de la vista View_Lista_Imagenes
		$this->fields[] ="*"; //todos los campos de la vista View_Lista_Imagenes
			
		
		$this->db = new MySQL();
		$this->primerFoto ="";
		
		if($this->db->error)
		{
			//header("Location: ".$this->PATH_ERROR."1");
			echo "No se puede establecer conexión con la base de datos";
			exit;
		}		
	}
	
	function __destruct()	{	}


function generaListaImgShadow( $evento,$fecha,$imgagregada)
	{	
		$idfoto=0;
		
		if(isset($_GET['foto'])){ 
			$idfoto=$_GET['foto']; 
		}
								
		$rs = $this->get_rows(2," evento =".$evento);				  	
		if($rs)
		{		
			
			foreach ($rs as $row) 
          {          					
				$rutaimg= "imagenes/".$row->directorio."/".$row->archivo;
          	
          	 if (file_exists($rutaimg) ) 
					{
						if ($row->id !=$imgagregada) {
							if ($idfoto!=$row->id) { 
								echo "<a id='foto".$evento.$row->id."' href= '".$rutaimg."'  rel='Shadowbox[principal".$evento."]'  title='".$fecha."' class='hidden'><a>";
							}							
						}						            	
            
					}
					else {
						if ($idfoto!=$row->id) {
							echo "<a id='foto".$evento.$row->id."' href= 'nd.jpg'  rel='Shadowbox[principal".$evento."]'  title='".$fecha."' class='hidden'><a>";
						}
																
					}				
		    }
		    
		      
		}
	}
	
	
	function dibujaCelda($evento,$id,$fecha,$rutaimg,$rutathumb) {
		$rsDetalle = $this->get_rows(3," evento = ".$evento);
		$fotos ="1";
		$municipio="Tapachula";
		
		if($rsDetalle)	{
			$rowEvento = $rsDetalle[0];
			$fotos = $rowEvento->fotos;
			$municipio = $rowEvento->municipio;
		}
	
		echo "<div class='tabla-col' >";		
		if ($this->primerFoto == $rutaimg) {
				echo "<a class='galeria-lightbox' href= '".$rutaimg."'  rel='Shadowbox[principall".$evento."]'  title='".$fecha."' class='hidden'>";
			}
		else { 
			echo "<a class='galeria-lightbox' href= '".$rutaimg."'  rel='Shadowbox[principal".$evento."]'  title='".$fecha."' class='hidden'>";
		}					
			echo "<img class='galeria-lightbox' src='".$rutathumb."' alt='".$fecha."'     title = '".$fecha."'>";
		echo "</a>";
			echo "<div class='span_overlay' >";
				echo "<span class='municipio'>". $municipio."</span>";
				echo "<span class='fotos'>". $fotos." imagen(es)</span>";
			echo "</div>";	
			$this->generaListaImgShadow($evento,$fecha,$id);	
		echo "</div>";
	}
	
	
	
	
function PrintEvento( $id, $foto)
	{
		$rsEvento = $this->get_rows(4," evento = " .$id ." and id= ".$foto);		
		if($rsEvento)
		{			
			$rowEvento = $rsEvento[0];			
			$parse_date = date_parse($rowEvento->fecha);	
			
			$this->primerFoto="imagenes/".$rowEvento->directorio."/".$rowEvento->archivo;
				
			$this->PrintEventos( $parse_date["year"],$parse_date["month"]);
			if(!isset($_GET["pagina"]) ) 
			{
				echo "<script>";
				echo "window.setTimeout(function(){";
					echo "  Shadowbox.open({ ";
					echo "  content: '".$this->primerFoto."',"; 
					echo "  player: 'img',";	
					echo "  gallery: 'principal".(string)$_GET['id']."',";					
					echo "title: '".$rowEvento->fecha."',";
					echo "          });";
				echo "     }, 200);";
				echo "</script>";						
			}							  
		}
	}	

	
		function PrintEventos( $anio, $mes)
	{		
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
		$rsResumenEventos = $this->get_rows(0," YEAR(  fecha ) = ".$anio. " and MONTH(fecha)=".$mes, "fecha DESC");
		//print_r($rsResumenEventos);
		echo '<div class="mes">'.$meses[$mes-1].'</div>';
		echo '<div id="msg" class="msg"></div>';
		echo '<div class="more"> <a id="morelnk" href="#">+EVENTOS</a></div>';
		echo '<div class="arriba"> <a id="menoslnk" href="#">+ARRIBA</a></div>';
				  	
		if($rsResumenEventos)
		{
			$indexCols = 1;
			$indexfilas =0;
			
			$openrow=false;
			$openpagina=false;
			
			foreach ($rsResumenEventos as $rowEvento) 
          {
          	
				$rutaimg=  "imagenes/".$rowEvento->directorio."/"     .$rowEvento->archivo;          	
          										$rutathumb="imagenes/".$rowEvento->directorio."/thumb".$rowEvento->archivo;				
				
          	//$rutathumb="imagenes/".$rowEvento->directorio."/thumb".$rowEvento->archivo;
          	 if (file_exists($rutaimg) ) 
					{
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
					}
					else {
						 //echo "<br>No existe crear foto en blanco -> ".$rutaimg;
						continue;				
					}         				
          		
          		
          		
          		if (!file_exists($rutathumb) ) 
					{
						try
       					{								
							   $mythumb = new thumb();
								if ($mythumb->loadImage($rutaimg)) {
									//echo "<br>imagen cargada ".$rutaimg."<br>";
									$mythumb->resize($ajustar,  $estilo);
									//echo "<br>imagen ajustada ".$rutaimg."<br>";
									$mythumb->crop (232,153,  'center');
									//echo "<br>imagen recortada ".$rutaimg."<br>";									
									if (!$mythumb->save($rutathumb, 90)) {
										echo "<br>No se pudo guardar ".$rutaimg."<br>";
									}
									else {
										echo "<br>nueva imagen en ".$rutaimg."<br>";
										}										
								}
								else {
									echo "<br>No se pudo cargar ".$rutaimg."<br>";									
								}	
							}
						catch(Exception $e)     
						{
  							echo $e->getMessage();
						}						
					}
					
					
						if ($openrow ) { 			//si esta bierta la fila
						 						
							if ($indexCols <= 3 ) { //agregamos una celda mas
							
									echo "<div class='tabla-celda' >";
									echo "<span>".$rowEvento->fecha."</span>";  
						 			$this->dibujaCelda($rowEvento->evento,$rowEvento->id, $rowEvento->fecha, $rutaimg,$rutathumb);
						 			echo "</div >";
						 	}
						 	else { //cerramos la fila
						 							 		
								echo "</div >";
								$indexCols=1;								
								$indexfilas+=1;
								
								if ( $indexfilas==3) {
									 echo "</div >"; // cierra pagina 
									 echo "<div class='tabla-pagina' >"; //abro nueva pagina 
									$indexfilas=0; 
								}

								
								echo "<div class='tabla-row' >";	
								echo "<div class='tabla-celda' >";
								echo "<span>".$rowEvento->fecha."</span>";
								$this->dibujaCelda($rowEvento->evento,$rowEvento->id, $rowEvento->fecha, $rutaimg,$rutathumb);
								echo "</div >";
								$openrow=true;	
								
															
						 	}
						}					 		
						else {
							if (!$openpagina) echo "<div class='tabla-pagina' >";
						 	echo "<div class='tabla-row' >";
						 	echo "<div class='tabla-celda' >";	
							echo "<span>".$rowEvento->fecha."</span>";
							$this->dibujaCelda($rowEvento->evento,$rowEvento->id, $rowEvento->fecha, $rutaimg,$rutathumb);
							echo "</div >";
							$openrow=true;	
							$openpagina=true;						
						}
				$indexCols+=1;
				
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