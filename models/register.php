<?php
// Iniciar la sesión
session_start();

// Incluir la clase Database
include('../config/database.php');

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Obtener los datos del formulario
$Nombre = $_POST['nombre'];
$Apellido = $_POST['apellido'];
$eMail = $_POST['eMail'];
$Contraseña = $_POST['contraseña'];

// Verificar que los campos no estén vacíos
if (empty($Nombre) || empty($Apellido) || empty($eMail) || empty($Contraseña)) {
    die("Por favor, complete todos los campos.");
}

// Verificar si el email ya existe en la base de datos
$sql = "SELECT eMail FROM usuarios WHERE eMail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $eMail);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Este correo electrónico ya está registrado.");
}

// Hashear la contraseña antes de almacenarla
$contraseña_hashed = password_hash($Contraseña, PASSWORD_DEFAULT);

// Insertar los datos en la base de datos
$sql = "INSERT INTO usuarios (Nombre, Apellido, eMail, Contraseña, rol) VALUES (?, ?, ?, ?, 'usuario')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $Nombre, $Apellido, $eMail, $contraseña_hashed);

if ($stmt->execute()) {
    // Registro exitoso, redirigir al login
    header("Location: ../../views/HTML/login_login.php?success=1");
    exit();
} else {
    // Error al registrar
    die("Error al registrar el usuario: " . $stmt->error);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
