<?php

require ('strona_kokpit_stage.inc');

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$kokpit_articlesList = new kokpit_stage($header_type, $show_content, $show_sidebar);

$kokpit_articlesList -> title = 'Kokpit';

$kokpit_articlesList -> keywords = 'kokpit';

$kokpit_articlesList -> description = 'kokpit';

$kokpit_articlesList -> Wyswietl();

?>
