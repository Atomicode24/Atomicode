<?php
session_start();
require '../../model/conexion.php';
require '../../config/config.php';



$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT Id_Productos, Nombre, Precio, descuento, $cantidad as cantidad FROM productos WHERE Id_Productos=? AND activo = 1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetchAll(PDO::FETCH_ASSOC);

    }
}else {
    header("Location: index.php");
    exit;
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">
    <link rel="stylesheet" href="../../assets/CSS/styletablapago.css">
    <link rel="stylesheet" href="../../assets/CSS/styleindicadorcarga.css">
    <script src="../../controllers/JS/indicadorcarga.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Fast Buy - Oficial</title>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        
        <!-- HEADER LOGO -->
        <section class="header__logo">
            <a href="../HTML/index.php" style="color: #fff;">
            <h3 class="logo__texto">
                <i class="fa-sharp fa-solid fa-cart-shopping"></i> Fast <span class="texto__bold">Buy</span>
            </h3>
            </a>
        </section>
    
        <!-- HEADER INPUT BUSCADOR -->
        <section class="header__buscador">
            <input class="buscador__input" type="text" placeholder="Buscar Producto..." aria-label="Buscar productos">
            <button class="buscador__boton" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
        </section>
    
        <!-- HEADER NAV MENU -->
        <nav class="header__nav" aria-label="Menú de usuario">
            <ul class="nav__list">
                <li class="list__itemhead itemhead--cuenta">
                    <a href="#" class="item__enlace enlace--modify">
                        <i class="fa-regular fa-user enlace__iconouser"></i>
                        <div class="text-container">
                            
                        <?php
                            // Comprobar si el usuario está logueado
                            if (isset($_SESSION["user_id"])) {
                                // Usuario está logueado
                                echo '<span class="span__texto_bienvenido">¡Bienvenido, <span class="usuario__nombre2">';
                                echo htmlspecialchars($_SESSION["user_name"]); // Sanitiza la salida para evitar XSS
                            } else {
                                                                // Usuario no está logueado
                                echo '<span class="span__texto_bienvenido">¡Bienvenido<span class="usuario__nombre2">';
                            }
                            
                            // Cierra el span de nombre de usuario
                            echo '!</span></span>';
                            
                            // Verificar si el usuario ha iniciado sesión para mostrar el texto correspondiente
                            if (isset($_SESSION["user_id"])) {
                                echo '<span class="span__texto_cuenta">Más Información <i class="bx bx-chevron-down"></i></span>';
                            } else {
                               
                                echo '<span class="span__texto_cuenta">Iniciar Sesión / Regístrate <i class="bx bx-chevron-down"></i></span>';
                            }
                            ?>

                            
                        </div>
                    </a>

                    <div class="submenu__cuenta">
                        <div class="cuentas__identificacion">
                        <?php if (isset($_SESSION["user_id"])): ?>
    <a href="../../controllers/PHP/controlador_cerrar_session.php?logout=true" id="boton__identificate" class="identificacion__boton-iniciosesion">
        Cerrar Sesión <i class="bx bx-log-out"></i>
    </a>
<?php else: ?>
    <a href="../HTML/loginpagina.php" id="boton__identificate" class="identificacion__boton-iniciosesion">
        Iniciar Sesión
    </a>
    <a id="boton_registrate" class="identificacion__boton-registrate" href="../HTML/register.php">
        Regístrate
    </a>
<?php endif; ?>
                        </div>
                        <div class="contenedor__opciones">
                            <ul class="opciones__usuario">
                                <li class="item--separador"></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-clipboard"></i>Mis Pedidos</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-credit-card"></i>Pago</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-heart"></i>Lista de deseos</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-solid fa-ticket"></i>Mis Cupones</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-user"></i>Mi Cuenta</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
        
                <li class="list__itemhead">
                    <a href="../HTML/checkout.php" class="item__enlace">
                        <i class="fa-solid fa-cart-shopping enlace__iconocarrito"></i>
                        <div class="text-container">
                            <span id="cart_count"><?php echo $num_cart; ?></span>
                            <span class="span__texto_cesta">cesta</span>
                        </div>
                    </a>
                </li>
                
            </ul>
        </nav>
    </header>
    
     <!-- FIN HEADER -->
      <section class="contenedor__articulos">
        <!-- HEADER NAV MENU ARTICULOS -->
        <nav class="nav_articulos">
            <ul class="nav__list_articulos">
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo enlace--articulo_modify abrir"><i class="fa-solid fa-bars  abrir"></i> Todas la Categorias</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Ofertas del Día</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Servicios</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Tarjetas de Regalo</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Vender</a></li>
                </ul>
        </nav>
        
      </section>
      <!-- CONTENEDOR MENU LATERAL -->
      <section class="menu__lateral_contenedor">
            <div class="menu__lateral_contenido">
                <!-- MENU LATERAL HEADER -->
                 <div class="menulateral__header">
                    <!-- HEADER MENU LATERAL IZQ -->
                    <div class="menulateral__header_usuario">
                    <span class="menuheader__item_usuario"><i class="fa-solid fa-user"></i>¡Bienvenido, <span class="usuario__nombre" style="color: #fff;">
                    <?php if (isset($_SESSION["user_id"])) {
                                      echo  $_SESSION["user_name"]; 
                                      }else {
                                        echo  '<a href="../HTML/loginpagina.php" class="usuario__nombre" style"color: #fff!important;">Iniciar Sesión</a>';
                                      }?>!</span></span>
                    <span class="menuheader__item_equis"><i class="fa-solid fa-x  salir"></i></span>
                    </div>
                 </div>

                 <!-- NAV MENU LATERAL IZQ -->
                  <section class="menulateral__nav">
                    <nav class="submenu">
                        <h2 class="submenu__subtitulo">Por departamento</h2>
                        <ul class="nav__list_menulateral">
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Computadoras</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Electronico</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Hogar</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Ver Todo</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="item--separador"></li>
                        </ul>
                    </nav>
                    <nav class="submenu-1">
                        <h2 class="submenu__subtitulo">Ropa y Accesorios</h2>
                        <ul class="nav__list_menulateral">
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Hombre</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Mujer</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Niño</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Mascota</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="item--separador"></li>
                        </ul>
                    </nav>
                    <nav class="submenu">
                        <h2 class="submenu__subtitulo">Ayuda & Ajustes</h2>
                        <ul class="nav__list_menulateral">
                            <li class="listalateral__item"><a class="itemlateral__enlace" href="#">Tu Cuenta</a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace" href="#"><i class="fa-solid fa-language"></i> Español</a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace" href="#"><i class="fa-solid fa-earth-americas"></i> Urguay</a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace" href="#"><span><i class="fa-solid fa-user"></i></span> Mi Cuenta</a></li>
                        </ul>
                    </nav>
                    <nav class="submenu3">
                        <h2 class="submenu__subtitulo">Ropa y Accesorios</h2>
                        <ul class="nav__list_menulateral">
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Hombre</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Mujer</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Niño</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="listalateral__item"><a class="itemlateral__enlace enlace--modificado" href="#"><div class="item__nombre">Mascota</div><i class='bx bx-chevron-right'></i></a></li>
                            <li class="item--separador"></li>
                        </ul>
                    </nav>
                  </section>
            </div>
        </section>

        <div class="container">
            <div class="contendor__texto-pago">
                <div class="texto__pago">
                    <h2>Detalles de pago</h2>
                    <div id="paypal-button-container"></div>
                </div>
            </div>

            <div class="contenedor_tabla">
                <table class="tabla" border="0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th     >Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($lista_carrito == null){
        echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td><tr>';
    } else {
        $total = 0;
        foreach ($lista_carrito as $producto_array) {
            foreach ($producto_array as $producto) {
                $_id = $producto['Id_Productos'];
                $nombre = $producto['Nombre'];
                $precio = $producto['Precio'];
                $descuento = $producto['descuento'];
                $cantidad = $producto['cantidad'];
                $precio_desc = $precio - (($precio * $descuento) / 100);  
                $subtotal = $cantidad * $precio_desc;
                $total += $subtotal;
    ?>
                        <tr>
                            <td colspan="3"><?php echo $nombre;?></td>
                            <td colspan="3">
                                <div id="subtotal_<?php echo $_id;?>" name="subtotal[]" ><?php echo MONEDA . number_format($subtotal,2,'.',',');?></div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <tr>
                            
                            <td colspan="4">
                                <p class="h3" id="total"><?php echo MONEDA . number_format($total,2,'.',',');?></p>
                            </td>

                        </tr>
                    </tbody>
                   
                    <?php } ?>
                    
                </table>
                </div>            
        </div>


        <div class="overlay" style="display: none;">

        </div>

        <div id="contenedor__carga">
        <div id="carga"></div>
        </div>

        <script src="https://sandbox.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID;?>&currency=<?php echo CURRENCY;?>"></script>
        <script>
    // Redondear el total a dos decimales en PHP
    var totalValue = parseFloat('<?php echo number_format($total, 2, '.', ''); ?>'); // Asegúrate de que tenga solo dos decimales

    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalValue.toFixed(2) // Asegúrate de que se envíe como un string con dos decimales
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            let URL = '../../model/clases/captura.php';
            actions.order.capture().then(function(detalles) {
                console.log(detalles);

                return fetch(URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'  // Corregir 'application'
                    },
                    body: JSON.stringify({
                        detalles: detalles
                    })
                }).then(function(response) {
                    // Redirigir a la página de "completado" con el ID de la transacción
                    window.location.href = "completado.php?key=" + detalles['id']; // Usar detalles['id'] directamente
                });
            });
        },
        onCancel: function(data) {
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
</script>


        <script src="../../controllers/JS/menulateral.js" defer></script>
        <script src="../../controllers/JS/menucuenta.js" defer></script>
        <script src="../../controllers/JS/checkout.js" defer></script>
    
</body>
</html>