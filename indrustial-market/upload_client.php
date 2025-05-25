<?php
include "db-con.php";
require "client.php";
$database = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_ejecucion = $_POST['tipo_ejecucion'];

    switch ($tipo_ejecucion) {
        case 'crear':
            $cliente = new Cliente($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['tipo_cliente']);
            Cliente::create($cliente, $database);
            break;
        case 'eliminar':
            Cliente::delete($database, $_POST['id']);
            break;
        case 'actualizar':
            $cliente = new Cliente($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['tipo_cliente']);
            $cliente->setIdUsuario($_POST['id_usuario']);
            Cliente::update($cliente, $database);
            break;
        default:
            echo "No escogiste nada";
            exit();
            break;
    }
}

header("Location: /indrustial-market/view/adminUsuarios.php");
exit();
