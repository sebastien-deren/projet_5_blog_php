<?php
namespace Blog\Form;


use Blog\DTO\Form\Mail\MailDTO;
use Blog\Form\NewFormValidifier;

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
            throw new \Error("des champs ont été laissé vide !");
        }
        ValidData::mail($this->data['mail'])?:throw new \Exception("l'adresse mail n'est pas valide");

    }
    protected function createDTO()
    {
        $this->DTO->mail = $this->data['mail'];
        $this->DTO->message = $this->data['message'];
        $this->DTO->name = $this->data['name'];
        
    }
}