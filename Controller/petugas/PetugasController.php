<?php 
require_once"ValidatePetugasController.php";
require_once('../../../spp-payment/Controller/Database.php');
$db = new Database;
$connect = $db->getConnection();
class PetugasController extends ValidatePetugasController{

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
                $_SESSION["id"] = $user["id_petugas"];
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

    // function auth petugas
    public function authPetugas($session) {
        return $session;
    }

    
    public function transactionReportStat($id) {
        global $connect;
        $query = "SELECT * FROM transaksi JOIN siswa ON transaksi.nisn = siswa.nisn JOIN petugas ON transaksi.id_petugas = petugas.id_petugas JOIN spp ON transaksi.id_spp = spp.id_spp WHERE transaksi.id_petugas=$id ORDER BY id_transaksi DESC limit 3";
        $result = $connect->query($query);
        $transaksi = [];

        while($data = $result->fetch_assoc()) {
            $transaksi[] = $data;
        }

        return $transaksi;
    }

    public function transactionReport($id, $start, $limit) {
        global $connect;
        $query = "SELECT * FROM transaksi JOIN siswa ON transaksi.nisn = siswa.nisn JOIN petugas ON transaksi.id_petugas = petugas.id_petugas JOIN spp ON transaksi.id_spp = spp.id_spp WHERE transaksi.id_petugas=$id ORDER BY id_transaksi DESC limit $start,$limit";
        $result = $connect->query($query);
        $transaksi = [];

        while($data = $result->fetch_assoc()) {
            $transaksi[] = $data;
        }

        return $transaksi;
    }

    public function transactionReportAll($id) {
        global $connect;
        $query = "SELECT * FROM transaksi JOIN siswa ON transaksi.nisn = siswa.nisn JOIN petugas ON transaksi.id_petugas = petugas.id_petugas JOIN spp ON transaksi.id_spp = spp.id_spp WHERE transaksi.id_petugas=$id";
        $result = $connect->query($query);
        $transaksi = [];

        while($data = $result->fetch_assoc()) {
            $transaksi[] = $data;
        }

        return $transaksi;
    }
    // logout
    public function logout($location) {
        session_destroy();
        header("Location: {$location}");
    }
    
        public function convertRupiah($angka){
            
            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
            return $hasil_rupiah;
        
        }
}
?>