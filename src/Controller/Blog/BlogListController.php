<?php

namespace Blog\Controller\Blog;


use Blog\Entity\Post;
use Blog\Controller\Controller;
use Blog\Controller\AbstractController;
use Blog\Service\PostService;

class BlogListController extends AbstractController
{
    public function execute():string
    {
        $template = $this->twig->load('@blog/list.html.twig');

        $postService =new PostService($this->entityManager);
        /*here we have two choice, 
        either fetch all the posts and display it with some js pagination
        or fetch 10posts and when we change pages fetch 10 other etc ...
        for our purpose we're gonna fetch all the posts for two reason,
        first that way we/the user can control how many post are displayed at any time withour reloading the page
        second we're not gonna have Mb of data to fetch from our db so the request will stay relatively small
        we can image a third solution who combine the two solution, fetch 100 by 100 and then the js will display it correctly.
        */ 
        $this->argument['posts']= $postService->getAll();
        return $template->render($this->argument);
        }
}
