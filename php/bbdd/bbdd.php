<?php

class BBDD {

    private $nombre_bbdd;
    private $server;
    private $usuario;
    private $contrasena;
    public $conn;

    function __construct($nombre_bbdd = "mysql", $server = "localhost", $usuario = "root", $contrasena = "") {
        $this->nombre_bbdd = $nombre_bbdd;
        $this->server = $server;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->establecerConn();
    }

    function establecerConn() {
        try {
            $this->conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->nombre_bbdd, 
                $this->usuario, 
                $this->contrasena);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "ERROR: " . $e->getMessage() . ".<br/>";
        }
    }

    function cambiarConn($nombre_bbdd, $server = "localhost", $usuario = "root", $contrasena = "") {
        $this->nombre_bbdd = $nombre_bbdd;
        $this->server = $server;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->establecerConn();
    }

    function cerrarConn() {
        $sth = null;
        $this->conn = null;
    }

    function crearTablas() {
        $this->conn->exec("
            USE $this->nombre_bbdd;
            CREATE TABLE IF NOT EXISTS clientes(
                dni VARCHAR(9) PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                direccion VARCHAR(50),
                localidad VARCHAR(30),
                provincia VARCHAR(30),
                telefono VARCHAR(9),
                email VARCHAR(30) NOT NULL
            )ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;
        ");
    }

    function borrarTablas() {
        $this->conn->exec("
            DELETE FROM $this->nombre_bbdd;
        ");
    }

    function count($table, $where = "") {
        $result = 0;
        if(!empty($this->conn)) {
            foreach($this->conn->query("SELECT COUNT(1) from $table $where") as $row) {
                $result = $row[0];
            } 
            return $result;  
        }
        throw new Exception('Conexión con BBDD no establecida.');
    }

}

?>