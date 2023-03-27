<?php

include 'db_connection.php';

session_start();

if (!key_exists('id', $_SESSION)) {
    return header("location:/homework/login.php");
}

$query = "delete from books where id = ?";
$result = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($result, 'i', $_POST['id']);
mysqli_stmt_execute($result);
header("location:/homework/index.php");
