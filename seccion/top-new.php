<?php
	//define('__ROOT__', dirname(dirname(__FILE__))); 
	if (!defined('__ROOT__')) 	define('__ROOT__', dirname(dirname(__FILE__)));
	require_once(__ROOT__."/core/Model.php");
	require_once(__ROOT__."/core/Mysql.php");
	require_once(__ROOT__.'/seccion/thumb.php');
	
	class GaleriaTop extends Model
	{
		private $fields;
		private $table;
		private $db;
		private $where;
		private $fotos;
		
		function __construct()
		{
			$this->table[] ="View_GaleriaTop";
			
			$this->fields[] ="id, evento, directorio, archivo, fecha";
			
			
			$this->db = new MySQL();
			
			if($this->db->error)
			{
				//header("Location: ".$this->PATH_ERROR."1");
				echo "No se puede establecer conexión con la base de datos";
				exit;
			}		
		}
		
		function __destruct()	{	}
		
		function MasImagenes()
		{
			//
			$this->CargarImagenes();//24
			//$this->CargarImagenes();//24
			//$this->CargarImagenes();//24
			
			return $this->fotos;
		}
		
		function MostrarGaleria()
		{
			$this->CargarImagenes();
			$col = 4;
			$row = 3;
			$index =0;
			
			echo '<div class="tabla-galeria">';
	
			for($i=0; $i<$row; $i++)
			{
				echo '<div id="fil-'.($i+1).'" class="tabla-row">';
				for($j=0; $j<$col; $j++)
				{
					//$index = rand(1,count($this->fotos)  ) - 1;
					
					$temp =  $this->fotos[$index];
					echo '
						<div id="col-'.($j+1).'" class="tabla-col"> 
							<a href="eventos.php?anio='.$temp['anio'].'&mes='.$temp['mes'].'&id='.$temp['evento'].'&foto='.$temp["foto"].'" title="">
								<img id="img-'.($j+1).''.($i+1).'" 
									src="imagenes/'. $temp["directorio"] .'/thumb'.$temp["archivo"].'" 
									mouse="0" onmouseover="TFG.onOver(this);" onmouseout="TFG.onOut(this);" />
							</a>
						</div>
					';
					$index = $index +1;
				}
				echo '</div>';
			}
			
			echo '</div>';
			
			$this->fotos=null;
			//$this->CargarImagenes();
			$this->CargarImagenes();
			
			return $this->fotos;
		}
		
		private function CargarImagenes()
		{
			//$this->fotos = array();
			$rsImg = $this->get_rows(0,false, false);
			
			if($rsImg)
			{
				foreach ($rsImg as $ri) 
				{
					//Comprobar la imagen y la miniatura 
					$this->ComprobarImagenMiniatura($ri);
					//echo count( $this->fotos[1]);
				}
			}
		}
		
		private function ComprobarImagenMiniatura($img)
		{
			$rImagen = __ROOT__."/imagenes/".$img->directorio."/".$img->archivo;
			$rThumb = __ROOT__."/imagenes/".$img->directorio."/thumb".$img->archivo;
			
			//echo $rImagen;
			if (file_exists($rImagen) )
			{
				if (!file_exists($rThumb) )
				{
					
					$mythumb = new thumb();
					$mythumb->loadImage($rImagen);				
					$mythumb->crop(233, 153, 'top');
					$mythumb->save($rThumb, 90);					
				}	
				
				$this->fotos[] = array( 'foto' => $img->id,
										'evento' => $img->evento,
										'directorio' => $img->directorio,
										'archivo' => $img->archivo,
										'anio' => date("Y", strtotime($img->fecha)),
										'mes' => date("m",  strtotime($img->fecha)));
																	
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

    

