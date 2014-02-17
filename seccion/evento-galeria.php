<?php
	define('__ROOT__', dirname(dirname(__FILE__))); 
	
	require_once(__ROOT__."/core/Model.php");
	require_once(__ROOT__."/core/Mysql.php");
	require_once(__ROOT__."/core/_global.php");
		
	class GaleriaEvento extends Model
	{
		private $fields;
		private $table;
		private $db;
		private $where;
		private $galeria;
		private $arreglo;
		
		function __construct()
		{
			$this->table[] ="evento";
			$this->table[] ="View_GaleriaEvento";
			
			$this->fields[] ="id, evento, descripcion, fecha";
			$this->fields[] ="IdImagen, directorio, archivo";
			
			
			$this->db = new MySQL();
			
			if($this->db->error)
			{
				//header("Location: ".$this->PATH_ERROR."1");
				echo "No se puede establecer conexión con la base de datos";
				exit;
			}		
		}
		
		function __destruct()	{	}
		
		function CargarSlider($idevento, $idimagen)
		{
			
			//echo $idevento . " - " . $idimagen;
			$this->CargarImagenes($idevento);
			/*$col = 4;
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
							<a href="eventos.php?id='.$temp['evento'].'&foto='.$temp["id"].'" title="">
								<img id="img-'.($j+1).''.($i+1).'" 
									src="imagenes/'. $temp[directorio] .'/thumb'.$temp[archivo].'" 
									mouse="0" onmouseover="onOver(this);" onmouseout="onOut(this);" />
							</a>
						</div>
					';
					$index = $index +1;
				}
				echo '</div>';
			}
			
			echo '</div>';*/
			
			//return $this->galeria;
			return $this->arreglo;
		}

		private function CargarImagenes($idevento)
		{
			//$this->fotos = array();
			$rsEvt = $this->get_rows(0, "activo=1 and id=".$idevento, false);
			
			if($rsEvt)
			{
				$this->ArregloImagenes($idevento);
				/*
				foreach ($rsEvt as $re) 
				{
					$this->galeria[] = array( 
											'evento' => $re->evento,
											'descripcion' => $re->descripcion,
											'fecha' => $re->fecha,
											'galeria' => $this->arreglo );	
					
				}
				
				$rsIim = $this->get_rows(0, "activo=1 and id=".$idevento, false);
				*/
			}
		}
		
		private function ArregloImagenes($idevento)
		{
			$g = new _global();
			$rsImg = $this->get_rows(1, "IdEvento=".$idevento, false);
			
			if($rsImg)
			{	
				$c=0;
				foreach ($rsImg as $ri) 
				{
					/*$this->arreglo[] = array( 'idimagen' => $ri->IdImagen,
										'directorio' => $ri->directorio,
										'archivo' => $ri->archivo);	*/
					$this->arreglo[] = array( 
											id => $ri->IdImagen,
											src => $g->URL.'imagenes/'.$ri->directorio.'/'.$ri->archivo
											 );
					$c =$c+1;
				}
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

    

