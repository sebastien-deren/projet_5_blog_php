<?php

namespace Blog\Form\Post;

use Blog\DTO\Post\CreatePostDTO;
use Blog\Form\Abstracts\FormValidifier;

class CreatePostForm extends FormValidifier
{

    public function __construct(CreatePostDTO $DTO,array $data){
        parent::__construct($data);
        $this->DTO=$DTO;

    }
    protected function checkingRequired(){
        if (empty($this->data['title'])) {
            throw new \Exception("pas de titre");
        }
        if (empty($this->data['excerpt'])) {
            throw new  \Exception("pas de résumé");
        }
        if (empty($this->data['content'])) {
            throw new \Exception("pas de contenu");
        }
    }
    protected function createDTO()
    {       
        $this->DTO->content = ($this->data['content']);
        $this->DTO->excerpt = $this->data['excerpt'];
        $this->DTO->title = $this->data['title']; 
    }
}
