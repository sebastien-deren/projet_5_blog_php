<?php

namespace Blog\Controller\Admin;


use Blog\Service\CommentService;
use Blog\Form\Comment\CommentModerationForm;
use Blog\DTO\Form\Comment\CommentModerationListDTO;


class PostCommentModerationController extends CommentModerationController
{
    public function execute(): string
    {

        try {
            $commentsValidifier = new CommentModerationForm(new CommentModerationListDTO);
            $commentArray =$commentsValidifier->validify($_POST);
            $commentService = CommentService::getService($this->entityManager);
            $modification = $commentService->moderateComments($commentArray);

            $this->argument["information"] = $modification['number'] . " commentaire(s) ont bien été " . $modification['method'] . " !";
        } catch (\InvalidArgumentException $e) {
            $this->argument['information'] = $e->getMessage();
        }
        return parent::execute();
    }
}
