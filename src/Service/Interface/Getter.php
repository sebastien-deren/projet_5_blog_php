<?php
namespace Blog\Service\Interface;

interface Getter{
    public function getAll();
    public function getBy(array $params);
}