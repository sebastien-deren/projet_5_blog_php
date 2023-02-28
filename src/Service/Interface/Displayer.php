<?php
namespace Blog\Service\Interface;

use Blog\DTO\AbstractDTO;

interface Displayer
{
    public function display(int $id);
}