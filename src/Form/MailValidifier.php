<?php
namespace Blog\Form;

use Blog\DTO\Mail\MailDTO;
use Blog\Form\NewFormValidifier;
use Error;

class MailValidifier extends NewFormValidifier{
    public function __construct(MailDTO $mailDto,array $data )
    {
    $this->DTO = $mailDto;
    parent::__construct($data);
    }
    public function validify():MailDTO{
        return parent::validify();
    }
    protected function checkingRequired(){
        if(count($this->data)!== count(\array_filter($this->data))){
            throw new Error("des champs ont été laissé vide !");
        }

    }
    protected function createDTO()
    {
        $this->DTO->mail = $this->data['mail'];
        $this->DTO->message = $this->data['message'];
        $this->DTO->name = $this->data['name'];
        
    }
}