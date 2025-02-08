<?php

require ('strona_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Article;

class index extends Strona2
{
    public function WyswietlPage()
    {
            include 'config_db.php';
            $articleModel = new Article($conn);
            $articles = $articleModel->getAllArticles();

            foreach($articles as $key => $article) //formatowanie tytułu i kontentu - dopisanie tych wartości do $article pod nowymi kluczami, żeby w widoku wyświetlić tytlko zmienne a nie mieć tam logiki php
            {
                $articles[$key]['sanitazed_title'] = $this->rewrite($article['title']);

                $no_html = strip_tags(htmlspecialchars($article['content'], ENT_QUOTES, 'UTF-8'));
                if( strlen($no_html) > 600) 
                {
                    $articles[$key]['flag'] = 1;
                    $str = explode( "\n", wordwrap($no_html, 600));
                    $articles[$key]['content_str'] = $str[0] . '...';
                }
                else
                {
                    $articles[$key]['flag'] = 0;
                    $articles[$key]['content_str'] = $no_html;
                }
            }

            include 'views/articles_list.php';
    }
}

$header_type = 1;
$show_content = true;
$show_sidebar = true; 
$show_motto = true;

$index = new index($header_type, $show_content, $show_sidebar, $show_motto);

$index -> title = 'Ubezpieczenia i Odszkodowania - informacje, artykuły, porady';

$index -> keywords = 'ubezpieczenia, odszkodowania, komunikacyjne, wypadkowe';

$index -> description = 'Artykuły od doradców, specjalistów od ubezpieczeń i odszkodowań.';

$index -> Wyswietl();
//print_r($index);// wyświetlanie obiektu - skonkretyzowanej klasy Strona2


?>
