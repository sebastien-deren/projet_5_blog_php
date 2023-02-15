<?php

namespace Blog\Form;


use Blog\DTO\Post\CreatePostDTO;

class CreatePostForm extends FormValidifier
{

    protected function checkingRequired(array $data){
        if (empty($data['title'])) {
            throw new \Exception("pas de titre");
        }
        if (empty($data['excerpt'])) {
            throw new  \Exception("pas de résumé");
        }
        if (empty($data['content'])) {
            throw new \Exception("pas de contenu");
        }
    }
    protected function createDTO(array $data)
    {       
        if(!($this->DTO instanceof CreatePostDTO)){
            throw new \Exception("DTO type exception");
        }
        $this->DTO->content = ($data['content']);
        $this->DTO->excerpt = $data['excerpt'];
        $this->DTO->title = $data['title']; 
    }
}
