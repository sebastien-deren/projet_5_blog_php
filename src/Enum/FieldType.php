<?php
namespace Blog\Enum;
enum FieldType :string{
    case MAIL ="mail";
    case LOGIN = "login";
    case NULL = "";
    //...
}