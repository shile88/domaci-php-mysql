<?php
session_start();
include '../db_connection.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] !== "" && $_POST['password'] !== "") {
       
        
        if ($success) {
            $username = $_POST['username'];
            $search = "SELECT * FROM users where username = '$username'";
            $result = mysqli_query($con, $search); 
            $getRow = mysqli_fetch_assoc($result);
            $password = $getRow['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $isPasswordCorrect = password_verify($password, $hashed_password);
            
            if ($getRow) {
                if ($isPasswordCorrect) {
                    $_SESSION['id'] = $getRow['id'];
                }
            }
        }
    }
        if (isset($_SESSION['id'])) {
            return header("location:/homework/index.php");
        }
}

header("location:/homework/login.php");
