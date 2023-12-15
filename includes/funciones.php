<?php
    define('TEMPLATES_URL',__DIR__.'\\templates');
    define('FUNCIONES_URL', __DIR__.'funciones.php');
    function incluirTemplate($nombre, $inicio=false){
            include TEMPLATES_URL."\\${nombre}.php";
    }
    function estaAutenticado()  {
            session_start();
            if(!$_SESSION['login']) {
                header ('Location: /');
                return false;
            }    
            return true;
        }
    function debuguear($variable){
    
        }
        function s($html):string{
        $s=htmlspecialchars($html);
        return $s;
    }
?>