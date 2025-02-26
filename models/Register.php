<?php

namespace Wikto\InsuranceAgentProjectGh\models;

class Register extends Model{
    protected $login;
    protected $email;
    protected $haslo;
    protected $haslo2;
    protected $gender;
    protected $languages;
    protected $regulamin;
    //private $haslo_hash;

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

    public function createUser($token)
    {
        $haslo_hash = password_hash($this->haslo, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (`login`, `pass`, `email`, `gender`, `languages`, `token`) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $params = [$this->login, $haslo_hash, $this->email, $this->gender, $this->languages, $token];
        $types = "ssssss";//UWAGA: nie generuje błędu jak jest tutaj namieszane np "ssssssfgj";

        $stmt = $this->executeQuery($query, $params, $types);
        $stmt->close();

        return true;
    }


    //Sprawdza, że login podany w rejestracji jest unikalny
    public function isLoginUnique($login)
    {
        $stmt = $this->executeQuery("SELECT COUNT(*) FROM users WHERE login = ?", [$login], "s");
        $count = $this->fetchSingleResult($stmt);
    
        return $count === 0;
    }

    //Sprawdza, że email podany w rejestracji jest unikalny
    public function isEmailUnique($email)
    {
        $stmt = $this->executeQuery("SELECT COUNT(*) FROM users WHERE email = ?", [$email], "s");
        $count = $this->fetchSingleResult($stmt);
    
        return $count === 0;
    }
    

}

?>