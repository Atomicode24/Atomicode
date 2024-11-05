<?php
session_start();
require '../../model/conexion.php';
require '../../config/config.php';
require '../../model/clases/clienteFunciones.php';

try {
    $db = new Database();
    $con = $db->conectar();
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verificar si se envió el formulario
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Verificar si los campos están vacíos
    if (esNulo([$usuario, $password])) {
        $errors[] = "Debe llenar todos los campos";
    }

    // Si no hay errores, proceder a la autenticación
    if (count($errors) === 0) {
        // Llama a la función login para verificar usuario y contraseña
        $resultado = login($usuario, $password, $con);

        if ($resultado !== true) { // Si el resultado no es true, hay un error
            $errors[] = $resultado; // Agregar el mensaje de error devuelto por login
        } else {
            // Si el inicio de sesión es exitoso, redirige al usuario
            header("Location: index.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Buy - Inicio Sesión</title>
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">
    <link rel="stylesheet" href="../../assets/CSS/styleformulariologin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="../../controllers/JS/contraseña.js" defer></script>
</head>
<body>
    <!-- CONTENEDOR / INICIO SESION -->
<div id="abrir__autenticacion" class="contenedor__autenticacion">
            <div class="autenticacion__titulo">
                <span class="autenticacion__texto">Inicio Sesión</span>
            
                <a class="autenticacion__salir-enlace" href="../HTML/index.php"><span class="autenticacion__salir"><i class='bx bx-left-arrow-alt' ></i></span> </a><!-- Este es el botón para cerrar -->
            </div>
            <form method="POST" action="loginpagina.php" class="contenedor-autenticacion__input" id="miformulario" autocomplete="off">
                
            <?php mostrarMensajes($errors)?>

    <div class="autenticacion__inputs">
        <input type="text" placeholder="Nombre Usuario" name="usuario" id="usuario">
    </div>
    <div class="autenticacion__inputs password__contenedor">
        <input id="input"  id="password" class="campo__contraseña"  type="password" name="password" placeholder="Contraseña">
        <span id="togglePassword" class="eye-icon">
            <i class="fa-regular fa-eye"></i>
        </span>
        
    </div>
    <div>
    <span class="autenticacion__problema-contraseña"><a href="../HTML/recuperar.php">¿Olvidaste tu contraseña?</a></span>
    </div>
    <div class="autenticacion__inputs">
        <input name="btningresar" class="btn" type="submit" value="INICIAR SESION">
    </div>
    <?php
       // Asegúrate de que la ruta es correcta
    ?>
</form>

            <span class="autenticacion__problema"><a href="../HTML/register.php">¿No tienes cuenta? Regístrate ahora</a></span>
            <section class="autenticacion__continuar">
                <p class="autenticacion_linea"><label for="">Continuar con</label></p>
                <div class="continuar__iconos">
                    <div class="icono__go">
                        <a class="icono__enlace" href=""><img src="../../assets/IMG/google.png" alt=""></a>
                    </div>
                    <div class="icono__fa">
                        <a class="icono__enlace" href=""><img src="../../assets/IMG/facebook.png" alt=""></a>
                    </div>
                </div>
            </section>
            <div class="autenticacion__privacidad">
                <span>Al continuar, confirmas que eres mayor de edad y que has leído y aceptado nuestros <a href="#">Términos de Uso y Políticas de Privacidad de Fast Buy</a>.</span>
            </div>
        </div>

        
</body>
</html>
        
