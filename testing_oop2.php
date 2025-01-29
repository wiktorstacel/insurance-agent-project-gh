<?php

//KOMPOZYCJA I DZIEDZICZENIE M.Zandstra str. 151

abstract class Lesson {
    private $duration;
    private $costStrategy;

    function __construct($duration, CostStrategy $strategy) {
        $this->duration = $duration;
        $this->costStrategy = $strategy;    
    }

    function cost() {
        return $this->costStrategy->cost($this); //wykonanie metody z innej klasy - obiekt odpowiedniego typu z wymuszoną implementacją tej metody przekazany w konstruktorze
    }

    function chargeType() {
        return $this->costStrategy->chargeType(); //wykonanie metody z innej klasy - obiekt odpowiedniego typu z wymuszoną implementacją tej metody przekazany w konstruktorze
    }

    function getDuration() {
        return $this->duration;
    }
}

class Lecture extends Lesson {
    //
}

class Seminar extends Lesson {
    //
}

abstract class CostStrategy {
    abstract function cost(Lesson $lesson);
    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy {

    function cost(Lesson $lesson) {
        return ($lesson->getDuration()*5);
    }

    function chargeType() {
        return "stawka godzinowa";
    }
}

class FixedCostStrategy extends CostStrategy {

    function cost(Lesson $lesson) {
        return 30;
    }

    function chargeType() {
        return "stawka stała";
    }
}

$lessons[] = new Seminar(4, new TimedCostStrategy);
$lessons[] = new Seminar(4, new FixedCostStrategy);

foreach ($lessons as $lesson) {
    print "Koszt lekcji: {$lesson->cost()}.";
    print "Sposób rozliczania: {$lesson->chargeType()}.<br>";
}

/*
//TESTOWANIE RĘCZNE M.Zandstra str. 383
class UserStore {
    private $users;
    function addUser($name, $mail, $pass){
        if(isset($this->users[$mail])){
            throw new Exception(
                "Konto {$mail} już istnieje w systemie");
        }
        if(strlen($pass) < 5){
            throw new Exception(
                "Hasło musi mieć co najmniej 5 liter");
        }
        $this->users[$mail] = array('pass' => $pass,
                                    'mail' => $mail,
                                    'name' => $name);
        return true;
    }
    function notifyPasswordFailure($mail){
        if(isset($this->users[$mail])){
            $this->users[$mail]['failed']=time();//tworzy nowe 'failed' w tablicy asocjacyjnej i przypisuje czas - to co zwraca time()
            print "<br>niepoprawne hasło!<br>";
            print_r($this->users);//Array ( [bob@example.com] => Array ( [pass] => 12345 [mail] => bob@example.com [name] => bob williams [failed] => 1738172314 ) )
        }
    }
    function getUser($mail){
        return($this->users[$mail]);
    }
}
class Validator{
    private $store;
    public function __construct(UserStore $store){
        $this->store = $store;
    }
    public function validateUser($mail, $pass){
        print_r($this->store);//UserStore Object ( [users:UserStore:private] => Array ( [bob@example.com] => Array ( [pass] => 12345 [mail] => bob@example.com [name] => bob williams ) ) )
        if(!is_array($user = $this->store->getUser($mail))){ //w PHP można przekazywać obiekt jako parametr do konstruktora innej klasy i wykonywać na nim metody
            return false;
        }
        if($user['pass'] == $pass){
            return true;
        }
        $this->store->notifyPasswordFailure($mail);
        return false;
    }
}
$store = new UserStore();
$store->addUser("bob williams", "bob@example.com", "12345");
$user = $store->getUser("bob@example.com");
print_r($user);
echo "<br>";
$validator = new Validator($store);
if($validator->validateUser("bob@example.com", "123453")){
    print "<br>zaliczone!\n";
}*/
?>