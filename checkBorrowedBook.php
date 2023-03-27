<?php
session_start();
include './db_connection.php';

if (!key_exists('id', $_SESSION)) {
    return header("location:/homework/login.php");
}

function checkBorrowedBook($con) {
    $selectFromBooks = "SELECT * FROM books where id = " . $_POST['id'] . "";
    $selectFromBookUser = "SELECT * FROM book_user where book_id = " . $_POST['id'] . "";
    $resultBooks = mysqli_query($con, $selectFromBooks);
    $resultBookUser = mysqli_query($con, $selectFromBookUser);
    $getBooks = mysqli_fetch_assoc($resultBooks);
    $getBookUser = mysqli_fetch_assoc($resultBookUser);
    
    if ($getBooks && !$getBookUser) {
        $userID = $_SESSION['id'];
        $bookID = $getBooks['id'];
        $query = "insert into book_user (book_id, user_id) values ($bookID, $userID)";
        $result = mysqli_prepare($con, $query);
        mysqli_stmt_execute($result);
    }
    if ($getBooks['available'] === 'dostupno') {
        $query = "update books set available='nedostupno' where id = " . $_POST['id'] . "";
        $result = mysqli_prepare($con, $query);
        mysqli_stmt_execute($result);
    } else {
        $query = "update books set available='dostupno' where id = " . $_POST['id'] . "";
        $result = mysqli_prepare($con, $query);
        mysqli_stmt_execute($result);

        $query = "delete from book_user where book_id = " . $_POST['id'] . "";
        $result = mysqli_prepare($con, $query);
        mysqli_stmt_execute($result);

    }
}

checkBorrowedBook($con);
header("location:/homework/index.php");