<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/sylelogin.css">
    <link rel="stylesheet" href="../../assets/CSS/style.css">
    <title>Fast Buy - Registro</title>
</head>
<body>
    <section class="contenedor__login">
        <div class="login">
            <a href="../../models/register.php"><span class="icono__atras"><i class="fa-solid fa-arrow-left"></i></span></a>
            <span class="logo__texto"><i class="fa-sharp fa-solid fa-cart-shopping"></i> Fast <b>Buy</b></span>
            <form action="../../models/register.php" method="POST">
                <div class="contenedor__input">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" required>

                    <label for="nombre">Apellido</label>
                    <input type="text" name="apellido" placeholder="Apellido" required>

                    <label for="email">Email</label>
                    <input type="email" name="eMail" placeholder="ejemplo@ejemplo.com" required>

                    <label for="contraseña">Contraseña</label>
                    <input type="password" name="Contraseña" placeholder="Ingrese contraseña" required>
                </div>
                <div class="contenedor__boton">
                    <button type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
