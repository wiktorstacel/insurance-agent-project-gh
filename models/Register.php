<?php

namespace Wikto\InsuranceAgentProjectGh\models;

class Register {
    private $conn;
    private string $login;
    private string $pass;
    private string $email;
    private string $gender;
    private string $languages;
    private string $token;

    public function __construct($conn) {
        $this->conn = $conn;
    }
}

?>