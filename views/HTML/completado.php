<?php
session_start();
require '../../model/conexion.php';
require '../../config/config.php';

$db = new Database();
$con = $db->conectar();

$id__transaccion = isset($_GET['key']) ? $_GET['key'] : '0';

$error = '';

if ($id__transaccion == '0') {
    $error = 'Error al procesar la petición';
} else {
    // Verificar que la transacción exista y esté completada
    $sql = $con->prepare("SELECT count(id) FROM compra WHERE id__transaccion=? AND status = ?");
    $sql->execute([$id__transaccion, 'COMPLETED']);
    
    if ($sql->fetchColumn() > 0) {
        // Obtener los detalles de la compra
        $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id__transaccion=? AND status = ? LIMIT 1");
        $sql->execute([$id__transaccion, 'COMPLETED']);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $idcompra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];

        // Consulta de los detalles de los productos comprados
        $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle__compra WHERE id__compra = ?");
        $sqlDet->execute([$idcompra]);
    } else {
        $error = 'Error al comprobar la compra';
    }      
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styletablacarrito.css">
    <title>Compra Completada</title>
</head>
<body>
<header class="header">
        
        <!-- HEADER LOGO -->
        <section class="header__logo">
            <a href="../HTML/index.php" style="color: #fff; text-align: center;" >
            <h1 class="logo__texto">
                <i class="fa-sharp fa-solid fa-cart-shopping"></i> Fast <span class="texto__bold">Buy</span>
            </h1>
            </a>
        </section>
    
    </header>
    <?php if (strlen($error) > 0) { ?>
    <div class="container">
        <h3><?php echo $error; ?></h3>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="contenedor_tabla">
            <div class="texto__bold-container">
                <b class="texto__bold-completado">Número de orden:  </b> <?php echo $id__transaccion; ?><br>
                <b class="texto__bold-completado">Fecha de compra:  </b> <?php echo $fecha; ?><br>
                <b class="texto__bold-completado">Total:  </b> <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
            </div>

            <table class="tabla" border="0">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
                        $importe = $row_det['precio'] * $row_det['cantidad']; ?>
                        <tr>
                            <td><?php echo $row_det['cantidad']; ?></td>
                            <td><?php echo $row_det['nombre']; ?></td>
                            <td><?php echo MONEDA . number_format($importe, 2, '.', ','); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>  

    
</body>
</html>
