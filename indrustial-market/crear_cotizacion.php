<?php
include "db-con.php";
require "cotizacion.php";
require "client.php";
require "products.php";

$database = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_ejecucion = $_POST['tipo_ejecucion'];

    switch ($tipo_ejecucion) {
        case 'crear_cotizado':
            $cotizacion = new Cotizacion($_POST['cliente']);
            $cliente = Cliente::get($database, $_POST['cliente']);
            $id_inserted =  Cotizacion::crear_cotizacion($cliente, $cotizacion, $database);
            header("Location: /indrustial-market/view/cotizacion.php?id_cotizacion=$id_inserted");
            exit();
            break;
        case 'agregar_producto':
            $cotizacion_id = $_POST['id_cotizacion'];
            $cotizacion = Cotizacion::get($database, $cotizacion_id);
            $producto = Product::get($database, $_POST["producto"]);
            $precio_subtotal =  $_POST["cantidad"] * $producto->precio;
            $detalle_cotizacion = new DetalleCotizacion(
                $_POST["producto"],
                $_POST["cantidad"],
                $producto->precio,
                $precio_subtotal

            );

            DetalleCotizacion::agregar_producto($detalle_cotizacion, $cotizacion, $database);

            header("Location: /indrustial-market/view/cotizacion.php?id_cotizacion=$cotizacion_id");
            exit();
            break;
        case 'actualizar':
            $cliente->setIdUsuario($_POST['id_usuario']);
            Cliente::update($cliente, $database);
            break;
        default:
            echo "No escogiste nada";
            exit();
            break;
    }

}

