<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/sylelogin.css">
    <link rel="stylesheet" href="../../assets/CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <script defer src="../../controllers/JS/carritocompras.js"></script>
    <script src="../../controllers/JS/jquery-3.7.1.js"></script>
    <title>Fast Buy</title>
</head>
<body>
    <section class="contenedor__login">
        <div class="login">
            <a href="../../views/HTML/index.php"> <span class="icono__atras"><i class="fa-solid fa-arrow-left"></i></span></a>
            <span class="logo__texto"><i class="fa-sharp fa-solid fa-cart-shopping"></i> Fast <b>Buy</b></span>
            <form class="contenedor__input" action="../../models/login.php" method="POST">
                <input id="correo" type="email" name="eMail" placeholder="ejemplo@ejemplo.com" required>
                
                <div style="position: relative;">
                    <input type="password" id="contrasenia" name="Contraseña" placeholder="Ingrese contraseña" required>
                    <i id="togglePassword" class="fa fa-eye" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></i>
                </div>

                <div class="contenedor__boton">
                    <a id="boton__iniciosesion" href="login_login.php">Inicio Sesion</a>
                    <a id="boton__registro" href="register_login.php">Regístrate</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#contrasenia');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute between password and text
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the icon between eye and eye-slash
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
