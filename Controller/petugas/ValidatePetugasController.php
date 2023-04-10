<?php 

class ValidatePetugasController {
    private $error = [];

    public function checkEmailPetugasLogin($email) {
        if(empty($email)) {
            $this->addError("email",'masukkan email terlebih dahulu');
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