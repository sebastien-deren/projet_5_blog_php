<?php

namespace Blog\Form\Post;

use Blog\DTO\Post\CreatePostDTO;
use Blog\Exception\FormException;
use Blog\Form\Abstracts\FormValidifier;

class CreatePostForm extends FormValidifier
{

    public function __construct(CreatePostDTO $DTO, array $data)
    {
        parent::__construct($data);
        $this->DTO = $DTO;
    }
    protected function checkingRequired(): void
    {
        if (\strlen($this->data['title']) < 6) {
            throw new FormException("le titre n'est pas assez long");
        }

        if (\strlen($this->data['content']) < 30) {
            throw new FormException("l'article n'es pas assez long");
        }
        if (\strlen($this->data['excerpt']) > 60) {
            throw new FormException("le résumé est trop long");
        }
        if (empty($this->data['excerpt'])) {
            $this->data['excerpt'] = \substr($this->data['content'], 0, 50) . "...";
        }
    }
    protected function createDTO(): void
    {
        $this->DTO->content = ($this->data['content']);
        $this->DTO->excerpt = $this->data['excerpt'];
        $this->DTO->title = $this->data['title'];
    }
}
