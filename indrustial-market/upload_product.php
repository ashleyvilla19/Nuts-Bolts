<?php
include "db-con.php";
require "products.php";

$database = new Database();
$target_dir = "./uploads_img/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_ejecucion = $_POST['tipo_ejecucion'];

    switch ($tipo_ejecucion) {
        case 'crear':

            $target_file = $target_dir . rand(0, 100) . basename($_FILES["myImage"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is an actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["myImage"]["tmp_name"]);

                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["myImage"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["myImage"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["myImage"]["name"])) . " has been uploaded.";

                    $product = new Product($_POST['nombre_producto'], $_POST['descripcion'], $_POST['precio'], $target_file);
                    Product::create($product, $database);
                    
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            break;
        case 'eliminar':
            Product::delete($database, $_POST['id']);
            break;
        default:
            echo "No escogiste nada";
            exit();
            break;
    }
}

header("Location: /indrustial-market/view/adminProductos.php");
exit();