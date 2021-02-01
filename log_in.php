<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(!isset($_POST['log_login']) || !isset($_POST['log_haslo']))
{
    header('location: login.php');
    exit();
}
else
{
    $login = htmlentities($_POST['log_login'], ENT_QUOTES, "UTF-8");
    $haslo = $_POST['log_haslo'];// htmlentities niepotrzebne bo hashujemy

    require_once 'config_db.php';

    $result = mysqli_query($conn, 
            sprintf("SELECT * FROM users WHERE login='%s' OR email='%s'",
            mysqli_real_escape_string($conn, $login),
            mysqli_real_escape_string($conn, $login)
                            ));
    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
    else 
    {
        $user_number = mysqli_num_rows($result);
        if($user_number > 0)
        {
            $row = mysqli_fetch_assoc($result);
            if(password_verify($haslo, $row['pass']) && $row['verifed'] == 1)
            {
                $_SESSION['zalogowany'] = true;


                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user'] = $row['login'];
                $_SESSION['timestamp'] = time();

                unset($_SESSION['blad']);

                mysqli_free_result($result);
                header('location: kokpit_userProfile.php');
            }
            else //jest login, nieprawidłowe hasło
            {
                $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                header('location: login.php');
            }
        }
        else //nie znalazło żadnego użytkownika
        {
            $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
            header('location: login.php');
        }
    }
    mysqli_close($conn);
}
