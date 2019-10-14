<?php
    include 'index.html';
    function is_pres()
    {
        $usr = file_get_contents("private/passwd");
        if (isset($usr[$_POST("login")]))
            return (false);
        return (true);
    }

    $usr = array("login" => "", "passwd" => "");
    if (isset($_POST["submit"]) && isset($_POST["submit"]) == "OK" && isset($_POST["login"]) && isset($_POST["passwd"]) && !is_pres())
    {
        $usr["login"] = $_POST["login"];
        $usr["passwd"] = hash("whirlpool", $_POST["passwd"]);
        if (file_exists("private") && file_exists("private/passwd"))
            file_put_contents("private/passwd", serialize($usr));
        else
        {
            mkdir("private");
            file_put_contents("private/passwd", $usr);
        }
        
    }

?>
