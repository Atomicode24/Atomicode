    <?php
    session_start();
    require '../../model/conexion.php';
    require '../../config/config.php';



    $db = new Database();
    $con = $db->conectar();

    $listaDeseo = isset($_SESSION['listaDeseo']) ? $_SESSION['listaDeseo'] : [];

    $total = 0; // Inicializar la variable total

    if (!empty($listaDeseo)) {
        foreach ($listaDeseo as $producto) {
            $precio = $producto['Precio']; // Asegúrate de que 'Precio' esté en tu lista
            $cantidad = $producto['cantidad']; // Asegúrate de que 'cantidad' esté en tu lista
            $subtotal = $precio * $cantidad; // Calcula el subtotal
            $total += $subtotal; // Suma al total
        }
    }

    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_POST['usuario_id']; // ID del usuario
    $producto_id = $_POST['producto_id']; // ID del producto
    $nombre = $_POST['nombre']; // Nombre del producto
    $precio = $_POST['precio']; // Precio del producto

    // Prepara la consulta
    $sql = "INSERT INTO lista_deseos (usuario_id, producto_id, nombre, precio) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iisd", $usuario_id, $producto_id, $nombre, $precio); // Asumiendo que usuario_id es INT, producto_id es INT, nombre es STRING y precio es DECIMAL

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Producto agregado a la lista de deseos.";
    } else {
        echo "Error: " . $stmt->error; // Muestra error si falla
    }
    
    $stmt->close();
    $conexion->close();
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
    <link rel="stylesheet" href="../../assets/CSS/styletablacarrito.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Fast Buy - Oficial</title>
</head>
<body>
<?php include 'menu.php'?>
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
      <div class="container">
    <div class="contenedor_tabla">
        <table class="tabla" border="0">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($listaDeseo)): ?>
                <tr>
                    <td colspan="5" class="text-center"><b>Tu lista de deseos está vacía.</b></td>
                </tr>
            <?php else: ?>
                <?php 
                $total = 0; // Inicializa el total
                foreach ($listaDeseo as $producto): 
                    $id = $producto['idProducto'];
                    $nombre = $producto['nombre']; // Nombre del producto
                    $precio = $producto['precio']; // Precio del producto
                    $cantidad = $producto['cantidad'];
                    $subtotal = $precio * $cantidad; // Calcula el subtotal
                    $total += $subtotal; // Suma al total
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nombre); ?></td> <!-- Escapar salida para seguridad -->
                        <td><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></td>
                        <td>
                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>"
                            size="5" id="cantidad_<?php echo $id; ?>" onchange="actualizaCantidad(this.value, <?php echo $id; ?>);">
                        </td>
                        <td>
                            <div id="subtotal_<?php echo $id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                        </td>
                        <td><a href="#" id="eliminar" class="btn abrir-alerta" data-id="<?php echo $id; ?>">Agregar Al carrito</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="4">
                    <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                </td>
                <td colspan="1.5"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


        <div class="container__modal" id="eliminaModal">
    <div class="modal">
        <div class="modal__titulo">
            <span>Alerta</span>
        </div>
        <div class="modal__texto">
            <p>¿Desea eliminar el producto de la lista?</p>
        </div>
        <div class="modal__botones">
            <button class="modal__boton-cerrar cerrar-alerta" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" id="btn-elimina" class="modal__boton-eliminar" onclick="eliminar()">Eliminar</button>
        </div>
    </div>
</div>


        <div class="overlay" style="display: none;">

        </div>
        <script src="../../controllers/JS/menulateral.js" defer></script>
        <script src="../../controllers/JS/menucuenta.js" defer></script>
        <script src="../../controllers/JS/checkout.js" defer></script>
        <script src="../../controllers/JS/deseo.js"></script>
        <script defer>
function toggleMenu(menuSelector, overlaySelector) {
    const menuContenedor = document.querySelector(menuSelector);
    const overlay = document.querySelector(overlaySelector);
    const isMenuVisible = menuContenedor.classList.contains("show");
    
    if (isMenuVisible) {
        menuContenedor.classList.remove("show");
        overlay.style.display = 'none'; // Oculta el overlay
        document.body.classList.remove("no-scroll");
    } else {
        menuContenedor.classList.add("show");
        overlay.style.display = 'block'; // Muestra el overlay
        document.body.classList.add("no-scroll");
    }
}

// Evento para abrir el menú lateral
document.querySelector(".abrir").addEventListener("click", function() {
    toggleMenu(".menu__lateral_contenedor", ".overlay");
});

// Evento para cerrar el menú lateral
document.querySelector(".salir").addEventListener("click", function() {
    toggleMenu(".menu__lateral_contenedor", ".overlay");
});

// Agregar evento a todos los botones de eliminar
// Agregar evento a todos los botones de eliminar
const eliminarButtons = document.querySelectorAll(".abrir-alerta");
eliminarButtons.forEach(button => {
    button.addEventListener("click", function(event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
        const id = this.getAttribute("data-id"); // Obtener el ID del producto
        document.getElementById('btn-elimina').setAttribute('data-id', id); // Guardar el ID en el botón de eliminar
        toggleMenu(".container__modal", ".overlay"); // Mostrar el modal
    });
});


// Evento para cerrar el nuevo menú
document.querySelector(".cerrar-alerta").addEventListener("click", function() {
    toggleMenu(".container__modal", ".overlay"); // Cambia esto si el selector es diferente
});
</script>

</body>
</html>