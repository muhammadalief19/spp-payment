<?php
$db = new Database;
$connection = $db->getConnection();
class ValidateKelas {
    private $error = [];

    public function nameCheck($class_name) {
        if($class_name == 0) {
            $this->addError('nama_kelas', 'isi nama terlebih dahulu');
            return false;
        }

        return true;
    }

    public function kompetensiCheck($kompetensi) {
        if($kompetensi == 0) {
            $this->addError('kompetensi', 'isi kompetensi terlebih dahulu');
            return false;
        }
        return true;
    }

    public function checkData($nama_kelas, $id_kompetensi) {
        global $connection;
        $query = "SELECT * FROM kelas WHERE nama_kelas='$nama_kelas' and id_kompetensi=$id_kompetensi";
        $result = $connection->query($query);

        if($result->num_rows > 0) {
            $this->addError('data', "kelas tidak tersedia");
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