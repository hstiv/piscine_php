<?php
session_start();

unset( $_SESSION["logged_in_user"] );
unset( $_SESSION["admin"] );
header("Location: /admin/index.php");