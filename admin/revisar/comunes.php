<?php
error_reporting ( E_ALL | E_STRICT );
ini_set ( "display_errors", 0 );
header('Content-Type: text/html; charset=UTF-8');

require "revisar/config.php";
require_once "../seccion/thumb.php"; 
	

	
	//Funciones para el alta de un evento 
	
	function ProcesaAlta( $evento, $descripcion, $fecha,$municipio, $tags,$folder, $conexion, $idEvento=0 ){
		
		//registramos el evento 
		if ( $idEvento == 0 ) {
			$idEvento=add_evento ( $evento, $descripcion, $fecha, $conexion);
			//echo 'Resultado de add_evento[debe regresar el id del evento insertado]'.$idEvento.'<br>';			
			if (!$idEvento ){			
					echo 'El sistema ha fallado al intentar registrar evento..<br> ';	
					return false;		
			}
			
			$procesadetalle=add_detalle_evento($idEvento,$municipio,$tags, $conexion);
			//echo 'Resultado de add_detalle_evento [debe regresar true / false ]'.$procesadetalle.'<br>';
									
			if (!$procesadetalle ){			
					echo 'El sistema ha fallado al intentar registrar los detalles del evento..<br> ';	
					return false;		
			}
			
		}
		
		
		$rutaFull="../imagenes/".$folder;
	 	$result = array();
		$result =UnificaArray ($_FILES["files"]);
	
		 //echo "ruta Inicial".$rutaFull."<br>"; 
	
		foreach ($result  as $datoFile)
		{		
				$name		=  $datoFile["name"];
				$type 	=	$datoFile["type"];
				$tmp_name=	$datoFile["tmp_name"];
				$error	=	$datoFile["error"];
				$size		= 	$datoFile["size"];
				
				if ( $size > 5000000) {
					echo "El sistema omite la imagen ".$name."por ser demasiado grande"; 
						continue;
				}
				//echo "tamaño del archivo en bytes ".$size."<br>";		
			            	
		   	//añadir registro de archivo en mysql 
		   	$id_file = add_db_image($datoFile["name"], $folder, $idEvento,$conexion);
		   	//echo 'Resultado de add_db_image en mysql  [debe regresar id_foto  ]'.$id_file.'<br>';
		   	
		   	//subir foto al servidor
		   	                    
		     $uploaded= upFile( $name, $type, $tmp_name,$error,$size, $rutaFull, $id_file, $idEvento,$conexion);
		      //echo 'Resultado de upFile  [debe regresar true / false ]'.$uploaded.'<br>';
		      
		      //Crear Thumbnail 
		      $ext= substr($name, -3,3);		      
		      
		      $ruta = $rutaFull."/".$idEvento."_".$id_file.".".$ext;
		      $rutaThumb = $rutaFull."/"."thumb".$idEvento."_".$id_file.".".$ext;
				//echo "imagen ya guardada -> ".$ruta."<br>";
		      //echo "miniatura -> ".$rutaThumb."<br>";
		      $isThumb= crea_thumb($ruta,$rutaThumb,$size); // puedo validar el thumb..
		      
		      switch($isThumb) {
		      	case -1:
		      		echo "El sistema no detecto el archivo fuente para crear el thumb ".$ruta;
		      	break;
		      	case 1:
		      		echo "El sistema creo el thumb correctamente ".$ruta;
		      	break;
		      	case 2:
		      		echo "El sistema creo el thumb correctamente y ajusto la imagen original por exceder la altura permitida   ";
		      	break;
		      	case 3:
		      		echo "El sistema creo el thumb correctamente y ajusto la imagen original por exceder el ancho  permitido   ";
		      	break;
		      	case 4:
		      		echo "El sistema creo el thumb correctamente y ajusto la imagen original para optimizar su transferencia";
		      	break;
		      	
		      	default: 
		      		echo "El sistema no detecto el resultado del proceso de crearThumbnails";
		      	break;
		      }
		      	   
		                         
	
		}
		
		return $idEvento;		
		
    }
   
   function crea_thumb ($rutaimg,$rutathumb, $sizeEnbytes) {
	//
   	
		if (file_exists($rutaimg)) {
			$size    = GetImageSize($rutaimg);
			$anchura = $size[0];
			$altura  = $size[1];
                                
			if ($altura > $anchura) {
         	$estilo  = "height";
            $ajustar = 256;
         } else {
         	$estilo  = "width";
            $ajustar = 233;
         }
       } 
       else 
       {                                
            return -1 ;
       }
                            
       //Crea la minatura con maxima resolucion 
        $mythumb = new thumb();
        $mythumb->loadImage($rutaimg);
        $mythumb->resize($ajustar, $estilo);
        
        if ($estilo == "height") {
        	$mythumb->crop(232, 153, "top");
        }
        
        $mythumb->save($rutathumb, 90);
        
        //Ajusto la  imagen si  excede el taño de 2000 px ya sea vertical u horizontal 
        
         if ($estilo =="height" && $altura > 1999) {
         	$ajustar = 600;         	
         	$imgvertical = new thumb();
        		$imgvertical->loadImage($rutaimg);
        		$imgvertical->resize($ajustar, $estilo);
        		$imgvertical->save($rutaimg, 90);
        		return 2;

         } 
         
         if ($estilo =="width" && $anchura  > 1999 ) {
				$ajustar = 800;
				$imghorizontal = new thumb();
        		$imghorizontal->loadImage($rutaimg);
        		$imghorizontal->resize($ajustar, $estilo);
        		$imghorizontal->save($rutaimg, 90);
        		return 3;
         }
         
         if ( $sizeEnbytes >  1500000 ) {
         	$img = new thumb();
        		$img->loadImage($rutaimg);
        		$img->save($rutaimg, 80);
        		return 4;
         } 
        return 1;   	
}
   
   function add_db_image ($archivo, $directorio, $evento, $conexion) {
   	//echo "Dir para almacenar en bd".$directorio."<br>";
		$consulta ="";
      $consulta = sprintf("INSERT INTO galeriaimagenes (archivo, directorio,evento) VALUES ('%s','%s','%d')", 
  	   					$conexion->real_escape_string($archivo),
  	   					$conexion->real_escape_string($directorio) ,
  	  						$conexion->real_escape_string($evento)  );
     		                	
				
		if (!$conexion)
		{
  			echo('No se puede establecer una conexion con la BD: ' . mysql_error());
  			return -1;
		}
					                    
     	if ($conexion->query($consulta))
     	{
			
			$ultimo_id = $conexion->insert_id;
			return $ultimo_id;			 
		}
		else		{ 
				echo "La inserci&oacute;n no se realiz&oacute;-> ".$consulta."</br>";  
				return -1; 							
		}      
   }
   
   
