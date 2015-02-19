<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

if ( file_exists( 'config/config.php' ) )
{
    define( 'CURRENT_PATH',dirname(__FILE__) );
    require_once 'config/config.php';
}
else
{
    exit('no fue posible localizar el archivo de configuración.');
}

function __autoload( $className )
{
    require_once LIBS_PATH . "{$className}.php";
}

require_once SNIPPETS_PATH . 'db/connection.php';

error_reporting( E_ALL | E_STRICT );
ini_set( 'display_errors', 1 );

if ( ! empty( $_GET['action'] ) )
{
    $action    = strip_tags( trim( $_GET[ 'action' ] ) );
    $data      = array();
    try
    {
        switch ( $action )
        {
            case 'contact':
                $toPass[ 'name' ]       = trim( $_POST[ 'name' ] );
                $toPass[ 'email' ]      = trim( $_POST[ 'email' ] );
                $toPass[ 'comments' ]   = trim( $_POST[ 'comments' ] );

                //$cc = array( );

                $doInsert   = new Review( $dbh, 'tufoto_contact_form' );
                $doInsert   = $doInsert->insertInit(
                    $toPass,
                    "email.tpl", "Hay un nuevo mensaje del sitio tu Foto con el Güero",
                    "contact@tufotoconelguero.com, contact@tufotoconelguero.com", $cc );
                $data       = json_encode ( $doInsert );
                $data       = json_encode ( array( 'success' => true, 'message' => 'Éxito' ) );

                break;
            case 'download':
                $_image = SITE_URL . trim( $_GET[ 'image' ] );

                if ( fopen( $_image, 'r' ) )
                {
                    try
                    {
                        $file   = imagecreatefromjpeg( $_image );
                        header( "Pragma: public" );
                        header( "Expires: 0" );
                        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
                        //header("Content-Type: application/force-download");
                        //header("Content-Type: application/octet-stream");
                        //header("Content-Type: application/download");
                        header( "Content-Disposition: attachment;filename=mi-foto-con-el-guero.jpg" );
                        header( "Content-Transfer-Encoding: binary" );
                        header( 'Content-Type: image/jpeg' );
                        imagejpeg( $file );
                    }
                    catch ( Exception $e )
                    {
                        $data       = json_encode ( $doInsert );
                        $data       = json_encode ( array( 'success' => false, 'message' => 'Error con la imagen' ) );
                    }
                }
                break;
            case 'share':
                $toPass[ 'email' ]      = trim( $_POST[ 'email' ] );
                $toPass[ 'image' ]      = SITE_URL . trim( $_POST[ 'image' ] );

                if ( fopen( $toPass[ 'image' ], 'r' ) )
                {
                    $data       = json_encode ( $doInsert );
                    $data       = json_encode ( array( 'success' => false, 'message' => 'No existe la imagen' ) );
                }
                else
                {
                    $doInsert   = new Review( $dbh, 'tufoto_contact_form' );
                    $doInsert   = $doInsert->shareImage(
                        $toPass,
                        "share.tpl", "Descarga tu foto con el Güero Velazco",
                        "contact@tufotoconelguero.com, contact@tufotoconelguero.com", $cc );
                    $data       = json_encode ( $doInsert );
                    $data       = json_encode ( array( 'success' => true, 'message' => 'Éxito' ) );
                }
                break;
        }
        echo $data;

    }
    catch ( Exception $e )
    {
        switch ( $e->getCode() )
        {
            case 5910 :
                echo 'DATA BASE ERROR: '.$e->getMessage();
                $message = 'Lo sentimos, ocurrió un error inesperado al tratar de guardar los datos.';
                break;
            case 5810 :
                echo 'MAILER ERROR: '. $e->getMessage();
                $message = 'Lo sentimos, ocurrió un error inesperado al tratar de enviar el correo.';
                break;
            default : $message = $e->getMessage();
        }

        $data = array ('success' => false , 'message' => $message ) ;
        echo json_encode( $data );
    }
}