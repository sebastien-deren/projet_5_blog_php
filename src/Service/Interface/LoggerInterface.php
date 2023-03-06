<?php

namespace Blog\Service\Interface;

use Blog\DTO\User\LoginDTO;

interface LoggerInterface
{
    public function log(LoginDTO $objecttoCreate): int;
}
