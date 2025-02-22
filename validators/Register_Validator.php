<?php

namespace Wikto\InsuranceAgentProjectGh\validators;

require_once 'vendor/autoload.php';

use Wikto\InsuranceAgentProjectGh\models\Register;

class Register_Validator
{
    private $register;
    private $errors = [];

    public function __construct(Register $register) {
        $this->register = $register;
    }

    public function validate()
    {
        if(empty($this->register->getLogin()) || empty($this->register->getEmail()) || empty($this->register->getHaslo()) || empty($this->register->getHaslo2()))
        {
            $this->errors['empty'] = "Wypełnij wszystkie pola!";
        }
        elseif(ctype_alnum($this->register->getLogin()) === false)//sprawdź odpowiednie znaki login
        {
            $this->errors['login'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)!";
        }
        elseif(strlen($this->register->getLogin()) < 3 || strlen($this->register->getLogin()) > 20)//sprawdz długość login
        {
            $this->errors['login'] = "Login musi posiadać od 3 do 20 znaków!";
        }
        elseif ((!filter_var($this->register->getEmail(), FILTER_VALIDATE_EMAIL))) //sprawdz poprawnosc email
        {  
            $this->errors['email'] = "Wprowadź poprawny e-mail!";
        }
        elseif((strlen($this->register->getHaslo()) < 8) || (strlen($this->register->getHaslo()) > 20))//sprawdz poprawność hasla
        {
            $this->errors['haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
        }
        elseif (!preg_match("#[0-9]+#", $this->register->getHaslo())) 
        {
            $this->errors['haslo'] .= " Hasło musi posiadać od 8 do 20 znaków!";
        }
        elseif (!preg_match("#[a-zA-Z]+#", $this->register->getHaslo())) 
        {
            $this->errors['haslo'] .= " Hasło musi posiadać co najmniej jedną literę!";
        }
        elseif($this->register->getHaslo() !== $this->register->getHaslo2())//sprawdz zgodność 2 haseł
        {
            $this->errors['haslo2'] = "Podane hasła nie są identyczne!";
        }
        elseif(!in_array($this->register->getGender(), ['male', 'female']))//sprawdz czy zaznaczono płeć
        {
            $this->errors['gender'] = "Zaznacz pole płeć!";
        }
        elseif(!$this->register->getRegulamin())//czy zaakceptowano regulamin
        {
            $this->errors['regulamin'] = "Potwierdź akceptację regulaminu!";
        }
        elseif(!$this->register->isLoginUnique($this->register->getLogin())) 
        {
            $this->errors['login'] = "Istnieje już konto z takim loginem!";
        }  
        elseif(!$this->register->isEmailUnique($this->register->getEmail())) 
        {
            $this->errors['email'] = "Istnieje już konto z takim e-mail!";
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