<?php
class Database {
    private $host = 'localhost:3306';
    private $db_name = 'hardware_store';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }
    }

     // Create
     public function create($tabla, $datos) {
        $cols = implode(", ", array_keys($datos));
        $vals = ":" . implode(", :", array_keys($datos));
        $sql = "INSERT INTO $tabla ($cols) VALUES ($vals)";
        $stmt = $this->conn->prepare($sql);
        
        foreach ($datos as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Read
    public function read($tabla, $cond = '') {
        $sql = "SELECT * FROM $tabla $cond";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Update
    public function update($tabla, $datos, $cond) {
        $campos = [];
        foreach ($datos as $key => $val) {
            $campos[] = "$key = :$key";
        }
        $set = implode(', ', $campos);
        $sql = "UPDATE $tabla SET $set WHERE $cond";
        $stmt = $this->conn->prepare($sql);

        foreach ($datos as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete
    public function delete($tabla, $cond) {
        $sql = "DELETE FROM $tabla WHERE $cond";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
}
