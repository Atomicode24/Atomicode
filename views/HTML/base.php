<?php
session_start();
require '../../model/conexion.php';
require '../../config/config.php';

$db = new Database();
$con = $db->conectar();

// Asegúrate de que la consulta SQL tenga los campos correctos
$sql = $con->prepare("SELECT Id_Productos, Nombre, Precio, descuento, descripcion FROM productos WHERE activo = 1");
$sql->execute();

// Obtener todos los resultados
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">
    <link rel="stylesheet" href="../../assets/CSS/styleindexbase.css">
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Fast Buy</title>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <!-- HEADER LOGO -->
        <section class="header__logo">
            <h3 class="logo__texto">
                <i class="fa-sharp fa-solid fa-cart-shopping"></i> Fast <span class="texto__bold">Buy</span>
            </h3>
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
                            <span class="span__texto_bienvenido">¡Bienvenido!</span>
                            <span class="span__texto_cuenta">Iniciar Sesión / Regístrate <i class='bx bx-chevron-down'></i></span>
                        </div>
                    </a>

                    <div class="submenu__cuenta">
                        <div class="cuentas__identificacion">
                            <a href="../HTML/loginpagina.php" id="boton__identificate" class="identificacion__boton-iniciosesion">Iniciar Sesión</a>
                            <a id="boton_registrate" class="identificacion__boton-registrate" href="../HTML/register.php">Regístrate</a>
                        </div>
                        <div class="contenedor__opciones">
                            <ul class="opciones__usuario">
                                <li class="item--separador"></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-clipboard"></i>Mis Pedidos</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-credit-card"></i>Pago</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-regular fa-heart"></i>Lista de deseos</a></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-solid fa-ticket"></i>Mis Cupones</a></li>
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
                        <span class="menuheader__item_usuario"><i class="fa-solid fa-user"></i>¡Bienvenido, <span class="usuario__nombre"><a class="usuario__nombre" href="../HTML/loginpagina.php">Inicie Sesión</a>!</span></span>
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
       <!-- CARRUSEL DE IMAGENES / BANNER -->
        <div class="container__carousel">
            <div class="carruseles" id="slider">
                <section class="slider__section">
                    <div class="container__texto">
                        <h1 class="slider__titulo">¡Potencia tu entrenamiento<br>con los mejores zapatos deportivos!</h1>
                        <p class="slider__descripcion">
                            Descubre nuestra selección de zapatos diseñados especialmente para tu entrenamiento.<br>Con soporte, comodidad y tecnología avanzada para mejorar tu rendimiento.
                        </p>
                        <button class="slider__boton">Ver colecciones</button>
                    </div>
                    <div class="overlay__slider"></div>
                    <img src="../../assets/IMG/championes.jpg" alt="" class="slider--1">
                </section>
                <section class="slider__section">
                    <div class="container__texto">
                        <h1 class="slider__titulo"> ¡Descubre el reloj perfecto<br> para cada momento!
                        </h1>
                        <p class="slider__descripcion">
                            Explora nuestra colección de relojes con diseños elegantes y tecnología de vanguardia.<br>El accesorio ideal para cualquier estilo y ocasión.
                        </p>
                        <button class="slider__boton">Ver colecciones</button>
                    </div>
                    <div class="overlay__slider"></div>
                    <img src="../../assets/IMG/reloj.jpg" alt="" class="slider--2">
                </section>
                <section class="slider__section">
                    <div class="container__texto">
                        <h1 class="slider__titulo">¡Potencia tu entrenamiento<br>con los mejores zapatos deportivos!</h1>
                        <p class="slider__descripcion">
                            Descubre nuestra selección de zapatos diseñados especialmente para tu entrenamiento.<br>Con soporte, comodidad y tecnología avanzada para mejorar tu rendimiento.
                        </p>
                        <button class="slider__boton">Ver colecciones</button>
                    </div>
                    <div class="overlay__slider"></div>
                    <img src="../../assets/IMG/reloj2.jpg" alt="">
                </section>
            </div>
            <div class="btn__left"><i class='bx bx-chevron-left'></i></div>
            <div class="btn__right"><i class='bx bx-chevron-right'></i></div>
        </div>
        <section class="seccion__informacion">
            <div class="informacion__item">
                <i class="fa-solid fa-truck-fast"></i>
                <p>Envíos a todo el país. <a href="#"> Más información</a></p>
            </div>
            <div class="informacion__item">
                <i class="fas fa-undo-alt"></i>
                <p>Devoluciones sencillas. <a href="#"> Política de devoluciones</a></p>
            </div>
            <div class="informacion__item">
                <i class="fas fa-lock"></i>
                <p>Paga de forma segura. <a href="#"> Métodos de pago</a></p>
            </div>
            <div class="informacion__item">
                <i class="fas fa-headset"></i>
                <p>Atención personalizada. <a href="#"> Contáctanos</a></p>
            </div>
        </section>
        <!-- TARJETAS OFERTAS -->
    <!--  <section class="seccion__productos">
            <div class="tarjeta__producto">
                <a href="producto.html"><img src="../../assets/IMG/tvsamsung.webp" alt=""></a>
                <div class="linea"></div>
                <div class="detalles__producto">
                    <a class="enlace__producto" href="producto.php">
                        <p class="descripcion__producto">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit...
                        </p>
                    </a>
                    <div class="calificacion__producto">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="precio__producto producto--antes">U$S 149.99</span>
                    <span class="precio__producto">U$S 119.99</span>
                    <a href="producto.php" class="añadir__producto"><i class="fa-solid fa-cart-plus"></i></a>
                </div>
             </div>
        </section>-->
        <section class="seccion__productos">
    <?php foreach($resultado as $row) { ?>
        <div class="tarjeta__producto">
            <?php 
                $id = $row['Id_Productos'];
                $imagen = "../../assets/IMG/". $id ."/principal.jpg";
                
                if (!file_exists($imagen)) {
                    $imagen = "../../assets/IMG/no-photo.png";
                }
            ?>
            <a href="producto.php?id=<?php echo $row['Id_Productos']; ?>&token=<?php echo hash_hmac('sha1', $row['Id_Productos'], KEY_TOKEN);?>">
                <img src="<?php echo $imagen; ?>" alt="">
            </a>
            <div class="linea"></div>
            <div class="detalles__producto">
                <div class="titulo__producto">
                    <h5 class="titulo__texto"><?php echo $row['Nombre']; ?></h5>
                </div>
                <a class="enlace__producto" href="producto.php?id=<?php echo $row['Id_Productos']; ?>&token=<?php echo hash_hmac('sha1', $row['Id_Productos'], KEY_TOKEN); ?>">
                    <p class="descripcion__producto"><?php echo $row['descripcion']; ?></p>
                </a>
                <div class="calificacion__producto">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>

                <?php
                // Comprobando si hay descuento
                if ($row['descuento'] > 0) {
                    $precio = $row['Precio']; 
                    $descuento = $row['descuento']; 
                    $precio_descuento = $precio - ($precio * ($descuento / 100)); 
                ?>
                    <span class="producto--antes">
                        Antes: <?php echo MONEDA . number_format($precio, 2, '.', ','); ?> 
                    </span>
                    <span class="precio__producto">
                        Ahora: <?php echo MONEDA . number_format($precio_descuento, 2, '.', ','); ?>
                    </span>
                    <a href="producto.php?id=<?php echo $row['Id_Productos']; ?>&token=<?php echo hash_hmac('sha1', $row['Id_Productos'], KEY_TOKEN); ?>" class="añadir__producto">
                        <i class="fa-solid fa-cart-plus"></i>
                    </a>
                <?php } else { ?>
                    <span class="producto--antes">
                    <div class="placeholder"></div> <!-- Placeholder para llenar el espacio -->
                    </span>
                    <span class="precio__producto" >
                        Precio: <?php echo MONEDA . number_format($row['Precio'], 2, '.', ','); ?>
                    </span>
                    <a href="producto.php?id=<?php echo $row['Id_Productos']; ?>&token=<?php echo hash_hmac('sha1', $row['Id_Productos'], KEY_TOKEN); ?>" class="añadir__producto" >
                        <i class="fa-solid fa-cart-plus"></i>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</section>
        <div class="overlay">

        </div>
        <div id="overlay">

        </div>
        <script src="../../controllers/JS/carrusel.js" defer></script>
        <script src="../../controllers/JS/menulateral.js" defer></script>
        <script src="../../controllers/JS/menucuenta.js" defer></script>
       <script>
        function toggleMenu() {
        const menuContenedor = document.querySelector(".menu__lateral_contenedor");
        const isMenuVisible = menuContenedor.classList.contains("show");
        
        if (isMenuVisible) {
            menuContenedor.classList.remove("show");
            document.body.classList.remove("no-scroll");
        } else {
            menuContenedor.classList.add("show");
            document.body.classList.add("no-scroll");
        }
    }
    // Evento para abrir el menú lateral
    document.querySelector(".abrir").addEventListener("click", toggleMenu);
    
    // Evento para cerrar el menú lateral
    document.querySelector(".salir").addEventListener("click", toggleMenu);
    
    
       </script>
</body>
</html>