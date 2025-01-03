<?php

class Article {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Metoda do pobierania artykułu po ID
    public function getArticleById($article_id) {
        $stmt = $this->conn->prepare(
            "SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views 
             FROM articles a 
             INNER JOIN users u ON a.user_id = u.user_id 
             WHERE a.article_id = ?"
        );
        $stmt->bind_param("i", $article_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        return $row;
    }
}

?>