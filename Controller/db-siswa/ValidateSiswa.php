<?php
$db = new Database;
$connection = $db->getConnection();
class ValidateSiswa {
    private $error = [];
    public function checkNisn($nisn) {
        global $connection;
        $query = $connection->query("SELECT * FROM siswa WHERE nisn='$nisn'");
        $result = $query->num_rows;
        if(empty($nisn)) {
            $this->addError('nisn', 'nisn wajib diisi');
            return false;
        } else if($result > 0) {
            $this->addError('nisn', 'nisn tidak tersedia');
            return false;
        }
        return true;
    }

    public function checkPassword($password) {
        if(empty($password)) {
            $this->addError('password', 'password wajib diisi');
            return false;
        } else if(strlen($password) > 8) {
            $this->addError('password', 'panjang password minimal 8 karakter');
        }
        return true;
    }

    public function checkAlamat($alamat) {
        if(empty($alamat)) {
            $this->addError('alamat', 'alamat wajib diisi');
            return false;
        }

        return true;
    }

    public function checkNoTelp($no_telp) {
        if(empty($no_telp)) {
            $this->addError('no_telp', 'nomor telpon wajib diisi');
            return false;
        }

        return true;
    }

    public function checkKelas($kelas) {
        if(empty($kelas)) {
            $this->addError('kelas', 'kelas wajib diisi');
            return false;
        }

        return true;
    }

    public function checkNama($nama) {
        if(empty($nama)) {
            $this->addError('nama', 'nama wajib diisi');
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
            $this->addError("foto_profile","upload gambar terlebih dahulu");
            return false;
        }
    
        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = array('jpg', 'jpeg', 'png', 'webp');
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            $this->addError("foto_profile","file yang anda upload bukan gambar");
            return false;
        }
    
        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            $this->addError("foto_profile","ukuran gambar terlalu besar");
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

?>