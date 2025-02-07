<?php

require ('strona_kokpit_stage.php');
require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Article;
use Wikto\InsuranceAgentProjectGh\validators\Article_Validator;

class article_save extends kokpit_stage
{
    public function WyswietlPage()//ArticleSaveController()
    {
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $content = isset($_POST['freeRTE_content']) ? trim($_POST['freeRTE_content']) : '';
        $user_id = $_SESSION['user_id'] ?? 0;
        $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
        
        include 'config_db.php';
        $articleModel = new Article($conn);
        $articleModel->setArticleData($title, $content, $user_id, $category_id);//->create();//setArticleData() musi zwracać $this, żeby było możliwe wywołanie łańcuchowe
    
        if (isset($_POST['submit'])) {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
        
            $articleValidator = new Article_Validator($articleModel);
 
            if ($articleValidator->validate()) {
                //echo "Dane poprawne!";
                if(isset($_POST['article_id'])){
                    $message = $articleModel->update($_POST['article_id']);
                }
                else{
                    $message = $articleModel->create();
                }
                $this->render('views/article_save.php', ['message' => $message]);
            } else {
                //echo "Błędy: ";
                //print_r($articleValidator->getErrors());
                $_SESSION['errors'] = $articleValidator->getErrors();
                $_SESSION['mem_category_id'] = $category_id;
                $_SESSION['mem_title'] = $title;
                $_SESSION['mem_content'] = $_POST['freeRTE_content'];
                if(isset($_POST['article_id'])) 
                {header('location: freerte/examples/edycja_articles.php?article_id='.$_POST['article_id']);}
                else 
                {header('location: freerte/examples/edycja_articles.php?article_id=new');}
                exit();
            }
        }
    }
}

$header_type = 2;
$show_content = true;
$show_sidebar = true; 

$article_save = new article_save($header_type, $show_content, $show_sidebar);

$article_save -> title = 'Kokpit';

$article_save -> keywords = 'kokpit';

$article_save -> description = 'kokpit';

$article_save -> Wyswietl();

?>
