<?php

namespace Blog\Controller\Blog;

use Blog\Controller\Controller;
use Blog\Entity\Post;
use Exception;

class BlogListController extends Controller
{
    public function execute():string
    {
        $template = $this->twig->load('@blog/list.html.twig');
        if (!isset($template)) {
            throw new Exception("WTF");
        }

        $posts = $this->getPosts();
        return $template->render(["posts" => $posts]);
        }
    private function getPosts()
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findAll();
        return $posts;
    }
}
