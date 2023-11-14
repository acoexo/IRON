<?php
require "./includes/app.php";
// Inicia o reanuda la sesión
session_start();
if (isset($_SESSION['user_name'])) {
    header('Location: main_page.php');
    exit;
}else{
   // Establece una conexión a la base de datos
    $db = connectDB();

    // Inicializa la variable de errores
    $errores = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                // Consulta para buscar al usuario por nombre de usuario
                $query = "SELECT id, username, password FROM users WHERE username = :username";
                $statement = $db->prepare($query);
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->execute();

                if ($statement->rowCount() > 0) {
                    // Se encontró un usuario con el nombre de usuario proporcionado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    $storedPassword = $row['password'];

                    // Verifica si la contraseña coincide con la contraseña almacenada
                    if (password_verify($password, $storedPassword)) {
                        // Inicia una sesión para el usuario y almacena información en las variables de sesión
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['user_name'] = $row['username'];
                        
                        // Redirige al usuario a la página principal
                        header('Location: main_page.php');
                        exit;
                    } else {
                        $errores = "Contraseña incorrecta. Inténtalo de nuevo.";
                    }
                } else {
                    $errores = "Usuario no encontrado. Verifica tus credenciales.";
                }
            } catch (PDOException $e) {
                $errores = "Error de conexión a la base de datos: " . $e->getMessage();
            }
        }
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="./src/SVG/mancuerna_roja.svg" >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRON LOGIN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/logincss.css">
</head>
<body>
    <main>
        <div class="mainform">
           <img src="./src/img/Icon.png" alt="IRONICON">
            <form id="login" class="login" method="POST" action="login.php">
                <input type="text" class="username" name="username" id="username" placeholder="Nombre" class="login--name">
                <div class="password--div">
                    <input class="password" type="password" name="password" id="password" placeholder="Contraseña"> 
                    <div class="toggle-password-button" onclick="togglePasswordVisibility()">
                    <img src="./src/img/ojo.png" alt="Mostrar/Ocultar contraseña">
                </div>
                </div>
                <div class="nav--buttons">
                    <input type="submit" class="submit--button">
                    <a href="signup.php" class="signup--button">SIGNUP</a>
                </div>
                
            </form>
        </div>
        <div class="errores">
            <?php
                if (!empty($errores)) {
                    echo '<ul style="color: #fff;">';
                    echo '<li>' . $errores . '</li>';
                    echo '</ul>';
                }
            ?>
        </div>
    </main>
    <script src="src/JS/js.js"></script>
</body>
</html>