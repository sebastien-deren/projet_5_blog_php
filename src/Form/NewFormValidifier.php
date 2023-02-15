<?php
namespace Blog\Form;

use Blog\DTO\AbstractDTO;
use Blog\Form\Interface\FormValidifier;

abstract class NewFormValidifier
{
    public function __construct(protected AbstractDTO $DTO,protected array $data)
    {
        
    }
    public function validify():AbstractDTO
    {
        $this->TokenValidation();
        $this->checkingRequired();
        $this->createDTO();
        return $this->DTO;
    }

    protected function TokenValidation()
    {
        if (!$this->data['token'] || $this->data['token'] !== $_SESSION['token']) {
            throw new \Exception("Method not allowed", 405);
        }
    }
    abstract protected function checkingRequired();
    abstract protected function createDTO();
}
