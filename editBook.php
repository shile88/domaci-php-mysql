<?php

include './db_connection.php';

session_start();

if (!key_exists('id', $_SESSION) || !isset($_POST['id'])) {
    return header("location:/homework/login.php");
}
function editBook($con, $title, $author, $description, $id)
{
    $query = "update books set title=?, author=?, description=? where id=?";
    $result = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($result, 'sssi', $title, $author, $description, $id);
    mysqli_stmt_execute($result);

    if ($result) {
        header("location:/homework/index.php");
    }
}

if (isset($_POST['submit'])) {
    editBook($con, $_POST['title'], $_POST['author'], $_POST['description'], $_POST['id']);
} else {
    $selectFromDatabase = "SELECT * FROM books where id = " . $_POST['id'] . "";

    $title = '';
    $author = '';
    $description = '';
    $result = mysqli_query($con, $selectFromDatabase);
    if ($result) {
        $getRow = mysqli_fetch_assoc($result);
        if ($getRow !== NULL) {
            $title = $getRow['title'];
            $author = $getRow['author'];
            $description = $getRow['description'];
            $id = $getRow['id'];
        }
    }
}

?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container mt-5">
        <h1>Promjeni podatke</h1>
        <form action="editBook.php" method="POST" class="mt-5 bg-light p-3 border border-3 rounded">
            <label for="title">Naslov </label>
            <input type="text" value="<?php echo $title ?>" id="title" required name="title" class="form-control w-50" placeholder="Unesite naslov knjige" />

            <label class="mt-3" for="author">Autor </label>
            <input type="text" value="<?php echo $author ?>" id="author" required name="author" class="form-control w-50" placeholder="Unesite autora knjige" />

            <label class="mt-3" for="description">Opis </label>
            <input type="text" value="<?php echo $description ?>" id="description" required name="description" class="form-control w-50" placeholder="Unesite kratak opis knjige" />
            <button name="submit" class="btn btn-success mt-3">Promjeni</button>
            <a href="home.php" class="btn btn-danger mt-3">Otkazi</a>

            <input type="hidden" name="id" value="<?php echo $id ?>" />
        </form>
    </div>


</body>

</html>