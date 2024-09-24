<?php
require_once 'controllers/UsuarioController.php';


$controller = new UsuarioController();


$action = isset($_GET['action']) ? $_GET['action'] : 'list'; 
$id = isset($_GET['id']) ? $_GET['id'] : null; 

switch ($action) {
    case 'create': 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $response = $controller->create($_POST); 
            echo $response; 
        } else {
            include 'views/crearUsuario.php';
        }
        break;
    case 'list': 
        $usuarios = $controller->readAll(); 
        include 'views/listarUsuarios.php'; 
        break;
    case 'edit': 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $response = $controller->update($_POST); 
            echo $response; 
        } else {
            $usuario = $controller->readOne($id); 
            include 'views/editarUsuario.php'; 
        }
        break;
    case 'delete': 
        $response = $controller->delete($id); 
        echo $response; 
        break;
    default: 
        $usuarios = $controller->readAll(); 
        include 'views/listarUsuarios.php'; 
        break;
}
