<?php 
class TableSpp {
    private $db , $connection;

    public function __construct()
    {
        $this->db = new Database;
        $this->connection = $this->db->getConnection();
    }

    public function listSpp($start, $limit) {
        $query = "SELECT * FROM spp limit $start,$limit";
        $result = $this->connection->query($query);
        $spp = [];

        while($data = $result->fetch_assoc()) {
            $spp[] = $data;
        }

        return $spp;
    }

    public function listSppAll() {
        $query = "SELECT * FROM spp";
        $result = $this->connection->query($query);
        $spp = [];

        while($data = $result->fetch_assoc()) {
            $spp[] = $data;
        }

        return $spp;
    }

    public function findSpp($id) {
        $query = "SELECT * FROM spp WHERE id_spp=$id limit 1";
        $result = $this->connection->query($query);
        return $result->fetch_assoc();
    }

    public function findSppYear($year) {
        $query = "SELECT * FROM spp WHERE tahun=$year limit 1";
        $result = $this->connection->query($query);

        return $result->fetch_assoc();
    }


    public function createSpp($data) {
        $date = date('Y');
        $nominal = $data["nominal"];

        $query = "INSERT INTO spp (tahun, nominal) VALUES ('$date', $nominal)";
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }

    public function updateSpp($data,$id) {
        $date = date('Y');
        $nominal = $data["nominal"];

        $query = "UPDATE spp SET tahun=$date, nominal=$nominal WHERE id_spp=$id";
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }

    public function deleteSpp($id) {
        $query = "DELETE FROM spp WHERE id_spp=$id";
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }
}