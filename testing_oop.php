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

//Badanie metod i składowych klas
echo "<br> Badanie klasy Router - metody: ";
print_r(get_class_methods('Router'));
echo "<br> Badanie klasy Router - właściwości: ";
print_r(get_class_vars('Router'));
echo "<br> Badanie klasy bazowej dla HomePage: ";
print(get_parent_class('HomePage'));
echo "<br> Badanie klasy ContactPage czy istnieje: ";
if (class_exists('ContactPage')) {
    echo "Klasa istnieje!";
}


echo "<br><br>BADANIE KLASY ROUTER z UŻYCIEM Reflection API: <br>";
// Tworzymy obiekt ReflectionClass dla klasy Router
$reflection = new ReflectionClass('Router');

// Wyświetlenie nazwy klasy
echo "Nazwa klasy: " . $reflection->getName() . "<br>";

// Wyświetlenie właściwości klasy
echo "Właściwości klasy:<br>";
foreach ($reflection->getProperties() as $property) {
    echo " - " . $property->getName() . " (" . implode(' ', Reflection::getModifierNames($property->getModifiers())) . ")<br>";
}

// Wyświetlenie metod klasy
echo "Metody klasy:<br>";
foreach ($reflection->getMethods() as $method) {
    echo " - " . $method->getName() . " (" . implode(' ', Reflection::getModifierNames($method->getModifiers())) . ")<br>";
}

// Wyświetlenie czy klasa jest abstrakcyjna
echo "Czy klasa jest abstrakcyjna? " . ($reflection->isAbstract() ? "Tak" : "Nie") . "<br>";

// Sprawdzenie, czy klasa ma konstruktor
if ($reflection->hasMethod('__construct')) {
    echo "Klasa ma konstruktor.<br>";
} else {
    echo "Klasa nie ma konstruktora.<br>";
}




/*Polimorfizm w akcji:

Wszystkie klasy (HomePage, ArticlePage, ContactPage) dziedziczą po Page.
Każda klasa implementuje metodę renderContent() na swój sposób, dostosowując ją do specyfiki danego rodzaju strony.
Uniwersalne wyświetlanie:

Dzięki polimorfizmowi metoda render() w klasie bazowej Page działa dla każdej strony w ten sam sposób, nawet jeśli szczegóły treści (renderContent()) są różne.
Prosty router:

Mechanizm oparty na $_GET['page'] pozwala użytkownikowi przełączać się między różnymi stronami.*/

?>