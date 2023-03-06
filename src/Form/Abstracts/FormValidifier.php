<?php

namespace Blog\Form\Abstracts;

use Blog\Form\Abstracts\Interface\FormValidifierInterface;


abstract class FormValidifier implements FormValidifierInterface
{

    protected object $DTO; // i'd like to infer a type here like this object is of type <T> and then when declared boom it's the DTO i want


    /**
     * create a FormValidifier with _POST in $data
     *
     * @var array $data this is the $_POST array
     *
     * @return void
     */
    public function __construct(protected array $data)
    {
    }

    /**
     * We check all our datas and send back a DTO
     * 
     * @return object(DTO) 
     */
    public function validify(): object
    {
        $this->tokenValidation();
        $this->checkingRequired();
        $this->createDTO();
        return $this->DTO;
    }


    /**
     * we check our token received with the token stocked in our server
     *
     * @throws Exception
     *
     * @return void
     */
    protected function tokenValidation(): void
    {
        if (!$this->data['token'] || ($this->data['token'] !== $_SESSION['token'])) {
            throw new \Exception("Method not allowed", 405);
        }
    }
    abstract protected function checkingRequired(): void;
    abstract protected function createDTO(): void;
}
