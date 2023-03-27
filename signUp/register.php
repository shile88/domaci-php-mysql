<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteka</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">

    <!-- Custom styles for this template -->
    <link href="../css/sign-in.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form action="../signUp/register.php" method="POST">
            <img class="mb-4" src="../css/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Kreiraj nalog!</h1>
            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" id="floatingInput" required placeholder="Enter your name...">
                <label for="floatingInput">Ime</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" id="floatingInput" required placeholder="Enter your username...">
                <label for="floatingInput">Korisnicko ime</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" id="floatingPassword" required placeholder="Password">
                <label for="floatingPassword">Sifra</label>
            </div>
            <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Registruj se</button>
            <a href="../login.php" class="w-100 btn btn-lg btn-danger mt-2">Otkazi</a>
    </main>

        <?php
            include '../db_connection.php';
            session_start();
            function addUser($con) {
                $name = $_POST['name'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "insert into users (name, username, password) values (?, ?, ?)";
            
                $result = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($result, 'sss', $name, $username, $hashed_password);
                mysqli_stmt_execute($result);
                
                if($result) {
                    unset($_SESSION['error']);
                    header("location:../index.php");
                }
            }

            if(isset($_POST['submit'])){
                addUser($con);
            };

        ?>
</body>

</html>