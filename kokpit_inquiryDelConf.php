<?php

require ('strona_kokpit_stage.inc');

class kokpit_inquiryDelConf extends kokpit_stage
{
    
    public function WyswietlPage()
    {

    echo '<div id="page_kokpit">
	<div id="content_kokpit">
		<div style="margin-bottom: 20px;">';
    
                echo '<br>';
                echo "<table class='lista_art'>";

                require_once 'config_db.php';
                if(isset($_GET['inquiry_id']) && !isset($_GET['inquiry_id_confirmation']))
                {
                    echo "<tr class='listwa'>";
                    echo '<td class="tytul">Treść zapytania</td>';
                    echo '<td class="plus">Data nadania</td>';
                    echo '<td class="plus">Potwierdzenie</td>';
                    echo '</tr>';
                    $inquiry_id = htmlentities($_GET['inquiry_id'], ENT_QUOTES, "UTF-8");
                    $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM inquiries WHERE inquiry_id='%d' AND `user_id`='%d' ORDER BY date DESC",
                        mysqli_real_escape_string($conn, $inquiry_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);} 
                    while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                    {
                        if($row[6] == 1)      //sprawdzanie czy wpis ma być wyswietlany jako aktywny
                        {
                            echo'<tr class="linia">';
                        }
                        else
                        {
                            echo'<tr class="linia2">';
                        }
                        echo'<td class="tytul">'.$row[1].'</td>';
                        echo'<td class="data">'.$row[5].'</td>';
                        echo'<td class="plus"><a href="kokpit_inquiryDelConf.php?inquiry_id_confirmation='.$row[0].'"><button type="">Usuń</button></a>'
                        . '<a href="kokpit_inquiriesList.php"><button style="margin-left: 6px;" type="">Anuluj</button></a></td>';
                        echo '</tr>';
                    }

                }
                elseif(!isset($_GET['inquiry_id']) && isset($_GET['inquiry_id_confirmation']))
                {
                    //szukamy czy jest taki inquiry w bazie z id zalogowanego uzytkownika
                    $delete_id = htmlentities($_GET['inquiry_id_confirmation'], ENT_QUOTES, "UTF-8");
                    $result = mysqli_query($conn, 
                        sprintf("SELECT * FROM `inquiries` WHERE `inquiry_id`='%d' AND `user_id`='%d'",
                        mysqli_real_escape_string($conn, $delete_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));
                    if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                    $record_number = mysqli_num_rows($result);
                    if($record_number > 0)
                    {
                        $result = mysqli_query($conn, 
                        sprintf("DELETE FROM `inquiries` WHERE `inquiry_id`='%d' AND `user_id`='%d'",
                        mysqli_real_escape_string($conn, $delete_id),
                        mysqli_real_escape_string($conn, $_SESSION['user_id'])
                                ));                                        
                        if($result != TRUE){echo 'Bład zapytania MySQL, odpowiedź serwera: '.mysqli_error($conn);}
                        else
                        {
                            echo'<tr class="linia"><td>Zapytanie zostało usunięte.</td></tr>';
                        }
                    }
                    else
                    {
                        echo '<tr class="linia"><td>Błąd. Zapytanie nie zostało usunięte, '
                        . 'spróbuj ponownie lub skontaktuj się z administratorem.</td></tr>';
                    }                  
                }
                else //brak ustawionych zmiennych GET
                {
                    header('location: kokpit_inquiriesList.php');
                }
                echo '</table>';
                echo '<br>';               
    
                mysqli_close($conn);
		
	echo'	</div>
		
	</div>
	<!-- end content -->';
    }

}

$kokpit_inquiryDelConf = new kokpit_inquiryDelConf();

$kokpit_inquiryDelConf -> title = 'Kokpit';

$kokpit_inquiryDelConf -> keywords = 'kokpit';

$kokpit_inquiryDelConf -> description = 'kokpit';

$kokpit_inquiryDelConf -> Wyswietl();

?>