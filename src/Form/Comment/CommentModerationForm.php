<?php

declare(strict_types=1);

namespace Blog\Form\Comment;

use Blog\DTO\AbstractDTO;
use Exception;
use Blog\Enum\CommentStatus;
use Blog\DTO\Comment\CommentModerationDTO;
use Blog\DTO\Comment\CommentModerationListDTO;
use Blog\Form\FormValidifier;
use Symfony\Component\Console\Exception\MissingInputException;

class CommentModerationForm extends FormValidifier
{

    protected function createDTO(array $data)
    {
        if ($this->DTO instanceof CommentModerationListDTO) {
            foreach ($data['id'] as $idComment) {
                $CommentDTO = new CommentModerationDTO(\intval($idComment));
                $this->DTO->commentsToModerate[] = $CommentDTO;
            }
        }
    }
    protected function checkingRequired(array $data)
    {
        isset($data['id']) ?: throw new MissingInputException("veuillez selectionner au moins un commentaire a modérer");
        foreach (CommentStatus::cases() as $case) {
            if (\array_key_exists($case->value, $data)) {
                $this->DTO->validity = $case;
            }
        }
        $this->DTO->validity ?? throw new \Exception("you cannot moderate comment like this");
    }
}
