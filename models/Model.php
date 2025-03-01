<?php

namespace Wikto\InsuranceAgentProjectGh\models;

abstract class Model
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //setuje składowe w modelu, ale tylko te, które przyszy w $data
    public function loadData($data)
    {
        foreach ($data as $key => $value) { //Przechodzi przez wszystkie klucze i wartości w $data (foreach).
            if(property_exists($this, $key)) { //Sprawdza, czy dany klucz ($key) istnieje jako właściwość w obiekcie (property_exists($this, $key)).
                $this->{$key} = $value; //Jeśli tak, przypisuje wartość do tej właściwości ($this->{$key} = $value;).
            }
        }
    }

    //wyciąga tablicę składowych modelu i ich wawrtości, ale tylko te które są zasetowane (nie null)
    //problem: zaciąga $conn !
    public function getNotNullAttributes(): array {
        $data = [];
        
        foreach (get_class_vars(self::class) as $key => $default) {
            if (isset($this->$key)) {
                $data[$key] = $this->$key;
            }
        }

        return $data;
    }

    protected function executeQuery($query, $params, $types = "")
    {
        try
        {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new \Exception("Błąd przygotowania zapytania: " . $this->conn->error);
            }

            if (strlen($types) !== count($params)) {
                throw new \Exception("Błędna liczba typów parametrów! Oczekiwano: " . count($params) . ", podano: " . strlen($types));
            }

            if ($params && $types) {
                if (!$stmt->bind_param($types, ...$params)) {
                    $stmt->close();
                    throw new \Exception("Błąd wiązania parametrów: " . $stmt->error);
                }
            }

            if (!$stmt->execute()) {
                $stmt->close();
                throw new \Exception("Błąd wykonania zapytania: " . $stmt->error);
            }

            return $stmt;
        }
        catch (\Exception $e) 
        {
            error_log("Błąd: " . $e->getMessage());
            throw new \Exception("Wystąpił błąd podczas pobierania danych. ". $e->getMessage()); //UWAGA: na produkcji nie wyświetlać tego
        }
    }

    //Jeśli zapytanie zwraca tylko jedną wartość (np. COUNT(*)), kod działa poprawnie
    protected function fetchSingleColumnResult($stmt)
    {
        try {
            $stmt->bind_result($result);
            if (!$stmt->fetch()) {
                throw new \Exception("Błąd podczas pobierania wyniku.");
            }
            $stmt->close();
            return $result;
        } catch (\Exception $e) {
            error_log("Błąd: " . $e->getMessage());
            throw new \Exception("Wystąpił błąd podczas pobierania danych.");
        }
    }

    //Jeśli zapytanie zwraca więcej kolumn, musisz użyć dynamicznego bind_result() 
    //- to obsługuje jak zwracana jest jedna kolumna lub wiele... podobno, bo nie zadziałało dla jednej
    /*protected function fetchSingleResult($stmt)
    {
        try {
            $meta = $stmt->result_metadata();
            $fields = [];
            $row = [];

            while ($field = $meta->fetch_field()) {
                $fields[] = &$row[$field->name];
            }

            call_user_func_array([$stmt, 'bind_result'], $fields);

            if (!$stmt->fetch()) {
                throw new Exception("Błąd podczas pobierania wyniku.");
            }

            $stmt->close();

            return $row; // Zwraca wszystkie dane jako tablica asocjacyjna
        } catch (Exception $e) {
            error_log("Błąd: " . $e->getMessage());
            throw new Exception("Wystąpił błąd podczas pobierania danych.");
        }
    }*/

    public function fetchSingleResult($stmt)
    {
        try {
            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Błąd pobierania wyników: " . $stmt->error);
            }
    
            $data = $result->fetch_assoc(); // Pobiera tylko JEDEN wiersz
            $stmt->close();
    
            return $data ?: null; // Jeśli brak wyników, zwracamy null
        } catch (\Exception $e) {
            error_log("Błąd bazy danych: " . $e->getMessage());
            throw new \Exception("Wystąpił błąd podczas pobierania danych.");
        }
    }
    

    public function fetchAllResults($stmt)
    {
        try {
            $result = $stmt->get_result();
            if (!$result) {
                throw new \Exception("Błąd pobierania wyników: " . $stmt->error);
            }

            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $data;
        } catch (\Exception $e) {
            error_log("Błąd bazy danych: " . $e->getMessage());
            throw new \Exception("Wystąpił błąd podczas pobierania danych.");
        }
    }
    /*
    DLACZEGO try-catch

    Logowanie błędów: error_log zapisuje błąd w logach serwera.
    Bezpieczniejsza obsługa: Możesz zwrócić własny komunikat zamiast surowego błędu.
    Unikanie przerwania skryptu: Możesz obsłużyć błąd bez zatrzymywania działania aplikacji.
    Bez try-catch, błąd przerwie skrypt. Z try-catch możesz go przechwycić i zareagować.
    */
}

