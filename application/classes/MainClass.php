<?php

namespace Blind;

class Main
{
    // method for validate with different regex
    protected static function validate($regex, $value) {
        if(!preg_match($regex, $value))
            return true;

        return false;
    }

    public static function redirect($location) {
        header('Location: '.$location);
        exit();
    }

    public static function csrf_protection($post_token, $header_token) {
        if(is_array($post_token) || is_array($header_token))
            return false;

        $header_token = trim($header_token);

        if ((trim($post_token) === $header_token) && ($header_token === $_SESSION['token']))
            return true;
        else
            return false;
    }

    // method for check is_array and trim user's input
    public static function validate_vars() {
        $count = func_num_args();
        $vars = func_get_args();

        for ($i = 0; $i < $count; $i++) {
            if (is_array($vars[$i]))
                return false;
            elseif (!trim($vars[$i]))
                return false;
        }

        return true;
    }

    public static function status($value, $bool = false) {
        header('Content-Type: application/json');
        echo json_encode(array('status' => $value, 'boolean' => $bool));
        exit();
    }
}