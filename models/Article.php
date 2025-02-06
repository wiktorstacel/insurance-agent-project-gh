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

    public function setArticleData($title, $content, $user_id, $category_id) {
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->category_id = $category_id;

        return $this; // Dzięki temu możliwe jest wywołanie łańcuchowe
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO articles (article_id, title, content, date, stan, user_id, category_id) VALUES (DEFAULT, ?, ?, CURDATE(), ?, ?, ?)"
        );
        $stmt->bind_param("ssiii", $this->title, $this->content, $this->stan, $this->user_id, $this->category_id);;
        $stmt->execute();
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

        return $result->fetch_all(MYSQLI_ASSOC);       
    }
}

?>