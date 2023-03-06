<?php

namespace Blog\Service;

use Blog\Form\ValidData;


use PHPMailer\PHPMailer\SMTP;
use Blog\DTO\Form\Mail\MailDTO;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{

    private PHPMailer $mailer;
    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'maildev'; //or another Adress
        $this->mailer->Port = 1025;
        $this->mailer->SMTPAutoTLS = false;
        $this->mailer->isHTML(true);
        $this->mailer->addAddress("sebastien.deren@boitemail.com");
        $this->mailer->Subject = "formulaire de contact"; //might need to create a method to set this one if more than one mailing service inside our app

    }
    public function sendMail(MailDTO $mailDto): bool
    {
        if (!ValidData::mail($mailDto->mail)) {
            throw new \Exception("votre adresse mail n'est pas correct");
        }
        $this->mailer->setFrom($mailDto->mail, $mailDto->name);
        $this->mailer->Body = $mailDto->message;
        return $this->mailer->send();
    }
}
