<?php
namespace Blog\Router;

use Blog\Controller\Controller;
use Blog\Exception\RouterException;

//the name of this class is really poorly choosen we will need to find a better one asap
class Path{
    private array $subpath =[];
    private bool $subPathIsId =false;
    public function __construct(private ?string $name=null ){}

    //we will create a new subpath with a name and link it to the list 
    public function addSubPath(string $name){
        $path = new Path($name);
        $this->subpath[]=$path;
        return $path;
    }
    public function addFinalPath(string $name,Controller $controller){
        $path = new PathFinal($name,$controller);
        $this->subpath[]=$path;
        return $path;
    }

    //we will check if the part of the url is a subpath of our site
    public function isSubPath(string $partOfPath):Path{
        foreach($this->subpath as $sub){
            if(\strtolower($sub->getPathName())===\strtolower($partOfPath)){
                return $sub;
            }
        }
        if(($this->name ===null)&& empty($partOfPath) ){
            throw new RouterException('on est dans index!');
        }
        throw new RouterException("pas de souspathe à ce nom ".$partOfPath);
    }
    /*if the path have a subpath called by an id (like blog/post)
    we will set the a boolean to say that we can wait for an integer*/
    public function subPathIdentifiable(){
        $this->subPathIsId=true;
    }
    //get the name of the path, index has an empty name
    public function getPathName():?string{
        return $this->name;
    }
}