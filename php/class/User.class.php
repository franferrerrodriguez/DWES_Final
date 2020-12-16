<?php

require_once('db/db.class.php');

class User {

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

    function __construct($firstName, $firstLastName, $secondLastName, $document, $phone1, $phone2, $address, $location, $province, $country, $email, $password, $rol) {
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
        $this->password = $password;
        $this->rol = $rol;
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

    public function getPassword() {
        return $this->password;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function getRol() {
        return $this->rol;
    }

    static function getAll() {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from USERS;");
                $stmt->execute();
                $records = $stmt->fetchAll();
            }
            $db->cerrarConn();
            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function getByEmail($email) {
        try {
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
                }
            }

            $db->cerrarConn();

            return $model;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function save() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "INSERT INTO USERS(firstname, first_lastname, second_lastname, document, phone1, phone2, address, location, province, country, email, rol) VALUES
                    (:firstName, :firstLastName, :secondLastName, :document, :phone1, :phone2, :address, :location, :province, :country, :email, :rol);"
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
                    ':rol' => $this->rol
                ));
            }
            
            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function update() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "UPDATE USERS 
                    SET firstname = :firstName, first_lastname = :firstLastName, second_lastname = :secondLastName, phone1 = :phone1, phone2 = :phone2,
                    address = :address, location = :location, province = :province, country = :country, email = :email, password = :password, rol = :rol
                    WHERE document LIKE :document"
                );
        
                $stmt->execute(array(
                    ':firstName' => $this->firstName,
                    ':firstLastName' => $this->firstLastName,
                    ':secondLastName' => $this->secondLastName,
                    ':phone1' => $this->phone1,
                    ':phone2' => $this->phone2,
                    ':address' => $this->address,
                    ':location' => $this->location,
                    ':province' => $this->province,
                    ':country' => $this->country,
                    ':email' => $this->email,
                    ':password' => $this->password,
                    ':rol' => $this->rol
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function delete() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM USERS WHERE email LIKE :email"
                );
        
                $stmt->execute(array(
                    ':email' => $this->email
                ));
            }

            $bbdd->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

}

?>