<?php
namespace Blog\Router;

use Blog\Exception\RouterException;
//the name of this class is really poorly choosen we will need to find a better one asap
class Domain{
    private array $subdomain =[];
    private bool $subDomainIsId =false;
    public function __construct(private ?string $name=null ){}

    //we will create a new subdomain with a name and link it to the list 
    public function addSubdomain(string $name){
        $domain = new Domain($name);
        $this->subdomain[]=$domain;
        return $domain;
    }

    //we will check if the part of the url is a subdomain of our site
    public function isSubdomain(string $partOfPath):Domain{
        if($this->subDomainIsId === true && \is_numeric($partOfPath)){
            
            return $partOfPath;
        }
        foreach($this->subdomain as $sub){
            if(\strtolower($sub->getDomainName())===\strtolower($partOfPath)){
                return $sub;
            }
        }
        throw new RouterException("pas de sousdomaine à ce nom ".$partOfPath);
    }
    /*if the domain have a subdomain called by an id (like blog/post)
    we will set the a boolean to say that we can wait for an integer*/
    public function subDomainIdentifiable(){
        $this->subDomainIsId=true;
    }
    //get the name of the domain, index has an empty name
    public function getDomainName():?string{
        return $this->name;
    }
}