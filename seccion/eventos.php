<?php

if (!defined('__ROOT__'))
    define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/core/Model.php");
require_once(__ROOT__ . "/core/Mysql.php");
require_once(__ROOT__ . '/seccion/thumb.php');

class Eventos extends Model {
    private $fields;
    private $table;
    private $db;
    private $where;
    public $primerFoto;
    private $omitir_in_hide;
    function __construct() {
        $this->table[] = "View_Eventos";
        //$this->table[] ="View_ResumenEventos";
        $this->table[] = "View_EventoReciente";
        $this->table[] = "View_Lista_Imagenes";
        $this->table[] = "View_DetalleEvento ";
        $this->table[] = "View_fotouser";
        
        
        
        $this->fields[] = "*"; //todos los campos de la vista View_ResumenEventos
        $this->fields[] = "*"; //todos los campos de la vista View_EventoReciente
        $this->fields[] = "*"; //todos los campos de la vista View_Lista_Imagenes
        $this->fields[] = "*"; //todos los campos de la vista View_Lista_Imagenes
        $this->fields[] = "*"; //todos los campos de la vista View_Lista_Imagenes
        
        
        $this->db         = new MySQL();
        $this->primerFoto = "";
        
        if ($this->db->error) {
            //header("Location: ".$this->PATH_ERROR."1");
            echo "No se puede establecer conexión con la base de datos";
            exit;
        }
    }
    
    function __destruct() {}
    
    function generaListaImgShadow_lighbox($evento) {
        $idfoto = 0;
        //print_r($this->omitir_in_hide);
        //return;
        if (isset($_GET['foto'])) {
            $idfoto = $_GET['foto'];
        }
        
        $rs = $this->get_rows(2, " evento =" . $evento);
        if ($rs) {
            
            foreach ($rs as $row) {
                $rutaimg = "imagenes/" . $row->directorio . "/" . $row->archivo;
                
                if (file_exists($rutaimg)) {
                    if ($row->id != $imgagregada) {
                        if ($idfoto != $row->id) {
                            if (!in_array($row->id, $this->omitir_in_hide, true)) {
                                echo "<a id='foto" . $evento . $row->id . "' href= '" . $rutaimg . "'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'><a>";
                            }
                            
                        }
                    }
                } else {
                    if ($idfoto != $row->id) {
                        echo "<a id='foto" . $evento . $row->id . "' href= 'nd.jpg'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'><a>";
                    }
                    
                }
            }
            
            
        }
    }
    function generaListaImgShadow($evento, $fecha, $imgagregada) {
        $idfoto = 0;
        
        if (isset($_GET['foto'])) {
            $idfoto = $_GET['foto'];
        }
        
        $rs = $this->get_rows(2, " evento =" . $evento);
        if ($rs) {
            
            foreach ($rs as $row) {
                $rutaimg = "imagenes/" . $row->directorio . "/" . $row->archivo;
                
                if (file_exists($rutaimg)) {
                    if ($row->id != $imgagregada) {
                        if ($idfoto != $row->id) {
                            
                            
                            echo "<a id='foto" . $evento . $row->id . "' href= '" . $rutaimg . "'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'><a>";
                            
                            
                        }
                    }
                } else {
                    if ($idfoto != $row->id) {
                        echo "<a id='foto" . $evento . $row->id . "' href= 'nd.jpg'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'><a>";
                    }
                    
                }
            }
            
            
        }
    }
    
