<?php

namespace Wikto\InsuranceAgentProjectGh\models;

class User extends Model{
    protected $user_id; //UWAGA: nie zawsze dobrą praktyką jest to mieć w modelu, lepiej bezpośrednio przekazywać do funkcji $_SESSION['user_id']
    protected $login;
    protected $email;
    protected $haslo0; //na potrzeby zmiany hasła - jest to dotychczasowe hasło
    protected $haslo;
    protected $haslo2;
    protected $gender;
    protected $languages;
    protected $regulamin;
    protected $surname;
    protected $address;
    protected $tel_num;
    protected $busi_area;
    //private $haslo_hash;

    public function getLogin() {
        return $this->login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getHaslo0() {
        return $this->haslo0;
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

    public function getSurname() {
        return $this->surname;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getTel_num() {
        return $this->tel_num;
    }

    public function getBusi_area() {
        return $this->busi_area;
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

    public function updateUser(array $data): bool 
    {
        if (empty($data)) {
            return false; // Nic do aktualizacji
        }
    
        // Tworzenie dynamicznego SET `column = ?`
        $setClause = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE users SET $setClause WHERE user_id = ?";
    
        // Tworzenie typów dla bind_param
        $types = str_repeat("s", count($data)) . "i"; // Wszystkie pola jako string, ID jako int
        $values = array_values($data);
        $values[] = $this->user_id; // Dodajemy ID użytkownika

        if (!isset($this->user_id)) {
            throw new \Exception("Błąd: user_id nie jest ustawione przed wykonaniem zapytania SQL!");
        }
    
        $stmt = $this->executeQuery($sql, $values, $types);

        return $stmt !== false; // Zwrot `true` jeśli `executeQuery()` działa, `false` jeśli błąd
    }

    public function updateUserPassword(): bool
    {
        if (empty($this->user_id)) {
            throw new \Exception("Błąd: user_id nie jest ustawione!");
        }

        // Haszowanie nowego hasła
        $hashedPassword = password_hash($this->haslo, PASSWORD_DEFAULT);
        
        // Wykonanie zapytania SQL
        $query = "UPDATE users SET pass = ? WHERE user_id = ?";
        $params = [$hashedPassword, $this->user_id];
        $types = "si"; // "s" - string (hasło), "i" - int (user_id)

        $stmt = $this->executeQuery($query, $params, $types);

        // Sprawdzenie, czy update się powiódł
        return $stmt->affected_rows > 0;
    }

    
    public function getUserById($id) 
    {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->executeQuery($query, [$id], "i");    
        return $this->fetchSingleResult($stmt);
    }
    
    //Sprawdza, że login podany w rejestracji jest unikalny
    public function isLoginUnique($login)
    {
        $stmt = $this->executeQuery("SELECT COUNT(*) FROM users WHERE login = ?", [$login], "s");
        $count = $this->fetchSingleColumnResult($stmt);
    
        return $count === 0;
    }

    //Sprawdza, że email podany w rejestracji jest unikalny
    public function isEmailUnique($email)
    {
        $stmt = $this->executeQuery("SELECT COUNT(*) FROM users WHERE email = ?", [$email], "s");
        $count = $this->fetchSingleColumnResult($stmt);
    
        return $count === 0;
    }
    
    public function isOldPasswordCorrect()
    {
        if (!isset($this->user_id)) {
            throw new \Exception("Błąd: user_id nie jest ustawione przed wykonaniem zapytania SQL!");
        }
        // Pobranie zaszyfrowanego hasła użytkownika z bazy
        $stmt = $this->executeQuery("SELECT pass FROM users WHERE user_id = ?", [$this->user_id], "i");
        $hashedPassword = $this->fetchSingleColumnResult($stmt);
    
        // Jeśli brak hasła w bazie → zwróć false
        if (!$hashedPassword) {
            return false;
        }
    
        // Sprawdzenie poprawności hasła
        return password_verify($this->haslo0, $hashedPassword);
    }
    
    
}

?>