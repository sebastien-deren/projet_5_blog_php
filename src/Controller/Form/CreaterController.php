<?php
namespace Blog\Controller\Form;

use Blog\Service\Interface\Creater;
use Blog\Form\Interface\FormValidifier;
use Blog\Controller\Interface\FormController;

class CreaterController implements FormController{
    public function __construct(private Creater $Creator,private FormValidifier $formValidifier){}
    public function handleForm($dataForm){
        $DTO = $this->formValidifier->validify($dataForm);
        $this->Creator->create($DTO);
    }
}