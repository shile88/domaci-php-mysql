<?php

session_start();

session_start();

if (!key_exists('id', $_SESSION)) {
    return header("location:./login.php");
}
unset($_SESSION['id']);
unset($_SESSION['error']);
session_destroy();
header("location:login.php");
