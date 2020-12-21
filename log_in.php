<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

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
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $row['login'];
        
        mysqli_free_result($result);
        header('location: kokpit_stage.php');
    }
    else //nie znalazło żadnego użytkownika
    {
        echo 'Brak';
    }

}


mysqli_close($conn);