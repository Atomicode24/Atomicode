<?php
include '../../model/conexion.php';
session_start();
$db = new Database();
$conn = $db->conectar();

$token_tmp = isset($_SESSION['token']) ? $_SESSION['token'] : null; // Asigna un valor predeterminado

// Verifica si 'id' está definido en la sesión
if (isset($_SESSION['id'])) {
    $Id_Usuarios = $_SESSION['id'];

    // Continúa con tu consulta
    $sql = "SELECT nombres, apellidos, email, telefono FROM clientes WHERE Id_Clientes = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $Id_Usuarios, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Location: micuenta.php');
}


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/micuenta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Mi Cuenta</title>
    <style>
        .form-container {
            display: none;
        }
    </style>
    <script>
        function toggleForm() {
            var formContainer = document.getElementById("form-container");
            formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
        }

        function validateForm() {
            var nombre = document.forms["editForm"]["nombres"].value;
            var apellido = document.forms["editForm"]["apellidos"].value;
            var email = document.forms["editForm"]["email"].value;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var telefono = document.forms["editForm"]["telefono"].value;

            if (nombre == "" || apellido == "" || email == "" || telefono == "") {
                alert("Por favor, complete todos los campos.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Por favor, ingrese un correo electrónico válido.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <section class="header__logo">
            <a href="../../views/HTML/index.php"><h3 class="logo__texto" style="color: white;"><i class="fa-sharp fa-solid fa-cart-shopping"></i>FastBuy</h3></a>
        </section>
    
        <nav class="header__nav" aria-label="Menú de usuario">
            <ul class="nav__list">
                <li class="list__itemhead itemhead--cuenta">
                    <a href="#" class="item__enlace enlace--modify">
                        <i class="fa-regular fa-user enlace__iconouser"></i>
                        <div class="text-container">
                            <span class="span__texto_bienvenido">¡Bienvenido/a!</span>
                            <?php
                                if (isset($_SESSION['nombre']) && isset($_SESSION['apellido'])) {
                                    echo '<span class="span__texto_cuenta">' . htmlspecialchars($_SESSION['nombre']) . ' ' . htmlspecialchars($_SESSION['apellido']) . '</span>';
                                } else {
                                    echo '<span class="span__texto_cuenta">Iniciar sesión / Registrarse<i class="bx bx-chevron-down"></i></span>';
                                }
                            ?>
                        </div>
                    </a>
                    <div class="submenu__cuenta">
                        <!-- Menu de usuario -->
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    
    <h1>Mi Cuenta</h1>
    <div id="user-info">
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['nombres']); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($user['apellidos']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <button onclick="toggleForm()">Editar datos</button>
    </div>

    <div id="form-container" class="form-container">
        <form name="editForm" action="actualizar-datos.php" method="POST" onsubmit="return validateForm();">
            <input type="hidden" name="Id_Usuarios" value="<?php echo $Id_Usuarios; ?>">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombres" value="<?php echo htmlspecialchars($user['nombres']); ?>"><br><br>

            <label for="apellido">Apellido:</label><br>
            <input type="text" id="apellido" name="apellidos" value="<?php echo htmlspecialchars($user['apellidos']); ?>"><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

            <label for="telefono">Telefono:</label><br>
            <input type="number" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>"><br><br>

            <label for="password">Nueva Contraseña (opcional):</label><br>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Guardar cambios">
        </form>
    </div>

    <script src="../../controllers/JS/menucuenta.js"></script>
</body>
</html>
