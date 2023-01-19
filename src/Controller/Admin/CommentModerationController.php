<?php
declare(strict_types=1);

namespace Blog\Controller\Admin;

use Blog\Controller\Controller;
use Blog\Service\CommentService;
use Blog\Form\Comment\CommentModerationValidify;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use InvalidArgumentException;
use Symfony\Component\Console\Exception\MissingInputException;

class CommentModerationController extends Controller
{
    private CommentService $commentService;
    public function render()
    {

        $this->commentService = new CommentService($this->entityManager);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentsToModerate = new CommentModerationValidify;
            try {
                $commentArray = $commentsToModerate->arrayToObjectCommentList($_POST);
                $numberOfModification = $this->commentService->moderateComments($commentArray);
                $this->argument["information"] = $numberOfModification . " commentaire(s) ont bien été " . $_POST["input"] . " !";
            } catch (InvalidArgumentException $e) {
                $this->argument['information'] = $e->getMessage();
            }
        }
        try{
        $this->argument['comments'] = $this->commentService->getCommentNotModerate();
        }catch(InvalidArgumentException $e){
            $this->argument['information'] = $e->getMessage();
        }
        echo $this->twig->render('@admin/commentModeration.html.twig', $this->argument);
    }
}
