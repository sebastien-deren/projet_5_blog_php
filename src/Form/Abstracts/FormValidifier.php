<?php
namespace Blog\Form\Abstracts;

use Blog\Form\Abstracts\Interface\FormValidifier as InterfaceFormValidifier;


abstract class FormValidifier implements InterfaceFormValidifier
{
    protected object $DTO;//i'd like to infer a type here like this object is of type <T> and then when declared boom it's the DTO i want
    public function __construct(protected array $data)
    {
        
    }
    public function validify():object
    {
        $this->TokenValidation();
        $this->checkingRequired();
        $this->createDTO();
        return $this->DTO;
    }

    protected function TokenValidation()
    {
        if (!$this->data['token'] || ($this->data['token'] !== $_SESSION['token'])) {
            throw new \Exception("Method not allowed", 405);
        }
    }
    abstract protected function checkingRequired();
    abstract protected function createDTO();
    
}
