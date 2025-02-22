<?php

require ('strona_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Register;

class register_page extends Strona2
{
    private $registerModel;
    public function WyswietlPage()
    {
        $this->render('views/register.php');
    }

    public static function form_begin($action, $method, $id)
    {
        return sprintf('<form action="%s" method="%s" id="%s">', $action, $method, $id);
    }

    public static function form_end()
    {
        return '</form>';
    }

    public static function form_field($label, $attribute, $type)
    {
        return sprintf('
                    <label for="rej_%s">%s: </label>
                    <input type="%s" id="rej_%s" name="rej_%s" value="" />', 
                    $attribute,
                    $label,
                    $type,  
                    $attribute,
                    $attribute);
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = false; 
$show_motto = true;

$register = new register_page($header_type, $show_content, $show_sidebar, $show_motto);

$register -> title = 'Rejestracja - utwórz konto';

$register -> keywords = 'ubezpieczenia, komunikacyjne, rzeszów, podkarpackie';

$register -> description = 'Rejestracja - utwórz konto';

$register -> Wyswietl();

?>
