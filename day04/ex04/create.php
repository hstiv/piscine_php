<?php

function is_new($content, $login) {
    foreach($content as $arr) {
        if ($arr['login'] == $login) {
                return (false);
        }
    }
    return (true);
}

if (isset($_POST['submit']) && $_POST['submit'] == 'OK') {
	if (isset($_POST['login']))
		$login = $_POST['login'];
    if (isset($_POST['passwd']) && $_POST['passwd'] != '') {
        $passwd = $_POST['passwd'];
        if (file_exists('../private/passwd') == true) {
            $content = unserialize(file_get_contents('../private/passwd'));
            if (!is_new($content, $login)) {
                header('Location: index.html');
                echo "ERROR\n";
            }
            else {
                $content[] = array('login' => $login, 'passwd' => hash('sha256',$passwd));
                if (!file_put_contents('../private/passwd', serialize($content))) {
                    header('Location: index.html');
                    echo "ERROR\n";
                }
                else {
                    header('Location: index.html');
                    echo "OK\n";
                }
            }
        }
        else {
            if (!file_exists('private'))
                mkdir('../private');
            if (!file_put_contents('../private/passwd', serialize(array(array('login' => $login, 'passwd' => hash('sha256',$passwd)))))) {
                header('Location: index.html');
                echo "ERROR\n";
            }
            else {
                header('Location: index.html');
                echo "OK\n";
            }
        }
    }
    else {
        header('Location: index.html');
        echo "ERROR\n";
    }
}
else {
    header('Location: index.html');
    echo "ERROR\n";
}