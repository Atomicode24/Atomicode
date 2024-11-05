<?php
session_start();
require '../../model/conexion.php';
require '../../config/config.php';
require '../../model/clases/clienteFunciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($user_id == '' || $token == '') {
    header("Location: index.php");
    exit;
}

try {
    $db = new Database();
    $con = $db->conectar();
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$errors = [];

if (!verificaTokenRequest($user_id, $token, $con)) {
    echo "No se pudo verificar la información";
    exit;
}

if (!empty($_POST)) {
    $password = trim($_POST['password'] ?? '');
    $repassword = trim($_POST['repassword'] ?? '');

    // Validaciones
    if (esNulo([$user_id, $token, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (empty($errors)) {
        // Hashea la nueva contraseña
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Llama a la función para actualizar la contraseña
        if (actualizaPassword($user_id, $password, $con)) {
            echo '<!DOCTYPE html>';
                            echo '<html lang="en">';
                            echo '<head>';
                            echo '    <meta charset="UTF-8">';
                            echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
                            echo '    <title>Fast Buy - Restablecer Contraseña</title>';
                            echo '    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>';
                            echo '    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">';
                            echo '    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">';
                            echo '    <link rel="stylesheet" href="../../assets/CSS/styleformulario.css">';
                            echo '    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">';
                            echo '</head>';
                                            
                           
                            echo '<div id="abrir__autenticacion-registro" class="contenedor__autenticacion contenedor__autenticacion2" >';
                            echo '    <div class="autenticacion__titulo">';
                            echo '        <span class="autenticacion__texto">Contraseña Modificada</span>';
 
                            echo '    </div>';
                            echo '    <div class="autenticacion__privacidad2">';
                            echo '      <p class="p">La contraseña se modificó exitosamente. Vuelve a iniciar sesión <a href="loginpagina.html">aquí</a>.</p>';
                            echo '    </div>';



                            echo '</div>';
            exit; // Termina el script aquí para no procesar más abajo.
        } else {
            $errors[] = "Error al modificar contraseña. Inténtalo nuevamente";
        }
    }
    
}




// Mostrar errores si existen
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Buy - Restablecer Contraseña</title>
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">
    <link rel="stylesheet" href="../../assets/CSS/styleformulariologin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="../../controllers/JS/contraseña.js" defer></script>
</head>
<body>
<div id="abrir__autenticacion" class="contenedor__autenticacion">
    <div class="autenticacion__titulo">
        <span class="autenticacion__texto">Restablecer Contraseña</span>
        <a class="autenticacion__salir-enlace" href="../HTML/index.php">
            <span class="autenticacion__salir"><i class='bx bx-left-arrow-alt'></i></span>
        </a>
    </div>
    <form method="POST" action="restablecer_password.php" class="contenedor-autenticacion__input" id="miformulario" autocomplete="off">
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">

        <?php mostrarMensajes($errors) ?>
        <div class="autenticacion__inputs password__contenedor">
            <input class="campo__contraseña" id="password" type="password" name="password" placeholder="Nueva Contraseña" >
            <span id="togglePassword" class="eye-icon">
                <i class="fa-regular fa-eye"></i>
            </span>
        </div>
        <div class="autenticacion__inputs password__contenedor">
            <input class="campo__contraseña2" id="repassword" type="password" name="repassword" placeholder="Confirmar Contraseña" > 
            <span id="togglePassword2" class="eye-icon">
                <i class="fa-regular fa-eye"></i>
            </span>
        </div>
        <div class="autenticacion__inputs">
            <input name="btningresar" class="btn" type="submit" value="RESTABLECER">
        </div>
    </form>
</div>
</body>
</html>
