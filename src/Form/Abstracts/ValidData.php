<?php

namespace Blog\Form\Abstracts;

use Blog\Enum\FieldType;


class ValidData
{
    public static function mail(string $mail): ?FieldType
    {
        return \filter_var($mail, \FILTER_VALIDATE_EMAIL) ? FieldType::MAIL : null;
    }
    public static function login(string $login): ?FieldType
    {
        //here we can do our regex logic
        return !\strchr($login, " ") && !\strchr($login, "@") ? FieldType::LOGIN : null;
    }
}
