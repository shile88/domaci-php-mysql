<?php

session_start();

if (!key_exists('id', $_SESSION)) {
    return header("location:/homework/login.php");
}

function getBooksFromDatabase($con, $term = "", $sort = 'asc') {
    $query = "SELECT * FROM books where title like '%$term%' or author like '%$term%' ORDER BY title $sort";
    $result = mysqli_query($con, $query);

    if ($result) {
        $assocArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $assocArray;
    }
}

