<?php

class ModelToolSendmail extends Model {

    public function send($param) {

        include_once(DIR_SYSTEM . 'phpmailer/PHPMailerAutoload.php');

//Create a new PHPMailer instance
        $mail = new PHPMailer();

        //SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set("Asia/Shanghai"); //设定时区东八区

        $mail->Charset = 'UTF-8';
//Tell PHPMailer to use SMTP
        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
//Set the hostname of the mail server
        $mail->Host = $this->config->get('config_smtp_host');
//Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $this->config->get('config_smtp_port');
//Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
//Username to use for SMTP authentication
        $mail->Username = $this->config->get('config_smtp_username');
//Password to use for SMTP authentication
        $mail->Password = $this->config->get('config_smtp_password');
//Set who the message is to be sent from
        $mail->setFrom($this->config->get('config_email'), $this->config->get('config_name'));
//Set who the message is to be sent to
        $mail->addAddress($param['sendto'], $param['receiver']);
//Set the subject line
        $mail->Subject = "=?utf-8?B?" . base64_encode($param['subject']) . "?=";
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML($param['msg']);

//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
    
    public function getinfobyoid($order_id) {
        
        $query = $this->db->query("SELECT o.email,op.producturl,op.name FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "order_product op ON o.order_id=op.order_id WHERE o.order_id = '" . (int) $order_id . "'");
        return $query->row;
    }

}

?>