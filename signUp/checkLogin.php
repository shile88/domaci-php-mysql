<?php
session_start();
include '../db_connection.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] !== "" && $_POST['password'] !== "") {
       
        
        if ($success) {
            $username = $_POST['username'];
            $search = "SELECT * FROM users where username = ?";
            $stmt = mysqli_prepare($con, $search);
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $getRow = mysqli_fetch_assoc($result);
            $password = $getRow['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $isPasswordCorrect = password_verify($password, $hashed_password);
            
            if ($getRow && $isPasswordCorrect) {
                    $_SESSION['id'] = $getRow['id'];               
            } else {
                $_SESSION['error'] = "error";
            }
        }
    }
        if (isset($_SESSION['id'])) {
            return header("location:../index.php");
        }
}

header("location:../index.php");
