<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(!isset($_POST['log_login']) || !isset($_POST['log_haslo']))
{
    header('location: logowanie.php');
    exit();
}

$login = $_POST['log_login'];
$haslo = $_POST['log_haslo'];

require_once 'config_db.php';

$result = mysqli_query($conn, "SELECT * FROM users WHERE login='$login' AND pass='$haslo'");
if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
else 
{
    $user_number = mysqli_num_rows($result);
    if($user_number > 0)
    {
        $_SESSION['zalogowany'] = true;
        
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user'] = $row['login'];
        
        unset($_SESSION['blad']);
        
        mysqli_free_result($result);
        header('location: kokpit_stage.php');
    }
    else //nie znalazło żadnego użytkownika
    {
        $_SESSION['user1'] = 'ciulik';
        $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
        header('location: logowanie.php');
    }

}


mysqli_close($conn);