<?php

declare(strict_types=1);

namespace Blog\Router;

use Blog\Controller\Controller;
use Blog\Controller\IndexController;
use Blog\Exception\RouterException;

class Router
{
    private array $paths = [];
    private string $controller;
    public function __construct()
    {
    }
    public function addPath(string $name, string $fullyQualifierController)
    {
        $this->paths[] =["name"=> $name,"controller"=>$fullyQualifierController];
    }
    public function getController(string $url): controller
    {
        if (empty($path)) {
            $this->controller = IndexController::class;
        }
        $this->controller = $this->findController($url);
        return new $this->controller;

    }
    private function findController(string $path):string
    {
        foreach ($this->paths as $validpath) {
            if (\strtolower($path) === \strtolower($validpath["name"])) {
                return $validpath["controller"];
            }
        }
        throw new RouterException("il n'y a pas de page à ce chemin");
    }
}
