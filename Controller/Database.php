<?php 
class Database {
    private $hostName,$username,$password,$databaseName,$conn;

    public function __construct()
    {
        $this->hostName = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->databaseName = "spp_payment";
        $this->connect();
    }

    public function connect() {
        // Koneksi database
        $this->conn = new mysqli($this->hostName, $this->username, $this->password, $this->databaseName);

        // jika koneksi gagal maka
        if($this->conn->connect_error) {
            die("Koneksi gagal : {$this->conn->connect_error}");
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}