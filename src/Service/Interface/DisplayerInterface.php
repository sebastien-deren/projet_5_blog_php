<?php

namespace Blog\Service\Interface;

use Blog\DTO\AbstractDTO;

interface DisplayerInterface
{
    public function display(int $id): object;
}
