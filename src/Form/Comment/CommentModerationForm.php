<?php

declare(strict_types=1);

namespace Blog\Form\Comment;

use Exception;
use Blog\DTO\AbstractDTO;
use Blog\Enum\CommentStatus;
use Blog\Exception\FormException;
use Blog\Form\Abstracts\FormValidifier;
use Blog\DTO\Comment\CommentModerationDTO;
use Blog\DTO\Form\Comment\CommentModerationListDTO;
use Symfony\Component\Console\Exception\MissingInputException;

class CommentModerationForm extends FormValidifier
{
    public function __construct(CommentModerationListDTO $DTO, array $data)
    {
        parent::__construct($data);
        $this->DTO = $DTO;
    }

    protected function createDTO(): void
    {
        foreach ($this->data['id'] as $idComment) {
            $this->DTO->commentsToModerate[] = (int)$idComment;
        }
    }
    protected function checkingRequired(): void
    {
        isset($this->data['id']) ?: throw new FormException("veuillez selectionner au moins un commentaire a modérer");
        foreach (CommentStatus::cases() as $case) {
            if (\array_key_exists($case->value, $this->data)) {
                $this->DTO->validity = $case;
            }
        }
        $this->DTO->validity ?? throw new FormException("you cannot moderate comment like this");
    }
}
