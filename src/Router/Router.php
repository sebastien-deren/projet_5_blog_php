<?php

declare(strict_types=1);

namespace Blog\Router;

<<<<<<< HEAD
use Blog\Router\Domain;
=======
use Exception;
use Twig\Environment;
use Blog\Router\Domain;
use Twig\TemplateWrapper;
use Blog\Router\SubPathFinal;
>>>>>>> 14cc5f9 (adding subpathfinal)

class Router
{

<<<<<<< HEAD
    private Domain $index ;

    public function setDomain(?string $name){
        $this->index= new Domain($name);
        return $this->index;
    }

    public function findOurRoute(string $url_argument, $method):string
    {
        $splittedUrl = $this->splitRoute($url_argument);
        $route = $this->checkRoute(\array_shift($splittedUrl),$splittedUrl,$this->index);
        return $route;
=======
    private Domain $index;

    public function setDomain(?string $name,$controller)
    {
        $this->index = new SubPathFinal($name,$controller);
        return $this->index;
    }

    public function findOurRoute(string $url_argument, $method): TemplateWrapper
    {
        $splittedUrl = $this->splitRoute($url_argument);
        $template = $this->checkRoute(\array_shift($splittedUrl), $splittedUrl, $this->index);
        return $template;
>>>>>>> 14cc5f9 (adding subpathfinal)
    }
    private function splitRoute(string $path): array
    {
        $splittedPath = explode("/", $path);
        if (empty($splittedPath)) {
            return null; //return the route to the index or go to the controller index etc...
        }
        return $splittedPath;
    }
<<<<<<< HEAD
    private function checkRoute(string $pathPart, array $pahtRest, Domain $inDomain){
        $domain = $inDomain->isSubdomain($pathPart);
        if($domain && !empty($pahtRest)){
            return $domain->getDomainName() ."\\". $this->checkRoute(\array_shift($pahtRest),$pahtRest,$domain);
        }
        else{
            return $domain->getDomainName();

        }
=======
    private function checkRoute(string $pathPart, array $pahtRest, Domain $inDomain): TemplateWrapper
    {
        $domain = $inDomain->isSubdomain($pathPart);
        if ($domain && !empty($pahtRest)) {
            return $this->checkRoute(\array_shift($pahtRest), $pahtRest, $domain);
        }
        if (\is_a($domain, SubPathFinal::class)) {
            return $this->callController($domain);
        }
        throw new Exception("le chemin n'est pas complet");
    }
    private function callController(SubPathFinal $finalPath){
        return $finalPath->callController();
        
>>>>>>> 14cc5f9 (adding subpathfinal)
    }
}
