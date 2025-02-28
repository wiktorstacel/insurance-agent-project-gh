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
        if($this->register->getLogin() !== null)
        {
            if(empty($this->register->getLogin()))
            {
                $this->errors['login'] = "Pole Login jest wymagane!";
            }
            elseif(ctype_alnum($this->register->getLogin()) === false)//sprawdź odpowiednie znaki login
            {
                $this->errors['login'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)!";
            }
            elseif(strlen($this->register->getLogin()) < 3 || strlen($this->register->getLogin()) > 20)//sprawdz długość login
            {
                $this->errors['login'] = "Login musi posiadać od 3 do 20 znaków!";
            }
            elseif(!$this->register->isLoginUnique($this->register->getLogin())) 
            {
                $this->errors['login'] = "Istnieje już konto z takim loginem!";
            }  
        }

        //Problem: potrzebne różne metody walidacji na różnych etapach np przy rejestr trzeba isEmailUnique, przy profileUpdate już nie
        if($this->register->getEmail() !== null)
        {
            if(empty($this->register->getEmail()))
            {
                $this->errors['email'] = "Pole E-mail jest wymagane!";
            }
            elseif ((!filter_var($this->register->getEmail(), FILTER_VALIDATE_EMAIL))) //sprawdz poprawnosc email
            {  
                $this->errors['email'] = "Wprowadź poprawny e-mail!";
            }
            elseif(!$this->register->isEmailUnique($this->register->getEmail())) 
            {
                $this->errors['email'] = "Istnieje już konto z takim e-mail!";
            } 
        }

        if($this->register->getHaslo() !== null)
        {
            if(empty($this->register->getHaslo()))
            {
                $this->errors['haslo'] = "Pole Twoje Hasło jest wymagane!";
            }
            elseif((strlen($this->register->getHaslo()) < 8) || (strlen($this->register->getHaslo()) > 20))//sprawdz poprawność hasla
            {
                $this->errors['haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
            }
            elseif (!preg_match("#[0-9]+#", $this->register->getHaslo())) 
            {
                $this->errors['haslo'] = "Hasło musi posiadać co najmniej jedną cyfrę!";
            }
            elseif (!preg_match("#[a-zA-Z]+#", $this->register->getHaslo())) 
            {
                $this->errors['haslo'] = "Hasło musi posiadać co najmniej jedną literę!";
            }
        }

        if($this->register->getHaslo2() !== null)
        {
            if(empty($this->register->getHaslo2()))
            {
                $this->errors['haslo2'] = "Pole Powtórz Hasło jest wymagane!";
            }
            elseif($this->register->getHaslo() !== $this->register->getHaslo2())//sprawdz zgodność 2 haseł
            {
                $this->errors['haslo2'] = "Podane hasła nie są identyczne!";
            }
        }
    
        if($this->register->getGender() !== null)
        {
            if(!in_array($this->register->getGender(), ['male', 'female']))//sprawdz czy zaznaczono płeć
            {
                $this->errors['gender'] = "Zaznacz pole płeć!";
            }
        }

        if($this->register->getLanguages() !== null)
        {
            if(!preg_match("/^(ą|ę| |\,|\.|\;|ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]){0,40}$/", $this->register->getLanguages()))
            {
                $this->errors['languages'] = "Pole Języki obce może składać się tylko z liter(w tym polskich) oraz spacji i znaków ,.; 0-40 znaków!";            
            }
        }

        if($this->register->getRegulamin() !== null)
        {
            if(!$this->register->getRegulamin())//czy zaakceptowano regulamin
            {
                $this->errors['regulamin'] = "Potwierdź akceptację regulaminu!";
            }
        }

        if($this->register->getSurname() !== null)
        {
            if(!preg_match("/^(ą|ę| |ź|ć|ń|ó|ś|ż|ł|Ą|Ę|Ź|Ć|Ń|Ó|Ś|Ż|[a-z]|[A-Z]){0,40}$/", $this->register->getSurname()))//sprawdź odpowiednie znaki surname
            {
                $this->errors['surname'] = "Pole Imię i nazwisko może składać się tylko z liter(w tym polskich) oraz spacji, 0-40 znaków!";           
            }
        }

        if($this->register->getAddress() !== null)
        {
            if(strlen($this->register->getAddress()) > 150)//sprawdź odpowiednie znaki surname
            {
                $this->errors['address'] = "Pole Adres może składać się z 0-150 znaków!";        
            }
        }

        if($this->register->getTel_num() !== null)
        {
            if(!preg_match("/^(\-|\+|\)|\(|\ |[0-9]){0,20}$/", $this->register->getTel_num()))//sprawdź odpowiednie znaki surname
            {
                $this->errors['tel_num'] = "Pole Numer Telefonu może składać się tylko z cyfr i znaków +-() 0-20 znaków!";            
            }
        }

        if($this->register->getBusi_area() !== null)
        {
            if(strlen($this->register->getBusi_area()) > 1000)//sprawdź odpowiednie znaki surname
            { 
                $this->errors['busi_area'] = "Pole Obszar dzialności może składać się z 0-1000 znaków!";         
            }
            elseif(preg_match('/[^?!@%.,;ĄąĆćĘęŁłŃńÓóŚśŻżŹźa-zA-Z\s\d]/', $this->register->getBusi_area()))//sprawdź odpowiednie znaki surname
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