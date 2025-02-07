<?php

namespace Wikto\InsuranceAgentProjectGh\models;

class Article {
    private $conn;
    private $title;
    private $content;
    private $stan =1;
    private $user_id;
    private $category_id;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function setArticleData($title, $content, $user_id, $category_id) {
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->category_id = $category_id;

        return $this; // Dzięki temu możliwe jest wywołanie łańcuchowe
    }

    public function create() {
        // Sprawdzenie, czy użytkownik dodał artykuł dzisiaj
        $this->stan = $this->hasUserSubmittedToday($this->user_id) ? 0 : 1;
        $stmt = $this->conn->prepare(
            "INSERT INTO articles (article_id, title, content, date, stan, user_id, category_id) VALUES (DEFAULT, ?, ?, CURDATE(), ?, ?, ?)"
        );

        if (!$stmt) {
            throw new Exception("Błąd przygotowania zapytania: " . $this->conn->error);
        }

        $stmt->bind_param("ssiii", $this->title, $this->content, $this->stan, $this->user_id, $this->category_id);

        if (!$stmt->execute()) {
            throw new Exception("Błąd wykonania zapytania: " . $stmt->error);
        }

        $stmt->close();

        // Zwrócenie odpowiedniego komunikatu w zależności od stanu
        if ($this->stan == 0) {
            return "Artykuł został zapisany, jednak ponieważ dodałeś już dzisiaj co najmniej 1 artykuł, stan będzie nieaktywny. Możesz aktywować artykuł od jutra.";
        } else {
            return "Artykuł zapisany i aktywny w serwisie.";
        }
    }

    // Sprawdzanie, czy użytkownik dodał artykuł danego dnia
    public function hasUserSubmittedToday($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM articles WHERE user_id = ? AND date = CURDATE() AND stan = 1"
        );

        if (!$stmt) {
            throw new Exception("Błąd przygotowania zapytania: " . $this->conn->error);
        }

        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Błąd wykonania zapytania: " . $stmt->error);
        }

        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    public function update($article_id) {
        $stmt = $this->conn->prepare(
            "UPDATE `articles` SET `title` = ?, `category_id` = ?, `content` = ? WHERE `article_id` = ? AND `user_id` = ? LIMIT 1"
        );

        if (!$stmt) {
            throw new Exception("Błąd przygotowania zapytania: " . $this->conn->error);
        }
        $stmt->bind_param("sisii", $this->title, $this->category_id, $this->content, $article_id, $this->user_id);

        if (!$stmt->execute()) {
            throw new Exception("Błąd wykonania zapytania: " . $stmt->error);
        }

        $affected_rows = $stmt->affected_rows;
        
        $stmt->close();

        // Zwrócenie odpowiedniego komunikatu w zależności od stanu
        if ($affected_rows > 0) {
            return "Artykuł został zaktualizowany.";
        } else {
            return "Nie dokonano żadnych zmian. Artykuł pozostał w niezmienionej formie.";
        }
    }

    // Metoda do pobierania artykułu po ID
    public function getArticleById($article_id) {
        $stmt = $this->conn->prepare(
            "SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views 
             FROM articles a 
             INNER JOIN users u ON a.user_id = u.user_id 
             WHERE a.article_id = ?"
        );

        if (!$stmt) {
            throw new Exception("Błąd przygotowania zapytania: " . $this->conn->error);
        }

        $stmt->bind_param("i", $article_id);

        if (!$stmt->execute()) {
            throw new Exception("Błąd wykonania zapytania: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Błąd pobierania wyniku: " . $stmt->error);
        }

        $stmt->close();

        $article = mysqli_fetch_assoc($result);
        return $article;
    }

    // Pobranie wszystkich artykułów
    public function getAllArticles() {
        $stmt = $this->conn->prepare(
            "SELECT a.article_id, a.title, a.content, a.date, u.surname 
            FROM articles a 
            INNER JOIN users u ON a.user_id = u.user_id 
            WHERE a.stan = 1 
            ORDER BY a.date DESC;"
        );

        if (!$stmt) {
            throw new Exception("Błąd przygotowania zapytania: " . $this->conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Błąd wykonania zapytania: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Błąd pobierania wyniku: " . $stmt->error);
        }

        $stmt->close();

        return $result->fetch_all(MYSQLI_ASSOC);       
    }
}

?>