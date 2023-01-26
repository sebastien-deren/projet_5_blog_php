<?php

declare(strict_types=1);

namespace Blog\Controller\Admin;

use Blog\Enum\CommentStatus;
use Blog\Service\PostService;
use InvalidArgumentException;
use Blog\Controller\Controller;
use Blog\Service\CommentService;
use Blog\DTO\CommentModerationListDTO;
use Blog\Form\Comment\CommentModerationForm;

class CommentModerationController extends Controller
{
    private CommentService $commentService;
    public function render()
    {

        $this->commentService = new CommentService($this->entityManager);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $status = CommentStatus::tryfrom($_POST['input']) ?: throw new \Exception("Ce status n'est pas défini: ".$_POST['input']);
                $commentsToModerate = new CommentModerationForm(new CommentModerationListDTO($status));
                $commentArray = $commentsToModerate->validify($_POST['id']);
                $numberOfModification = $this->commentService->moderateComments($commentArray);
                $this->argument["information"] = $numberOfModification . " commentaire(s) ont bien été " . $status->value . " !";
            } catch (InvalidArgumentException $e) {
                $this->argument['information'] = $e->getMessage();
            }
        }
        try {
            $postService = new PostService($this->entityManager);
            $this->argument['posts']= $postService->getPostListWithComment(CommentStatus::Pending);
        } catch (InvalidArgumentException $e) {
            $this->argument['information'] = $e->getMessage();
        }
        echo $this->twig->render('@admin/commentModeration.html.twig', $this->argument);
    }
}
