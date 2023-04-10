<?php
require_once "ValidateSiswa.php";
$db = new Database();
$conn = $db->getConnection();
class TableSiswa extends ValidateSiswa {
    public function listSiswa($start, $limit) {
        global $conn;
        $query = "SELECT * FROM siswa JOIN kelas ON siswa.id_kelas = kelas.id_kelas JOIN spp ON siswa.id_spp = spp.id_spp JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi   limit $start,$limit";
        $result = $conn->query($query);
        $students = [];
        while($student = $result->fetch_assoc()) {
            $students[] = $student;
        }

        return $students;
    }

    public function listSiswaAll() {
        global $conn;
        $query = "SELECT * FROM siswa JOIN kelas ON siswa.id_kelas = kelas.id_kelas JOIN spp ON siswa.id_spp = spp.id_spp JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi";
        $result = $conn->query($query);
        $students = [];
        while($student = $result->fetch_assoc()) {
            $students[] = $student;
        }

        return $students;
    }

    public function findSiswa($nisn) {
        global $conn;
        $query = "SELECT * FROM siswa JOIN kelas ON siswa.id_kelas = kelas.id_kelas JOIN spp ON siswa.id_spp = spp.id_spp JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi WHERE nisn='$nisn'";
        $result = $conn->query($query);

        return $result->fetch_assoc();
    }

    public function kelasAll() {
        global $conn;
        $query = "SELECT * FROM kelas JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi ORDER BY id_kelas ASC";
        $result = $conn->query($query);
        $kelas = [];

        while($dataKelas = $result->fetch_assoc()) {
            $kelas[] = $dataKelas;
        }

        return $kelas;
    }

    public function createSiswa($data) {
        global $conn;
        $spp = $this->sppNow();
        $nisn = htmlspecialchars($data["nisn"]);
        $nama = htmlspecialchars($data["nama"]);
        $password = password_hash(htmlspecialchars($data["password"]), PASSWORD_DEFAULT);
        $alamat = htmlspecialchars($data["alamat"]);
        $no_telp = htmlspecialchars($data["no_telp"]);
        $id_kelas = htmlspecialchars($data["id_kelas"]);
        $id_spp = $spp["id_spp"];

        // validasi 
        $checkNisn = $this->checkNisn($nisn);
        $checkNama = $this->checkNama($nama);
        $checkPassword = $this->checkPassword($data["password"]);
        $checkAlamat = $this->checkAlamat($alamat);
        $checkNoTelp = $this->checkNoTelp($no_telp);
        $checkKelas = $this->checkKelas($id_kelas);
        $checkFoto = $this->checkFoto($_FILES);

        if(!$checkNisn || !$checkNama || !$checkPassword || !$checkAlamat || !$checkNoTelp || !$checkKelas || !$checkFoto) {
            return false;
        }

        $foto_profile = $this->upload_foto_profile($_FILES);

        // create siswa
        $query = "INSERT INTO siswa (nisn, id_kelas, id_spp, nama_siswa, password, alamat, no_telp, foto_profile_siswa) VALUES ('$nisn', $id_kelas, $id_spp, '$nama', '$password', '$alamat', '$no_telp', '$foto_profile')";
        $conn->query($query);

        return $conn->affected_rows;
    }

    public function sppNow() {
        global $conn;
        $year = date('Y');
        $query = "SELECT * FROM spp WHERE tahun=$year";
        $result = $conn->query($query);

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

        public function deleteSiswa($nisn,$img) {
            global $conn;
            $query = "DELETE FROM siswa WHERE nisn=$nisn";
            $conn->query($query);
            if($conn->affected_rows > 0) {
                unlink("../../../public/assets/foto-profile/{$img}");
            }
            
            return $conn->affected_rows;
        }

        public function updateSiswa($data,$nisn) {
            global $conn;
            $spp = $this->sppNow();
            $nama = htmlspecialchars($data["nama"]);
            $alamat = htmlspecialchars($data["alamat"]);
            $no_telp = htmlspecialchars($data["no_telp"]);
            $id_kelas = htmlspecialchars($data["id_kelas"]);
            $id_spp = $spp["id_spp"];
            $foto_lama = htmlspecialchars($data["foto_lama"]);
    

            // validasi 
            $checkNama = $this->checkNama($nama);
            $checkAlamat = $this->checkAlamat($alamat);
            $checkNoTelp = $this->checkNoTelp($no_telp);
            $checkKelas = $this->checkKelas($id_kelas);
            $checkFoto = $this->checkFoto($_FILES);
    
            // pengecekan
            if($_FILES["foto_profile"]["error"] === 4) {
                $foto_profile = $foto_lama;
            } else {
                if(!$checkNama || !$checkAlamat || !$checkNoTelp || !$checkKelas || !$checkFoto) {
                    return false;
                } else {
                    unlink("../../../public/assets/foto-profile/{$foto_lama}");
                    $foto_profile = $this->upload_foto_profile($_FILES);
                }  
            }
    
            // query crate
            $query = "UPDATE siswa SET nama_siswa='$nama', alamat='$alamat', no_telp='$no_telp', id_kelas=$id_kelas, id_spp=$id_spp, foto_profile_siswa='$foto_profile' WHERE nisn='$nisn'";
            $conn->query($query);

            return $conn->affected_rows;
        }
}


?>