    function dibujaCelda($evento, $id, $fecha, $rutaimg, $rutathumb, $class = 'img-width', $descripcion = 'Sin Descripción') {
        $meses = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
        
        $rsDetalle = $this->get_rows(3, " evento = " . $evento);
        
        $fotos     = "1";
        $municipio = "Tapachula";
        
        if ($rsDetalle) {
            $rowEvento = $rsDetalle[0];
            $fotos     = $rowEvento->fotos;
            $municipio = $rowEvento->municipio;
        }
        
        $parse_date = date_parse($fecha);
        
        
        
        echo '<div class="caja_eventos">
<!--Municipio-->
<div class="muni">
 ' . $municipio . '
</div>
<div class="fecha_event">';
        echo $parse_date["day"] . ' de ' . $meses[$parse_date["month"] - 1] . ' de ' . $parse_date["year"];
        echo '</div>
<hr  align="LEFT" size="1"  color="#999999" noshade> 
<div class="Img-foto">';
        
        if ($this->primerFoto == $rutaimg) {
            echo "<a class='" . $class . "'  href='eventos.php?anio='" . $parse_date["year"] . "&mes=" . $parse_date["month"] . "  &id=" . $evento . "&foto=" . $id . "'  title='" . $fecha . "' class='hidden'>";
        } else {
            echo "<a class='" . $class . "'  href='eventos.php?anio=" . $parse_date["year"] . "&mes=" . $parse_date["month"] . "&id=" . $evento . "&foto=" . $id . "'    title='" . $fecha . "' class='hidden'>";
        }
        echo "<img width='206' height='145' class='" . $class . "' src='" . $rutathumb . "' alt='" . $fecha . "'     title = '" . $fecha . "'>";
        echo "</a>";
        
        
        echo '</div>
<div class="descrip_event">' . substr($descripcion, 70) . '...</div>';
        
        
        //$this->generaListaImgShadow($evento,$fecha,$id);
        echo '</div>';
        
    }
    function dibujaCeldaConLinks($evento, $id, $fecha, $rutaimg, $rutathumb, $class = 'img-width', $descripcion = 'Sin Descripción') {
        $meses = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
        
        $rsDetalle = $this->get_rows(3, " evento = " . $evento);
        
        $fotos     = "1";
        $municipio = "Tapachula";
        
        if ($rsDetalle) {
            $rowEvento = $rsDetalle[0];
            $fotos     = $rowEvento->fotos;
            $municipio = $rowEvento->municipio;
        }
        
        $parse_date = date_parse($fecha);
        
        
        
        echo '<div class="caja_eventos">
<!--Municipio-->
<div class="muni">
 ' . $municipio . '
</div>
<div class="fecha_event">';
        echo $parse_date["day"] . ' de ' . $meses[$parse_date["month"] - 1] . ' de ' . $parse_date["year"];
        echo '</div>
<hr  align="LEFT" size="1"  color="#999999" noshade> 
<div class="Img-foto">';
        
        if ($this->primerFoto == $rutaimg) {
            echo "<a class='" . $class . "' href= '" . $rutaimg . "'  rel='Shadowbox[principall" . $evento . "]'  title='" . $fecha . "' class='hidden'>";
        } else {
            echo "<a class='" . $class . "' href= '" . $rutaimg . "'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'>";
        }
        echo "<img width='206' height='145' class='" . $class . "' src='" . $rutathumb . "' alt='" . $fecha . "'     title = '" . $fecha . "'>";
        echo "</a>";
        
        
        echo '</div>
<div class="descrip_event">' . substr($descripcion, 70) . '...</div>';
        
        
        $this->generaListaImgShadow($evento, $fecha, $id);
        echo '</div>';
        
    }
    function dibujaCeldaLighbox($evento, $id, $fecha, $rutaimg, $rutathumb, $class = 'img-width') {
        $rsDetalle = $this->get_rows(3, " evento = " . $evento);
        $fotos     = "1";
        $municipio = "Tapachula";
        
        if ($rsDetalle) {
            $rowEvento = $rsDetalle[0];
            $fotos     = $rowEvento->fotos;
            $municipio = $rowEvento->municipio;
        }
        
        $this->omitir_in_hide[] = $id;
        
        echo "<div class='tabla-col' >";
        if ($this->primerFoto == $rutaimg) {
            echo "<a class='" . $class . "' href= '" . $rutaimg . "'  rel='Shadowbox[principall" . $evento . "]'  title='" . $fecha . "' class='hidden'>";
        } else {
            echo "<a class='" . $class . "' href= '" . $rutaimg . "'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'>";
        }
        echo "<img class='" . $class . "' src='" . $rutathumb . "' alt='" . $fecha . "'     title = '" . $fecha . "'>";
        echo "</a>";
        
        echo "</div>";
    }
    function dibujaCelda_($evento, $id, $fecha, $rutaimg, $rutathumb, $class = 'img-width') {
        $rsDetalle = $this->get_rows(3, " evento = " . $evento);
        $fotos     = "1";
        $municipio = "Tapachula";
        
        if ($rsDetalle) {
            $rowEvento = $rsDetalle[0];
            $fotos     = $rowEvento->fotos;
            $municipio = $rowEvento->municipio;
        }
        
        echo "<div class='tabla-col' >";
        if ($this->primerFoto == $rutaimg) {
            echo "<a class='" . $class . "' href= '" . $rutaimg . "'  rel='Shadowbox[principall" . $evento . "]'  title='" . $fecha . "' class='hidden'>";
        } else {
            echo "<a class='" . $class . "' href= '" . $rutaimg . "'  rel='Shadowbox[principal" . $evento . "]'  title='" . $fecha . "' class='hidden'>";
        }
        echo "<img class='" . $class . "' src='" . $rutathumb . "' alt='" . $fecha . "'     title = '" . $fecha . "'>";
        echo "</a>";
        echo "<div class='span_overlay' >";
        echo "<span class='municipio'>" . $municipio . "</span>";
        echo "<span class='fotos'>" . $fotos . " imagen(es)</span>";
        echo "</div>";
        $this->generaListaImgShadow($evento, $fecha, $id);
        echo "</div>";
    }
    
