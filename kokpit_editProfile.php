<?php

require ('strona_kokpit_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Register;
use Wikto\InsuranceAgentProjectGh\validators\Register_Validator;

class kokpit_editProfile extends kokpit_stage
{

    public function WyswietlPage()
    {
      include 'config_db.php';
      $userModel = new Register($conn);
      //$userProfile = $userModel->getUserById($_SESSION['user_id']);
      $userModel->loadData($userModel->getUserById($_SESSION['user_id']));// przypisanie danych do składowych modelu i potem korzystanie z tych składowych w widoku
      $this->render('views/kokpit/edit_profile.php', ['userProfile' => $userModel]);

    }

}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$kokpit_editProfile = new kokpit_editProfile($header_type, $show_content, $show_sidebar);

$kokpit_editProfile -> title = 'Kokpit';

$kokpit_editProfile -> keywords = 'kokpit';

$kokpit_editProfile -> description = 'kokpit';

$kokpit_editProfile -> Wyswietl();

?>
