<?php

namespace Wikto\InsuranceAgentProjectGh\validators;

require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Article;

class Article_Validator
{
    private $article;
    private $errors = [];

    public function __construct(Article $article) {
        $this->article = $article;
        //var_dump($article);
    }

    public function validate()
    {
        if((int)$this->article->getCategoryId() === 0)
        {
            $this->errors['category'] = "Przypisz artykuł do kategorii!";
        }

        if(strlen($this->article->getTitle()) < 15 || strlen($this->article->getTitle()) > 128)
        {
            $this->errors['title'] = "Tytuł musi mieć długość od 15 do 128 znaków!";
        }           
        //if(!preg_match("/^(ą|ę| |\,|\.|\-|\?|\!|\%|ź|ć|ń|ó|&oacute;|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[0-9]|[a-z]|[A-Z])$/", $this->article->getTitle()))
        if(!preg_match("/^[ąćęóźćńóśżłĄĘŹĆŃÓŚŻ0-9a-zA-Z ,.\-!?%]*$/", $this->article->getTitle()))
        {
            //!preg_match('/^[\p{L}\p{N} ,.!\-?%]+$/u', $title) - do przetestowania
            $this->errors['title'] .= " Dozwolone litery, cyfry, spacja oraz !?,.-!";
        }

        if(strlen($this->article->getContent()) < 100 || strlen($this->article->getContent()) >100000)
        {
            $this->errors['content'] = "Artykuł musi mieć długość od 100 do 100000 znaków!";
        }

        $no_html_content = strip_tags($this->article->getContent());
        $content_array = explode(" ", $no_html_content);
        foreach($content_array as $word)
        {
            if(strlen($word) > 60)// && preg_match('/[^><a-zA-Z\d]/', $word)
            {
                $this->errors['content'] .= " Artykuł nie może zawierać ciągu znaków bez spacji powyżej 60! Tekst: ".substr($word, 0, 8)."...";;
                break;
            }
        }

        //Usuwanie wyrażeń regularnych, kwestia pytania ile takich niebezpiecznych jest.
        //Można wracać z informacją o usnięciu czegoś albo zablokować dostęp do konta.
        $count = 0;
        // Zakazane słowa, w tym potencjalne ataki XSS
        $forbidden_words = array("onerror", "alert", "cookie", "document.cookie", "eval", "window.location", "kurwa", "chuj", "pierdol", "cipa", "dupa", "pizda");
        // Tworzymy wyrażenie regularne, które będzie szukać tych słów (ignorując wielkość liter)
        $pattern = '/\b(' . implode('|', $forbidden_words) . ')\b/i';

        // Sprawdzamy, czy treść zawiera zakazane słowa
        if (preg_match_all($pattern, $no_html_content, $matches)) //użycie strip_tags przed poprzednim IF
        {
            $count = count($matches[0]); 
            // Tworzymy komunikat zawierający wykryte słowa
            $forbidden_words = implode(', ', array_unique($matches[0]));
            // Przypisujemy komunikat o błędzie
            $this->errors['content'] .= " Znaleziono w treści $count wyrażenia niedozwolone: $forbidden_words";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

}