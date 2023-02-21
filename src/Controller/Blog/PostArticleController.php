<?php
declare(strict_types=1);
namespace Blog\Controller\Blog;

use Blog\Form\CommentForm;
use Blog\Service\CommentService;
use Blog\DTO\Form\Comment\CommentCreationDTO;

class PostArticleController extends ArticleController{
    public function execute():string
    {
    $formValidifier = new CommentForm(new CommentCreationDTO, $_POST);
    $dto = $formValidifier->validify();
    //here we need to merge comment moderation before rewriting all the commentService
    $commentservice = CommentService::getService($this->entityManager);
    $commentservice->create($dto);
        return parent::execute();
    }

}