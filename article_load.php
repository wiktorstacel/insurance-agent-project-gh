<?php

require ('strona_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Article; //to odzwierciedla strukturę katalogów zgodnie z zasadami PSR-4

class article_load extends Strona2
{
    //Set class variables also keywords and description for each article instead of doing it down below
    function setTitle()
    {
        require 'config_db.php';
        $article_id = htmlentities($_GET['article_id'], ENT_QUOTES, "UTF-8");
        $result = mysqli_query($conn,
                    sprintf("SELECT a.title, a.content, u.surname FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = '%d'",
                    mysqli_real_escape_string($conn, $article_id)
                        ));                
        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $this->title = $row[0];
        
        $pieces = explode(" ", $row[0]);
        $length = count($pieces);
        for ($i = 0; $i < $length; $i++) {
            if(strlen($pieces[$i]) < 4)
            {
                unset($pieces[$i]);//delete index, there are other function that reindex array - for implode() works
            }
        }
        $words_comma = implode(", ", $pieces);
        $vowels = array("!", "?", ".", "-"); //special character allowed for titles
        $words_comma = str_replace($vowels, " ", $words_comma);//delete characters sorrounding keywords
        $this->keywords = $words_comma;
        
        $this->description = $row[0];
        
        //view count
            $result = mysqli_query($conn,
            sprintf("UPDATE articles SET views = views + 1 WHERE article_id = '%d'",
            mysqli_real_escape_string($conn, $article_id)
                        ));                
            if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
        return true; 
    }
    
    public function WyswietlTytul()
    {
        echo '<meta name="verify-v1" content="TNJHeoK61VQS0o5RHL6ATlM5xAQS1jdwD34gtOl0LpI=" />
                     <meta name="y_key" content="d53f09aab117dc53">
                     <meta http-equiv="Content-Language" content="pl">';
        $this->setTitle();
        echo "<title> $this->title </title>\n";
    }
    
    public function WyswietlPage()
    {  
        // Pobranie i walidacja ID artykułu
        $article_id = $_GET['article_id'] ?? 0; // Domyślnie 0, jeśli brak danych
        $article_id = intval($article_id); // Rzutowanie na liczbę całkowitą dla bezpieczeństwa       
        $this->getArticle($article_id);            
    }
    
    public function getArticle($article_id)  //Kontroler pobierania artykułu
    {
        require 'config_db.php';
        $articleModel = new Article($conn);// Utworzenie obiektu klasy Article z modelu
        try 
        {        
            $article = $articleModel->getArticleById($article_id);// Pobranie artykułu z modelu
            include 'views/article.php';//załadowanie widoku
        }
        catch(Exception $e)
        {
            echo '<p>Wystąpił błąd podczas pobierania artykułu: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
        }
    }

}

$header_type = 1;
$show_content = true;
$show_sidebar = true; 
$show_motto = true;

$article_load = new article_load($header_type, $show_content, $show_sidebar, $show_motto);

//$article_load -> title = 'Artykuł'; //In case article is loaded function setTitle set those proporties

//$article_load -> keywords = 'ubezpieczenia, komunikacyjne, odszkodowania, rzeszów, podkarpackie';

//$article_load -> description = 'ubezpieczenia, odszkodowania';

$article_load -> Wyswietl();

?>
