<?php
namespace Blog\Form;

use Blog\DTO\Post\PostDisplayDTO;
use Blog\DTO\Post\SinglePostDTO;
use Blog\Form\NewFormValidifier;

class EditPostValidifier extends NewFormValidifier{
    public function __construct(SinglePostDTO $Dto , $data)
    {
        $this->DTO =$Dto;
        parent::__construct($data);
        
    }
    protected function checkingRequired(){

    }
    protected function createDTO(){
        $this->DTO->authorId = \intval($_POST['author']);
        $this->DTO->content =$_POST['content'];
        $this->DTO->excerpt = $_POST['excerpt'];
        $this->DTO->id = \intval($_POST['id']);
        $this->DTO->title =$_POST['title'];

    }
}