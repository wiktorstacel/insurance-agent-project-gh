<?php

namespace Wikto\InsuranceAgentProjectGh\models;

class Article extends Model{
    private $title;
    private $content;
    private $stan =1;
    private $user_id;
    private $category_id;

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

    
    public function create() 
    {
        if (empty($this->user_id)) {
            throw new \Exception("Błąd: user_id nie jest ustawione!");
        }
    
        // Sprawdzenie, czy użytkownik dodał artykuł dzisiaj
        $this->stan = $this->hasUserSubmittedToday($this->user_id) ? 0 : 1;
    
        // Zapytanie SQL
        $query = "INSERT INTO articles (title, content, date, stan, user_id, category_id) VALUES (?, ?, CURDATE(), ?, ?, ?)";
        $params = [$this->title, $this->content, $this->stan, $this->user_id, $this->category_id];
        $types = "ssiii"; // "ss" = string, "iii" = int
    
        // Wykonanie zapytania
        $stmt = $this->executeQuery($query, $params, $types);

        // Sprawdzenie, czy insert się powiódł
        if ($stmt->affected_rows > 0) {
            return $this->stan == 0 
                ? "Artykuł został zapisany, jednak ponieważ dodałeś już dzisiaj co najmniej 1 artykuł, stan będzie nieaktywny. Możesz aktywować artykuł od jutra." 
                : "Artykuł zapisany i aktywny w serwisie.";
        } else {
            throw new \Exception("Błąd: nie udało się dodać artykułu!");
        }
    }


    // Sprawdzanie, czy użytkownik dodał artykuł danego dnia
    public function hasUserSubmittedToday($user_id) 
    {
        if (empty($user_id)) {
            throw new \Exception("Błąd: user_id nie jest ustawione!");
        }
    
        // Zapytanie SQL
        $query = "SELECT COUNT(*) FROM articles WHERE user_id = ? AND date = CURDATE() AND stan = 1";
        
        // Wykonanie zapytania
        $stmt = $this->executeQuery($query, [$user_id], "i");
    
        // Pobranie wyniku jako pojedyncza wartość
        $count = $this->fetchSingleColumnResult($stmt);
    
        return $count > 0;
    }
    

    public function update($article_id) 
    {
        if (empty($this->user_id)) {
            throw new \Exception("Błąd: user_id nie jest ustawione!");
        }
    
        // Zapytanie SQL
        $query = "UPDATE articles SET title = ?, category_id = ?, content = ? WHERE article_id = ? AND user_id = ? LIMIT 1";
        $params = [$this->title, $this->category_id, $this->content, $article_id, $this->user_id];
        $types = "sisii"; // "s" = string, "i" = int
    
        // Wykonanie zapytania
        $stmt = $this->executeQuery($query, $params, $types);
    
        // Sprawdzenie, czy jakiekolwiek rekordy zostały zmodyfikowane
        return $stmt->affected_rows > 0 
            ? "Artykuł został zaktualizowany." 
            : "Nie dokonano żadnych zmian. Artykuł pozostał w niezmienionej formie.";
    }
    

    // Metoda do pobierania artykułu po ID
    public function getArticleById($article_id) {
        if (empty($article_id)) {
            throw new \Exception("Błąd: article_id nie jest ustawione!");
        }
    
        // Zapytanie SQL
        $query = "
            SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views 
            FROM articles a 
            INNER JOIN users u ON a.user_id = u.user_id 
            WHERE a.article_id = ?
        ";
    
        // Wykonanie zapytania
        $stmt = $this->executeQuery($query, [$article_id], "i");
    
        // Pobranie wyniku jako pojedynczy rekord
        return $this->fetchSingleResult($stmt);
    }
    

    // Pobranie wszystkich artykułów
    public function getAllArticles() {
        // Zapytanie SQL
        $query = "
            SELECT a.article_id, a.title, a.content, a.date, u.surname 
            FROM articles a 
            INNER JOIN users u ON a.user_id = u.user_id 
            WHERE a.stan = 1 
            ORDER BY a.date DESC;
        ";
    
        // Wykonanie zapytania
        $stmt = $this->executeQuery($query, [], "");
    
        // Pobranie wyników jako tablica asocjacyjna
        return $this->fetchAllResults($stmt);
    }
    
}

?>