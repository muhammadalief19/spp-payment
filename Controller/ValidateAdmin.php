<?php 
require_once "Database.php";
$db = new Database;
$conn = $db->getConnection();

class ValidateAdmin {
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

    public function checkFoto($files) {
        $namaFile = $files["foto_profile"]["name"];
        $ukuranFile = $files["foto_profile"]["size"];
        $error = $files["foto_profile"]["error"];
    
    
        // cek apakah ada gambar yang diupload 
        if ($error === 4) {
            $this->addError("image","upload gambar terlebih dahulu");
            return false;
        }
    
        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = array('jpg', 'jpeg', 'png', 'webp');
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            $this->addError("image","file yang anda upload bukan gambar");
            return false;
        }
    
        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            $this->addError("image","ukuran gambar terlalu besar");
            return false;
        }
        
        return true;
    }

    public function checkPassword($password) {
        if(empty($password)) {
            $this->addError('password', 'password wajib diisi');
            return false;
        } elseif(strlen($password) < 8) {
            $this->addError('password', 'password harus berisi minimal 8 karakter');
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