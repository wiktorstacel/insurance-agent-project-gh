<?php

require ('strona_stage.inc');

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
      echo '
        <div id="content" class="row">
            <main style="margin-bottom: 20px;">';//style="float:left;"
            
                //<!-- write content here -->
                require 'config_db.php';
                // Pobranie i walidacja ID artykułu
                $article_id = $_GET['article_id'] ?? 0; // Domyślnie 0, jeśli brak danych
                $article_id = intval($article_id); // Rzutowanie na liczbę całkowitą dla bezpieczeństwa

                // Przygotowanie zapytania
                $stmt = $conn->prepare(
                    "SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views 
                    FROM articles a 
                    INNER JOIN users u ON a.user_id = u.user_id 
                    WHERE a.article_id = ? 
                    ORDER BY a.date DESC"
                );

                // Powiązanie parametru
                $stmt->bind_param("i", $article_id); // "i" oznacza, że parametr jest liczbą całkowitą

                // Wykonanie zapytania
                $stmt->execute();

                // Pobranie wyników
                $result = $stmt->get_result();

                //PIERWOTNY KOD z 01.2021
                //$result = mysqli_query($conn,
                //            sprintf("SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views FROM articles a, users u WHERE a.user_id = u.user_id AND a.article_id = '%d' ORDER BY a.date DESC",
                //            mysqli_real_escape_string($conn, $article_id)
                //                )); 
                //Błąd w powyższym kodzie: Masz podatność na SQL Injection, ponieważ używasz sprintf z mysqli_real_escape_string. 
                //To połączenie jest niepotrzebne i niezalecane. Dla typu liczbowego (%d) nie musisz stosować mysqli_real_escape_string, 
                //ponieważ sprintf('%d', $article_id) automatycznie rzutuje zmienną na liczbę całkowitą. 
 
                //PRÓBA POPRAWY:
                //$query = sprintf(
                //    "SELECT a.article_id, a.title, a.content, a.date, u.surname, u.user_id, a.views 
                //     FROM articles a 
                //     INNER JOIN users u ON a.user_id = u.user_id 
                //     WHERE a.article_id = %d 
                //     ORDER BY a.date DESC",
                //    $article_id
                //);
                //$result = mysqli_query($conn, $query);
                //sprintf: Używając sprintf, sam musisz zadbać o odpowiednie oczyszczenie danych (np. intval dla liczb lub 
                //mysqli_real_escape_string dla tekstów). Jeśli zrobisz to nieprawidłowo lub coś pominiesz, aplikacja może być 
                //podatna na SQL Injection.

                
                if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
                

                //Wyświetlanie danych (np. $row[1] lub $row[2]) jest podatne na XSS (Cross-Site Scripting), 
                //ponieważ dane z bazy danych nie są oczyszczane przed ich wyświetleniem w HTML.
                //Zabezpiecz dane: Użyj htmlspecialchars, aby zapobiec wstrzyknięciu niebezpiecznego kodu HTML/JavaScript:
                echo '<div class="col-sm-12"><article>';
                echo '<header><h2 class="title">'. htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') .'</h2></header>';
                echo '<br />';
                echo htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8');
                echo '<br><br><b>Autor:</b> '.htmlspecialchars($row[4], ENT_QUOTES, 'UTF-8').', '.htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8').', wyświetleń: '.htmlspecialchars($row[6], ENT_QUOTES, 'UTF-8');
                echo '<br /><br />';
                
                echo '<footer>';
                //Tak, potrzebujesz zabezpieczyć dane w atrybutach HTML, nawet jeśli nie są bezpośrednio widoczne w przeglądarce.
                echo '<div class="user_profile_kontakt" id="kontaktform_div'.htmlspecialchars($row[5], ENT_QUOTES, 'UTF-8').'">';
                echo '<br><img src="css\images\envelop2.png" width="16" height="16" alt="alt"/>'
                . '<button class="kontaktform_loadButt" value="'.htmlspecialchars($row[5], ENT_QUOTES, 'UTF-8').'"> &nbspNapisz zapytanie o ofertę handlową lub spotkanie do autora...</button>';
                echo '</div>';
                echo '... lub wyszukaj kontakt do doradcy w Twojej okolicy w zakładce <u>Kontakt</u>';
                echo '</footer>';
                echo'</article></div>';
                
                
                mysqli_close($conn);               
 
                //$this -> title = $row[1]; jak ustawić z tego miejsca title na poziomie klasy. ODP:$this -> setSomething($s);

                                
            echo '</main>';//END OF MAIN
            if($this->show_motto)$this->WyswietlMotto();

        echo'</div>'; //end of content
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
