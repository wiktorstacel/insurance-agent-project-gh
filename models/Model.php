<?php

namespace Wikto\InsuranceAgentProjectGh\models;

abstract class Model
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function executeQuery($query, $params, $types = "")
    {
        try
        {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Błąd przygotowania zapytania: " . $this->conn->error);
            }

            if ($params && $types) {
                if (!$stmt->bind_param($types, ...$params)) {
                    $stmt->close();
                    throw new Exception("Błąd wiązania parametrów: " . $stmt->error);
                }
            }

            if (!$stmt->execute()) {
                $stmt->close();
                throw new Exception("Błąd wykonania zapytania: " . $stmt->error);
            }

            return $stmt;
        }
        catch (Exception $e) 
        {
            error_log("Błąd: " . $e->getMessage());
            throw new Exception("Wystąpił błąd podczas pobierania danych.");
        }
    }

    protected function fetchSingleResult($stmt)
    {
        try {
            $stmt->bind_result($result);
            if (!$stmt->fetch()) {
                throw new Exception("Błąd podczas pobierania wyniku.");
            }
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Błąd: " . $e->getMessage());
            throw new Exception("Wystąpił błąd podczas pobierania danych.");
        }
    }
    
    public function fetchAllResults($stmt)
    {
        try {
            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Błąd pobierania wyników: " . $stmt->error);
            }

            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $data;
        } catch (Exception $e) {
            error_log("Błąd bazy danych: " . $e->getMessage());
            throw new Exception("Wystąpił błąd podczas pobierania danych.");
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

