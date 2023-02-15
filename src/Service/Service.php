<?php
namespace Blog\Service;

use Doctrine\ORM\EntityManager;

abstract class Service{
    public function __construct(protected EntityManager $entityManager)
    {
        
    }
}