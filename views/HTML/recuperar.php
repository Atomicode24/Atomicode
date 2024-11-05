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
    $email = trim($_POST['email']);

    // Validaciones
    if (esNulo([$email])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La dirección de correo electrónico no es válida";
    }

    if (count($errors) == 0) {
        if (emailExiste($email, $con)) {
            $sql = $con -> prepare("SELECT usuarios.Id_Usuarios, clientes.nombres FROM usuarios INNER JOIN clientes ON usuarios.id__cliente = clientes.id WHERE clientes.email LIKE ? LIMIT 1");
            $sql -> execute([$email]);
            $row = $sql -> fetch(PDO::FETCH_ASSOC);
            $user_id = $row['Id_Usuarios'];
            $user_nombre = $row['nombres'];

            $token = solicitaPassword($user_id, $con);

            if ($token !== null) {
                require '../../model/clases/Mailer.php';
                $mailer = new Mailer();
                $url = SITE_URL . '/views/HTML/restablecer_password.php?id=' . $user_id . '&token=' . $token;

                $asunto = "Restablecer Contraseña - Tienda online FastBuy";
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
        <h1>Restablecimiento de Contraseña</h1>
        <p>Estimado $user_nombre:</p>
        <p>Hemos recibido una solicitud para restablecer tu contraseña. <strong>Si no has realizado esta solicitud, puedes ignorar este correo</strong>. De lo contrario, haz clic en el siguiente enlace para continuar con el proceso:</p>
        <a href='$url' class='btn enlace' style='color: #fff; font-weight: 600;'>Restablecer Contraseña</a>
    </div>
    <div class='footer'>
        <p>Si tienes algún problema o no solicitaste este cambio, por favor contacta con nuestro equipo de soporte.</p>
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
                            echo '        <span class="autenticacion__texto">Compruebe su direccion de correo electronico</span>';
 
                            echo '    </div>';
                            echo '    <div class="autenticacion__privacidad2">';
                            echo '      <p class="p">Para restablecer tu contraseña, hemos enviado un mensaje de instrucciones a <span>' . $email . '</span>. Por favor, revisa tu bandeja de entrada y sigue las instrucciones del correo para restablecer tu contraseña.</p>';
                            echo '    </div>';

                            echo '<span class="autenticacion__problema"><a href="#"  name="btningresar" class="btn" type="submit">¿ No recibió ningun mensaje? Enviar otra vez</a></span>';


                            echo '</div>';
 
                                                
                                                exit;
                                            }
                                            
                                        }
                                        
                                    }else {
                                        $errors[] = "No existe una cuenta asociada a esta direccion de correo electronico";
                                    }
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
    <link rel="stylesheet" href="../../assets/CSS/styleformulario.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <!-- CONTENEDOR / REGÍSTRATE -->
    <div id="abrir__autenticacion-registro" class="contenedor__autenticacion">
        <div class="autenticacion__titulo">
            <span class="autenticacion__texto">Restablecer Contraseña</span>
            <a class="autenticacion__salir-enlace" href="../HTML/index.php">
                <span class="autenticacion__salir"><i class='bx bx-left-arrow-alt'></i></span>
            </a> <!-- Este es el botón para cerrar -->
        </div>
        <form class="contenedor-autenticacion__input" action="recuperar.php" autocomplete="off" method="POST">
        <?php mostrarMensajes($errors)?>
            <!--  CORREO  -->
            <div class="autenticacion__inputs">
                <input type="email" name="email" id="email" placeholder="Correo Electrónico" >
            </div>
            <div class="autenticacion__inputs">
        <input name="btningresar" class="btn" type="submit" value="REESTABLECER CONTRASEÑA">
    </div>
        </form>
        <span class="autenticacion__problema"><a href="../HTML/register.php">¿No tiene cuenta? Regístrate ahora</a></span>
        <div class="autenticacion__privacidad">
            <span>Al continuar, confirmas que eres mayor de edad y que has leído y aceptado nuestros <a href="#">Términos de Uso y Políticas de Privacidad de Fast Buy</a>.</span>
        </div>
    </div>

</body>
</html>
