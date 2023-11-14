<?php
// Incluye el archivo de configuración de la base de datos
require './includes/app.php';

// Inicializa la matriz de errores
$errores = [];


// Comprueba si se ha enviado una solicitud POST (cuando se envía el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define un arreglo con los campos requeridos del formulario
    $required_fields = ['nombre', 'fNac', 'num', 'username', 'email', 'pwd', 'heigth', 'weigth', 'actividadFisica', 'sexo'];

    // Variable para controlar si faltan campos requeridos
    $fields_missing = false;

    // Recorre los campos requeridos y verifica que no estén vacíos
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $fields_missing = true;
            $errores[] = "El campo $field es obligatorio.";
        }
    }

    // Verifica si los campos "actividad física" y "sexo" no son 0
    if ($_POST['actividadFisica'] === '0') {
        $fields_missing = true;
        $errores[] = "Por favor, seleccione una actividad física válida.";
    }
    if ($_POST['sexo'] === '0') {
        $fields_missing = true;
        $errores[] = "Por favor, seleccione un sexo válido.";
    }

    // Si no faltan campos requeridos
    if (!$fields_missing) {
        // Conecta a la base de datos
        $db = connectDB();

        // Obtiene los valores de los campos del formulario
        $nombre = $_POST['nombre'];
        $fNac = $_POST['fNac'];
        $num = $_POST['num'];
        $sexo = $_POST['sexo'];
        $usuario = $_POST['username'];
        $email = $_POST['email'];
        $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $altura = $_POST['heigth'];
        $peso = $_POST['weigth'];
        $actividadFisica = $_POST['actividadFisica'];

        // Consulta para verificar si el correo electrónico o el nombre de usuario ya existen en la base de datos
        $query = "SELECT email, username FROM users WHERE email = :email OR username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $usuario);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        // Si ya existe un usuario con el mismo correo electrónico o nombre de usuario
        if ($existingUser) {
            $errores[] = "El correo electrónico o el nombre de usuario ya existen en la base de datos. Por favor, elija otros.";
        } else {
            // Inserta el nuevo usuario en la base de datos
            $query = "INSERT INTO users (name, date, gen, tfn, username, email, password) VALUES (:nombre, :fNac, :sexo, :num, :usuario, :email, :pwd)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fNac', $fNac);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':num', $num);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':pwd', $pwd);
            $resultado = $stmt->execute();

            // Si se insertó el usuario con éxito
            if ($resultado) {
                $userId = $db->lastInsertId();
                $age = calcularEdad($fNac);

                // Inserta las estadísticas del usuario en la base de datos
                $query = "INSERT INTO stadistics (userid, age, weigth, heigth, activity_factor) VALUES (:userId, :age, :peso, :altura, :actividadFisica)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':age', $age);
                $stmt->bindParam(':peso', $peso);
                $stmt->bindParam(':altura', $altura);
                $stmt->bindParam(':actividadFisica', $actividadFisica);
                $resultado = $stmt->execute();

                // Si se insertaron las estadísticas con éxito, redirige al usuario a la página principal
                if ($resultado) {
                    header('Location: main_page.php?id=' . $userId);
                    exit;
                } else {
                    $errores[] = "Error al registrar estadísticas del usuario.";
                }
            } else {
                $errores[] = "Error al registrar el usuario.";
            }
        }
    }
}

// Función para calcular la edad a partir de la fecha de nacimiento
function calcularEdad($fechaNacimiento)
{
    $hoy = new DateTime();
    $fechaNac = new DateTime($fechaNacimiento);
    $edad = $hoy->diff($fechaNac);
    return $edad->y;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="/src/SVG/mancuerna_roja.svg" >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRON SIGNUP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/signupcss.css">
</head>
<body>
    <section class="signup_container">
        <img src="./src/img/iron_stats.png" alt="IronStatsPNG" width="252" height="94">
        <form class="signup_boxes" method="POST" action="">
            <input class="box" type="text" name="nombre" placeholder="Name" id="nombre">
            <input class="box" type="date" name="fNac" placeholder="Birth Date" id="fNac">
            <input class="box" type="number" name="num" placeholder="Phone Number" pattern="[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}" id="num">
            <select class="select--ph" name="sexo" id="sexo">
                <option value="0">Sexo</option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
            </select>
            <input class="box" type="text" name="username" placeholder="Username" id="username">
            <input class="box" type="email" name="email" placeholder="Correo Electronico" id="email">
            <input class="box" type="password" name="pwd" placeholder="Contraseña" id="pwd">
            <input class="box" type="number" name="heigth" placeholder="Altura (cm)" id="heigth">
            <input class="box" type="number" name="weigth" placeholder="Peso (kg)" id="weigth">
            <select class="select--ph" name="actividadFisica" id="actividadFisica">
                <option value="0">Actividad Física</option>
                <option value="1">Poco o Ninguno</option>
                <option value="2">Ligero (1-3 días/semana)</option>
                <option value="3">Moderado (3-5 días/semana)</option>
                <option value="4">Fuerte (6-7 días/semana)</option>
                <option value="5">Muy Fuerte (2 sesiones/día)</option>
            </select>
            <input type="submit" name="signup" class="submit--button" value="SIGNUP">
            <a href="index.php" class="exit--button">Salir</a>
        </form>
    </section>
    <section class="errores">
    <?php 
        if(!empty($errores)){
            echo '<ul>';
            foreach($errores as $error){
                echo "<li>".($error)."</li>";
            }
            echo '</ul>';
        }
    ?>
</section>
</body>
</html>