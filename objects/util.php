<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'utils/PHPMailer/src/PHPMailer.php';
require 'utils/PHPMailer/src/SMTP.php';
require 'utils/PHPMailer/src/Exception.php';

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'ajcodalify@gmail.com';
            $this->mail->Password   = 'kppv omij rxyk adyq';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port       = 587;
            $this->mail->setFrom('ajcodalify@gmail.com', 'HarvestHub Support');
        } catch (Exception $e) {
            throw new Exception("Mailer Initialization Error: {$e->getMessage()}");
        }
    }

    public function send($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

?>
