<?php

require ('strona_stage.inc');

$header_type = 1;

$index = new Strona2($header_type);

$index -> title = 'Ubezpieczenia i Odszkodowania - informacje, artykuły, porady';

$index -> keywords = 'ubezpieczenia, odszkodowania, komunikacyjne, wypadkowe';

$index -> description = 'Artykuły od doradców, specjalistów od ubezpieczeń i odszkodowań.';

$index -> Wyswietl();

?>
