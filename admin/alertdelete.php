<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,200;9..40,400;9..40,1000&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/src/SVG/mancuerna_roja.svg" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/src/css/styles.css">
    <link rel="stylesheet" href="/src/css/normalize.css">
    <link rel="stylesheet" href="/src/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>IRON</title>
</head>
<body>
    <h1>¿Are you sure?</h1>
    <p>You are about to delete all your data; once deleted, it cannot be recovered. Are you sure?</p>
    <form action="/admin/usuarios/borrar.php" method="post">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="DELETE ACCOUNT  ">
    </form>
    <a href="/admin/usuarios/borrar.php"></a>
    <a href="/main_page.php"></a>
</body>
</html>