<?php 
require_once "Database.php";
$db = new Database;
$conn = $db->getConnection();

class ValidatePetugas {
    private $error = [];

    public function checkNamaPetugas($name) {
        if(empty($name)) {
            $this->addError('nama', 'masukkan nama terlebih dahulu');
            return false;
        }
        return true;
    }
    
    public function checkEmailPetugas($email) {
        global $conn;
        $result = $conn->query("SELECT * FROM petugas WHERE email='$email' limit 1");
        $count = $result->num_rows;
        if(empty($email)) {
            $this->addError("email",'masukkan email terlebih dahulu');
            return false;
        } elseif($count > 0) {
            $this->addError("email",'email tidak tersedia');
            return false;
        } 
        return true;
    }

    public function checkEmailPetugasLogin($email) {
        if(empty($email)) {
            $this->addError("email",'masukkan email terlebih dahulu');
            return false;
        }
        return true;
    }


    public function addError($index, $value){
        $this->error[$index] = $value;
    }

    public function getError() {
        return $this->error;
    }
}