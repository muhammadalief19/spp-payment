<?php

class ValidateKompetensi {
    private $error = [];
    public function validateNama($data) {
        if(empty($data)) {
            $this->addError('nama', 'nama wajib diisi');
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