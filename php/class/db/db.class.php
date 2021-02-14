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
            //000WebHost
            /*$this->db_name = "id15747557_frandiab_dwes";
            $this->user = "id15747557_root";
            $this->password = "xe8ItQ/V4\GJ-6f[";*/

            // GoogieHost
            $this->db_name = "frandiab_dwes";
            $this->user = "frandiab_dwes";
            $this->password = "7)1cZ8fpbAYu";
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

    static function query($select, $table, $condition = "") {
        $result = 0;
        $db = new DB();
        $stmt = $db->conn->prepare("SELECT $select from $table $condition");
        $stmt->execute();
        $records = $stmt->fetchAll();
        return $records;
    }

    static function count($table, $condition = "") {
        $result = 0;
        $db = new DB();
        $stmt = $db->conn->prepare("SELECT COUNT(1) from $table $condition");
        $stmt->execute();
        $records = $stmt->fetchAll();
        return $records[0][0];
    }

    function isLocal() {
        return $_SERVER['REMOTE_ADDR'] === "::1" || $_SERVER['REMOTE_ADDR'] === "127.0.0.1" || $_SERVER['REMOTE_ADDR'] === "localhost";
    }

}

?>