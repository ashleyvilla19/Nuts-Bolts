<?php
include "../db-con.php";
require "../client.php";
$database = new Database();
$clientes = Cliente::list($database);
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
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
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
                    <h4 class="fw-bold pe-3">Tabla Usuarios</h4>
                    <button type="button" class="btn btn-dark px-4 py-2" onclick="openEditModal('crear', [])">Crear</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">tipo cliente</th>
                            <th scope="col">Aciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($clientes as $cliente) {
                        ?>
                            <tr>
                                <td scope="row"><?php echo $cliente->id_usuario;  ?></td>
                                <td><?php echo $cliente->nombre;  ?></td>
                                <td><?php echo $cliente->apellidos;  ?></td>
                                <td><?php echo $cliente->email;  ?></td>
                                <td><?php echo $cliente->tipo_cliente_nombre;  ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex flex-column justify-content-center align-items-center text-black">
                                            <button class="btn-none" type="button" onclick="openEditModal('actualizar', ['<?php echo  $cliente->nombre; ?>', '<?php echo  $cliente->apellidos; ?>', '<?php echo  $cliente->email; ?>', '<?php echo  $cliente->tipo_cliente; ?>', '<?php echo  $cliente->id_usuario; ?>'])">
                                                <i class="fa-solid fa-pen-to-square fs-6"></i>
                                                <p class="fs-7 text-center">Editar</p>
                                            </button>
                                        </div>
                                        <form action="../upload_client.php" method="post" class="popup-form">
                                            <input type="hidden" name="tipo_ejecucion" value="eliminar">
                                            <input type="hidden" name="id" value="<?php echo $cliente->id_usuario;  ?>">
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
        
<div class="modal fade" id="createUser" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"><h2 class="popup-title">Registro</h2>
            <form action="../upload_client.php" method="post" class="popup-form">
                <input type="hidden" id="tipo_ejecucion" name="tipo_ejecucion">
                <input type="hidden" id="id_usuario" name="id_usuario">
                <input type="text" placeholder="Nombre" id="nombre" name="nombre" required value="">
                <input type="text" placeholder="Apellidos" id="apellidos" name="apellidos" required>
                <input type="email" placeholder="Email" id="email" name="email" required>
                <label for="role">Tipo Cliente:</label>
                <select class="product-select" id="tipo_cliente" name="tipo_cliente" required>
                    <option value="0" selected>seleccione un tipo cliente</option>
                    <option value="4">Nuevo</option>
                    <option value="1">Permanente</option>
                    <option value="2">Periódico</option>
                    <option value="3">Casual</option>
                </select><br>
                <button type="submit">Registrarse</button>
            </form> 
      </div>
    </div>
  </div>
</div>
    <div id="modaRegistro"></div>
    <div id="footer"></div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/adminUsuarios.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>

