<?php


namespace Core\Lib;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once __LIB__ . '/PHPMailer/src/Exception.php';
require_once __LIB__ . '/PHPMailer/src/PHPMailer.php';
require_once __LIB__ . '/PHPMailer/src/SMTP.php';

class Mail
{
    public $mail;
    public static $config = null;

    public function __construct()
    {
        $this->mail = $mail = new PHPMailer(false);

        if(!$this->config){
            $this->config = require_once __ROOT__ . '/config/mail.php';
        }

        try {
            //Server settings
            //$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                         //Enable verbose debug output
            $mail->isSMTP();                                                //Send using SMTP
            $mail->Host       = $this->config['host'];                      //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                       //Enable SMTP authentication
            $mail->Username   = $this->config['username'];                  //SMTP username
            $mail->Password   = $this->config['password'];                  //SMTP password
            if($this->config['security'] == 'tls'){
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
            }
            if($this->config['security'] == 'ssl'){
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            }
            $mail->Port       = $this->config['PORT'];                      //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->config['FromAddress'], $this->config['FromName']);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML

        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendMessage($to, $subject, $body){

        $this->mail->addAddress($to /*, 'Mister Prada'*/);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name


        //Content
        $this->mail->Subject = $subject;
        $this->mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        try {
            return $this->mail->send();
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

}
