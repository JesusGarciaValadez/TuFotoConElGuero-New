<?php
define('__ROOT__', dirname(dirname(__FILE__))); 

require_once(__ROOT__."/core/Model.php");
require_once(__ROOT__."/core/Mysql.php");

class Menu extends Model
{
	private $fields;
    private $table;
    private $db;
    private $where;
	
	function __construct()
	{
		$this->table[] ="View_EventosAnios";
		$this->table[] ="View_EventosMeses";
		$this->fields[] ="Anio";
		$this->fields[] ="Mes";
		//$this->where ="";	
		
		$this->db = new MySQL();
		
		if($this->db->error)
		{
			//header("Location: ".$this->PATH_ERROR."1");
			echo "No se puede establecer conexión con la base de datos";
			exit;
		}		
	}
	
	function __destruct()	{	}
	
	function PrintMenu( $anio, $mes )
	{
		if( is_null($anio))
			$anio = 0;
		
		//$css_Active="";
		$anio_active="";
		$mes_activo="init";
			
		echo '<ul id="nav-evento">';
		
		$rsAnio = $this->get_rows(0,false, "Anio DESC");  ///leyendo años de eventos [0]
		
		if($rsAnio)
		{
			foreach ($rsAnio as $ra) 
            {
				$rsMes =  $this->get_rows(1,"Anio=".$ra->Anio, "Mes DESC"); 
				
				if($ra->Anio == $anio)
					$anio_active ='id="submenu-'.$anio.'"';
				else
					$anio_active="";
				
				
				
				echo "\n";
				echo '<li class="has-sub">
						<a '.$anio_active.' href="#" onclick="return false;">
							<span>'.$ra->Anio.'</span>
						</a>';
				
				if($rsMes)
				{
					echo '<ul>';
					foreach ($rsMes as $rm)
            		{//eventos.php?anio='.$ra->Anio.'&mes='.$rm->Mes.'">
					
						if((int)$rm->Mes == (int)$mes)						
							$mes_activo="mes-activo";
						else
							$mes_activo="noactive";
						
						echo '<li class="'.$mes_activo.' ">
								<a href="eventos.php?anio='.$ra->Anio.'&mes='.$rm->Mes.'">
									<span>'.$this->get_nombremes($rm->Mes).'</span>
								</a>
							  </li>';
					}
					echo '</ul>
						</li>';
				}
		    }
		}		
		echo '</ul>';
	}
	
	private function get_rows($categoria, $where_str=false, $order_str=false)
	{
	   $where_str =$where_str ? "$where_str " : "";	
	   $order_str =$order_str ? "$order_str " : "";	   
	   	  
	   $rst = $this->getlist($this->db, $this->table[$categoria] ,$this->fields[$categoria], $where_str, $order_str );
       return $rst;
    } 
	
	private function get_nombremes($mes)
	{
		$nombremes="";
		
		switch($mes) 
      	 { 
      	 case 1: 
         	 $nombremes="Enero"; 
         	 break; 
      	 case 2: 
         	 $nombremes="Febrero"; 
         	 break; 
      	 case 3: 
         	 $nombremes="Marzo"; 
         	 break; 
      	 case 4: 
         	 $nombremes="Abril"; 
         	 break; 
      	 case 5: 
         	 $nombremes="Mayo"; 
         	 break; 
      	 case 6: 
         	 $nombremes="Junio"; 
         	 break; 
      	 case 7: 
         	 $nombremes="Julio"; 
         	 break; 
      	 case 8: 
         	 $nombremes="Agosto"; 
         	 break; 
      	 case 9: 
         	 $nombremes="Septiembre"; 
         	 break; 
      	 case 10: 
         	 $nombremes="Octubre"; 
         	 break; 
      	 case 11: 
         	 $nombremes="Noviembre"; 
         	 break; 
      	 case 12: 
         	 $nombremes="Diciembre"; 
         	 break; 
      	 } 
		 
		 return $nombremes;
	}
}
?>