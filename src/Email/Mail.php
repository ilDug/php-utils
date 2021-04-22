<?php

namespace ilDug\Email;

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

/**
 * classe per l'invio di mail con l'account del dominio
 */
class Mail
{
    private array $recipents = array();
    private string $subject;
    private string $body;
    protected $reply_to;

    private SMTPConfig $c;


    function __construct(SMTPConfig $config)
    {
        $this->c = $config;
    }
    /**
     * assegna l'oggetto della mail
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject ? $subject : "Server Message";
        return $this;
    }

    /**
     * Assegna il corpo della mail
     */
    public function setBody(string $body)
    {
        $this->body = $body ? $body : "HTML email";
        return $this;
    }

    /**
     * aggiunge destinatario 
     */
    public function addRecipient(string $recipent)
    {
        $this->recipents[] = $recipent;
        return $this;
    }

    /**
     * aggiunge a Replay To
     */
    public function setReplyTo($email)
    {
        $this->reply_to = $email;
        return $this;
    }


    /**
     * invia la mail e ritorna il risultato della risposta
     */
    public function send()
    {
        //Create a new PHPMailer instance
        //Passing true to the constructor enables the use of exceptions for error handling
        $mail = new PHPMailer(true);

        try {
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // SMTP::DEBUG_OFF = off (for production use)
            // SMTP::DEBUG_CLIENT = client messages
            // SMTP::DEBUG_SERVER = client and server messages
            $mail->SMTPDebug = SMTP::DEBUG_OFF;

            //Ask for HTML-friendly debug output
            //$mail->Debugoutput = 'html';

            //Set the hostname of the mail server
            $mail->Host = $this->c->host;
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = $this->c->port;
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            //Username to use for SMTP authentication
            $mail->Username = $this->c->user;
            //Password to use for SMTP authentication
            $mail->Password = $this->c->password;
            //Set who the message is to be sent from
            $mail->setFrom($this->c->sender_address, $this->c->sender_name);

            //Set an alternative reply-to address
            if ($this->reply_to)  $mail->addReplyTo($this->reply_to);

            foreach ($this->recipents as $email_address) {
                //Set who the message is to be sent to
                $mail->addAddress($email_address);
            }

            // Set email format to HTML
            $mail->isHTML(true);

            //Set the subject line
            $mail->Subject = $this->subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($this->body);
            //Replace the plain text body with one created manually
            // $mail->AltBody = 'error - Please, try read this mail in a HTML reader';

            $delivery = $mail->send();

            $mail->SmtpClose();
            unset($mail);

            return $delivery;
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            throw new \PHPMailer\PHPMailer\Exception($e->errorMessage(), 500);
        }
    }
} //chide classe
