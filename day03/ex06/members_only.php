<?php
    if ($_SERVER["PHP_AUTH_USER"] && $_SERVER["PHP_AUTH_PW"] &&
    $_SERVER["PHP_AUTH_USER"] == "zaz" && $_SERVER["PHP_AUTH_PW"] == "Ilovemylittleponey")
    {
        header('Content-type: text/html');
    }
    else
    {
        header('HTTP/1.0 401 Unauthorized');
        header("WWW-Authenticate: Basic realm=''Member area''");
        header('Content-length: 72');
        header('Content-type: text/html');
        echo "<html><body>That area is accessible for members only</body></html>     \n";
        exit(0);
    }
?>
<html><body>
Hello Zaz<br />
<img src='data:image/png;base64,<?php $s = base64_encode(file_get_contents('../img/42.png')); echo "$s";?>'>
</body></html>
