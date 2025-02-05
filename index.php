<?php

require ('strona_stage.php');

$header_type = 1;
$show_content = true;
$show_sidebar = true; 
$show_motto = true;

$index = new Strona2($header_type, $show_content, $show_sidebar, $show_motto);

$index -> title = 'Ubezpieczenia i Odszkodowania - informacje, artykuły, porady';

$index -> keywords = 'ubezpieczenia, odszkodowania, komunikacyjne, wypadkowe';

$index -> description = 'Artykuły od doradców, specjalistów od ubezpieczeń i odszkodowań.';

$index -> Wyswietl();
//print_r($index);// wyświetlanie obiektu - skonkretyzowanej klasy Strona2


?>
