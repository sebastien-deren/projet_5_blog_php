<?php
namespace Blog\Entity;

enum RoleEnum : int{
    case Admin = 1;
    case User = 0;
}