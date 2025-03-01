<?php

namespace Wikto\InsuranceAgentProjectGh\validators;

require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\User;

class User_Validator
{
    private $userModel;
    private $errors = [];

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function validate()
    {
        if($this->userModel->getLogin() !== null)
        {
            if(empty($this->userModel->getLogin()))
            {
                $this->errors['login'] = "Pole Login jest wymagane!";
            }
            elseif(ctype_alnum($this->userModel->getLogin()) === false)//sprawdź odpowiednie znaki login
            {
                $this->errors['login'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)!";
            }
            elseif(strlen($this->userModel->getLogin()) < 3 || strlen($this->userModel->getLogin()) > 20)//sprawdz długość login
            {
                $this->errors['login'] = "Login musi posiadać od 3 do 20 znaków!";
            }
            elseif(!$this->userModel->isLoginUnique($this->userModel->getLogin())) 
            {
                $this->errors['login'] = "Istnieje już konto z takim loginem!";
            }  
        }

        //Problem: potrzebne różne metody walidacji na różnych etapach np przy rejestr trzeba isEmailUnique, przy profileUpdate już nie
        if($this->userModel->getEmail() !== null)
        {
            if(empty($this->userModel->getEmail()))
            {
                $this->errors['email'] = "Pole E-mail jest wymagane!";
            }
            elseif ((!filter_var($this->userModel->getEmail(), FILTER_VALIDATE_EMAIL))) //sprawdz poprawnosc email
            {  
                $this->errors['email'] = "Wprowadź poprawny e-mail!";
            }
            elseif(!$this->userModel->isEmailUnique($this->userModel->getEmail())) 
            {
                $this->errors['email'] = "Istnieje już konto z takim e-mail!";
            } 
        }

        if($this->userModel->getHaslo() !== null)
        {
            if(empty($this->userModel->getHaslo()))
            {
                $this->errors['haslo'] = "Pole Twoje Hasło jest wymagane!";
            }
            elseif((strlen($this->userModel->getHaslo()) < 8) || (strlen($this->userModel->getHaslo()) > 20))//sprawdz poprawność hasla
            {
                $this->errors['haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
            }
            elseif (!preg_match("#[0-9]+#", $this->userModel->getHaslo())) 
            {
                $this->errors['haslo'] = "Hasło musi posiadać co najmniej jedną cyfrę!";
            }
            elseif (!preg_match("#[a-zA-Z]+#", $this->userModel->getHaslo())) 
            {
                $this->errors['haslo'] = "Hasło musi posiadać co najmniej jedną literę!";
            }
        }

        if($this->userModel->getHaslo2() !== null)
        {
            if(empty($this->userModel->getHaslo2()))
            {
                $this->errors['haslo2'] = "Pole Powtórz Hasło jest wymagane!";
            }
            elseif($this->userModel->getHaslo() !== $this->userModel->getHaslo2())//sprawdz zgodność 2 haseł
            {
                $this->errors['haslo2'] = "Podane hasła nie są identyczne!";
            }
        }
    
        if($this->userModel->getGender() !== null)
        {
            if(!in_array($this->userModel->getGender(), ['male', 'female']))//sprawdz czy zaznaczono płeć
            {
                $this->errors['gender'] = "Zaznacz pole płeć!";
            }
        }

        if($this->userModel->getLanguages() !== null)
        {
            if(!preg_match("/^(ą|ę| |\,|\.|\;|ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]){0,40}$/", $this->userModel->getLanguages()))
            {
                $this->errors['languages'] = "Pole Języki obce może składać się tylko z liter(w tym polskich) oraz spacji i znaków ,.; 0-40 znaków!";            
            }
        }

        if($this->userModel->getRegulamin() !== null)
        {
            if(!$this->userModel->getRegulamin())//czy zaakceptowano regulamin
            {
                $this->errors['regulamin'] = "Potwierdź akceptację regulaminu!";
            }
        }

        if($this->userModel->getSurname() !== null)
        {
            if(!preg_match("/^(ą|ę| |ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]){0,40}$/", $this->userModel->getSurname()))//sprawdź odpowiednie znaki surname
            {
                $this->errors['surname'] = "Pole Imię i nazwisko może składać się tylko z liter(w tym polskich) oraz spacji, 0-40 znaków!";           
            }
        }

        if($this->userModel->getAddress() !== null)
        {
            if(strlen($this->userModel->getAddress()) > 150)//sprawdź odpowiednie znaki surname
            {
                $this->errors['address'] = "Pole Adres może składać się z 0-150 znaków!";        
            }
        }

        if($this->userModel->getTel_num() !== null)
        {
            if(!preg_match("/^(\-|\+|\)|\(|\ |[0-9]){0,20}$/", $this->userModel->getTel_num()))//sprawdź odpowiednie znaki surname
            {
                $this->errors['tel_num'] = "Pole Numer Telefonu może składać się tylko z cyfr i znaków +-() 0-20 znaków!";            
            }
        }

        if($this->userModel->getBusi_area() !== null)
        {
            if(strlen($this->userModel->getBusi_area()) > 1000)//sprawdź odpowiednie znaki surname
            { 
                $this->errors['busi_area'] = "Pole Obszar dzialności może składać się z 0-1000 znaków!";         
            }
            elseif(preg_match('/[^?!@%.,;ĄąĆćĘęŁłŃńÓóŚśŻżŹźa-zA-Z\s\d]/', $this->userModel->getBusi_area()))//sprawdź odpowiednie znaki surname
            {
                $this->errors['busi_area'] = "Pole Obszar dzialności może składać się tylko z liter(w tym polskich) oraz spacji i znaków ,.;?!%@";
            }
        }
        /*elseif(empty($_POST['captchaResponse']))
        {
            //reCapcha
            //$_POST['captchaResponse'] zamiast standardowego $_POST['g-recaptcha-response'], bo odbieram te dane
            //w js(jquery) i przesyłam do tego pliku pod inną nazwą
            $errorBot = true;
            echo '<span class="form-error">Potwierdź, że nie jesteś robotem!</span>';
            $errors['bot'] = "Potwierdź, że nie jesteś robotem!";
        }
        else
        {
            require_once 'config_reCaptcha.php';
            $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['captchaResponse']);
            $response = json_decode($check);
            //printf($response->success);
            if(($response->success))
            {
                $errorBot = true;
                echo '<span class="form-error">Błąd weryfikacji reCaptcha!</span>';
                $errors['bot'] = "Błąd weryfikacji reCaptcha!";
            }
        }*/

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getErrorsAsJson() {
        header('Content-Type: application/json');
        return json_encode($this->errors, JSON_UNESCAPED_UNICODE);
    }

}