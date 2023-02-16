<?php

namespace Blog\Controller\Homepage;

use Blog\DTO\Mail\MailDTO;
use Blog\Form\MailValidifier;
use Blog\Service\MailService;
use Blog\Controller\Traits\Token;

class PostIndexController extends IndexController
{

    public function execute(): string
    {
        $formvalidifier = new MailValidifier(new MailDTO, $_POST);
        $mailDto = $formvalidifier->validify();
        $mailSend = (new MailService())->sendmail($mailDto);
        $this->argument['mail'] = $mailSend ? $mailDto : throw new \Exception("echec de l'envoi");

        return parent::execute();
    }
}