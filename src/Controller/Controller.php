<?php
namespace Blog\Controller;

use Twig\Environment;


Abstract class Controller  
{
    public function __construct(protected Environment $twig)
    {}
    public function doYourThing(){
    }
}
