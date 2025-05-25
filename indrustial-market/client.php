<?php

class Cliente
{
    public $id_usuario;
    public $nombre;
    public $apellidos;
    public $email;
    public $tipo_cliente;
    public $tipo_cliente_nombre;
    public $fecha_registro;
    private static $tabla = "usuario";
    private static $tabla_tipo_cliente = "tipo_cliente";

    public function __construct(
        $nombre,
        $apellidos,
        $email,
        $tipo_cliente,
    )
    {
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->email=$email;
        $this->tipo_cliente=$tipo_cliente;
    }

    // Setters
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTipoCliente($tipo_cliente) {
        $this->tipo_cliente = $tipo_cliente;
    }

    public static function create(
        Cliente $cliente,
        Database $db
    ) {

        $datos = [
            'nombre' => $cliente->nombre,
            'apellidos' => $cliente->apellidos,
            'email' => $cliente->email,
            'tipo_cliente' => $cliente->tipo_cliente,
            'fecha_registro' => date("Y-m-d H:i:s", time())
        ];

        $db->create(self::$tabla, $datos);

    }

    public static function list(
        Database $db
    ) {
        $list = $db->read(self::$tabla);
        $client_list = array();

        foreach($list as $item) { 
            $cliente = new Cliente("","","","");
            foreach($item as $property => $value) { 
                $cliente->$property = $value; 
            }

            $tipo_cliente = $db->read(self::$tabla_tipo_cliente, "WHERE id_tipo_cliente = $cliente->tipo_cliente");
            $cliente->tipo_cliente_nombre = $tipo_cliente[0]->nombre;
            array_push($client_list, $cliente);
        }

        return $client_list;
    }

    public static function get(
        Database $db,
        $id
    ) {
        $cliente = new Cliente("","","","");
        $objecto = $db->read(self::$tabla, "WHERE id_usuario = $id")[0];
        foreach($objecto as $property => $value) { 
            $cliente->$property = $value; 
        } 
        return $cliente;
    }

    public static function update(
        Cliente $cliente,
        Database $db
    ) {
        $id = $cliente->id_usuario;
        $datos = [
            'nombre' => $cliente->nombre,
            'apellidos' => $cliente->apellidos,
            'email' => $cliente->email,
            'tipo_cliente' => $cliente->tipo_cliente,
        ];

        $db->update(self::$tabla, $datos, "id_usuario = $id");
    }

    public static function delete(
        Database $db,
        $id
    ) {
        return $db->delete(self::$tabla, "id_usuario = $id");
    }
}
