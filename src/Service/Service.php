<?php
namespace Blog\Service;

use Doctrine\ORM\EntityManager;

class Service{
    public function __construct(protected EntityManager $entityManager)
    {
        
    }
}