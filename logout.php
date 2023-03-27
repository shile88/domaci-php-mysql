<?php

session_start();

session_start();

if (!key_exists('id', $_SESSION)) {
    return header("location:/homework/login.php");
}
unset($_SESSION['id']);
session_destroy();
header("location:login.php");