function ProcesaImagenes($idEvento, $folder, $conexion  ){
				
		$rutaFull="../imagenes/".$folder;
	 	$result = array();
		$result =UnificaArray ($_FILES["files"]);
	
		 
	$count=0;
		foreach ($result  as $datoFile)
		{		
				$name		=  $datoFile["name"];
				$type 	=	$datoFile["type"];
				$tmp_name=	$datoFile["tmp_name"];
				$error	=	$datoFile["error"];
				$size		= 	$datoFile["size"];
				
				if ( $size > 5000000) {
					echo "El sistema omite la imagen ".$name."por ser demasiado grande"; 
						continue;
				}
				echo "file  ".$datoFile["name"]."<br>";
				//echo "tamaño del archivo en bytes ".$size."<br>";	
			           	
		   	//añadir registro de archivo en mysql 
		   	$id_file = add_db_image($datoFile["name"], $folder, $idEvento,$conexion);
		   	//echo 'Resultado de add_db_image en mysql  [debe regresar id_foto  ]'.$id_file.'<br>';
		   	
		   	//subir foto al servidor
		   	                    
		     $uploaded= upFile( $name, $type, $tmp_name,$error,$size, $rutaFull, $id_file, $idEvento,$conexion);
		      //echo 'Resultado de upFile  [debe regresar true / false ]'.$uploaded.'<br>';
		      
		      //Crear Thumbnail 
		      $ext= substr($name, -3,3);		      
		      
		      $ruta = $rutaFull.$idEvento."_".$id_file.".".$ext;		       
		      $rutaThumb = $rutaFull."thumb".$idEvento."_".$id_file.".".$ext;
		      echo "img origen -> ".$ruta."<br>";
		      echo "miniatura -> ".$rutaThumb."<br>";
		      $isThumb= crea_thumb($ruta,$rutaThumb,$size); // puedo validar el thumb..
		      
		      switch($isThumb) {
		      	case -1:
		      		echo "El sistema no detecto el archivo fuente para crear el thumb ".$ruta;
		      	break;
		      	case 1:
		      		echo "El sistema creo el thumb correctamente ".$ruta;
		      	break;
		      	case 2:
		      		echo "El sistema creo el thumb correctamente y ajusto la imagen original por exceder la altura permitida   ";
		      	break;
		      	case 3:
		      		echo "El sistema creo el thumb correctamente y ajusto la imagen original por exceder el ancho  permitido   ";
		      	break;
		      	case 4:
		      		echo "El sistema creo el thumb correctamente y ajusto la imagen original para optimizar su transferencia";
		      	break;
		      	
		      	default: 
		      		echo "El sistema no detecto el resultado del proceso de crearThumbnails";
		      	break;
		      }
		      	   
		  $count+=1;                       
	
		}
		
		return $count;		
		
    }
     
   function updateNameFile ($id, $name , $conexion) {
   	$consulta = "update  galeriaimagenes set  archivo= '".$name."' where id = ".$id;
  		                	
		if (!$conexion)
		{
  			echo ('No se puede establecer una conexion con la BD: ' . mysql_error());
  			return -1;
		}
			$updated= $conexion->query($consulta);		                    
     	  return $updated; 	
   }
   
   
   function UpdateDetalles ($id_evento, $tags, $municipio, $conexion) {
   	$consulta = "update  detalle_evento set  tags= '".$tags."', municipio =".$municipio." where evento=  ".$id_evento;
  		               	
		if (!$conexion)
		{
  			echo ('No se puede establecer una conexion con la BD: ' . mysql_error());
  			return -1;
		}
			$updated= $conexion->query($consulta);		                    
     	  return $updated;      
   }
   
   function UpdateEvento ($id_evento, $evento, $descripcion, $fecha,$activo, $conexion) {
   	$consulta = "update  evento set  evento= '".$evento."', descripcion ='".$descripcion."' , fecha= '".$fecha."', activo = ".$activo." where id=  ".$id_evento;
  		                	
		if (!$conexion)
		{
  			echo ('No se puede establecer una conexion con la BD: ' . mysql_error());
  			return -1;
		}
			$updated= $conexion->query($consulta);		                    
     	  return $updated;      
   }
   
   function add_evento ($evento, $descripcion, $fecha,$conexion) {
   	$consulta = sprintf("INSERT INTO evento (evento, descripcion, fecha) VALUES ('%s','%s','%s')",	      
      $conexion->real_escape_string($evento),$conexion->real_escape_string($descripcion) ,$conexion->real_escape_string($fecha));

		echo "<br> consulta para insertar ".$consulta."<br>";
  		                	
		if (!$conexion)
		{
  			echo ('No se puede establecer una conexion con la BD: ' . mysql_error());
  			return -1;
		}
					                    
     	if ($conexion->query($consulta))
     	{
			
			$ultimo_id = $conexion->insert_id;   							
			$idEvento = $ultimo_id ; 
			return $idEvento;			 
		}
		else		{ 
				echo "La inserción no se realizó-> ".$consulta."</br>";  
				return -1; 							
		}      
   }
   
   function add_detalle_evento ($evento, $municipio, $tags, $conexion) {
   	$consulta = sprintf("INSERT INTO detalle_evento (evento, municipio, tags) VALUES ('%d','%d','%s')", 
      $conexion->real_escape_string($evento),$conexion->real_escape_string($municipio) ,$conexion->real_escape_string($tags));
  		                	
		if (!$conexion)
		{
  			echo ('No se puede establecer una conexion con la BD: ' . mysql_error());
  			return false;
		}
					                    
     	if ($conexion->query($consulta))
     	{
			return true;			 
		}
		else		{ 
				echo "La inserción no se realizó-> ".$consulta."</br>";  
				return false; 							
		}      
   }
   
   function upFile($name, $type, $tmp_name,$error,$size, $folderBase, $id_file, $idEvento,$conexion){     
        // Se comprueba que el archivo a subir sea una imagen.        	 
         $ext= substr($name, -3,3);
         //echo " extension ". $ext."<br>"; 
         $nuevo_nombre_file = $idEvento."_".$id_file.".".$ext ;
         $updated=updateNameFile ($id_file,$nuevo_nombre_file,$conexion);
         echo " nombre actualizado en bd ->1 [si] ". $updated."<br>";
         echo " nuevo_nombre_file ". $nuevo_nombre_file."<br>";
         //return true ;
         
        if( $type == "image/jpeg"){
            
            // Se comprueba si ha ocurrido algun error al subir el archivo.
            if ($error) {
                echo '<div class="error">Error '.$error.'al intentar subir el archivo '.$name.'</div>';
            }else{            	
                // Se comprueba si ya se ha creado el subdirectorio para almacenar la imagen.
                // Y se crea si no existe aun.
                // echo "folder base ".$folderBase."<br>";
                // echo "nombre fichero  ".$nuevo_nombre_file."<br>"; 

                if(!is_dir($folderBase)){
                	echo "intento de crear direcorterio " .$folderBase ."<br>"; 
                	                	
                    mkdir($folderBase, 0755,true);
                }                                                
						//Concateno base direcotior + nuvo nombre de archivo 
						                       
                $nuevo_nombre_file = $folderBase ."/".$nuevo_nombre_file;
                   echo "Ruta del archivo ". $nuevo_nombre_file ."<br>"; 
                              
                // Comprobamos que no haya ningun archivo con el mismo nombre en el servidor.
                if (file_exists( $nuevo_nombre_file )) {
                    //echo '<div class="error">Ya hay un archivo con nombre '.$nuevo_nombre_file.'. Renombralo y vuelve a subirlo.</div>';
                    //unlink($nuevo_nombre_file); //En caso de que necesitemos borrar 
                    rename($nuevo_nombre_file, $nuevo_nombre_file."_".$id_file."_".rand(1, 15000)); //Optamos por guardar una copia                     
                    move_uploaded_file($tmp_name, $nuevo_nombre_file );
                                           
                }else{
                    // Subimos la imagen.
                    move_uploaded_file($tmp_name, $nuevo_nombre_file );
                    echo '<div class="subido">Archivo '.$nuevo_nombre_file.' subido.</div>';						
                    
                }                	 
                return true;
            }
        }else{
             echo '<div class="error">'.$name.': Formato de archivo no permitido. </div>';
             return false;
        }      
    }
     
   function UnificaArray($vector) { 
    $result = array(); 
    foreach($vector as $key1 => $value1) 
        foreach($value1 as $key2 => $value2) 
            $result[$key2][$key1] = $value2; 
    return $result; 
}

   //Calcula el folder para el evento en base a la fecha
	function fijaFolderBase(){
			$hoy = getdate();						
			return $hoy["year"]."/".$hoy["month"]."/".$hoy["weekday"].$hoy["mday"];	
	}
	//Obtiene la extension de un arhivo. pero provoca un warnign.. 
	
	function obtenerExtensionFichero(  $str ){
        return end(explode(".", $str));
}

