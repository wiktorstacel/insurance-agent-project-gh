<?php

// Klasa bazowa dla stron
abstract class Page {
    abstract public function renderContent(): string;

    public function render(): string {
        return "
            <html>
                <head><title>Moja Strona</title></head>
                <body>
                    <header><h1>Witaj na stronie!</h1></header>
                    <main>
                        {$this->renderContent()}
                    </main>
                    <footer><p>&copy; 2025 Moja Strona</p></footer>
                </body>
            </html>
        ";
    }
}

// Strona główna
class HomePage extends Page {
    public function renderContent(): string {
        return "<p>To jest strona główna.</p>";
    }
}

// Strona artykułu
class ArticlePage extends Page {
    private string $articleTitle;
    private string $articleContent;

    public function __construct(string $title, string $content) {
        $this->articleTitle = $title;
        $this->articleContent = $content;
    }

    public function renderContent(): string {
        return "<h2>{$this->articleTitle}</h2><p>{$this->articleContent}</p>";
    }
}

// Strona kontaktowa
class ContactPage extends Page {
    public function renderContent(): string {
        return "
            <h2>Kontakt</h2>
            <form method='post' action='/send'>
                <label for='name'>Imię:</label>
                <input type='text' id='name' name='name' required>
                <label for='message'>Wiadomość:</label>
                <textarea id='message' name='message' required></textarea>
                <button type='submit'>Wyślij</button>
            </form>
        ";
    }
}

class Router {
    private static int $requestCount = 0;
    
    public static function handleRequest($pageType) {
        // Zwiększ licznik wywołań
        self::$requestCount++;
        
        return match ($pageType) {
            'home' => new HomePage(),
            'article' => new ArticlePage("Tytuł artykułu", "Treść artykułu."),
            'contact' => new ContactPage(),
            default => new HomePage(),
        };
    }

    public static function getRequestCount(): int {
        return self::$requestCount;
    }
}

// Odczytanie typu strony z parametru GET
$pageType = $_GET['page'] ?? 'home';

// Dopasowanie strony za pomocą statycznej funkcji
$page = Router::handleRequest($pageType); //trzeba tą linię kodu skopiować i wywołać tutaj 2 razy, żeby ilość obsłużonych żądań była 2!


// Wywołanie metody render na utworzonym obiekcie (zakładamy, że każda klasa ma metodę render)
echo $page->render();

// Wyświetli liczbę żądań - w celu zastosowania składowej statycznej - $requestCount
echo "Ilość obsłużonych żądań: " . Router::getRequestCount(); 


/*Polimorfizm w akcji:

Wszystkie klasy (HomePage, ArticlePage, ContactPage) dziedziczą po Page.
Każda klasa implementuje metodę renderContent() na swój sposób, dostosowując ją do specyfiki danego rodzaju strony.
Uniwersalne wyświetlanie:

Dzięki polimorfizmowi metoda render() w klasie bazowej Page działa dla każdej strony w ten sam sposób, nawet jeśli szczegóły treści (renderContent()) są różne.
Prosty router:

Mechanizm oparty na $_GET['page'] pozwala użytkownikowi przełączać się między różnymi stronami.*/

?>