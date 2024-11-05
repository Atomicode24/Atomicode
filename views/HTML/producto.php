<?php
    session_start();
    require '../../model/conexion.php';
    require '../../config/config.php';
    
    
    $db =  new Database();
    $con = $db->conectar();

    
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if($id == '' || $token == ''){
        echo 'Error al procesar la petición';
        exit();
    }else {
        $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

        if ($token == $token_tmp) {
            
            $sql = $con->prepare("SELECT count(Id_Productos) FROM productos WHERE Id_Productos=? AND activo = 1");
            $sql -> execute([$id]);
            if($sql -> fetchColumn() > 0){
                
                $sql = $con->prepare("SELECT Nombre, descripcion, Precio, Descuento, Stock, Marca, Modelo FROM productos WHERE Id_Productos=? AND activo = 1 LIMIT 1");
                $sql -> execute([$id]);
                $row = $sql -> fetch(PDO::FETCH_ASSOC);
                $nombre = $row['Nombre'];
                $precio = $row['Precio'];
                $descripcion = $row['descripcion'];
                $stock = $row['Stock'];
                $marca = $row['Marca'];
                $modelo = $row['Modelo'];
                $descuento = $row['Descuento'];
                $precio_descuento = $precio - (($precio * $descuento) / 100); 
                $_SESSION['producto'] = [
                    'nombre' => $row['Nombre'],
                    'precio' => $row['Precio'],
                    'descuento' => $descuento,
                    'precio_descuento' => $precio_descuento
                    
                ];

                $dir_imagenes = '../../assets/IMG/'.$id.'/';

                $rutaImg = $dir_imagenes . 'principal.jpg';

                if(!file_exists($rutaImg)){
                    $rutaImg = '../../assets/IMG/no-photo.png';
                }

                $images = array();
                if(file_exists($dir_imagenes)){

                
                $dir = dir($dir_imagenes);

                while(($archivo = $dir -> read()) != false){
                    if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg') || strpos($archivo, 'png '))){
                        $imagenes = 
                        $images[] = $dir_imagenes . $archivo;
                    }
                }
                $dir -> close();
                }
            }

        }else {
            echo 'Error al procesar la petición';
            exit();
        }
    }


    $sql = $con->prepare("SELECT Id_Productos, Nombre, Precio, descripcion FROM productos WHERE activo = 1");
    $sql -> execute();
    $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['precio'] = $precio;
    $_SESSION['stock'] = $precio;
    $_SESSION['descuento'] = $descuento;
    $_SESSION['precio_descuento'] = $precio_descuento;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleproducto.css">
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/styleindexbase.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title><?php echo $nombre?></title>
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
    <section class="menu__lateral_contenedor">
            <div class="menu__lateral_contenido">
                <!-- MENU LATERAL HEADER -->
                 <div class="menulateral__header">
                    <!-- HEADER MENU LATERAL IZQ -->
                    <div class="menulateral__header_usuario">
                    <span class="menuheader__item_usuario"><i class="fa-solid fa-user"></i>¡Bienvenido, <span class="usuario__nombre"> <?php if (isset($_SESSION["user_id"])) {
                                      echo  $_SESSION["user_name"]; 
                                      }else {
                                        echo  '<a href="../HTML/loginpagina.php" class="usuario__nombre">Iniciar Sesión</a>';
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
        
    <section class="contenedor__articulos">
        <!-- HEADER NAV MENU ARTICULOS -->
        <nav class="nav_articulos">
            <ul class="nav__list_articulos">
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo enlace--articulo_modify abrir"><i class="fa-solid fa-bars abrir"></i> Todas las Categorías</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Ofertas del Día</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Servicios</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Tarjetas de Regalo</a></li>
                <li class="list__item_articulo"><a href="#" class="item__enlace_articulo">Vender</a></li>
            </ul>
        </nav>
    </section>
      <div class="contenedor__salir">
        <div class="contenedor__icono">
        <a href="index.php"><i class='bx bx-arrow-back'></i></a>
        </div>
      </div>
    <div class="contenedor__main">
    <div class="contenedor__img">
        <div class="contenedor__img-miniaturas">
            <?php foreach($images as $img) { ?>
            <a href="producto.php" onclick="changeImage('<?php echo $img?>'); return false;">
                <img src="<?php echo $img?>" alt="">
            </a>
            <?php }?>
        </div>
        <div class="contenedor__imagen-principal">
            <img id="mainImage" src="<?php echo $rutaImg?>" alt="" onclick="resetImage();" style="cursor: pointer;"> <!-- Se eliminó el enlace y se añadió un onclick -->
        </div>
    </div>

        <div class="contenedor__detalles-producto">
            <h1 class="detalles__producto-titulo"><?php echo $row['Nombre'] ?></h1>
            <div class="contenedor__calificacion">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <p><span class="calificacion__cantidad">7466</span> Calificaciones</p>
            </div> 
            <div class="contenedor__caracterisiticas">
                <p>Disponibilidad: <span><?php if($stock < 1){
            echo  "No hay stock disponible";}else {echo $stock;}?></span> </p>
                <p>Marca: <span><?php echo $marca;?></span> </p>
                <p>Modelo: <span><?php echo $modelo;?></span></p>
                <ul>
                    <li class="item--separador"></li>
                </ul>
                <p class="caracteristicas__descripcion"><?php echo $descripcion?></p>
            </div>
        </div>
        <div class="contenedor__compra-producto">
            <div class="contenedor__producto-precio">
                <span class="producto__favorito"><i class='bx bx-heart'></i></span>
                <?php if ($descuento > 0) { ?>
                <p class="producto__precio-antes">Antes: <span><?php echo MONEDA . number_format($precio,2 ,'.', ',');?></span></p>
                <p class="producto__precio-ahorro"><span>Ahorras: <?php echo $descuento."%"?></span></p>
                <span class="producto__precio-ahora"><?php echo MONEDA . number_format($precio_descuento,2 ,'.', ',');?></span>
                <?php }else { ?>
                    <span class="producto__precio-ahora"><?php echo MONEDA . number_format($precio,2 ,'.', ',');?></span>
                <?php }?>
                <div class="contenedor__info">
                    <span><i class='bx bxs-cart-add'></i><strong>Agrega el artículo al carro</strong> para ver el costo de envíos.</span>
                </div>
                <div class="contenedor__info">
                    <span><i class='bx bxs-plane-land'></i><strong>Disfruta de envíos rápidos</strong> y muchas más ventajas.</span>
                </div>
                <div class="contenedor__info">
                    <span><i class='bx bx-credit-card'></i><strong>Disfruta de opciones de pago</strong> flexibles y ventajas únicas.</span>
                </div>
            </div>
            <div class="contenedor__pago">
                <span>Cantidad: <input type="number" min="1" value="1"></span>
                <button class="pago__comprar">Comprar</button>
                <button id="pago__añadir" onclick="addProducto(<?php echo $id;?>, '<?php echo $token_tmp?>');" >Añadir al carrito</button>
            </div>
        </div>
    </div>
    
    <div class="menu__lateral_contenedor">
        <div class="menu__cerrar">
            <button class="salir">Cerrar <i class="bx bx-x"></i></button>
        </div>
        <ul class="menu__opciones">
            <li class="menu__opcion"><a href="#">Electrodomésticos</a></li>
            <li class="menu__opcion"><a href="#">Muebles</a></li>
            <li class="menu__opcion"><a href="#">Tecnología</a></li>
            <li class="menu__opcion"><a href="#">Hogar</a></li>
            <li class="menu__opcion"><a href="#">Cuidado Personal</a></li>
            <li class="menu__opcion"><a href="#">Hogar y Jardín</a></li>
            <li class="menu__opcion"><a href="#">Viajes</a></li>
            <li class="menu__opcion"><a href="#">Deportes</a></li>
            <li class="menu__opcion"><a href="#">Moda</a></li>
        </ul>
    </div>
    <div class="overlay">

</div>
<div id="overlay">

</div>

    <script src="../../controllers/JS/imagenesproductos.js" defer></script>
    <script src="../../controllers/JS/carrito.js"  defer></script>
    <script defer>
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
