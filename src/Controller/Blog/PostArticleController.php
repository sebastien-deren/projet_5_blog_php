<?php
declare(strict_types=1);
namespace Blog\Controller\Blog;

use Blog\Form\CommentForm;
use Blog\DTO\Comment\CommentDTO;
use Blog\Service\CommentService;
use Blog\Controller\AbstractController;
use Blog\DTO\Comment\CreateComment;

class PostArticleController extends ArticleController{
    public function execute():string
    {
    $formValidifier = new CommentForm(new CreateComment, $_POST);
    $dto = $formValidifier->validify();
    //here we need to merge comment moderation before rewriting all the commentService
    $commentservice = CommentService::getService($this->entityManager);
    $commentservice->create($dto,$_SESSION['id']);
        return parent::execute();
    }

}