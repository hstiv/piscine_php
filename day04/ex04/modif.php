<?php

function if_present($content, $login, $newpw, $oldpw2) {
    foreach($content as $key => $arr) {
        if ($arr['login'] == $login) {
            $oldpw = hash("sha256", $oldpw2);
            if ($arr['passwd'] != $oldpw)
                return (false);
            $content[$key]["passwd"] = hash("sha256", $newpw);
            file_put_contents('../private/passwd', serialize($content));
            return (true);
        }
    }
    return (false);
}

if (isset($_POST['submit']) && $_POST['submit'] == 'OK') {
	if (isset($_POST['login']))
		$login = $_POST['login'];
    if (isset($_POST['oldpw']) && $_POST['oldpw'] != '' && isset($_POST['newpw']) && $_POST['newpw'] != '') {
        $oldpw = $_POST['oldpw'];
        $newpw = $_POST['newpw'];
        if (file_exists('../private/passwd') == true) {
            $content = unserialize(file_get_contents('../private/passwd'));
            if (!if_present($content, $login, $newpw, $oldpw)) {
                header('Location: index.html');
                echo "ERROR\n";
            }
            else {
                header('Location: index.html');
                echo "OK\n";
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
}
else {
    header('Location: index.html');
    echo "ERROR\n";
}