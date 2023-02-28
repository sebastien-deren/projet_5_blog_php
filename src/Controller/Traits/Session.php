<?php
namespace Blog\Controller\Traits;
class Session
{
    public static function addElement(array $data)
    {
        $_SESSION['ipAddress']=$_SERVER['REMOTE_ADDR'];
        $_SESSION['userAgent']=$_SERVER['HTTP_USER_AGENT'];
        $_SESSION =\array_merge($data, $_SESSION);
    }
}