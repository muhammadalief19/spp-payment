<?php
require_once"ValidateSiswaController.php";
require_once"Database.php";
$db = new Database;
$connect = $db->getConnection();

class SiswaController extends Validate {
    public function loginSiswa($data) {
        global $connect;
        $nisn = $data["nisn"];
        $password = $data["password"];
        
        // validasi 
        $checkNisn = $this->checkNisnLogin($nisn);
        $checkPassword = $this->checkPasswordLogin($password);

        if(!$checkNisn || !$checkPassword) {
            return false;
        }

        $query = $connect->query("SELECT * FROM siswa WHERE nisn='$nisn'");
        if($query->num_rows === 1) {
            // cek apakah password yang diinputkan itu benar
            $user = $query->fetch_assoc();
            if(password_verify($password, $user["password"])){
                $_SESSION["login"] = true;
                $_SESSION["nisn"] = $user["nisn"];
                $_SESSION["nama"] = $user["nama_siswa"];
                $_SESSION["alamat"] = $user["alamat"];
                $_SESSION["foto_profile"] = $user["foto_profile_siswa"];
                $_SESSION["role"] = "siswa";
                $_SESSION["foto_profile"] = $user["foto_profile"];
                return $query->num_rows;
            } else {
            $this->addError('login', 'username/password salah');
            }
        } else {
            $this->addError('login', 'username/password salah');
        }
    }

    public function userAuth() {
        return $_SESSION;
    }

    public function sppPayment($data, $nisn) {
        global $connect;
        $jumlah_bayar = $data["jumlah_bayar"];
        $id_spp = $data["id_spp"];
        $petugas = $this->getPetugas();
        $id_petugas = $petugas["id_petugas"];
        $tahun = date('Y');
        $tgl = date('Y/m/d');
        $status = "pending";
        $bulan = $this->getBulan();

        // validasi 
        $checkBukti = $this->checkBukti($_FILES);
        if(!$checkBukti) {
            return false;
        }

        $bukti_pembayaran = $this->upload_bukti_pembayaran($_FILES);

        $query = "INSERT INTO transaksi (id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_bayar,id_spp,jumlah_bayar,status,bukti_pembayaran) VALUES ($id_petugas,'$nisn','$tgl','$bulan','$tahun',$id_spp,$jumlah_bayar,'$status','$bukti_pembayaran')";

        $connect->query($query);

        return $connect->affected_rows;

    }

    public function getPetugas() {
        global $connect;
        $query = "SELECT * FROM petugas WHERE role='admin' limit 1";
        $petugas = $connect->query($query);

        return $petugas->fetch_assoc();
    }

    public function getSiswaAuth($nisn) {
        global $connect;
        $query = "SELECT * FROM siswa JOIN spp ON siswa.id_spp = spp.id_spp JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE siswa.nisn=$nisn";
        $siswa = $connect->query($query);

        return $siswa->fetch_assoc();
    }

    public function getSiswaAuthLunas($nisn) {
        global $connect;
        $query = "SELECT * FROM siswa JOIN spp ON siswa.id_spp = spp.id_spp JOIN kelas ON siswa.id_kelas = kelas.id_kelas JOIN transaksi ON siswa.nisn = transaksi.nisn WHERE siswa.nisn=$nisn";
        $siswa = $connect->query($query);

        return $siswa->fetch_assoc();
    }

    public function getBulan() {
        $bulans = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $bulanSekarang = date('m');
        // hilangin 0 di angka pertama
        $bulanSekarang = $bulanSekarang[0] == "0" ? $bulanSekarang[1] : $bulanSekarang;
        // kurangi satu biar sesuai dengan index array
        $indexBulanSekarang = $bulanSekarang - 1;

        return $bulans[$indexBulanSekarang];
    }

    public function checkPembayaran($nisn) {
        global $connect;
        $query = "SELECT * FROM transaksi WHERE nisn='$nisn'";
        $payment = $connect->query($query);

        if($payment->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

     // function upload bukti pembayaran
     public function upload_bukti_pembayaran($files) {
        $namaFile = $files["bukti_pembayaran"]["name"];
        $ukuranFile = $files["bukti_pembayaran"]["size"];
        $error = $files["bukti_pembayaran"]["error"];
        $tmpName = $files["bukti_pembayaran"]["tmp_name"];
    
    
        // cek apakah ada gambar yang diupload 
        if ($error === 4) {
            $this->addError("bukti_pembayaran","upload gambar terlebih dahulu");
            return false;
        }
    
        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = array('jpg', 'jpeg', 'png', 'webp');
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            $this->addError("bukti_pembayaran","file yang anda upload bukan gambar");
            return false;
        }
    
        // cek jika ukurannya terlalu besar
        if ($ukuranFile > 2000000) {
            $this->addError("bukti_pembayaran","ukuran gambar terlalu besar");
            return false;
        }
    
        // lolos pengecekan, gambar siap diupload

        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;
    
        move_uploaded_file($tmpName,'../public/assets/bukti-pembayaran/'.$namaFileBaru);
    
        return $namaFileBaru;
    }

    // logout
    public function logout($location) {
        session_destroy();
        header("Location: {$location}");
    }
}
    
?>