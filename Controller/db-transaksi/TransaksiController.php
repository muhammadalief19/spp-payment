<?php 
require_once"ValidateTransaksi.php";
$db = new Database;
$connection = $db->getConnection();
class TransaksiController extends ValidateTransaksi {

    function createPembayaranPetugas($data, $petugas) {
        date_default_timezone_set("Asia/Jakarta");
        global $connection;
        $nisn = $data["nisn"];
        $jumlah_bayar = $data["jumlah_bayar"];
        $bulan = $this->getBulan();
        $tahun = date('Y');
        $tgl = date('Y/m/d');
        $spp = $this->getSppNow($tahun);
        $id_spp = $spp["id_spp"];
        $status = "disetujui";

        // validasi 
        $checkNisn = $this->checkNisn($nisn);
        $checkJumlahBayar = $this->checkPembayaran($jumlah_bayar);
        $checkBukti = $this->checkBukti($_FILES);

        if(!$checkNisn || !$checkJumlahBayar || !$checkBukti) {
            return false;
        }

        $bukti_pembayaran = $this->upload_bukti_pembayaran($_FILES);

        $query = "INSERT INTO transaksi (id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_bayar,id_spp,jumlah_bayar,status,bukti_pembayaran) VALUES ($petugas,'$nisn','$tgl','$bulan','$tahun',$id_spp,$jumlah_bayar,'$status','$bukti_pembayaran')";
        $connection->query($query);

        return $connection->affected_rows;
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

    public function getSppNow($year) {
        global $connection;
        $query = "SELECT * FROM spp WHERE tahun=$year";
        $result = $connection->query($query);

        return $result->fetch_assoc();
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
                    
                        move_uploaded_file($tmpName,'../../public/assets/bukti-pembayaran/'.$namaFileBaru);
                    
                        return $namaFileBaru;
                    }
}