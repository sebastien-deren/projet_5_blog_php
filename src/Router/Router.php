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

    public function setPath(?string $name,$controller)
    {
        $this->index = new PathFinal($name,$controller);
        return $this->index;
    }

    public function findOurRoute(string $url_argument): TemplateWrapper
    {
        $splittedUrl = $this->splitRoute($url_argument);
        $template = $this->checkRoute(\array_shift($splittedUrl), $splittedUrl, $this->index);
        return $template;
    }
    private function splitRoute(string $path): array
    {
        $splittedPath = explode("/", $path);
        if (empty($splittedPath)) {
            return null; //return the route to the index or go to the controller index etc...
        }
        return $splittedPath;
    }
    private function checkRoute(string $pathPart, array $pathRest, Path $inPath): TemplateWrapper
    {
        $path = $inPath->isSubPath($pathPart);
        //check if we are in a finalpath (fullyqualifiedpath)
        if (\is_a($path, PathFinal::class)&&(count($pathRest)==0 || \is_numeric($pathRest[0])))
        {
            return $this->callController($path,$pathRest);
        }
        //check if we are in the good path and if we still have subpath to check
        if ($path && !empty($pathRest)) {
            return $this->checkRoute(\array_shift($pathRest), $pathRest, $path);
        }


        throw new Exception("le chemin n'est pas complet");
    }
    private function callController(PathFinal $finalPath,array $pathRest){
        /**
         * check if we have just one element who is not a path of our finalpath (checked before)
         * if we have more than one path we throw an exception
         * if not we will send our pathrest as an argument
         * and we will let the controller do its thing, he might throw an exception if it doesn't accept any argument.
         * **/
        if(count($pathRest)>1)
        {
            throw new Exception("le chemin est trop long");
        }
        return $finalPath->callController(empty($pathRest[0]) ? null : $pathRest[0]);
        
    }
}
