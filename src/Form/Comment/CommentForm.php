<?php

declare(strict_types=1);

namespace Blog\Form\Comment;

use Exception;
use Blog\Exception\FormException;
use Blog\DTO\Comment\CreateComment;
use Blog\Form\Abstracts\FormValidifier;

class CommentForm extends FormValidifier
{
    public function __construct(CreateComment $DTO, array $data)
    {
        $this->DTO = $DTO;
        parent::__construct($data);
    }
    protected function checkingRequired()
    {
        if (!isset($_SESSION['id'])) {
            throw new FormException("you must be connected to post a comment");
        }
        if (empty($this->data['content'])) {
            throw new FormException("you must write a comment before sending it");
        }
    }
    protected function createDTO()
    {
        $this->DTO->content = $this->data['content'];
        $this->DTO->postId = intval($this->data['idPost']);
    }
}
