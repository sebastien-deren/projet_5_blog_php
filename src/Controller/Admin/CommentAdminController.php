<?php
namespace Blog\Controller\Admin;

use Twig\Environment;
use Blog\Controller\Controller;

class CommentAdminController implements Controller{
    public function __construct(private Environment $twig){

    }
    public function createView(?int $id){}
    
}