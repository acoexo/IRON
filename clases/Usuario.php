<?php
namespace App;
use PDO;
use PDOException;

class Usuario{
    public static $db;
    private $userID;

    public function __construct()
    {
        
    }
    public static function setDB($database){
        self::$db = $database;
    }

    public function iniciarSesion($username, $password)
    {
        session_start();

        if (isset($_SESSION['user_name'])) {
            header('Location: main_page.php');
            exit;
        }

        $errores = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($username) && isset($password)) {
                try {
                    $query = "SELECT id, username, password FROM users WHERE username = :username";
                    $statement = self::$db->prepare($query);
                    $statement->bindParam(':username', $username, PDO::PARAM_STR);
                    $statement->execute();

                    if ($statement->rowCount() > 0) {
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                        $storedPassword = $row['password'];

                        if (password_verify($password, $storedPassword)) {
                            $_SESSION['user_id'] = $row['id'];
                            $_SESSION['user_name'] = $row['username'];
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
        if (!empty($errores)) {
            echo '<div style="color: red;">' . $errores . '</div>';
        }
    }
}
