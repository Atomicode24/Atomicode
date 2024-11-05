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
                                    
                                                                    <?php if (isset($_SESSION["user_name"])) {?>
                                <li class="opciones__item"><a class="opciones__enlace" href="miscompras.php"><i class="fa-regular fa-credit-card"></i>Mis Compras</a></li>
                                <?php } else {?>
                                    <?php   // Usuario no logueado, redirigir a loginpagina.php al hacer clic
    echo '<li class="opciones__item"><a class="opciones__enlace" href="loginpagina.php"><i class="fa-regular fa-user"></i>Mis Compras</a></li>';
}?> 
                                <li class="opciones__item" style="position: relative;"><a class="opciones__enlace" href="deseo.php"><i class="fa-regular fa-heart"></i>Lista de deseos</a> <span class="contador__deseo" id="btnCantidadDeseo" style="background-color: #76ABAE; padding: 6px; width: 24px; height: 24px; position: absolute; right: 0; border-radius: 100%; display: flex; align-items: center; justify-content: center; margin-right: .4rem;"></span></li>
                                <li class="opciones__item"><a class="opciones__enlace" href="#"><i class="fa-solid fa-ticket"></i>Mis Cupones</a></li>
                                <?php

// Verificar si el usuario está logueado
if (isset($_SESSION["user_name"])) {
    // Usuario logueado, mostrar enlace a "Mi Cuenta"
    echo '<li class="opciones__item"><a class="opciones__enlace" href="micuenta.php"><i class="fa-regular fa-user"></i>Mi Cuenta</a></li>';
} else {
    // Usuario no logueado, redirigir a loginpagina.php al hacer clic
    echo '<li class="opciones__item"><a class="opciones__enlace" href="loginpagina.php"><i class="fa-regular fa-user"></i>Mi Cuenta</a></li>';
}
?>

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