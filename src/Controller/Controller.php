<?php
namespace Blog\Controller;

use Twig\Environment;


interface Controller  
{
    public function __construct(Environment $twig);
    public function createView(?int $id);
}
