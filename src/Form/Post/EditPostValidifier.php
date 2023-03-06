<?php

namespace Blog\Form\Post;

use Blog\DTO\Form\Post\PostEditionDTO;
use Blog\DTO\Post\UpdatePostDTO;

use Blog\Form\Abstracts\FormValidifier;

class EditPostValidifier extends FormValidifier
{
    public function __construct(PostEditionDTO $Dto, $data)
    {
        $this->DTO = $Dto;
        parent::__construct($data);
    }
    protected function checkingRequired(): void
    {
        if (count($this->data) !== count(\array_filter($this->data))) {
            throw new \Exception("un ou plusieur champs à été mal rempli");
        }
    }
    protected function createDTO(): void
    {
        $this->DTO->authorId = \intval($this->data['author']);
        $this->DTO->content = $this->data['content'];
        $this->DTO->excerpt = $this->data['excerpt'];
        $this->DTO->id = \intval($this->data['id']);
        $this->DTO->title = $this->data['title'];
    }
}
