<?php

declare(strict_types=1);

namespace Blog\Router;

use Blog\Router\Domain;

class Router
{

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
    }
    private function splitRoute(string $path): array
    {
        $splittedPath = explode("/", $path);
        if (empty($splittedPath)) {
            return null; //return the route to the index or go to the controller index etc...
        }
        return $splittedPath;
    }
    private function checkRoute(string $pathPart, array $pahtRest, Domain $inDomain){
        $domain = $inDomain->isSubdomain($pathPart);
        if($domain && !empty($pahtRest)){
            return $domain->getDomainName() ."\\". $this->checkRoute(\array_shift($pahtRest),$pahtRest,$domain);
        }
        else{
            return $domain->getDomainName();

        }
    }
}
