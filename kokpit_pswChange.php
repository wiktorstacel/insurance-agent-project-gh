<?php

require ('strona_kokpit_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\User;
use Wikto\InsuranceAgentProjectGh\validators\User_Validator;

class kokpit_pswChange extends kokpit_stage
{

    public function WyswietlPage()
    {
        $this->render('views/kokpit/psw_change.php');
    }

    public function processProfileForm()
    {
        $body = [];
        foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);//przerobi wszystkie dane na string
        }
        //UWAGA w przypadku Regulamin - boolean FILTER_SANITIZE_SPECIAL_CHARS przerobi na string "false", które w if("false") zwraca true - niepusty string traktowany jest jako prawda w warunkach logicznych
        $body['user_id'] = $_SESSION['user_id'];

        include 'config_db.php';
        $changePswModel = new User($conn); //Dyskusyjne: korzystanie z modelu do rejestracji
        $changePswModel->loadData($body);

        $changePswValidator = new User_Validator($changePswModel, User_Validator::MODE_PASSWORD_CHANGE); //Dyskusyjne: korzystanie z walidatora do rejestracji
 
        if (!$changePswValidator->validate()) 
        {
            echo $changePswValidator->getErrorsAsJson();
        } 
        else 
        {
            try {
                if ($changePswModel->updateUserPassword()) {
                    echo json_encode(['success' => 'Zmiany zostały zapisane.']);
                } else {
                    echo json_encode(['error' => 'Błąd podczas zapisu danych!']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Wystąpił błąd: ' . $e->getMessage()]);
            }
        }
    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$kokpit_pswChange = new kokpit_pswChange($header_type, $show_content, $show_sidebar);

$kokpit_pswChange -> title = 'Kokpit';

$kokpit_pswChange -> keywords = 'kokpit';

$kokpit_pswChange -> description = 'kokpit';

//Kontroler - jedna klasa, która wyświetla formularz a potem przetwarza z niego dane po 'submit'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kokpit_pswChange->ObsluzSesje();
    $kokpit_pswChange->processProfileForm();  // Odbiór danych
} else {
    //ObsluzSesję jest wywołana w Wyswietl() domoślnie
    $kokpit_pswChange->Wyswietl(); // Wyświetlenie formularza
}

?>
