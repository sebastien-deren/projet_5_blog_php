<?php
namespace Blog\Form;

use Blog\DTO\Post\UpdatePostDTO;
use Blog\Form\NewFormValidifier;

class EditPostValidifier extends NewFormValidifier{
    public function __construct(UpdatePostDTO $Dto , $data)
    {
        $this->DTO =$Dto;
        parent::__construct($data);
        
    }
    protected function checkingRequired(){
        if(count($this->data)!==count(\array_filter($this->data))){
            throw new \Exception("un ou plusieur champs à été mal rempli");
        }
    }
    protected function createDTO(){
        $this->DTO->authorId = \intval($this->data['author']);
        $this->DTO->content =$this->data['content'];
        $this->DTO->excerpt = $this->data['excerpt'];
        $this->DTO->id = \intval($this->data['id']);
        $this->DTO->title =$this->data['title'];

    }
}