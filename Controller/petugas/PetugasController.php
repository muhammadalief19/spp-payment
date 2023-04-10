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

    
    public function transactionReport($id) {
        global $connect;
    }
    // logout
    public function logout($location) {
        session_destroy();
        header("Location: {$location}");
    }
}

?>