<?php
namespace Blog\Service\Interface;

use Blog\DTO\User\LoginDTO;

interface Logger{
    public function log(LoginDTO $objecttoCreate);
}