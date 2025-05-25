<?php
include "../db-con.php";
require "../products.php";
$database = new Database();

$productos = Product::list($database);

$show_new = $_SERVER['SCRIPT_NAME']; 
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
    <?php require "../shared/components/header.php"; ?>
    <div id="load-adminProductos">
        <div class="main">
            <main class="content pt-5 pb-5">
                <div class="d-flex justify-content-between align-items-center mb-4"> 
                    <h4 class="fw-bold pe-3">Tabla productos</h4>
                    <button type="button" class="btn btn-dark px-4 py-2" data-bs-toggle="modal" data-bs-target="#createProduct">Crear</button>
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Descipcion</th>
                        <th scope="col">Aciones</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($productos as $producto) {
                        ?>
                      <tr>
                        <td scope="row"><?php echo $producto->id_producto;  ?></td>
                        <td><img src="../<?php echo $producto->imagen;  ?>" width="50px" alt="tornillodeacero"></td>
                        <td><?php echo $producto->nombre_producto;  ?></td>
                        <td><?php echo $producto->descripcion;  ?></td>
                        <td>$<?php echo number_format($producto->precio);  ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <form action="../upload_product.php" method="post" class="popup-form">
                                <input type="hidden" name="tipo_ejecucion" value="eliminar">
                                <input type="hidden" name="id" value="<?php echo $producto->id_producto;  ?>">
                                <div class="d-flex flex-column justify-content-center align-items-center text-danger">
                                    <button class="btn-none" type="submit">
                                        <i class="fa-solid fa-trash fs-6"></i>
                                        <p class="fs-7 text-center">Eliminar</p>
                                    </button>
                                </div>
                                </form>
                            </div>
                        </td>
                      </tr>
                      <?php
                        }
                        ?>

                    </tbody>
                  </table>
            </main>
        </div>
    </div>
    <div class="modal fade" id="createProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"><h2 class="popup-title">Crear producto</h2>
            <form action="../upload_product.php" method="post" class="popup-form" enctype="multipart/form-data">
                <input type="hidden" name="tipo_ejecucion" value="crear">
                <input type="file" id="file" name="myImage" accept="image/png, image/gif, image/jpeg" hidden class="d-none">
                <input type="text" placeholder="Imagen" id="imagen" name="imagen" required readonly onclick="document.getElementById('file').click()">
                <input type="text" placeholder="Nombre" id="nombre_producto" name="nombre_producto" required>
                <input type="number" placeholder="Precio" id="precio" name="precio" required>
                <textarea placeholder="Descripcion" id="descripcion" name="descripcion" rows="5" require></textarea>
                <br>
                <button type="submit">Crear</button>
            </form> 
      </div>
    </div>
  </div>
</div>
    <div id="modaRegistro"></div>
    <div id="footer"></div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/adminProductos.js"></script>
    <script src="../js/main.js"></script>

      
<script>
  // Obtén las referencias a los elementos
  const fileInput = document.getElementById('file');
  const textInput = document.getElementById('imagen');

  // Escucha el evento de cambio en el input de archivo
  fileInput.addEventListener('change', function() {
    // Verifica si se ha seleccionado un archivo
    if (fileInput.files.length > 0) {
      // Obtén el nombre del archivo seleccionado y lo asigna al input de texto
      textInput.value = fileInput.files[0].name;
    }
  });
</script>
</body>
</html>