function validadatosUpImagenes ($idevento, $folder ) {
		//datos para registar el evento
		if (empty( $idevento )) return 2; 
		if (empty( $folder )) return 3;							
	return 1 ; 	
}


function validadatosDetalle ($idevento, $tags , $municipio) {
		//datos para registar el evento
		if (empty( $idevento )) return 2; 
		if (empty( $tags )) return 3;
		if (empty( $municipio )) return 4;					
	return 1 ; 	
	}


function validadatosEvento ($idevento, $evento , $descripcion, $fecha,$activo) {
		//datos para registar el evento
		if (empty( $idevento )) return 2; 
		if (empty( $evento )) return 3;
		if (empty( $descripcion )) return 4;
		if (empty( $fecha )) return 5;
		if (empty( $activo )) return 6;			
	return 1 ; 	
	}

	function validadatosAlta ($evento , $descripcion, $fecha,$municipio,$tags,$folder) {
		//datos para registar el evento 
		if (empty( $evento )) return 0;
		if (empty( $descripcion )) return 2;
		if (empty( $fecha )) return false;
		 //datos pra registrar los detalles del evento
		 if (empty( $municipio )) return 3;
		 if (empty( $tags )) return 4; 
		 
		//valores para los archios.. 
		if (empty( $folder) ) return 5;
	return 1 ; 	
	}
	
	
	function activaSelect ( $val, $val2){
		if ( $val=$val2) return "selected='selected'";
		return "";	
	} 
?>