<?php
namespace Blog\Service\Interface;

use Blog\DTO\AbstractDTO;

interface Creater{
    public function create(AbstractDTO $objecttoCreate);
}