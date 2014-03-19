<?php
#####################################
# Include PHP Mailer Class
#####################################
require("class.phpmailer.php");

?>
<?php
#####################################
# Function to send email
#####################################
function sendEmail ($fromName, $fromEmail, $toEmail, $subject, $emailBody) {
    $mail = new PHPMailer();
    $mail->FromName = $fromName;
    $mail->From = $fromEmail;
    $mail->AddAddress("$toEmail");
        
    $mail->Subject = $subject;
    $mail->Body = $emailBody;
    $mail->isHTML(true);
    $mail->WordWrap = 150;
        
    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

#####################################
# Function to Read a file 
# and store all data into a variable
#####################################
function readTemplateFile($FileName) {
        $fp = fopen($FileName,"r") or exit("Unable to open File ".$FileName);
        $str = "";
        while(!feof($fp)) {
            $str .= fread($fp,1024);
        }   
        return $str;
}
?>
<?php
#####################################
# Finally send email
#####################################

header('Content-Type: text/html; charset=UTF-8');

    //Data to be sent (Ideally fetched from Database)
    
    $UserEmail = trim($_POST['contact_mail']);
    $lnk=trim($_POST['lnk']);
    
    //Send email to user containing username and password
    //Read Template File 
    $emailBody = readTemplateFile("template.html");
            
    //Replace all the variables in template file
    $emailBody = str_replace("#email#",$UserEmail ,$emailBody);
    $emailBody = str_replace("#lnk#",$lnk,$emailBody);
    
            
    //Send email
    $emailStatus = sendEmail ( "TUFOTOCONELGUERO.COM", "contacto@tufotoconelguero.com", $UserEmail, "Mira esta foto en el evento de tu GOBERNADOR", $emailBody);
    
    //If email function return false
    if ($emailStatus != 1) {
        $response   = array(
            'success'   => 'false',
            'message'   => 'No pudimos enviar la foto. ¿Puedes intentarlo de nuevo?.'
        );
        echo json_encode($response);
    } else {
        $response   = array(
            'success'   => 'true',
            'message'   => 'Ya enviamos la foto a tu correo.'
        );
        echo json_encode($response);
    }
?>