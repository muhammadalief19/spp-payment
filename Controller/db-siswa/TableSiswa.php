<?php
require_once "ValidateSiswa.php";
$db = new Database();
$conn = $db->getConnection();
class TableSiswa extends ValidateSiswa {
    public function listSiswa($start, $limit) {
        global $conn;
        $query = "SELECT * FROM siswa JOIN kelas ON siswa.id_kelas = kelas.id_kelas JOIN spp ON siswa.id_spp = spp.id_spp limit $start,$limit";
        $result = $conn->query($query);
        $students = [];
        while($student = $result->fetch_assoc()) {
            $students[] = $student;
        }

        return $students;
    }
}

?>