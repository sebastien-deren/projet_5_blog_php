<?php

namespace Blog\Controller\Admin\ModerateComment;


use Blog\Service\CommentService;
use Blog\Exception\FormException;
use Blog\Form\Comment\CommentModerationForm;
use Blog\DTO\Form\Comment\CommentModerationListDTO;
use Blog\Controller\Admin\ModerateComment\CommentModerationController;


class PostCommentModerationController extends CommentModerationController
{
    public function execute(): string
    {

        try {
            $commentsValidifier = new CommentModerationForm(new CommentModerationListDTO, $_POST);
            $commentArray = $commentsValidifier->validify();
            $commentService = CommentService::getService($this->entityManager);
            $modification = $commentService->moderateComments($commentArray);

            $this->argument["information"] = $modification['number'] . " commentaire(s) ont bien été " . $modification['method'] . " !";
        } catch (FormException $e) {
            $this->argument['information'] = $e->getMessage();
        }
        return parent::execute();
    }
}
