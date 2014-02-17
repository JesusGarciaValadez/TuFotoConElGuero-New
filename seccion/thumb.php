<?php
class thumb {

var $image;
var $type;
var $width;
var $height;
var $name; 

//---Método de leer la imagen
function loadImage($name) {
	 try{	 	
			//---Tomar las dimensiones de la imagen
			$info = GetImageSize($name);		
			$this->width = $info[0];
			$this->height = $info[1];
			$this->type = $info[2];
 			//echo"<br> tamaño y tipo listo<br> tipo imagen ".$this->type;
 			//echo"<br>IMAGETYPE_JPEG =  ".IMAGETYPE_JPEG;
 			
			//---Dependiendo del tipo de imagen crear una nueva imagen
			switch($this->type){
				case IMAGETYPE_JPEG:				
					$this->image = imagecreatefromjpeg($name);				
				//$this->image = imagecreatefromjpeg($name);					
				break;
				case IMAGETYPE_GIF:
				$this->image = imagecreatefromgif($name);
				break;
				case IMAGETYPE_PNG:
				$this->image = imagecreatefrompng($name);
				break;
			}
		
		if(!$this->image)
    			{
        				/* Crear una imagen en blanco */
        				$this->image  = imagecreatetruecolor(150, 30);
        				$fondo = imagecolorallocate($this->image, 255, 255, 255);
        				$ct  = imagecolorallocate($this->image, 0, 0, 0);
        				imagefilledrectangle($this->image, 0, 0, 150, 30, $fondo);
        				/* Imprimir un mensaje de error */
        				imagestring($this->image, 1, 5, 5, 'Error cargando ' . $name, $ct);
    			}
		return true;			
	 	}
	 	catch (Exception $e)
	 	{    
         echo "Error al cargar imagen ".$e->getMessage();
         return false;
    	}


}

//---Método de guardar la imagen
function save($name, $quality = 100) {
	//---Guardar la imagen en el tipo de archivo correcto
	switch($this->type){
	case IMAGETYPE_JPEG:
		imagejpeg($this->image, $name, $quality);
	break;
	case IMAGETYPE_GIF:
		imagegif($this->image, $name);
	break;
	case IMAGETYPE_PNG:
		$pngquality = floor(($quality - 10) / 10);
		imagepng($this->image, $name, $pngquality);
	break;
	}
	return true;
}

//---Método de mostrar la imagen sin salvarla
function show() {

//---Mostrar la imagen dependiendo del tipo de archivo
switch($this->type){
case IMAGETYPE_JPEG:
	imagejpeg($this->image);
break;
case IMAGETYPE_GIF:
	imagegif($this->image);
break;
case IMAGETYPE_PNG:
	imagepng($this->image);
break;
}
}

//---Método de redimensionar la imagen sin deformarla
function resize($value, $prop){
	
	//---Determinar la propiedad a redimensionar y la propiedad opuesta
	$prop_value = ($prop == 'width') ? $this->width : $this->height;
	$prop_versus = ($prop == 'width') ? $this->height : $this->width;
	
	//---Determinar el valor opuesto a la propiedad a redimensionar
	$pcent = $value / $prop_value;
	$value_versus = $prop_versus * $pcent;
	
	//---Crear la imagen dependiendo de la propiedad a variar
	$image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus) : imagecreatetruecolor($value_versus, $value);
	
	//---Hacer una copia de la imagen dependiendo de la propiedad a variar
	switch($prop){
	
	case 'width':
		imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);
	break;
	
	case 'height':
		imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);
	break;
	
	}
	
	//---Actualizar la imagen y sus dimensiones
	//$info = getimagesize($name);
	
	$this->width = imagesx($image);
	$this->height = imagesy($image);
	$this->image = $image;

}

//---Método de extraer una sección de la imagen sin deformarla
function crop($cwidth, $cheight, $pos = 'center') {

//---Dependiendo del tamaño deseado redimensionar primero la imagen a uno de los valores
if($cwidth > $cheight){
$this->resize($cwidth, 'width');
}else{
$this->resize($cheight, 'height');
}

//---Crear la imagen tomando la porción del centro de la imagen redimensionada con las dimensiones deseadas
$image = imagecreatetruecolor($cwidth, $cheight);

switch($pos){

case 'center':
imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
break;

case 'left':
imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
break;

case 'right':
imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
break;

case 'top':
imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
break;

case 'bottom':
imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
break;

}

$this->image = $image;
}

}
?>