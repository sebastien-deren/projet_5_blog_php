<?php
namespace Blog\Controller;

use Twig\Environment;

class PostController implements Controller{
    public function __construct(private Environment $twig)
    {
        # code...
    }
    public function doYourThing(?int $id)
    {
        # code...
    }

}