<?php
include './getBooksFromDatabase.php';
include './db_connection.php';
include './checkBorrowedStatus.php';

if (!key_exists('id', $_SESSION)) {
    return header("location:./login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <?php
    $arrow = "bi bi-arrow-up";
    $sorting = 'desc';
    if (!isset($_GET['sort'])) {
        $sorting = 'desc';
        $arrow = "bi bi-arrow-down";
    }
    if (isset($_GET['sort']) && $_GET['sort'] === 'asc') {
        $sorting = 'desc';
        $arrow = "bi bi-arrow-down";
    }
    if (isset($_GET['sort']) && $_GET['sort'] === 'desc') {
        $sorting = 'asc';
        $arrow = "bi bi-arrow-up";
    }

    echo "<form action=\"logout.php\" method=\"POST\">
                <button class=\"btn btn-light position-absolute top-0 end-0 mt-2 me-2 fs-2\">Log out</button>
            </form>"
    ?>

    <div class="container text-center mt-5" id="content">

        <h1>Biblioteka</h1>

        <div class="container mt-5">
            <nav class="navbar navbar-light mb-3">
                <form class="d-flex w-50" role="search" action="home.php" method="GET">
                    <input name="term" class="form-control me-2" value="<?php if (key_exists('term', $_GET))
                                                                            echo $_GET['term'] ?>" placeholder="Trazi knjige po naslovu ili autoru">
                    <button class="btn btn-outline-success" type="submit">Trazi</button>
                </form>
                <a href="addBooksToDatabase.php" class="btn btn-success" type="submit">Dodaj knjigu</a>
            </nav>
            <table class="table table-hover">
                <thead>
                    <th>
                        <form action='index.php' method="GET" id='sort'>
                            <button><i class="<?php echo $arrow ?>"></i></button>
                            <input type="hidden" name='sort' value="<?php echo $sorting ?>" />
                        </form> Naslov
                    </th>
                    <th>Autor</th>
                    <th>Opis</th>
                    <th>Dostupnost</th>
                    <th>Posudi/vrati knjigu</th>
                    <th>Izbrisi</th>
                    <th>Promjeni</th>
                </thead>
                <tbody>
                    <?php

                    if (key_exists('term', $_GET)) {
                        $data = getBooksFromDatabase($con, $_GET['term'], isset($_GET['sort']) ? $_GET['sort'] : 'asc');
                    } else
                        $data = getBooksFromDatabase($con, '', isset($_GET['sort']) ? $_GET['sort'] : 'asc');

                    $borrowedStatus = checkBorrowedStatus($con);


                    if (!$data) {
                        echo "<td colspan=\"8\">
                                 Trenutno nema knjiga u bazi.
                             </td>";
                    } else {
                        foreach ($data as $currentElement) {

                            $id = $currentElement["id"];
                            $title = $currentElement["title"];
                            $author = $currentElement["author"];
                            $description = $currentElement["description"];
                            $availableBook = $currentElement["available"];
                            $status = $availableBook === "dostupno" ? "Posudi knjigu" : "Vrati knjigu";
                            $available = $availableBook === "dostupno" ? "badge text-bg-success" : "badge text-bg-danger";

                            $borrowed = in_array(strval($id), $borrowedStatus);
                            $test = '';
                            $hidden = '';

                            if ($availableBook === "nedostupno" && $borrowed) {
                                $test = 'Vrati';
                            }
                            if ($availableBook === "dostupno") {
                                $test = 'Posudi';
                            }
                            if ($availableBook === "nedostupno" && !$borrowed) {
                                $test = '';
                                $hidden = "d-none";
                            }


                            echo "<tr>                                
                                    <td>$title</td>
                                    <td>$author</td>
                                    <td>$description</td>
                                    <td><span class=\"$available\">$availableBook</span></td>
                                    <td>
                                        <form action=\"checkBorrowedBook.php\" method=\"POST\">
                                            <input type=\"hidden\" name=\"id\" value=\"$id\"/>
                                           
                                            <button class=\"$hidden btn btn-primary\" >$test</button>
                                        </form>

                                    </td>
                                    <td>
                                        <form action=\"deleteBook.php\" method=\"POST\">
                                            <input type=\"hidden\" name=\"id\" value=\"$id\"/>
                                            <button class=\"btn btn-danger\">X</button>
                                        </form>
                                     </td>
                                     <td>
                                     <form action=\"editBook.php\" method=\"POST\">
                                            <input type=\"hidden\" name=\"id\" value=\"$id\"/>
                                            <button class=\"btn btn-warning\">Promjeni</button>
                                        </form>
                                     </td>
                                </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>