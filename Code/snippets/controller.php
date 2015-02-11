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

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

if ( ! empty( $_GET['action'] ) )
{
    $action = strip_tags( trim( $_GET[ 'action' ] ) );
    $data = array();
    try
    {
        switch ( $action )
        {
            case 'contact':
                session_start();

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
            case 'share':
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