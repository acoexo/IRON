<?php
    require 'funciones.php';
    require 'config/database.php';
    require __DIR__ . '/../vendor/autoload.php';
    use App\Usuario;
    $usuario= new Usuario();
    $db=connectDB();
    Usuario::setDB($db);
    