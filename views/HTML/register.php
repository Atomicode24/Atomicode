<?php
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

if (!empty($_POST)) {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    // Validaciones
    if (esNulo([$nombres, $apellidos, $email, $telefono, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La dirección de correo electrónico no es válida";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $con)) {
        $errors[] = "El nombre de usuario <strong>$usuario</strong> ya existe";
    }

    if (emailExiste($email, $con)) {
        $errors[] = "El correo electrónico <strong>$email</strong> ya existe";
    }

    // Si no hay errores, procedemos con el registro
    if (count($errors) == 0) {
        // Registrar cliente
        $idCliente = registraCliente([$nombres, $apellidos, $email, $telefono], $con);

        if ($idCliente > 0) {
            // Registrar usuario
            require '../../model/clases/Mailer.php';
            $mailer = new Mailer();
            $token = generarToken();

            // Encriptar contraseña
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            // Registrar usuario en la base de datos
            $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $idCliente], $con);

            if ($idUsuario > 0) {
                // Generar URL para la activación
                $url = SITE_URL . '/activa_cliente.php?id=' . $idUsuario . '&token=' . $token;
                error_log("URL de activación generada: " . $url);


$asunto = "Activar cuenta - Fast Buy";
$cuerpo = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://kit.fontawesome.com/610fbd17c7.js' crossorigin='anonymous'></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: Poppins;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
        }

        h3 {
        font-size: 3.5em;
        }

        .content {
            padding: 10px;
            text-align: center;
        }
        .content h1 {
            color: #222831;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 15px 50px;
            margin: 20px 0;
            font-size: 16px;
            background-color: #222831;
            border-radius: 25px;
            text-decoration: none;
            color: #76ABAE;
        }
        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
            padding-top: 20px;
        }
        
        .logo__texto {
        font-weight: 400;
        color: #222831;
        }

        .texto__bold {
        font-weight: 700;
        color: #76ABAE;
        }
        .enlace {
        color: #76ABAE;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h3 class='logo__texto'>
                Fast <span class='texto__bold'>Buy</span>
            </h3>
        </div>
        <div class='content'>
            <h1>Confirmación de registro</h1>
            <p>Estimado $usuario:</p>
            <p>Gracias por registrarte en nuestra tienda. Para continuar con el proceso de registro, haz clic en el siguiente enlace para activar tu cuenta.</p>
            <a href='$url' class='btn enlace' style='color: #fff; font-weight: 600;'>Activar Cuenta</a>
        </div>
        <div class='footer'>
            <p>Si tienes algún problema, por favor contacta con nuestro equipo de soporte.</p>
        </div>
    </div>
</body>
</html>";


                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
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
                            echo '        <span class="autenticacion__texto">Activacion de Cuenta</span>';
 
                            echo '    </div>';
                            echo '    <div class="autenticacion__privacidad2">';
                            echo '      <p class="p">Para finalizar tu registro, hemos enviado un mensaje de activación a  <span>' . $email . '</span> Por favor, revisa tu bandeja de entrada y sigue las instrucciones del correo para activar tu cuenta.</p>';
                            echo '    </div>';

                            echo '<span class="autenticacion__problema"><a href="#"  name="btningresar" class="btn" type="submit">¿ No recibió ningun mensaje? Enviar otra vez</a></span>';


                            echo '</div>';
                    exit;
                } else {
                    $errors[] = "Error al enviar el correo electrónico.";
                }
            } else {
                $errors[] = "Error al registrar usuario.";
            }
        } else {
            $errors[] = "Error al registrar cliente.";
        }
    }
}



?>            

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Buy - Registro</title>
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">
    <link rel="stylesheet" href="../../assets/CSS/styleformulario.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <!-- CONTENEDOR / REGÍSTRATE -->
    <div id="abrir__autenticacion-registro" class="contenedor__autenticacion">
        <div class="autenticacion__titulo">
            <span class="autenticacion__texto">Regístrate</span>
            <a class="autenticacion__salir-enlace" href="../HTML/index.php">
                <span class="autenticacion__salir"><i class='bx bx-left-arrow-alt'></i></span>
            </a> <!-- Este es el botón para cerrar -->
        </div>
        <form class="contenedor-autenticacion__input" action="register.php" method="POST">
        <?php mostrarMensajes($errors)?>
            <div class="autenticacion__inputs inputs--modify">
                <input type="text" name="nombres" id="nombres" placeholder="Nombre" >
                <input type="text" name="apellidos" id="apellidos" placeholder="Apellido">
            </div>
            <div class="autenticacion__inputs">
                <input type="text" name="usuario" placeholder="Nombre Usuario" id="usuario"/>
            </div>
            <span id="validaUsuario" class="texto__validacion-usuario"></span>    
            <!--  CORREO  -->
            <div class="autenticacion__inputs">
                <input type="email" name="email" id="email" placeholder="Correo Electrónico" >
            </div>
            <span id="validaEmail" class="texto__validacion-usuario"></span> 
            <div class="autenticacion__inputs">
                <input type="tel" name="telefono" id="telefono" placeholder="Número de Teléfono" >
            </div>
            <!--PASSWORD-->
            <div class="autenticacion__inputs" style="margin: 0;">
                <div class="autenticacion__inputs password__contenedor">
                    <input class="campo__contraseña" id="password" type="password" name="password" placeholder="Contraseña" >
                    <span id="togglePassword" class="eye-icon">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
                <div class="autenticacion__inputs password__contenedor">
                    <input class="campo__contraseña2" id="repassword" type="password" name="repassword" placeholder="Repetir Contraseña" > 
                    <span id="togglePassword2" class="eye-icon">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>
            <div class="autenticacion__inputs">
                <input type="submit" name="registro" value="Registrar">
            </div>
        </form>
        <span class="autenticacion__problema"><a href="../HTML/loginpagina.php">¿Ya tienes una cuenta? Inicia sesión aquí</a></span>
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
    <script src="../../controllers/JS/contraseña.js" defer></script>
    <script src="../../controllers/JS/clienteregister.js"></script>
</body>
</html>
