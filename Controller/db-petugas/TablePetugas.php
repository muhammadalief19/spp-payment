<?php 
require_once"ValidatePetugas.php";
class TablePetugas extends ValidatePetugas {
    private $db,$connection;

    public function __construct()
    {
        $this->db = new Database;
        $this->connection = $this->db->getConnection();
    }

    public function listPetugas($start, $limit) {
        $query = "SELECT * FROM petugas limit $start, $limit";
        $result = $this->connection->query($query);
        $petugas = [];

        while($data = $result->fetch_assoc()) {
            $petugas[] = $data;
        }

        return $petugas;
    }

    public function listPetugasAll() {
        $query = "SELECT * FROM petugas";
        $result = $this->connection->query($query);
        $petugas = [];

        while($data = $result->fetch_assoc()) {
            $petugas[] = $data;
        }

        return $petugas;
    }

    public function deletePetugas($id,$img) {
        $query = "DELETE FROM petugas WHERE id_petugas=$id";
        unlink("../../../public/assets/foto-profile/{$img}");
        $this->connection->query($query);
        return $this->connection->affected_rows;
    }

    public function createPetugas($data) {
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $password = password_hash(htmlspecialchars($data["password"]), PASSWORD_DEFAULT);
        $role = htmlspecialchars($data["role"]);
        
        // validasi
        $checkNama = $this->checkNama($nama);
        $checkEmail = $this->checkEmail($email);
        $checkPassword = $this->checkPassword($data["password"]);
        $checkFoto = $this->checkFoto($_FILES);
        $checkRole = $this->checkRole($role);

        // pengecekan
        if(!$checkNama || !$checkEmail || !$checkPassword || !$checkRole || !$checkFoto) {
            return false;
        }

        $foto_profile = $this->upload_foto_profile($_FILES);

        // query crate
        $query = "INSERT INTO petugas (nama,email,password,role,foto_profile) VALUES ('$nama','$email','$password','$role','$foto_profile')"; 
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }

    public function updatePetugas($data,$id) {
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $role = htmlspecialchars($data["role"]);
        $foto_lama = htmlspecialchars($data["foto_lama"]);

        // validasi
        $checkNama = $this->checkNama($nama);
        $checkEmail = $this->checkEmail($email);
        $checkFoto = $this->checkFoto($_FILES);
        $checkRole = $this->checkRole($role);

        // pengecekan
        if($_FILES["foto_profile"]["error"] === 4) {
            $foto_profile = $foto_lama;
        } else {
            if(!$checkNama || !$checkEmail || !$checkRole || !$checkFoto) {
                return false;
            } else {
                unlink("../../../public/assets/foto-profile/{$foto_lama}");
                $foto_profile = $this->upload_foto_profile($_FILES);
            }
        }

        // query crate
        $query = "UPDATE petugas set nama='$nama', email='$email', role='$role', foto_profile='$foto_profile' WHERE id_petugas=$id"; 
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }

    public function findPetugas($id) {
        $query = "SELECT * FROM petugas WHERE id_petugas=$id";
        $result = $this->connection->query($query);

        return $result->fetch_assoc();
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
            
                move_uploaded_file($tmpName,'../../../public/assets/foto-profile/'.$namaFileBaru);
            
                return $namaFileBaru;
            }
}