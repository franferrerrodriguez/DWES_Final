<?php

class DB {

    private $db_name;
    private $server;
    private $user;
    private $password;
    public $conn;

    function __construct($db_name = "frandiab_dwes", $password = "", $server = "localhost", $user = "root") {
        $this->db_name = $db_name;
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;

        // MOCK
        if($this->isLocal()) {
            $this->user = "root";
            $this->password = "";
        } else {
            $this->db_name = "id15747557_frandiab_dwes";
            $this->user = "id15747557_root";
            $this->password = "xe8ItQ/V4\GJ-6f[";

            //$this->user = "frandiab_dwes";
            //$this->password = "7)1cZ8fpbAYu";
        }

        $this->establecerConn();
    }

    function establecerConn() {
        try {
            $this->conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->db_name, $this->user, $this->password, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "ERROR: " . $e->getMessage() . "<br/>";
        }
    }

    function cambiarConn($db_name, $server = "localhost", $user = "root", $password = "") {
        $this->db_name = $db_name;
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->establecerConn();
    }

    function cerrarConn() {
        $sth = null;
        $this->conn = null;
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

    function isLocal() {
        return $_SERVER['REMOTE_ADDR'] === "::1" || $_SERVER['REMOTE_ADDR'] === "127.0.0.1" || $_SERVER['REMOTE_ADDR'] === "localhost";
    }

}

?>