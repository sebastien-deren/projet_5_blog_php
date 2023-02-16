<?php
namespace Blog\Form;

use Blog\DTO\AbstractDTO;
use Blog\Form\Interface\FormValidifier;

abstract class NewFormValidifier
{
    protected object $DTO;//i'd like to infer a type here like this object is of type <T> and then when declared boom it's the DTO i want
    public function __construct(protected array $data)
    {
        
    }
    public function validify()
    {
        $this->TokenValidation();
        $this->checkingRequired();
        $this->createDTO();
        return $this->DTO;
    }

    protected function TokenValidation()
    {
        var_dump($_SESSION['token']);
        var_dump($this->data['token']);
        if (!$this->data['token'] || ($this->data['token'] !== $_SESSION['token'])) {
            throw new \Exception("Method not allowed", 405);
        }
    }
    abstract protected function checkingRequired();
    abstract protected function createDTO();
}
