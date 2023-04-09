<?php 
require_once"Database.php";
require_once"ValidateAdmin.php";
$db = new Database;
$connect = $db->getConnection();
class AdminController extends ValidateAdmin { 

    public function loginPetugas($data){
        global $connect;
        $email = htmlspecialchars($data["email"]);
        $password = htmlspecialchars($data["password"]);
        
        // validasi
        $checkEmail = $this->checkEmailPetugasLogin($email);
        if(!$checkEmail){
            return false;
        }
        $query = $connect->query("SELECT * FROM petugas WHERE email='$email'");
        if($query->num_rows === 1) {
            // cek apakah password yang diinputkan itu benar
            $user = $query->fetch_assoc();
            if(password_verify($password, $user["password"])){
                $_SESSION["login"] = true;
                $_SESSION["id"] = $user["id"];
                $_SESSION["nama"] = $user["nama"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["foto_profile"] = $user["foto_profile"];
                return $query->num_rows;
            } else {
            $this->addError('login', 'username/password salah');
            }
        } else {
            $this->addError('login', 'username/password salah');
        }

    }

    public function registrasiAdmin($data){
        global $connect;
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $password = password_hash(htmlspecialchars($data["password"]), PASSWORD_DEFAULT);
        $role = htmlspecialchars($data["role"]);
        
        // validasi
        $checkEmail = $this->checkEmailPetugas($email);
        $checkNama = $this->checkNamaPetugas($nama);
        $checkFoto = $this->checkFoto($_FILES);
        $checkPassword = $this->checkPassword($data["password"]);
        
        // proses validasi
        if(!$checkFoto || !$checkEmail || !$checkNama || !$checkPassword) {
            return false;
        }
        
        $foto_profile = $this->upload_foto_profile($_FILES);

        // query register
        $query = "INSERT INTO petugas (nama,email,password,role,foto_profile) VALUES ('$nama','$email','$password','$role','$foto_profile')"; 
        $connect->query($query);

        return $connect->affected_rows;
    }

    // function auth petugas
    public function authPetugas($session) {
        return $session;
    }

        // function upload foto profile
        public function upload_foto_profile($files) {
            $namaFile = $files["foto_profile"]["name"];
            $ukuranFile = $files["foto_profile"]["size"];
            $error = $files["foto_profile"]["error"];
            $tmpName = $files["foto_profile"]["tmp_name"];
        
        
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
        
            // lolos pengecekan, gambar siap diupload
    
            // generate nama gambar baru
            $namaFileBaru = uniqid();
            $namaFileBaru .= '.';
            $namaFileBaru .= $ekstensiGambar;
        
            move_uploaded_file($tmpName,'../../public/assets/foto-profile/'.$namaFileBaru);
        
            return $namaFileBaru;
        }

        public function logout($location) {
        session_destroy();
        header("Location: {$location}");
        }
}