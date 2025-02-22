<?php

require ('strona_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Register;
use Wikto\InsuranceAgentProjectGh\validators\Register_Validator;

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

    public function processRegisterForm() //funckja "zwraca" JSON, gdyż jest wywoływana przez AJAX i działa asynchronicznie
    {
        // Odbiór danych wejściowych
        if(isset($_POST['submit']))
        {
            $login = isset($_POST['login']) ? trim($_POST['login']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';   
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $haslo = isset($_POST['haslo']) ? trim($_POST['haslo']) : '';
            $haslo2 = isset($_POST['haslo2']) ? trim($_POST['haslo2']) : '';
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
            $languages = isset($_POST['languages']) ? trim($_POST['languages']) : '';
            $regulamin = filter_var($_POST['regulamin'], FILTER_VALIDATE_BOOLEAN);
            //$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
        }
        else
        {
            echo 'Błąd przetwarzania danych!'; //Tu powinien być render z przekazaniem message w innym widoku - nie pod formularzem.
            exit;                               //chociaż to jest obłsugiwane z AJAC, to nie wiem czy render() czy wysłać JSON
        }
        
        include 'config_db.php';
        $registerModel = new Register($conn);
        $registerModel->setRegisterData($login, $email, $haslo, $haslo2, $gender, $languages, $regulamin);

        $registerValidator = new Register_Validator($registerModel);
 
        if (!$registerValidator->validate()) {
            echo $registerValidator->getErrorsAsJson();
        } else {
            echo json_encode(['success' => 'Rejestracja udana!']);
        }
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register->processRegisterForm();  // Odbiór danych
} else {
    $register->Wyswietl(); // Wyświetlenie formularza
}

?>
