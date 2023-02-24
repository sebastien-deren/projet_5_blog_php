<?php

declare(strict_types=1);

namespace Blog\Form\Comment;

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
        $countline =substr_count( $this->data['content'], "\n" );
        $countchar =\strlen($this->data['content'])-$countline;
        if (!isset($_SESSION['id'])) {
            throw new FormException("Vous devez être connecter pour poster un commentaire.");
        }
        if ($countchar<6) {
            throw new FormException("Vous devez écrire un vrai commentaire (minimum 6 charactère) avant de l'envoyer.");
        }
        if(($countline>10)||(($countline>3)&&(($countchar/$countline)<10))){
            throw new FormException("Soyons sérieux trois secondes, ".$countline." ligne dans un commentaire de ".$countchar." characteres.\n Je peux pas accepter ça!");
        }
    }
    protected function createDTO()
    {
        $this->DTO->content = $this->data['content'];
        $this->DTO->postId = intval($this->data['idPost']);
    }
}
