<?php
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/php/logs/php_error.log');
error_reporting(E_ALL);

// Iniciar el buffer de salida y la sesión
session_start();

trigger_error("Mensaje de error", E_USER_NOTICE); // E_USER_NOTICE, E_USER_WARNING, E_USER_ERROR

include('../config/Database.php');

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Obtener los datos del formulario
$eMail = $_POST['eMail'];
$Contraseña = $_POST['Contraseña'];


// Inicializar variables
$rol = null;

// Verificar si el usuario está en la tabla `admins`
$sql = "SELECT eMail, Contraseña FROM admins WHERE eMail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $eMail);
$stmt->execute();
$result = $stmt->get_result();

// Si el usuario es admin
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    
    if (password_verify($Contraseña, $usuario['Contraseña'])) {
        $_SESSION['user_role'] = 'admin'; // Asignar el rol de administrador
        error_log("Usuario admin, redirigiendo al backoffice...");
        header("Location: ../../backoffice/html/Index.html");
        exit();
    } else {
        error_log("Contraseña incorrecta para admin.");
        header("Location: ../../views/HTML/login_login.php?error=1");
        exit();
    }
} else {
    // Si no es admin, buscar en la tabla `usuarios`
    $sql = "SELECT eMail, Contraseña, rol FROM usuarios WHERE eMail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eMail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($Contraseña, $usuario['Contraseña'])) {
            $_SESSION['user_role'] = $usuario['rol']; // Asignar el rol del usuario

            // Verificar el rol y redirigir
            if ($_SESSION['user_role'] == 'admin') {
                error_log("Usuario admin, redirigiendo al backoffice...");
                header("Location: ../../backoffice/html/Index.html");
                exit();
            } else {
                error_log("Usuario común, redirigiendo al index...");
                header("Location: ../../views/HTML/index.php");
                exit();
            }
        } else {
            error_log("Contraseña incorrecta para usuario.");
            header("Location: ../../views/HTML/login_login.php?error=1");
            exit();
        }
    } else {
        error_log("Usuario no encontrado.");
        header("Location: ../../views/HTML/login_login.php?error=1");
        exit();
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