    function get_FullEventoRecienteMunicipio($evento) {
        
        $rsEvento = $this->get_rows(1, " evento =" . $evento);
        
        if ($rsEvento) {
            foreach ($rsEvento as $row) {
                
                //Obtener  miniaturas y paginar
                
                if ($row->Total <= 0) {
                    echo "<span >";
                    echo "No se encontraron imágenes en este evento";
                    echo "</span>";
                } else {
                    $numeroRegistros = $row->Total;
                    $tamPag          = 9;
                    
                    if (!isset($_GET["pagina"])) {
                        $pagina = 1;
                        $inicio = 1;
                        $final  = $tamPag;
                    } else {
                        $pagina = $_GET["pagina"];
                    }
                    
                    //calculo del limite inferior 
                    $limitInf = ($pagina - 1) * $tamPag;
                    
                    //calculo del numero de paginas 
                    $numPags = ceil($numeroRegistros / $tamPag);
                    
                    if (!isset($pagina)) {
                        $pagina = 1;
                        $inicio = 1;
                        $final  = $tamPag;
                    } else {
                        $seccionActual = intval(($pagina - 1) / $tamPag);
                        $inicio        = ($seccionActual * $tamPag) + 1;
                        
                        if ($pagina < $numPags) {
                            $final = $inicio + $tamPag - 1;
                        } else {
                            $final = $numPags;
                        }
                        
                        if ($final > $numPags) {
                            $final = $numPags;
                        }
                    }
                    
                    //Aki se rellenan las imagenes
                    $rsListaImagenes = $this->get_rows(2, " evento =" . $evento, " id   LIMIT " . $limitInf . ", " . $tamPag);
                    
                    //print_r($rsListaImagenes);
                    $aux     = 0;
                    $openrow = false;
                    if ($rsListaImagenes) //Vrificamos que la consulta se haya ejecutado 
                        {
                        $indexCols  = 1;
                        $indexfilas = 0;
                        $openrow    = false;
                        $openpagina = false;
                        
                        foreach ($rsListaImagenes as $rowEvento) {
                            $rutathumb = "imagenes/" . $rowEvento->directorio . "/thumb" . $rowEvento->archivo;
                            $rutaimg   = "imagenes/" . $rowEvento->directorio . "/" . $rowEvento->archivo;
                            
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
                            } else {
                                
                                continue;
                            }
                            
                            if (!file_exists($rutathumb)) {
                                $mythumb = new thumb();
                                $mythumb->loadImage($rutaimg);
                                $mythumb->resize($ajustar, $estilo);
                                if ($estilo == "height") {
                                    $mythumb->crop(232, 153, "top");
                                }
                                $mythumb->save($rutathumb, 90);
                                
                            }
                            
                            
                            if ($openrow) { //si esta bierta la fila
                                
                                if ($indexCols <= 3) { //agregamos una celda mas
                                    
                                    echo "<div class='tabla-celda' >";
                                    $this->dibujaCeldaLighbox($evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo);
                                    echo "</div >";
                                } else { //cerramos la fila
                                    
                                    echo "</div >";
                                    $indexCols = 1;
                                    $indexfilas += 1;
                                    
                                    if ($indexfilas == 3) {
                                        echo "</div >"; // cierra pagina 
                                        echo "<div class='tabla-pagina' >"; //abro nueva pagina 
                                        $indexfilas = 0;
                                    }
                                    
                                    
                                    echo "<div class='tabla-row' >";
                                    echo "<div class='tabla-celda' >";
                                    //echo "<span>".$rowEvento->fecha."</span>";
                                    $this->dibujaCeldaLighbox($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo);
                                    echo "</div >";
                                    $openrow = true;
                                    
                                    
                                }
                            } else {
                                if (!$openpagina)
                                    echo "<div class='tabla-pagina' >";
                                echo "<div class='tabla-row' >";
                                echo "<div class='tabla-celda' >";
                                //echo "<span>".$rowEvento->fecha."</span>";
                                $this->dibujaCeldaLighbox($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo);
                                echo "</div >";
                                $openrow    = true;
                                $openpagina = true;
                            }
                            $indexCols += 1;
                        } //fin cargar todas las imagenes
                        
                        if ($openrow)
                            echo "</div >"; // cierra row
                        if ($openpagina)
                            echo "</div >"; // cierra row 
                        
                        
                        //dibujar la paginacion
                        echo "<div class='footer-paginar'>";
                        if ($pagina > 1) {
                            if (isset($_GET['id'])) { //Id del evento en caso de que se pase
                                echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina - 1) . "&id=" . $evento . "&fecha='" . $_GET['fecha'] . "'>";
                            } else {
                                echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina - 1) . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                            }
                            
                            
                            echo "<";
                            echo "</a> ";
                        }
                        
                        for ($i = $inicio; $i <= $final; $i++) {
                            if ($i == $pagina) {
                                echo "<b>" . $i . "</b> ";
                            } else {
                                if (isset($_GET['id'])) { //Id del evento en caso de que se pase
                                    echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . $i . "&id=" . $_GET['id'] . "&foto=" . $_GET['foto'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                } else {
                                    echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . $i . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                }
                                
                                
                                echo "" . $i . "</a> ";
                            }
                        }
                        if ($pagina < $numPags) {
                            if (isset($_GET['id'])) { //Id del evento en caso de que se pase
                                echo " <a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina + 1) . "&id=" . $_GET['id'] . "&foto=" . $_GET['foto'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                            } else {
                                echo " <a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina + 1) . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                            }
                            
                            
                            echo "></a>";
                        }
                        
                        //Fin paginacion 
                        //compartir social
                        //echo "<div class='footer-compartir'>";
                        //echo "    <a class='lnk_eventofb' rel='pop-upfb' href=''> <img class='social' src='img/fb.png' alt='' > </a>";
                        //echo "    <a class='lnk_eventotw' rel='pop-uptw' href=''> <img class='social' src='img/tw.png' alt='' > </a>";
                        //echo "    <a class='lnk_eventog+' rel='pop-upg+' href=''> <img class='social' src='img/g+.png' alt='' > </a>";
                        //echo "</div>"; //compartir
                        echo "</div>"; //fin div paginar
                        
                    } //Fin evaluacion contulta ejecutada 
                } //end if row->total
            } //End for 
        } //end datos 
        
        
    }
    function get_FullEventoReciente($evento, $fecha = '') {
        
        $rsEvento = $this->get_rows(1, " evento =" . $evento);
        
        if ($rsEvento) {
            foreach ($rsEvento as $row) {
                
                //Obtener  miniaturas y paginar
                
                if ($row->Total <= 0) {
                    echo "<span >";
                    echo "No se encontraron imágenes en este evento";
                    echo "</span>";
                } else {
                    $numeroRegistros = $row->Total;
                    $tamPag          = 9;
                    
                    if (!isset($_GET["pagina"])) {
                        $pagina = 1;
                        $inicio = 1;
                        $final  = $tamPag;
                    } else {
                        $pagina = $_GET["pagina"];
                    }
                    
                    //calculo del limite inferior 
                    $limitInf = ($pagina - 1) * $tamPag;
                    
                    //calculo del numero de paginas 
                    $numPags = ceil($numeroRegistros / $tamPag);
                    
                    if (!isset($pagina)) {
                        $pagina = 1;
                        $inicio = 1;
                        $final  = $tamPag;
                    } else {
                        $seccionActual = intval(($pagina - 1) / $tamPag);
                        $inicio        = ($seccionActual * $tamPag) + 1;
                        
                        if ($pagina < $numPags) {
                            $final = $inicio + $tamPag - 1;
                        } else {
                            $final = $numPags;
                        }
                        
                        if ($final > $numPags) {
                            $final = $numPags;
                        }
                    }
                    
                    //Aki se rellenan las imagenes
                    $rsListaImagenes = $this->get_rows(2, " evento =" . $evento, " id   LIMIT " . $limitInf . ", " . $tamPag);
                    
                    //print_r($rsListaImagenes);
                    $aux     = 0;
                    $openrow = false;
                    if ($rsListaImagenes) //Vrificamos que la consulta se haya ejecutado 
                        {
                        $indexCols  = 1;
                        $indexfilas = 0;
                        $openrow    = false;
                        $openpagina = false;
                        
                        foreach ($rsListaImagenes as $rowEvento) {
                            $rutathumb = "imagenes/" . $rowEvento->directorio . "/thumb" . $rowEvento->archivo;
                            $rutaimg   = "imagenes/" . $rowEvento->directorio . "/" . $rowEvento->archivo;
                            
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
                            } else {
                                
                                continue;
                            }
                            
                            if (!file_exists($rutathumb)) {
                                $mythumb = new thumb();
                                $mythumb->loadImage($rutaimg);
                                $mythumb->resize($ajustar, $estilo);
                                if ($estilo == "height") {
                                    $mythumb->crop(232, 153, "top");
                                }
                                $mythumb->save($rutathumb, 90);
                                
                            }
                            
                            
                            if ($openrow) { //si esta bierta la fila
                                
                                if ($indexCols <= 3) { //agregamos una celda mas
                                    
                                    echo "<div class='tabla-celda' >";
                                    $this->dibujaCeldaLighbox($evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo);
                                    echo "</div >";
                                } else { //cerramos la fila
                                    
                                    echo "</div >";
                                    $indexCols = 1;
                                    $indexfilas += 1;
                                    
                                    if ($indexfilas == 3) {
                                        echo "</div >"; // cierra pagina 
                                        echo "<div class='mas-EventoReciente' >"; //abro nueva pagina 
                                        $indexfilas = 0;
                                    }
                                    
                                    
                                    echo "<div class='tabla-row' >";
                                    echo "<div class='tabla-celda' >";
                                    //echo "<span>".$rowEvento->fecha."</span>";
                                    $this->dibujaCeldaLighbox($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo);
                                    echo "</div >";
                                    $openrow = true;
                                    
                                    
                                }
                            } else {
                                if (!$openpagina)
                                    echo "<div class='EventoReciente' >";
                                echo "<div class='tabla-row' >";
                                echo "<div class='tabla-celda' >";
                                //echo "<span>".$rowEvento->fecha."</span>";
                                $this->dibujaCeldaLighbox($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo);
                                echo "</div >";
                                $openrow    = true;
                                $openpagina = true;
                            }
                            $indexCols += 1;
                        } //fin cargar todas las imagenes
                        
                        if ($openrow)
                            echo "</div >"; // cierra row
                        if ($openpagina)
                            echo "</div >"; // cierra row 
                        
                        
                        //dibujar la paginacion
                        echo "<div class='footer-paginar'>";
                        //Este if dibuja el boton de regresar 
                        if ($pagina > 1) {
                            if (isset($_GET['fecha'])) { //Id del evento en caso de que se pase
                                echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina - 1) . "&municipio=" . $_GET['municipio'] . "&fecha=" . $_GET['fecha'] . "'>";
                            } else {
                                if (isset($_GET['id'])) { //Id del evento en caso de que se pase
                                    echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina - 1) . "&id=" . $_GET['id'] . "&foto=" . $_GET['foto'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                } else {
                                    echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina - 1) . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                }
                            }
                            echo "<<";
                            echo "</a> ";
                        }
                        //esta seccion dibuja las paginas 
                        for ($i = $inicio; $i <= $final; $i++) {
                            if ($i == $pagina) {
                                echo "<b>" . $i . "</b> ";
                            } else {
                                if (isset($_GET['fecha'])) { //Id del evento en caso de que se pase                                
                                    echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . $i . "&municipio=" . $_GET['municipio'] . "&fecha=" . $_GET['fecha'] . "'>";
                                } else {
                                    if (isset($_GET['id'])) { //Id del evento en caso de que se pase
                                        echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . $i . "&id=" . $_GET['id'] . "&foto=" . $_GET['foto'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                    } else {
                                        echo "<a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . $i . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                    }
                                }
                                echo "" . $i . "</a> ";
                            }
                        }
                        //esta seccion dibuja el boton  de siguiente si hay 
                        if ($pagina < $numPags) {
                            if (isset($_GET['fecha'])) { //Id del evento en caso de que se pase
                                echo " <a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina + 1) . "&municipio=" . $_GET['municipio'] . "&fecha=" . $_GET['fecha'] . "'>";
                            } else {
                                if (isset($_GET['id'])) { //Id del evento en caso de que se pase
                                    echo " <a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina + 1) . "&id=" . $_GET['id'] . "&foto=" . $_GET['foto'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                } else {
                                    echo " <a class='p' href='" . $_SERVER["PHP_SELF"] . "?pagina=" . ($pagina + 1) . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "&anio=" . $_GET['anio'] . "&mes=" . $_GET['mes'] . "'>";
                                }
                            }
                            echo ">></a>";
                        }
                        
                        //Fin paginacion 
                        //compartir social
                        //echo "<div class='footer-compartir'>";
                        //echo "    <a class='lnk_eventofb' rel='pop-upfb' href=''> <img class='social' src='img/fb.png' alt='' > </a>";
                        //echo "    <a class='lnk_eventotw' rel='pop-uptw' href=''> <img class='social' src='img/tw.png' alt='' > </a>";
                        //echo "    <a class='lnk_eventog+' rel='pop-upg+' href=''> <img class='social' src='img/g+.png' alt='' > </a>";
                        //echo "</div>"; //compartir
                        echo "</div>"; //fin div paginar
                        
                    } //Fin evaluacion contulta ejecutada 
                } //end if row->total
            } //End for 
        } //end datos 
        
        
    }
    
    function PrintEventoTop($rsResumenEventos) {
        $meses = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
        //$rsResumenEventos = $this->get_rows(0," evento = ".$evento , "fecha DESC");
        
        //print_r($rsResumenEventos);
        
        if ($rsResumenEventos) {
            
            foreach ($rsResumenEventos as $rowEvento) {
                $rutathumb = "imagenes/" . $rowEvento->directorio . "/thumb" . $rowEvento->archivo;
                
                $parse_date = date_parse($rowEvento->fecha);
                
                echo '<div class="mes">' . $meses[$parse_date["month"] - 1] . '</div>';
                echo '<div class="more"> <a id="morelnk" href="#">REGRESAR</a></div>';
                
                echo '<div class="PrintEventoTop tabla-evento-reciente">';
                echo '<span class="fecha" >';
                echo $parse_date["day"] . ' de ' . $meses[$parse_date["month"] - 1] . ' de ' . $parse_date["year"];
                echo '</span>';
                echo '<span class="titulo">"' . $rowEvento->titulo . '...</span>';
                echo '<span class="descripcion">' . substr($rowEvento->descripcion, 0, 60) . '...</span>';
                //$this->omitir_in_hide[] =$_GET["foto"];                                      
                $this->get_FullEventoReciente($rowEvento->evento);
                $this->generaListaImgShadow_lighbox($rowEvento->evento);
                
                echo '</div>';
                
                break;
            }
            
        }
    }
    function PrintEventoReciente($anio, $mes) {
        $meses            = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
        $rsResumenEventos = $this->get_rows(0, " YEAR(  fecha ) = " . $anio . " and MONTH(fecha)=" . $mes . " and evento = " . $_GET["id"], "fecha DESC");
        
        //print_r($rsResumenEventos);
        
        if ($rsResumenEventos) {
            
            foreach ($rsResumenEventos as $rowEvento) {
                $rutathumb  = "imagenes/" . $rowEvento->directorio . "/thumb" . $rowEvento->archivo;
                $parse_date = date_parse($rowEvento->fecha);
                echo '<div class="mes">' . $meses[$mes - 1] . '</div>';
                echo '<div class="regresarXdia"> <a id="back" href="eventos.php?anio=' . $parse_date["year"] . '&mes=' . $parse_date["month"] . '"></a></div>';
                echo '<div class="PrintEventoReciente tabla-evento-reciente">';
                echo "<span class='fecha'>";
                echo $parse_date["day"] . ' de ' . $meses[$parse_date["month"] - 1] . ' de ' . $parse_date["year"];
                echo "</span>";
                echo "<span class='titulo'>" . $rowEvento->titulo . "...</span>";
                echo "<span class='descripcion'>" . $rowEvento->descripcion . "...</span>";
                $this->get_FullEventoReciente($_GET['id'], $rowEvento->fecha);
                $this->generaListaImgShadow_lighbox($_GET['id']);
                
                echo '</div>';
                
                
                break;
            }
            
        }
    }
    function PrintEventoxMunicipio($municipio, $fecha) {
        
        $Meses = array(
            0 => 'Enero',
            1 => 'Febrero',
            2 => 'Marzo',
            3 => 'Abril',
            4 => 'Mayo',
            5 => 'Junio',
            6 => 'Julio',
            7 => 'Agosto',
            8 => 'Septiembre',
            9 => 'Octubre',
            10 => 'Noviembre',
            11 => 'Diciembre'
        );
        
        $dia        = substr($fecha, 0, 2);
        $restofecha = substr($fecha, 3);
        $resultado  = strpos($restofecha, "-");
        $mes        = substr($fecha, 3, $resultado);
        $cveMes     = array_search($mes, $Meses) + 1;
        $anio       = substr($fecha, -4);
        
        $fechaFormateada = $anio . "-" . $cveMes . "-" . $dia;
        
        $rsResumenEventos = $this->get_rows(0, " idmunicipio = " . $municipio . " and fecha='" . $fechaFormateada . "'", " fecha DESC");
        
        if ($rsResumenEventos) {
            
            $calculo = count($rsResumenEventos);
            if ($calculo > 1) {
                //imprime el evento tipoxfecha
                //echo "imprime el evento tipoxfecha";
                $this->PrintEventoxFechaxMunicipios($rsResumenEventos);
            } else {
                //echo "imprime el evento tipo lighbox"; 
                //echo $rsResumenEventos[0]->evento;
                
                //$this->PrintEventoxMunicipioxEvento( $rsResumenEventos[0]->evento,$rsResumenEventos[0]->id, $rsResumenEventos);
                $this->PrintEventoTop($rsResumenEventos);
            }
        } else {
            echo "<div class=\"PrintEventoReciente tabla-evento-reciente\"><span class=\"fecha\">No hay Resultados.</span></div>";
        }
    }
    function PrintEventoxFoto($id, $foto) {
        $rsEvento = $this->get_rows(4, " evento = " . $id . " and id= " . $foto);
        
        if ($rsEvento) {
            $rowEvento  = $rsEvento[0];
            $parse_date = date_parse($rowEvento->fecha);
            
            $this->primerFoto = "imagenes/" . $rowEvento->directorio . "/" . $rowEvento->archivo;
            $this->PrintEventoReciente($parse_date["year"], $parse_date["month"]);
            
        }
    }
    function PrintEventoxFechaxMunicipios($rsResumenEventos) {
        $meses = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
        //$rsResumenEventos = $this->get_rows(0," YEAR(  fecha ) = ".$anio. " and MONTH(fecha)=".$mes, "fecha DESC");
        
        echo '<div class="mes">' . $meses[$mes - 1] . '</div>';
        echo '<div id="msg" class="msg"></div>';
        echo '<div class="more"> <a id="morelnk" href="#">+EVENTOS</a></div>';
        echo '<div class="arriba"> <a id="menoslnk" href="#">+ARRIBA</a></div>';
        
        if ($rsResumenEventos) {
            $indexCols  = 1;
            $indexfilas = 0;
            
            $openrow    = false;
            $openpagina = false;
            
            foreach ($rsResumenEventos as $rowEvento) {
                $rutathumb = "imagenes/" . $rowEvento->directorio . "/thumb" . $rowEvento->archivo;
                $rutaimg   = "imagenes/" . $rowEvento->directorio . "/" . $rowEvento->archivo;
                //$rutathumb="imagenes/".$rowEvento->directorio."/thumb".$rowEvento->archivo;
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
                } else {
                    continue;
                }
                
                if (!file_exists($rutathumb)) {
                    $mythumb = new thumb();
                    $mythumb->loadImage($rutaimg);
                    $mythumb->resize($ajustar, $estilo);
                    if ($estilo == "height") {
                        $mythumb->crop(232, 153, "top");
                    }
                    $mythumb->save($rutathumb, 90);
                    //$rutaimg=$rutathumb;
                }
                
                if ($openrow) { //si esta bierta la fila
                    //echo "indexCols".$indexCols;
                    if ($indexCols <= 3) { //agregamos una celda mas
                        
                        echo "<div class='tabla-celda' >";
                        //echo "<span>".$rowEvento->fecha."</span>";  
                        $this->dibujaCelda($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo, $rowEvento->descripcion);
                        echo "</div >";
                    } else { //cerramos la fila
                        
                        echo "</div >";
                        $indexCols = 1;
                        $indexfilas += 1;
                        
                        if ($indexfilas == 2) {
                            echo "</div >"; // cierra pagina 
                            echo "<div class='tabla-pagina' >"; //abro nueva pagina 
                            $indexfilas = 0;
                        }
                        
                        
                        echo "<div class='tabla-row' >";
                        echo "<div class='tabla-celda' >";
                        //echo "<span>".$rowEvento->fecha."</span>";
                        $this->dibujaCelda($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo, $rowEvento->descripcion);
                        echo "</div >";
                        $openrow = true;
                        
                        
                    }
                } else {
                    if (!$openpagina)
                        echo "<div class='tabla-pagina' >";
                    echo "<div class='tabla-row' >";
                    echo "<div class='tabla-celda' >";
                    //echo "<span>".$rowEvento->fecha."</span>";
                    $this->dibujaCelda($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo, $rowEvento->descripcion);
                    echo "</div >";
                    $openrow    = true;
                    $openpagina = true;
                }
                $indexCols += 1;
                
            }
            if ($openrow)
                echo "</div >"; // cierra row
            if ($openpagina)
                echo "</div >"; // cierra row  
        }
    }
    function PrintEventoxFecha($anio, $mes) {
        $meses            = array(
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        );
        $rsResumenEventos = $this->get_rows(0, " YEAR(  fecha ) = " . $anio . " and MONTH(fecha)=" . $mes, "fecha DESC");
        
        echo '<div class="mes">' . $meses[$mes - 1] . '</div>';
        echo '<div id="msg" class="msg"></div>';
        echo '<div class="more"> <a id="morelnk" href="#">+EVENTOS</a></div>';
        echo '<div class="arriba"> <a id="menoslnk" href="#">+ARRIBA</a></div>';
        
        if ($rsResumenEventos) {
            $indexCols  = 1;
            $indexfilas = 0;
            
            $openrow    = false;
            $openpagina = false;
            
            foreach ($rsResumenEventos as $rowEvento) {
                $rutathumb = "imagenes/" . $rowEvento->directorio . "/thumb" . $rowEvento->archivo;
                $rutaimg   = "imagenes/" . $rowEvento->directorio . "/" . $rowEvento->archivo;
                //$rutathumb="imagenes/".$rowEvento->directorio."/thumb".$rowEvento->archivo;
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
                } else {
                    continue;
                }
                
                if (!file_exists($rutathumb)) {
                    $mythumb = new thumb();
                    $mythumb->loadImage($rutaimg);
                    $mythumb->resize($ajustar, $estilo);
                    if ($estilo == "height") {
                        $mythumb->crop(232, 153, "top");
                    }
                    $mythumb->save($rutathumb, 90);
                    //$rutaimg=$rutathumb;
                }
                
                if ($openrow) { //si esta bierta la fila
                    //echo "indexCols".$indexCols;
                    if ($indexCols <= 3) { //agregamos una celda mas
                        
                        echo "<div class='tabla-celda' >";
                        //echo "<span>".$rowEvento->fecha."</span>";
                        $this->dibujaCelda($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo, $rowEvento->descripcion);
                        echo "</div >";
                    } else { //cerramos la fila
                        
                        echo "</div >";
                        $indexCols = 1;
                        $indexfilas += 1;
                        
                        if ($indexfilas == 2) {
                            echo "</div >"; // cierra pagina 
                            echo "<div class='tabla-pagina' >"; //abro nueva pagina 
                            $indexfilas = 0;
                        }
                        
                        
                        echo "<div class='tabla-row' >";
                        echo "<div class='tabla-celda' >";
                        //echo "<span>".$rowEvento->fecha."</span>";
                        $this->dibujaCelda($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo, $rowEvento->descripcion);
                        echo "</div >";
                        $openrow = true;
                        
                        
                    }
                } else {
                    if (!$openpagina)
                        echo "<div class='tabla-pagina' >";
                    echo "<div class='tabla-row' >";
                    echo "<div class='tabla-celda' >";
                    //echo "<span>".$rowEvento->fecha."</span>";
                    $this->dibujaCelda($rowEvento->evento, $rowEvento->id, $rowEvento->fecha, $rutaimg, $rutathumb, $estilo, $rowEvento->descripcion);
                    echo "</div >";
                    $openrow    = true;
                    $openpagina = true;
                }
                $indexCols += 1;
                
            }
            if ($openrow)
                echo "</div >"; // cierra row
            if ($openpagina)
                echo "</div >"; // cierra row
        }
    }
    
    function PrintEventos() {
        
        $mes       = (empty($_GET["mes"])) ? date("m") : $_GET["mes"];
        $anio      = (empty($_GET["anio"])) ? date("Y") : $_GET["anio"];
        $id        = (empty($_GET["id"])) ? 0 : $_GET["id"];
        $foto      = (empty($_GET["foto"])) ? 0 : $_GET["foto"];
        $municipio = (empty($_GET["municipio"])) ? 0 : $_GET["municipio"];
        $fecha     = (empty($_GET["fecha"])) ? 0 : $_GET["fecha"];
        
        if ($id != 0) {
            //Este llama el evento  con un ligbox al inicio
            //echo "Evento x foto".$id;
            $this->PrintEventoxFoto($id, $foto);
            
        } else {
            
            if ($municipio != 0) {
                //Este llama el evento  con un ligbox al inicio
                //echo "Evento x muni".$id;
                $this->PrintEventoxMunicipio($municipio, $fecha);
                
            } else {
                //Cuando  se le pasa el año (anio), mes y un evento (id) en especifico, se lanza desde mas eventos
                // leer parametro $id y cargar el evento que se ha seleccionado
                //$eventos->PrintEventoReciente($anio,$mes);
                //echo "Evento x fecha";
                $this->PrintEventoxFecha($anio, $mes);
            }
        }
        
    }
    private function get_rows($categoria, $where_str = false, $order_str = false) {
        $where_str = $where_str ? "$where_str " : "";
        $order_str = $order_str ? "$order_str " : "";
        
        $rst = $this->getlist($this->db, $this->table[$categoria], $this->fields[$categoria], $where_str, $order_str);
        return $rst;
    }
    private function get_rows_by_sql($sql, $sql2) {
        //echo $sql ." UNION " . $sql2; 
        $rst = $this->getrowbysql($sql . " UNION " . $sql2);
        
        return $rst;
    }
}
?>