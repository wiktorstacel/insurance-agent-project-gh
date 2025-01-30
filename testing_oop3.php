<?php

abstract class Employee {
    protected $name;
    private static $types = array('minion', 'cluedup', 'wellconnected');

    static function recruit($name) {
        print_r(self::$types); //Array ( [0] => minion [1] => cluedup [2] => wellconnected ) 
        $num = rand(1, count(self::$types)) - 1;
        $class = self::$types[$num];
        return new $class($name);
    }

    function __construct($name) {
        $this->name = $name;
    }

    abstract function fire();
}

class Minion extends Employee {
    function fire() {
        print "{$this->name}: Spakuję manatki <br>";
    }
}

class CluedUp extends Employee {
    function fire() {
        print "{$this->name}: Zadzwonię do adwokata <br>";
    }
}

class WellConnected extends Employee {
    function fire() {
        print "{$this->name}: Poskarżę się ojcu <br>";
    }
}

class NastyBoss {
    public $employees = array();

    function addEmployee(Employee $employee) {
        $this->employees[] = $employee;
    }
    /*Wstrzykiwanie zależności polega na przekazywaniu obiektu podrzędnego jako parametru do konstruktora, 
    metody lub właściwości obiektu nadrzędnego, zamiast tworzenia zależności wewnątrz klasy nadrzędnej. 
    Dzięki temu klasa nadrzędna staje się bardziej elastyczna, łatwiejsza do testowania i mniej zależna od konkretnych implementacji.*/
    
    function projectFails() {
        if(count($this->employees)) {
            $emp = array_pop($this->employees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss;
$boss->addEmployee(Employee::recruit("Harry")); //Wstrzykiwanie zależności po utworzeniu obiektu (w trakcie tworzenia obiektu z użyciem konstruktora)
$boss->addEmployee(Employee::recruit("Bob"));
$boss->addEmployee(Employee::recruit("Mary"));
print_r($boss->employees);
echo "<br>";
$boss->projectFails();
$boss->projectFails();
$boss->projectFails();

?>