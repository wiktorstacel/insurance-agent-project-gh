<?php

require ('strona_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\User;
use Wikto\InsuranceAgentProjectGh\validators\User_Validator;

//use PHPMailer\PHPMailer\PHPMailer;

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
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
            $languages = isset($_POST['languages']) ? trim($_POST['languages']) : '';
            $regulamin = filter_var($_POST['regulamin'], FILTER_VALIDATE_BOOLEAN);

            $data = [
                'login' => $login,
                'email' => $email,
                'haslo' => $haslo,
                'haslo2' => $haslo2,
                'gender' => $gender,
                'languages' => $languages,
                'regulamin' => $regulamin,
            ];
            /*$data = [];
            foreach ($_POST as $key => $value) {
              $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }*/
            //UWAGA w przypadku Regulamin - boolean FILTER_SANITIZE_SPECIAL_CHARS przerobi na string "false", które w if("false") zwraca true - niepusty string traktowany jest jako prawda w warunkach logicznych       
        }
        else
        {
            echo 'Błąd przetwarzania danych!'; //Tu powinien być render z przekazaniem message w innym widoku - nie pod formularzem.
            exit;                               //chociaż to jest obłsugiwane z AJAC, to nie wiem czy render() czy wysłać JSON
        }
        
        include 'config_db.php';
        $registerModel = new User($conn);
        $registerModel->loadData($data);
        //$registerModel->setRegisterData($login, $email, $haslo, $haslo2, $gender, $languages, $regulamin);

        $registerValidator = new User_Validator($registerModel, User_Validator::MODE_REGISTRATION);
 
        if (!$registerValidator->validate()) 
        {
            echo $registerValidator->getErrorsAsJson();
        } 
        else 
        {
            try {
                if($token = $this->sendVerificationEmail($email)) {
                    if ($registerModel->createUser($token)) {
                        echo json_encode(['success' => 'Nowe konto utworzone! Sprawdź skrzynkę pocztową i potwierdź rejestrację.']);
                    } else {
                        echo json_encode(['error' => 'Nie udało się utworzyć konta.']);
                    }
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Wystąpił błąd: ' . $e->getMessage()]);
            }
        }
    }

    public function sendVerificationEmail($email) //do przerobienia: ogólnie jedna funkcja wysyłająca e-mail w różnym celu
    {
        //Tworzenie tokena do weryfikacji e-maila
        $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!/)(*';
        $token = str_shuffle($token);
        $token = substr($token, 0, 20);

        //Wysłanie email do użytkownika w celu weryfikacji
        include_once "PHPMailer/PHPMailer.php";
        include_once "PHPMailer/SMTP.php";
        include_once "PHPMailer/Exception.php";

        require_once 'config_smtp.php';
        //Email Settings
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->setFrom('info@ubezpieczenia-odszkodowania.pl');
        $mail->FromName="ubezpieczenia-odszkodowania";
        $mail->addAddress($email);
        $mail->Subject = "Weryfikacja adresu e-mail - serwis Ubezpieczenia i Odszkodowania";
        $mail->Body = "
            Kliknij poniższy link w celu weryfikacji adresu e-mail:<br><br>

            <a href='https://ubezpieczenia-odszkodowania.pl/register_verify_acc.php?email=$email&token=$token'>Weryfikacja</a>
        ";
        if (!$mail->send()) {
            throw new Exception("Błąd podczas wysyłania wiadomości: " . $mail->ErrorInfo);
        }
        else
        {
            return $token;
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

//Kontroler - jedna klasa, która wyświetla formularz a potem przetwarza z niego dane po 'submit'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register->processRegisterForm();  // Odbiór danych
} else {
    $register->Wyswietl(); // Wyświetlenie formularza
}

?>
