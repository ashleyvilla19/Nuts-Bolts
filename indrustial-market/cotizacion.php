<?php

class Cotizacion
{
    public $id_cotizacion;
    public $id_usuario;
    public $fecha_cotizacion;
    public $total = 0;
    public $descuento_aplicado = 0;
    public $total_con_descuento = 0;

    private static $tabla_usuario = "usuario";
    private static $tabla_cotizacion = "cotizacion";
    private static $tabla_detalle_cotizacion = "detalle_cotizacion";

    public function __construct(
        $id_usuario
    )
    {
        $this->id_usuario=$id_usuario;
    }

    public static function crear_cotizacion(
        Cliente $cliente,
        Cotizacion $cotizacion,
        Database $db
    ) {

        $datos = [
            'id_usuario' => $cliente->id_usuario,
            'total' => $cotizacion->total,
            'descuento_aplicado' => $cotizacion->descuento_aplicado,
            'total_con_descuento' => $cotizacion->total_con_descuento,
            'fecha_cotizacion' => date("Y-m-d H:i:s", time())
        ];

        return $db->create(self::$tabla_cotizacion, $datos);
    }

    public static function get(
        Database $db,
        $id
    ) {
        $cotizacion = new Cotizacion("");
        $objecto = $db->read(self::$tabla_cotizacion, "WHERE id_cotizacion = $id")[0];
        foreach($objecto as $property => $value) { 
            $cotizacion->$property = $value; 
        } 
        return $cotizacion;
    }

    public static function actualizar_total(
        Cotizacion $cotizacion,
        Database $db
    ) {
        $descuentos = [
            1 => 10,
            2 => 5,
            3 => 2,
            4 => 0,
        ];

        $product_list = $db->read(self::$tabla_detalle_cotizacion, "WHERE id_cotizacion = $cotizacion->id_cotizacion");
        $cliente =  $db->read(self::$tabla_usuario, "WHERE id_usuario = $cotizacion->id_usuario")[0];
        $total = 0;
        
        foreach ($product_list as $item) {
            $total += $item->subtotal;
        }
        $descuento_adicional = 0;
        if ($total > 100000){
            $descuento_adicional = 2;
        }

        $descuento_aplicado = $total * (($descuentos[$cliente->tipo_cliente] + $descuento_adicional) / 100) ;

        $total_con_descuento = $total - $descuento_aplicado;

        $datos = [
            'total' => $total,
            'descuento_aplicado' => $descuento_aplicado,
            'total_con_descuento' => $total_con_descuento
        ];

        $db->update(self::$tabla_cotizacion, $datos, "id_cotizacion = $cotizacion->id_cotizacion");
    }

}

class DetalleCotizacion
{
    public $id_detalle;
    public $id_cotizacion;
    public $id_producto;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;

    private static $tabla_detalle_cotizacion = "detalle_cotizacion";

    public function __construct(
        $id_producto,
        $cantidad,
        $precio_unitario,
        $subtotal,
    )
    {
        $this->id_producto=$id_producto;
        $this->cantidad=$cantidad;
        $this->precio_unitario=$precio_unitario;
        $this->subtotal=$subtotal;
    }

    public static function agregar_producto(
        DetalleCotizacion $detalle_cotizacion,
        Cotizacion $cotizacion,
        Database $db
    ) {

        $datos = [
            'id_cotizacion' => $cotizacion->id_cotizacion,
            'id_producto' => $detalle_cotizacion->id_producto,
            'cantidad' => $detalle_cotizacion->cantidad,
            'precio_unitario' => $detalle_cotizacion->precio_unitario,
            'subtotal' => $detalle_cotizacion->subtotal
        ];

        $db->create(self::$tabla_detalle_cotizacion, $datos);
        
        Cotizacion::actualizar_total($cotizacion, $db);
    }

    public static function list(
        Database $db,
        $id_cotizacion
    ) {
        $list = $db->read(self::$tabla_detalle_cotizacion, "WHERE id_cotizacion = $id_cotizacion");
        $products_list = array();

        foreach($list as $item) { 
            $cliente = new DetalleCotizacion("","","","");

            foreach($item as $property => $value) { 
                $cliente->$property = $value; 
            }

            array_push($products_list, $cliente);
        }

        return $products_list;
    }
}