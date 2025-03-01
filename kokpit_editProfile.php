<?php

require ('strona_kokpit_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\User;
use Wikto\InsuranceAgentProjectGh\validators\User_Validator;

class kokpit_editProfile extends kokpit_stage
{

    public function WyswietlPage()
    {
        include 'config_db.php';
        $userModel = new User($conn);
        //$userProfile = $userModel->getUserById($_SESSION['user_id']);
        $userModel->loadData($userModel->getUserById($_SESSION['user_id']));// przypisanie danych do składowych modelu i potem korzystanie z tych składowych w widoku
        $this->render('views/kokpit/edit_profile.php', ['userProfile' => $userModel]);

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
        $profileModel = new User($conn); //Dyskusyjne: korzystanie z modelu do rejestracji
        $profileModel->loadData($body);

        $profileValidator = new User_Validator($profileModel, User_Validator::MODE_PROFILE_UPDATE); //Dyskusyjne: korzystanie z walidatora do rejestracji
 
        if (!$profileValidator->validate()) 
        {
            echo $profileValidator->getErrorsAsJson();
        } 
        else 
        {
            try {
                if ($profileModel->updateUser($body)) {
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

$kokpit_editProfile = new kokpit_editProfile($header_type, $show_content, $show_sidebar);

$kokpit_editProfile -> title = 'Kokpit';

$kokpit_editProfile -> keywords = 'kokpit';

$kokpit_editProfile -> description = 'kokpit';

//Kontroler - jedna klasa, która wyświetla formularz a potem przetwarza z niego dane po 'submit'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kokpit_editProfile->ObsluzSesje();
    $kokpit_editProfile->processProfileForm();  // Odbiór danych
} else {
    //ObsluzSesję jest wywołana w Wyswietl() domoślnie
    $kokpit_editProfile->Wyswietl(); // Wyświetlenie formularza
}

?>
