<?php
require_once'ValidateKelas.php';
$db = new Database;
$connection = $db->conn; 

class TableKelas extends ValidateKelas {
    public function listKelas($start, $limit) {
        global $connection;
        $query = "SELECT * FROM kelas JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi limit $start,$limit";
        $result = $connection->query($query);
        $data = [];
        while($kelas = $result->fetch_assoc()) {
            $data[] = $kelas;
        }

        return $data;
    }

    public function kelasAll() {
        global $connection;
        $query = "SELECT * FROM kelas JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi";
        $result = $connection->query($query);
        $data = [];
        while($kelas = $result->fetch_assoc()) {
            $data[] = $kelas;
        }

        return $data;
    }

    public function findKelas($id) {
        global $connection;
        $query = "SELECT * FROM kelas JOIN kompetensi_keahlian ON kelas.id_kompetensi = kompetensi_keahlian.id_kompetensi WHERE id_kelas=$id";
        $result = $connection->query($query);
        $kelas = $result->fetch_assoc();

        return $kelas;
    }

    public function createKelas($data) {
        global $connection;
        $nama_kelas = htmlspecialchars($data["nama_kelas"]);
        $id_kompetensi = htmlspecialchars($data["id_kompetensi"]);

        // validasi
        $check_nama = $this->nameCheck($nama_kelas);
        $check_kompetensi = $this->kompetensiCheck($id_kompetensi);
        $check_data = $this->checkData($nama_kelas,$id_kompetensi);
        if(!$check_nama || !$check_kompetensi || !$check_data) {
            return false;
        }

        $query = "INSERT INTO kelas (id_kompetensi,nama_kelas) VALUES ($id_kompetensi,'$nama_kelas')";
        $connection->query($query);

        return $connection->affected_rows;
    }

    public function deleteKelas($id) {
        global $connection;
        $query = "DELETE FROM kelas WHERE id_kelas=$id";
        $connection->query($query);

        return $connection->affected_rows;
    }

    public function updateKelas($data,$id) {
        global $connection;
        $nama_kelas = htmlspecialchars($data["nama_kelas"]);
        $id_kompetensi = htmlspecialchars($data["id_kompetensi"]);

        // validasi
        $check_data = $this->checkData($nama_kelas,$id_kompetensi);
        if(!$check_data) {
            return false;
        }

        $query = "UPDATE kelas SET nama_kelas='$nama_kelas', id_kompetensi=$id_kompetensi WHERE id_kelas=$id";
        $connection->query($query);

        return $connection->affected_rows;
    }
}
?>