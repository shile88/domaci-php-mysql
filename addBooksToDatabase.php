<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h1>Dodaj knjigu</h1>
        <form action="addBooksToDatabase.php" method="POST" class="mt-5 bg-light p-3 border border-3 rounded">
            <label for="title">Naslov </label>
            <input type="text" id="title" required name="title" class="form-control w-50" placeholder="Unesite naslov knjige" />

            <label class="mt-3" for="author">Autor </label>
            <input type="text" id="author" required name="author" class="form-control w-50" placeholder="Unesite autora knjige" />

            <label class="mt-3" for="description">Opis </label>
            <input type="text" id="description" required name="description" class="form-control w-50" placeholder="Unesite kratak opis knjige" />
            <button name="submit" class="btn btn-success mt-3">Dodaj</button>
            <a href="index.php" class="btn btn-danger mt-3">Otkazi</a>
        </form>
    </div>

    <?php

    include './db_connection.php';

    session_start();

    if (!key_exists('id', $_SESSION)) {
        return header("location:./login.php");
    }
    function addBooksToDatabase($con)
    {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $query = "insert into books (title, author, description) values (?, ?, ?)";

        $result = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($result, 'sss', $title, $author, $description);
        mysqli_stmt_execute($result);

        if ($result) {
            header("location:./index.php");
        }
    }

    if (isset($_POST['submit'])) {
        addBooksToDatabase($con);
    };

    ?>
</body>

</html>