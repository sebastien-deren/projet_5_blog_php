<?php

declare(strict_types=1);

namespace Blog\Form;



use Blog\Form\NewFormValidifier;

use Blog\DTO\Form\Comment\CommentCreationDTO;

class CommentForm extends NewFormValidifier
{
    public function __construct(CommentCreationDTO $DTO,$data)
    {
        $this->DTO = $DTO;
        parent::__construct($data);
    }
    protected function checkingRequired()
    {
          if(!isset($_SESSION['id'])){
            throw new \Exception("you must be connected to post a comment");
        }
        if(empty($this->data['content'])){
            throw new \Exception("you must write a comment before sending it");
        }
    }
    protected function createDTO()
    {
        $this->DTO->content = $this->data['content'];
        $this->DTO->postId = intval($this->data['idPost']);
    }
}
