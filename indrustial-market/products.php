<?php

class Product
{
    public $id_producto;
    public $nombre_producto;
    public $descripcion;
    public $precio;
    public $imagen;
    private static $tabla = "producto";

    public function __construct(
        $nombre_producto,
        $descripcion,
        $precio,
        $imagen,
    )
    {
        $this->nombre_producto=$nombre_producto;
        $this->descripcion=$descripcion;
        $this->precio=$precio;
        $this->imagen=$imagen;
    }

    // Setters
    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function setNombreProducto($nombre_producto) {
        $this->nombre_producto = $nombre_producto;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public static function create(
        Product $producto,
        Database $db
    ) {

        $datos = [
            'nombre_producto' => $producto->nombre_producto,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'imagen' => $producto->imagen
        ];

        $db->create(self::$tabla, $datos);

    }

    public static function list(
        Database $db
    ) {
        $list = $db->read(self::$tabla);

        $product_list = array();
        foreach($list as $item) { 
            $producto = new Product("","","","");
            foreach($item as $property => $value) { 
                $producto->$property = $value; 
            } 
            array_push($product_list, $producto);
        }
        return $product_list;
    }

    public static function get(
        Database $db,
        $id
    ) {
        $producto = new Product("","","","");
        $objecto = $db->read(self::$tabla, "WHERE id_producto = $id")[0];
        foreach($objecto as $property => $value) { 
            $producto->$property = $value; 
        } 
        return $producto;
    }

    public static function update(
        Product $producto,
        Database $db
    ) {
        $id = $producto->id_producto;

        $datos = [
            'nombre_producto' => $producto->nombre_producto,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'imagen' => $producto->imagen
        ];

        $db->update(self::$tabla, $datos, "id_producto = $id");
    }

    public static function delete(
        Database $db,
        $id
    ) {
        return $db->delete(self::$tabla, "id_producto = $id");
    }
}
