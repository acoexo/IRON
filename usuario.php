<?php
require './includes/app.php';

// Inicializa el mensaje
$mensaje = '';

try {
    $db = connectDB();
    $nombre = 'Juan';
    $usuario = 'juanito10';
    $fnac = '2004-10-12';
    $sexo = 'H';
    $dni = '98784561H';
    $telefono = '693852741';
    $email = 'correos@correo.com';
    $password = '123456';
    $altura = '197';
    $peso = '93';
    $edad = '18';
    $AF = '1';
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, date, gen, tfn, username, email, password) VALUES (:nombre, :fnac, :sexo, :telefono, :usuario, :email, :password)";
    $statement = $db->prepare($query);
    $statement->bindParam(':nombre', $nombre);
    $statement->bindParam(':fnac', $fnac);
    $statement->bindParam(':sexo', $sexo);
    $statement->bindParam(':telefono', $telefono);
    $statement->bindParam(':usuario', $usuario);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $passwordHash);
    $statement->execute();

    $query2 = "INSERT INTO stadistics (userid, age, weight, height, activity_factor) VALUES (1, :edad, :peso, :altura, :AF)";

    $statement2 = $db->prepare($query2);
    $statement2->bindParam(':edad', $edad);
    $statement2->bindParam(':peso', $peso);
    $statement2->bindParam(':altura', $altura);
    $statement2->bindParam(':AF', $AF);
    $statement2->execute();

    // Establece el mensaje de éxito
    $mensaje = 'Inserciones exitosas';
} catch (PDOException $e) {
    // Establece el mensaje de error en caso de problemas
    $mensaje = "Error al insertar datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" href="./SVG/mancuerna_roja.svg" >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    <div>
        <p><?php echo $mensaje; ?></p>
    </div>
    <a href="index.php">Volver a la página de inicio</a>
</body>
</html>