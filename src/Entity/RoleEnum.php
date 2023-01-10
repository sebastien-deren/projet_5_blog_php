<?php
declare(strict_types=1);
namespace Blog\Entity;

enum RoleEnum : int{
    case Admin = 1;
    case User = 0;
}