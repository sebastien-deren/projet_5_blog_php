<?php
namespace Blog\Form\Interface;

interface FormValidifier{
    public function validify(array $data);
}