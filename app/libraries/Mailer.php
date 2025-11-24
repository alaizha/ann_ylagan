<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/* ================================================
   MANUALLY LOAD PHPMailer (No Composer Needed)
   ================================================ */
require_once APP_DIR . 'libraries/PHPMailer/src/PHPMailer.php';
require_once APP_DIR . 'libraries/PHPMailer/src/SMTP.php';
require_once APP_DIR . 'libraries/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer {

    public function __construct() {}

    public function send($to, $subject, $message) {
        $mail = new PHPMailer(true);

        try {

            /* ===========================
               SMTP SERVER SETTINGS
            =========================== */
            $mail->isSMTP();
            $mail->Host       = config_item('smtp_host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config_item('smtp_user');
            $mail->Password   = config_item('smtp_pass');
            $mail->SMTPSecure = config_item('smtp_crypto');
            $mail->Port       = config_item('smtp_port');

            /* ===========================
               FROM + RECIPIENT
            =========================== */
            $mail->setFrom(config_item('smtp_user'), config_item('clinic_name'));
            $mail->addAddress($to);

            /* ===========================
               EMAIL CONTENT
            =========================== */
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
