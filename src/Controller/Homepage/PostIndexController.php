<?php

namespace Blog\Controller\Homepage;

use Blog\DTO\Mail\MailDTO;
use Blog\Service\MailService;
use Blog\Controller\Traits\Token;
use Blog\Exception\FormException;
use Blog\Form\Mail\MailValidifier;

class PostIndexController extends IndexController
{

    public function execute(): string
    {
        try {
        $formvalidifier = new MailValidifier(new MailDTO, $_POST);
        $mailDto = $formvalidifier->validify();
        $mailSend = (new MailService())->sendmail($mailDto);
        $this->argument['mail'] = $mailSend ? $mailDto : throw new \Exception("echec de l'envoi");
        }
        catch(FormException $e){
            $this->argument['error']=$e;
        }

        return parent::execute();
    }
}
