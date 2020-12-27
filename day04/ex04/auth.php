<?php

function function_auth($login, $passwd) {
    if (file_exists('../private/passwd') == true) {
        $content = unserialize(file_get_contents('../private/passwd'));
        foreach($content as $arr) {
            if ($arr['login'] == $login && $arr['passwd'] == hash('sha256', $passwd)) {
                    return (true);
            }
        }
        return (false);
    }
}