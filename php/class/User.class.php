<?php

require_once('db/db.class.php');

class User {

    // Permission Levels
    const USER = 0;
    const EMPLOYMENT = 1;
    const ADMIN = 5;

    private $id;
    private $firstName;
    private $firstLastName;
    private $secondLastName;
    private $document;
    private $phone1;
    private $phone2;
    private $address;
    private $location;
    private $province;
    private $country;
    private $email;
    private $password;
    private $rol;
    private $isActive;

    function __construct($firstName, $firstLastName, $secondLastName, $document, $phone1, $phone2, $address, $location, $province, $country, $email, $password, $rol, $isActive) {
        $this->firstName = $firstName;
        $this->firstLastName = $firstLastName;
        $this->secondLastName = $secondLastName;
        $this->document = $document;
        $this->phone1 = $phone1;
        $this->phone2 = $phone2;
        $this->address = $address;
        $this->location = $location;
        $this->province = $province;
        $this->country = $country;
        $this->email = $email;
        $this->setEncryptPassword($password);
        $this->rol = $rol;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstLastName($firstLastName) {
        $this->firstLastName = $firstLastName;
    }

    public function getFirstLastName() {
        return $this->firstLastName;
    }

    public function setSecondLastName($secondLastName) {
        $this->secondLastName = $secondLastName;
    }

    public function getSecondLastName() {
        return $this->secondLastName;
    }

    public function setDocument($document) {
        $this->document = $document;
    }

    public function getDocument() {
        return $this->document;
    }

    public function setPhone1($phone1) {
        $this->phone1 = $phone1;
    }

    public function getPhone1() {
        return $this->phone1;
    }

    public function setPhone2($phone2) {
        $this->phone2 = $phone2;
    }

    public function getPhone2() {
        return $this->phone2;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setProvince($province) {
        $this->province = $province;
    }

    public function getProvince() {
        return $this->province;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEncryptPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setActive($isActive) {
        $this->isActive = $isActive;
    }

    public function isActive() {
        return $this->isActive;
    }

    static function getAll($condition = "", $orderBy = "id DESC") {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from USERS $condition ORDER BY $orderBy");
            $stmt->execute();
            $records = $stmt->fetchAll();
        }

        $objects = [];
        foreach ($records as $index => $r) {
            $object = new User($r['firstname'], $r['first_lastname'], $r['second_lastname'], $r['document'], 
                    $r['phone1'], $r['phone2'], $r['address'], $r['location'], $r['province'], $r['country'], 
                    $r['email'], $r['password'], $r['rol'], $r['is_active']);
            $object->id = $r['id'];
            array_push($objects, $object);
        }

        $db->cerrarConn();
        return $objects;
    }

    static function getById($id) {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * FROM USERS WHERE id = :id");
            $stmt->execute(array(
                ':id' => $id
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
            if($records) {
                $r = $records[0];
                $object = new User($r['firstname'], $r['first_lastname'], $r['second_lastname'], $r['document'], 
                    $r['phone1'], $r['phone2'], $r['address'], $r['location'], $r['province'], $r['country'], 
                    $r['email'], $r['password'], $r['rol'], $r['is_active']);
                $object->id = $id;
                return $object;
            } else {
                return null;
            }
        }
        $db->cerrarConn();
        return $records;
    }

    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO USERS(firstname, first_lastname, second_lastname, document, phone1, phone2, address, location, province, country, email, password, rol, is_active) VALUES
                (:firstName, :firstLastName, :secondLastName, :document, :phone1, :phone2, :address, :location, :province, :country, :email, :password, :rol, :isActive)"
            );
    
            $stmt->execute(array(
                ':firstName' => $this->firstName,
                ':firstLastName' => $this->firstLastName,
                ':secondLastName' => $this->secondLastName,
                ':document' => $this->document,
                ':phone1' => $this->phone1,
                ':phone2' => $this->phone2,
                ':address' => $this->address,
                ':location' => $this->location,
                ':province' => $this->province,
                ':country' => $this->country,
                ':email' => $this->email,
                ':password' => $this->password,
                ':rol' => $this->rol,
                ':isActive' => $this->isActive
            ));
        }
        
        $db->cerrarConn();
    }

    function update() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "UPDATE USERS 
                SET firstname = :firstName, first_lastname = :firstLastName, second_lastname = :secondLastName, document = :document, phone1 = :phone1, phone2 = :phone2,
                address = :address, location = :location, province = :province, country = :country, email = :email, password = :password, rol = :rol, is_active = :isActive
                WHERE id LIKE :id"
            );
    
            $stmt->execute(array(
                ':id' => $this->id,
                ':firstName' => $this->firstName,
                ':firstLastName' => $this->firstLastName,
                ':secondLastName' => $this->secondLastName,
                ':document' => $this->document,
                ':phone1' => $this->phone1,
                ':phone2' => $this->phone2,
                ':address' => $this->address,
                ':location' => $this->location,
                ':province' => $this->province,
                ':country' => $this->country,
                ':email' => $this->email,
                ':password' => $this->password,
                ':rol' => $this->rol,
                ':isActive' => $this->isActive
            ));
        }

        $db->cerrarConn();
    }

    static function delete($id) {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "DELETE FROM USERS WHERE id LIKE :id"
            );
    
            $stmt->execute(array(
                ':id' => $id
            ));
        }

        $db->cerrarConn();
    }

    static function getByEmail($email) {
        $model = null;
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "SELECT * FROM USERS WHERE email LIKE :email"
            );
    
            $stmt->execute(array(':email' => $email));

            $record = $stmt->fetch();

            if($record) {
                $model = new User("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
                $model->id = $record['id'];
                $model->firstName = $record['firstname'];
                $model->firstLastName = $record['first_lastname'];
                $model->secondLastName = $record['second_lastname'];
                $model->document = $record['document'];
                $model->phone1 = $record['phone1'];
                $model->phone2 = $record['phone2'];
                $model->address = $record['address'];
                $model->location = $record['location'];
                $model->province = $record['province'];
                $model->country = $record['country'];
                $model->email = $record['email'];
                $model->password = $record['password'];
                $model->rol = $record['rol'];
                $model->isActive = $record['is_active'];
            }
        }

        $db->cerrarConn();

        return $model;
    }

    static function getUserSession() {
        if(session_id() == '') {
            session_start();
        }

        $user = null;
        if(isset($_SESSION["current_session"])) {
            $current_session = $_SESSION["current_session"];
            $user = User::getById($current_session["id"]);
        }

        return $user;
    }

    static function isUnlogged() {
        $result = false;
        if(!isset($_SESSION["current_session"])) {
            $result = true;
        }
        return $result;
    }

    static function isUser() {
        $result = false;
        if(isset($_SESSION["current_session"])) {
            $result = $_SESSION["current_session"]['rol'] == User::USER;
        }
        return $result;
    }

    static function isEmployment() {
        $result = false;
        if(isset($_SESSION["current_session"])) {
            $result = $_SESSION["current_session"]['rol'] == User::EMPLOYMENT;
        }
        return $result;
    }

    static function isAdmin() {
        $result = false;
        if(isset($_SESSION["current_session"])) {
            $result = $_SESSION["current_session"]['rol'] == User::ADMIN;
        }
        return $result;
    }

    static function getLevel() {
        if(isset($_SESSION["current_session"])) {
            return $_SESSION["current_session"]['rol'];
        }
    }

}

?>