<?php

namespace Blog\Form\Mail;

use Error;
use Blog\DTO\Form\Mail\MailDTO;
use Blog\Exception\FormException;
use Blog\Form\Abstracts\ValidData;
use Blog\Form\Abstracts\FormValidifier;

class MailValidifier extends FormValidifier
{
    public function __construct(MailDTO $mailDto, array $data)
    {
        $this->DTO = $mailDto;
        parent::__construct($data);
    }
    public function validify(): MailDTO
    {
        return parent::validify();
    }
    protected function checkingRequired(): void
    {
        if (count($this->data) !== count(\array_filter($this->data))) {
            throw new FormException("des champs ont été laissé vide !");
        }
        ValidData::mail($this->data['mail']) ?: throw new FormException("l'adresse mail n'est pas valide");
        if (\strlen($this->data['message']) < 10) {
            throw new FormException("le message est trop court");
        }
    }
    protected function createDTO(): void
    {
        $this->DTO->mail = $this->data['mail'];
        $this->DTO->message = $this->data['message'];
        $this->DTO->name = $this->data['name'];
    }
}
