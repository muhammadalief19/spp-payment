<?php
class ValidateTransaksi {
    private $error = [];

    public function checkNisn($nisn) {
        if(empty($nisn)) {
            $this->addError('nisn', 'nisn wajib diisi');
            return false;
        }
        return true;
    }

    public function checkPembayaran($pembayaran) {
        if(empty($pembayaran)) {
            $this->addError('pembayaran', 'Jumlah Pembayaran wajib diisi');
            return false;
        }
        return true;
    }

    public function checkBukti($files) {
        $namaFile = $files["bukti_pembayaran"]["name"];
        $ukuranFile = $files["bukti_pembayaran"]["size"];
        $error = $files["bukti_pembayaran"]["error"];
    
    
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