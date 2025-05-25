<?php
include "../db-con.php";
require "../products.php";
require "../cotizacion.php";
require "../client.php";

$id_cotizacion = $_GET["id_cotizacion"];

$database = new Database();

$productos = Product::list($database);
$cotizacion = Cotizacion::get($database, $id_cotizacion);
$detalle_cotizacion = DetalleCotizacion::list($database, $id_cotizacion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <title>Hardware Store Nuts and Bolts</title>
</head>
<body>
    <div id="header"></div>
    <div id="load-cotizacion" class="p-3">
        <div class="main-container">
            <main class="content pb-5">
                <!-- Sistema de Cotización --> 
                <h4 class="text-center mt-5 mb-4 fw-bold">Cotización en línea</h4>
                <section class="quote-section" id="quote">
                    <form id="quote-form" action="../crear_cotizacion.php" method="post" class="quote-form">
                    <input type="hidden" id="tipo_ejecucion" name="tipo_ejecucion" value="agregar_producto">
                    <input type="hidden" id="id_cotizacion" name="id_cotizacion" value="<?php echo $id_cotizacion;  ?>">
                        <div class="product-selection">
                            <div id="products-container">
                                <div class="product-entry">
                                    <select class="product-select" id="producto" name="producto" required>
                                        <option value="">Seleccione un producto</option>
                                        <?php
                                        foreach ($productos as $producto) {
                                        ?>
                                        <option value="<?php echo $producto->id_producto;  ?>"><?php echo $producto->nombre_producto;  ?> - $<?php echo number_format($producto->precio);  ?> COP</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="number" class="product-quantity" min="1" value="1" id="cantidad" name="cantidad" required>
                                </div>
                            </div>
                            <button type="submit" class="add-product-btn">Agregar Producto</button>
                        </div>
                                                                <!-- Tabla de Productos -->
                        <div class="table-responsive mt-4">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio Unitario</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($detalle_cotizacion as $detalle) {
                                        $producto_sel = Product::get($database, $detalle->id_producto);
                                    ?>
                                    <tr>
                                        <td><?php echo $producto_sel->nombre_producto;  ?></td>
                                        <td><?php echo $detalle->cantidad;  ?></td>
                                        <td>$ <?php echo  number_format($detalle->precio_unitario);  ?> COP</td>
                                        <td>$ <?php echo  number_format($detalle->subtotal);  ?> COP</td>
                                    </tr>
                                    <?php
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="quote-summary">
                            <h3>Resumen de Cotización</h3>
                            <div class="summary-details">
                                <p>Subtotal: <span id="subtotal"><?php echo number_format($cotizacion->total);  ?> COP</span></p>
                                <p>Descuento: <span id="discount"><?php echo number_format($cotizacion->descuento_aplicado);  ?> COP</span></p>
                                <p>Total: <span id="total"><?php echo number_format($cotizacion->total_con_descuento);  ?> COP</span></p>
                            </div>
                            <button type="submit" class="submit-quote-btn">Solicitar Cotización</button>
                        </div>
                    </form>
                </section>
    
            </main>
        </div>
        
    </div>
    <div id="modaRegistro"></div>
    <div id="footer"></div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/cotizacion.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
