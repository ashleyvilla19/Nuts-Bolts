<?php
include "../db-con.php";
require "../client.php";
$database = new Database();
$clientes = Cliente::list($database);
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
                <h4 class="text-center mt-5 mb-4 fw-bold">Nueva cotización</h4>
                <section class="quote-section" id="quote">
                    <form id="quote-form" class="quote-form" method="post" action="../crear_cotizacion.php">
                    <input type="hidden" name="tipo_ejecucion" value="crear_cotizado">
                        <div class="product-selection">
                            <div id="products-container">
                                <div class="product-entry">
                                    <select class="product-select" id="cliente" name="cliente" required>
                                        <option value="">Seleccione un Cliente</option>
                                        <?php
                                        foreach ($clientes as $cliente) {
                                        ?>
                                        <option value="<?php echo $cliente->id_usuario;  ?>"><?php echo $cliente->nombre;  ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="add-product-btn">Cotizar</button>
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
