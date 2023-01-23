<?php

use Blog\Controller\Interface\FormController;
use Blog\Controller\Interface\ReceivingPost;
use Blog\Form\Interface\FormValidifier;
use Blog\Service\Interface\Creater;
use Twig\Environment;

class PostRegisterController implements FormController{
    public function __construct(private Environment $twig,private Creater $creator, private FormValidifier $formValidifier)
    {
        
    }
    public function handleForm(array $data)
    {
        $DTO = $this->formValidifier->validify($data);
        $this->creator->create($DTO);
    }
}