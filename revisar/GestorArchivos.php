<?php

    /**
     * Funcion que comprueba los input file que contienen algo y llama a la funcion encargada de subir las imagenes.
     * 
     * @param type $dir Directorio en el que se quiere subir las imagenes (usar '' si no se quiere usar un subdirectorio).
     * @param $conexion Conexion con la base de datos.
     */
     
     
       function addImagenEvento($index, $dir, $conexion ,  $idEvento ){     
        // Se comprueba que el archivo a subir sea una imagen.
			
			$valor=trim($dir);
		     if(empty($valor))
     			{
     				
     					$consulta ="SELECT directorio FROM galeriaimagenes WHERE evento =". $idEvento." LIMIT 1";
     	 				$folders= $conexion->query($consulta);
     	 				$folder = $folders->fetch_array(MYSQLI_ASSOC);
     	 				$dir=$folder["directorio"];     	 				         
     			}
     else
     {
			echo "valido".$dir;          
         
     }			 
			 
        if($_FILES['files']['type'][$index]  == "image/jpeg"){
            
            // Se comprueba si ha ocurrido algun error al subir el archivo.
            if ($_FILES['files']["error"][$index]) {
                echo '<div class="error">Error '.$_FILES["files"]["error"][$index].'al intentar subir el archivo '.$_FILES["files"]["name"][$index].'</div>';
            }else{
            	
                // Se comprueba si ya se ha creado el subdirectorio para almacenar la imagen.
                // Y se crea si no existe aun.
                if(!is_dir("imagenes/".$dir)){
                    echo '<div class="error">El directorio no existe</div>';
                    return ;
                }
                                                
					
                // Comprobamos que no haya ningun archivo con el mismo nombre en el servidor.
                if (file_exists("imagenes/".$dir."/".$_FILES["files"]["name"][$index])) {
                	echo '<div class="error">Ya hay un archivo con nombre '.$_FILES["files"]["name"][$index].'. Renombralo y vuelve a subirlo.</div>';   
                }else{
                    // Subimos la imagen.
                    move_uploaded_file($_FILES["files"]["tmp_name"][$index], "imagenes/".$dir."/".$_FILES["files"]["name"][$index]);
                    echo '<div class="subido">Archivo '.$_FILES["files"]["name"][$index].' subido.</div>';
							
                    	//Agregar registro de imagen en el         
                    	// Agregamos la imagen a la base de datos.
                    $consulta ="";
                    $consulta = sprintf("INSERT INTO galeriaimagenes (archivo, directorio,evento) VALUES ('%s','%s','%d')", 
                    		$conexion->real_escape_string($_FILES["files"]["name"][$index]),$conexion->real_escape_string($dir) ,$conexion->real_escape_string($idEvento)
                    );
                    //echo "La nueva consulta es ".$consulta."</br>";
                    // Se ejecuta la consulta.
                    $conexion->query($consulta);
                }
            }
        }else{
             echo '<div class="error">'.$_FILES[$archivo]["name"].': Formato de archivo no permitido. </div>';
        }      
    }

    function subirImagenes($dir, $conexion){
        // Recorremos la lista de campos para subir archivos.
        foreach ($_FILES  as $key => $value) {
            // Se comprueba si el nombre del archivo no esta vacio para subirlo
            if ($_FILES[$key]["name"] != ''){
                subirImagen($key, $dir, $conexion);                
            }
        }
    }
    //subirImagenesConEvento($folder,$conexion,$evento , $descripcion, $fecha, $idEvento);
    function subirImagenesConEvento($dir, $conexion , $evento, $descripcion, $fecha, $idEvento){
        // Recorremos la lista de campos para subir archivos.
        foreach ($_FILES  as $key => $value) {
            // Se comprueba si el nombre del archivo no esta vacio para subirlo
            if ($_FILES[$key]["name"] != ''){            	
               subirImagenConEvento($key, $dir, $conexion,  $evento, $descripcion, $fecha, $idEvento);
                
            }
        }
    }


    function subirImagenConEvento($archivo, $dir, $conexion ,  $evento, $descripcion, $fecha, $idEvento ){     
        // Se comprueba que el archivo a subir sea una imagen.
         
        if($_FILES[$archivo]["type"] == "image/jpeg"){
            
            // Se comprueba si ha ocurrido algun error al subir el archivo.
            if ($_FILES[$archivo]["error"]) {
                echo '<div class="error">Error '.$_FILES["archivo"]["error"].'al intentar subir el archivo '.$_FILES[$archivo]["name"].'</div>';
            }else{
            	
                // Se comprueba si ya se ha creado el subdirectorio para almacenar la imagen.
                // Y se crea si no existe aun.
                if(!is_dir("imagenes/".$dir)){
                    mkdir("imagenes/".$dir, 0755);
                }
                                                
                try {
							if ( $idEvento == 0 ) {								  						
  									$consulta = sprintf("INSERT INTO evento (evento, descripcion, fecha) VALUES ('%s','%s','%s')", 
                    				$conexion->real_escape_string($evento),$conexion->real_escape_string($descripcion) ,$conexion->real_escape_string($fecha)
                    			);
  							
                  	
					if (!$conexion)
					{
	  					die('No se puede establecer una conexion con la BD: ' . mysql_error());
					}
					                    
                    	if ($conexion->query($consulta))
                    	{
   							
   							$ultimo_id = $conexion->insert_id;   							
   							$idEvento = $ultimo_id ; 
   							 
							}
							else		{ 
   								echo "La inserción no se realizó-> ".$consulta."</br>";  
   								return; 							
							}                    
						} else { 
							$ultimo_id = $idEvento;
							//echo "No se inserta evento ".$ultimo_id."</br>"; 	
						}
	
					} catch (ErrorException $e) {
        				// este bloque no se ejecuta, no coincide el tipo de excepción
        				echo 'ErrorException' . $e->getMessage();
    				} catch (Exception $e) {
        				// este bloque captura la excepción
        				echo 'Exception' . $e->getMessage();
    				}



                //Verificamos si no  esta registrado el evento
					
					
                // Comprobamos que no haya ningun archivo con el mismo nombre en el servidor.
                if (file_exists("imagenes/".$dir."/".$_FILES[$archivo]["name"])) {
                    echo '<div class="error">Ya hay un archivo con nombre '.$_FILES[$archivo]["name"].'. Renombralo y vuelve a subirlo.</div>';   
                }else{
                    // Subimos la imagen.
                    move_uploaded_file($_FILES[$archivo]["tmp_name"], "imagenes/".$dir."/".$_FILES[$archivo]["name"]);
                    echo '<div class="subido">Archivo '.$_FILES[$archivo]["name"].' subido.</div>';
							
                    	//Agregar registro de imagen en el         
                    	// Agregamos la imagen a la base de datos.
                    $consulta ="";
                    $consulta = sprintf("INSERT INTO galeriaimagenes (archivo, directorio,evento) VALUES ('%s','%s','%d')", 
                    		$conexion->real_escape_string($_FILES[$archivo]["name"]),$conexion->real_escape_string($dir) ,$conexion->real_escape_string($ultimo_id)
                    );
                    //echo "La nueva consulta es ".$consulta."</br>";
                    // Se ejecuta la consulta.
                    $conexion->query($consulta);
                }
            }
        }else{
             echo '<div class="error">'.$_FILES[$archivo]["name"].': Formato de archivo no permitido. </div>';
        }      
    }    

    /**
     * Funcion para subir imagenes
     * 
     * @param $campoArchivo Nombre del campo en el que se subira el archivo.
     * @param $dir Directorio en el que se guardara la imagen. 
     * @param $conexion Conexion con la base de datos.
     */
    function subirImagen($archivo, $dir, $conexion){     
        // Se comprueba que el archivo a subir sea una imagen.
        if($_FILES[$archivo]["type"] == "image/jpeg"){
            
            // Se comprueba si ha ocurrido algun error al subir el archivo.
            if ($_FILES[$archivo]["error"]) {
                echo '<div class="error">Error '.$_FILES["archivo"]["error"].'al intentar subir el archivo '.$_FILES[$archivo]["name"].'</div>';
            }else{
            
                // Se comprueba si ya se ha creado el subdirectorio para almacenar la imagen.
                // Y se crea si no existe aun.
                if(!is_dir("imagenes/".$dir)){
                    mkdir("imagenes/".$dir, 0755);
                }

                // Comprobamos que no haya ningun archivo con el mismo nombre en el servidor.
                if (file_exists("imagenes/".$dir."/".$_FILES[$archivo]["name"])) {
                    echo '<div class="error">Ya hay un archivo con nombre '.$_FILES[$archivo]["name"].'. Renombralo y vuelve a subirlo.</div>';   
                }else{
                    // Subimos la imagen.
                    move_uploaded_file($_FILES[$archivo]["tmp_name"], "imagenes/".$dir."/".$_FILES[$archivo]["name"]);
                    echo '<div class="subido">Archivo '.$_FILES[$archivo]["name"].' subido.</div>';
							//Obtener el id del evento                     
                    	//Registrar el Evento  si no existe 
                    
                    	//Agregar registro de imagen en el         
                    	// Agregamos la imagen a la base de datos.
                    $consulta = sprintf("INSERT INTO galeriaimagenes (archivo, directorio) VALUES ('%s','%s')",          
                        $conexion->real_escape_string($_FILES[$archivo]["name"]),
                        $conexion->real_escape_string($dir)
                    );
                    
                    // Se ejecuta la consulta.
                    $conexion->query($consulta);
                }
            }
        }else{
             echo '<div class="error">'.$_FILES[$archivo]["name"].': Formato de archivo no permitido. </div>';
        }      
    }


       
    function calculaclase( $val )   {
    	if (  $val < 8 )  { 
    			return (string)$val;  
    	}
    	else { 		return "0"; }
    	}
			 
    
?>