<?php
function connectDB(){
    $dsn = 'mysql:host=localhost;dbname=irondb';
    $usuario = 'iron_user';
    $contrasena = '1357'; 
    
    try {
        $db = new PDO($dsn, $usuario, $contrasena);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        error_log("Error al conectar a la base de datos: " . $e->getMessage(), 0);
        echo "Ha ocurrido un error. Por favor, inténtalo de nuevo más tarde.".$e->getMessage();
        exit;
    }
}
?>