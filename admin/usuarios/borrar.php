<?php
    require './../../includes/app.php';
session_start();
    

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las credenciales del formulario
    $username = $_SESSION["user_id"];
    $password = $_POST["password"];

    // Validar las credenciales utilizando PDO
    try {
        $db = connectDB();

        // Consulta preparada para obtener la contraseña almacenada del usuario
        $stmt = $db->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->bindParam(':id', $username);
        $stmt->execute();
        $hashedPassword = $stmt->fetchColumn();

        // Verificar la contraseña
        if ($hashedPassword && password_verify($password, $hashedPassword)) {
            // Usuario y contraseña son válidos, proceder con el borrado

            try {
                $db = connectDB();

                // Iniciar una transacción para garantizar la consistencia de ambas operaciones
                $db->beginTransaction();

                // Consulta preparada para eliminar al usuario de la tabla "users"
                $deleteUserStmt = $db->prepare("DELETE FROM users WHERE id = :id");
                $deleteUserStmt->bindParam(':id', $username);
                
                // Ejecutar la consulta para borrar al usuario
                if ($deleteUserStmt->execute()) {
                    // Consulta preparada para eliminar la línea correspondiente en la tabla "stadistics"
                    $deleteStadisticsStmt = $db->prepare("DELETE FROM stadistics WHERE userid = :id");
                    $deleteStadisticsStmt->bindParam(':id', $username);

                    // Ejecutar la consulta para borrar la línea en la tabla "stadistics"
                    $deleteStadisticsStmt->execute();

                    // Confirmar la transacción
                    $db->commit();

                    echo "Usuario y estadísticas eliminadas correctamente.";

                    // Espera 3 segundos antes de redirigir
                    echo '<script>
                            setTimeout(function(){
                                window.location.href = "/index.php";
                            }, 3000);
                        </script>';
                    
                    // Limpiar la sesión
                    $_SESSION = [];
                    exit(); // Asegura que el script se detenga después de la redirección
                } else {
                    // Si la eliminación del usuario falla, realizar un rollback para deshacer la transacción
                    $db->rollBack();
                    echo "Error al intentar eliminar al usuario.";
                }
            } catch (PDOException $e) {
                // Si hay algún error, realizar un rollback para deshacer la transacción
                $db->rollBack();
                echo "Error de base de datos: " . $e->getMessage();
            } finally {
                // Cerrar la conexión a la base de datos
                $db = null;
            }
        } else {
            // Usuario o contraseña no válidos
            echo "Error: User not found.";
        }
    }catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $db = null;
    }
}
?>