<?php

namespace Wikto\InsuranceAgentProjectGh\models;

class Register {
    private $conn;

    private $login;
    private $email;
    private $haslo;
    private $haslo2;
    private $gender;
    private $languages;
    private $regulamin;
    //private $haslo_hash;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getHaslo() {
        return $this->haslo;
    }

    public function getHaslo2() {
        return $this->haslo2;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getLanguages() {
        return $this->languages;
    }

    public function getRegulamin() {
        return $this->regulamin;
    }

    public function setRegisterData($login, $email, $haslo, $haslo2, $gender, $languages, $regulamin) {
        $this->login = $login;
        $this->email = $email;
        $this->haslo = $haslo;
        $this->haslo2 = $haslo2;
        $this->gender = $gender;
        $this->languages = $languages;
        $this->regulamin = $regulamin;

        return $this; // Dzięki temu możliwe jest wywołanie łańcuchowe
    }
}

?>