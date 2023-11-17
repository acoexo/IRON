<?php
    // Incluye el archivo de configuración de la base de datos
    require './../../includes/app.php';
    session_start();
    // Inicializa la matriz de errores
    $errores = [];

    // Comprueba si se ha enviado una solicitud POST (cuando se envía el formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Define un arreglo con los campos requeridos del formulario
        $required_fields = ['height', 'weight', 'actividadFisica'];

        // Variable para controlar si faltan campos requeridos
        $fields_missing = false;

        // Recorre los campos requeridos y verifica que no estén vacíos
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $fields_missing = true;
                $errores[] = "El campo $field es obligatorio.";
            }
        }
        // Verifica si los campos "actividad física" no es 0
        if ($_POST['actividadFisica'] === '0') {
            $errores[] = "Por favor, seleccione una actividad física válida.";
        }
        if (!$fields_missing) {
            // Conecta a la base de datos
            $db = connectDB();

            // Obtiene los valores de los campos del formulario
            $altura = $_POST['height'];
            $peso = $_POST['weight'];
            $actividadFisica = $_POST['actividadFisica'];

            $userId = $_SESSION['user_id'];

            // Actualiza las estadísticas del usuario en la base de datos
            $query = "UPDATE stadistics SET weight=:peso, height=:altura, activity_factor=:actividadFisica WHERE userid=:userId";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':peso', $peso);
            $stmt->bindParam(':altura', $altura);
            $stmt->bindParam(':actividadFisica', $actividadFisica);
            $resultado = $stmt->execute();

            // Si se actualizaron las estadísticas con éxito, redirige al usuario a la página principal
            if ($resultado) {
                header('Location: /main_page.php?id=' . $userId);
                exit;
            } else {
                $errores[] = "Error al actualizar estadísticas del usuario.";
            }
        }
    }else {
        // Si no es una solicitud POST, obtén los datos actuales del usuario
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Conecta a la base de datos
            $db = connectDB();

            // Consulta para obtener los datos actuales del usuario
            $query = "SELECT weight, height, activity_factor FROM stadistics WHERE userid = :userId";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $userStats = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si no hay sesión válida, redirige al usuario al inicio de sesión
            header('Location: /login.php');
            exit;
        }
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
    <link rel="stylesheet" href="./../../src/css/normalize.css">
    <link rel="stylesheet" href="./../../src/css/signupcss.css">
</head>
<body>
    <section class="signup_container">
        <img src="./../../src/img/iron_stats.png" alt="IronStatsPNG" width="252" height="94">
        <form class="signup_boxes" method="POST" action="">
            <label for="">Los campos en blanco no se actualizarán</label>
            <input class="box" type="number" name="height" placeholder="Altura (cm)" id="height" value="<?php echo isset($userStats['height']) ? $userStats['height'] : ''; ?>">
            <input class="box" type="number" name="weight" placeholder="Peso (kg)" id="weight" value="<?php echo isset($userStats['weight']) ? $userStats['weight'] : ''; ?>">
            <select class="select--ph" name="actividadFisica" id="actividadFisica">
                <option value="0">ACTIVITY FACTOR</option>
                <option value="1">LITTLE OR NONE</option>
                <option value="2">LIGHT (1-3 DAYS/WEEK)</option>
                <option value="3">MODERATE (3-5 DAYS/WEEK)</option>
                <option value="4">HEAVY (6-7 DAYS/WEEK)</option>
                <option value="5">VERY HEAVY (2 SESSIONS/DAY)</option>
            </select>
            <input type="submit" name="signup" class="submit--button" value="UPDATE">
            <a href="/main_page.php" class="exit--button">Salir</a>
            <a href="/admin/alertdelete.php" class="exit--button">Borrar datos</a>
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