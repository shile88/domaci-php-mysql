<?php

function checkBorrowedStatus($con) {
    $selectFromBookUser = "SELECT * FROM book_user where user_id = " . $_SESSION['id'] .""; 
    $result = mysqli_query($con, $selectFromBookUser);
    $getData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
   $ids = array_column($getData, 'book_id');
   return $ids;
}