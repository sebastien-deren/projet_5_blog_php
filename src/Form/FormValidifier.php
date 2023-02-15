<?php
namespace Blog\Form;

use Blog\DTO\AbstractDTO;
use Blog\Form\Interface\FormValidifier as InterfaceFormValidifier;

abstract class FormValidifier implements InterfaceFormValidifier
{
    public function __construct(protected object $DTO)
    {
        
    }
    public function validify(array $data)
    {
        $this->TokenValidation($data['token']);
        $this->checkingRequired($data);
        $this->createDTO($data);
        return $this->DTO;
    }

    protected function TokenValidation($userToken)
    {
        if (!$userToken || $userToken !== $_SESSION['token']) {
            throw new \Exception("Method not allowed", 405);
        }
    }
    abstract protected function checkingRequired(array $data);
    abstract protected function createDTO(array $data);
}
