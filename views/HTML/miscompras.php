<?php
session_start();

require '../../model/conexion.php';
require '../../config/config.php';
require '../../model/clases/clienteFunciones.php';


$db = new Database();
$con = $db->conectar();

$token = generarToken();
$_SESSION['token'] = $token;
$idCliente = $_SESSION['user_cliente'];




// Asegúrate de que la consulta SQL tenga los campos correctos
$sql = $con->prepare("SELECT id__transaccion, fecha, status, total, email FROM compra WHERE id__cliente=? ORDER BY DATE(fecha) DESC");
$sql->execute([$idCliente]);



$total_compra = 0;


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/610fbd17c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/CSS/styleindex.css">
    <link rel="stylesheet" href="../../assets/CSS/styletarjetas.css">
    <link rel="stylesheet" href="../../assets/CSS/miscompras.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Fast Buy - Oficial</title>
</head>
<body>
    <?php include 'menu.php';?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1> Bienvenido a tu Historial de Compras <?php echo $_SESSION['user_name']?></h1>
        
        <table class="purchase-history">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-calendar-days"></i> Fecha</th>
                    <th>Email de Notificación</th>
                    <th>Token de Venta</th>
                    <th>Estatus</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $sql -> fetch(PDO::FETCH_ASSOC)){?>
                <?php $fecha = new DateTime($row['fecha']);?>
                <?php $fecha = $fecha -> format('d/m/Y ');?>
                <tr>
                    <td><?php echo $fecha?></td>
                    <td><?php echo $row['email']?></td>
                    <td><span><?php echo $row['id__transaccion']?></span></td>
                    <td><?php echo $row['status']?></td>
                    <td><?php echo number_format($row['total'], 2, '.', ',')?></td>
                    <td><a href="compra__detalle.php?orden=<?php echo $row['id__transaccion']?>&token=<?php echo $token?>"><span class="token token-success">Ver Detalle Compra</span></a></td>

                </tr>
                <?php $total_compra += $row['total']?>
                <?php }?>
            </tbody>
            
            <tfoot>
                <tr>
                    <td colspan="4" class="total-label">Total de la compra </td>
                    <td class="total-amount"><?php echo number_format($total_compra, 2, '.', ',');?></td>
                </tr>
            </tfoot>

        </table>
        
    </div>
</body>
</html>

</body>
<script src="../../controllers/JS/deseo.js"></script>
</html>