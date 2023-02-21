<?php

namespace Blog\Form\Abstracts;

use Blog\Enum\FieldType;


class ValidData
{
    public static function mail($mail)
    {
        return \filter_var($mail, \FILTER_VALIDATE_EMAIL) ? FieldType::MAIL : null;
    }
    public static function login($login)
    {
        //here we can do our regex logic
        return !\strchr($login, " ") && !\strchr($login, "@") ? FieldType::LOGIN : null;
    }

}
