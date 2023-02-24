<?php

declare(strict_types=1);

namespace Blog\Controller\Blog;

use Blog\DTO\Comment\CommentDTO;
use Blog\Service\CommentService;
use Blog\Form\Comment\CommentForm;
use Blog\DTO\Comment\CreateComment;
use Blog\Controller\AbstractController;
use Blog\Exception\FormException;

class PostArticleController extends ArticleController
{
    public function execute(): string
    {
        try {
            $formValidifier = new CommentForm(new CreateComment, $_POST);
            $comment = $formValidifier->validify();
            //here we need to merge comment moderation before rewriting all the commentService
            $commentservice = CommentService::getService($this->entityManager);
            $commentservice->create($comment, $_SESSION['id']);
            $this->argument['comment'] = $comment;
        } catch (FormException $e) {
            $this->argument['error'] = $e;
        }

        return parent::execute();
    }
}
