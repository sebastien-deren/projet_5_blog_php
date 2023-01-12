<?php

declare(strict_types=1);

namespace Blog\Router;

use Exception;
use Twig\Environment;
use Blog\Router\Path;
use Twig\TemplateWrapper;
use Blog\Router\PathFinal;

class Router
{

    private Path $index;

    public function initPath(?string $name, $controller)
    {
        $this->index = new PathFinal($name, $controller);
        return $this->index;
    }

    public function FindTheController(string $url_argument): TemplateWrapper
    {
        $splittedPath = $this->splitPathIntoSubPath($url_argument);
        $template = $this->checkPathsInSite($splittedPath, $this->index);
        return $template;
    }
    private function splitPathIntoSubPath(string $path): array
    {
        $splittedPath = explode("/", $path);
        if (empty($splittedPath)) {
            return null; //return the route to the index or go to the controller index etc...
        }
        return $splittedPath;
    }
    private function checkPathsInSite(array $pathToCheck, Path $validPath): TemplateWrapper
    {
        $subpathToCheck = \array_shift($pathToCheck);
        $subPath = $validPath->isSubPath($subpathToCheck);
        //check if we are in a finalpath (fullyqualifiedpath) and if we have (numerical argument after that or nothing)
        if (\is_a($subPath, PathFinal::class) && (count($pathToCheck) == 0 || \is_numeric($pathToCheck[0]))) {
            return $this->useController($subPath, $pathToCheck);
        }
        //check if we are in the good path and if we still have subpath to check
        if (!empty($pathToCheck)) {
            return $this->checkPathsInSite( $pathToCheck, $subPath);
        }
        throw new Exception("le chemin n'est pas correct");
    }
    private function useController(PathFinal $finalPath, array $pathRest)
    {
        /**
         * check if we have just one element who is not a path of our finalpath (checked before)
         * if we have more than one path we throw an exception
         * if not we will send our pathrest as an argument
         * and we will let the controller do its thing, he might throw an exception if it doesn't accept any argument.
         * **/
        if (count($pathRest) > 1) {
            throw new Exception("On ne peut pas avoir (pour l'instant d'argument après une id");
        }
        $controller =$finalPath->getController();
        return $controller->createView(empty($pathRest[0]) ? null : \intval($pathRest[0]) );
    }
}
