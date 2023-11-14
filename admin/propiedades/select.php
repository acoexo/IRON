<?php
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    $db=conectarDB();

    if ($_SERVER['REQUEST_METHOD']==="GET"){
        $nombre=$_GET['nombre'];
        $contraseña=$_GET['password'];
        $query="SELECT nombre, password FROM iron.usuarios where nombre=\"{$nombre}\"";
        $resultado=mysqli_query($db,$query);
        
    }
?>