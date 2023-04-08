<?php
require_once 'ValidateKompetensi.php';
$db = new Database;
$connection = $db->getConnection(); 
class TableKompetensi extends ValidateKompetensi {
    public function listKomptensi($start, $limit) {
        global $connection;
        $query = "SELECT * FROM kompetensi_keahlian limit $start,$limit";
        $result = $connection->query($query);
        $kompetens = [];
        while($kompeten = $result->fetch_assoc()) {
            $kompetens[] = $kompeten;
        }

        return $kompetens;
    }

    public function createKompetensi($data) {
        global $connection;
        $nama = htmlspecialchars($data["nama"]);
        $query = "INSERT INTO kompetensi_keahlian (nama) VALUES ('$nama')";
        $validateName = $this->validateNama($nama);
        if(!$validateName) {
            return false;
        }
        $connection->query($query);

        return $connection->affected_rows;
    }

    public function updateKompetensi($data,$id) {
        global $connection;
        $nama = htmlspecialchars($data["nama"]);
        $query = "UPDATE kompetensi_keahlian SET nama='$nama' WHERE id_kompetensi=$id";
        $validateName = $this->validateNama($nama);
        if(!$validateName) {
            return false;
        }
        $connection->query($query);

        return $connection->affected_rows;
    }

    public function deleteKompetensi($id) {
        global $connection;
        $query = "DELETE FROM kompetensi_keahlian WHERE id_kompetensi=$id";
        $connection->query($query);

        return $connection->affected_rows;
    }

    public function kompetensiAll() {
        global $connection;
        $query = "SELECT * FROM kompetensi_keahlian";
        $result = $connection->query($query);
        $kompetens = [];
        while($kompeten = $result->fetch_assoc()) {
            $kompetens[] = $kompeten;
        }

        return $kompetens;
    }

    public function findKompetensi($id) {
        global $connection;
        $query = "SELECT * FROM kompetensi_keahlian WHERE id_kompetensi=$id";
        $result = $connection->query($query);

        return $result->fetch_assoc();
    }

}