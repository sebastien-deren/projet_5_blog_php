<?php

declare(strict_types=1);

namespace Blog\Router;

use Exception;
use Blog\Enum\Method;
use Twig\Environment;
use Blog\Exception\RouterException;
use Blog\Controller\ErrorController;
use Doctrine\ORM\EntityManagerInterface;
use Blog\Controller\Homepage\IndexController;
use Blog\Controller\Interface\ControllerInterface;


class Router
{
    private array $paths = [];
    private string $controller;
    public function __construct(
        private string $url,
        private Method $methodRequested,
        private Environment $twig,
        private EntityManagerInterface $entityManager
    )
    {

    }
    /**
     * addPath
     * @param string $name nom du chemin
     * @param string $fullyQualifierController nom du Controller
     * @param Method $method methode d'accés à la page
     * @return void
     */
    public function addPath(string $name, string $fullyQualifierController, Method $method = Method::GET)
    {
        $this->paths[] = ["name" => $name, "controller" => $fullyQualifierController, 'method' => $method];
    }
    /**
     * getController
     * @return ControllerInterface
     */
    public function getController(): ControllerInterface
    {
        try {
            $this->url = \trim($this->url, '/');
            $this->controller = $this->findController();
            return new $this->controller($this->twig, $this->entityManager);
        } catch (Exception $e) {
            return new ErrorController($this->twig, $this->entityManager, $e);
        }
    }

    private function findController(): string
    {
        foreach ($this->paths as $validpath) {
            if (TRUE === $this->checkController($validpath)) {
                return $validpath["controller"];
            }
        }
        throw new RouterException("page non trouvé", 404);
    }
    /**
     * @param array<["name"=string],["controller"=string],["method"=Method]> $pathtocheck
     * @return bool
     */
    private function checkController(array $pathtocheck): bool
    {
        if (\strtolower($pathtocheck['name']) !== \strtolower($this->url)) {
            return false;
        }
        if ($this->methodRequested !== $pathtocheck['method']) {
            return false;
        }
        return true;
    }
}
