<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_lib
{

    protected $ci;

    public function __construct()
    {
        // Get CI super object
        $this->ci = &get_instance();
        // Load PHPMailer library
        $this->ci->load->library('Phpmailer_lib');
    }

    public function email_sent($email_info)
    {
        // Load email configuration
        $this->ci->load->config('email');
        $mail = $this->ci->phpmailer_lib->load();


        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $this->ci->config->item('smtp_host');    // Set your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->ci->config->item('smtp_user');    // SMTP username
            $mail->Password   = $this->ci->config->item('smtp_pass');    // SMTP password
            $mail->SMTPSecure = $this->ci->config->item('smtp_secure');  // Encryption type
            $mail->Port       = $this->ci->config->item('smtp_port');    // Port

            // Recipients
            $mail->setFrom($this->ci->config->item('smtp_user'), $email_info['alias']);
            $mail->addAddress($email_info['email_recepients']);
            if (isset($email_info['email_attachment'])) {
                $email_attachment = $email_info['email_attachment'];
                $mail->addStringAttachment($email_attachment, 'invoice.pdf');
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $email_info['email_subject'];
            $mail->Body    = $email_info['email_body'];
            $mail->AltBody = 'This is the plain text version';

            // Send email
            if ($mail->send()) {
                return true; // Return true if sent successfully
            } else {
                return false; // Return false if not sent
            }
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
