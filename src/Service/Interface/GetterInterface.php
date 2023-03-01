<?php

namespace Blog\Service\Interface;

interface GetterInterface
{
    public function getAll(): array;
    public function getBy(array $params): object;
}
