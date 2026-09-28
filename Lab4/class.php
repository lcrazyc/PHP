<?php

echo "<h2>Завдання 1</h2>";

trait MyFirstTrait {
    public function traitFunction() {
        echo "Hello world<br>";
    }

    public function greeting() {
        $hour = date("H");

        if ($hour < 6) {
            echo "Good night<br>";
        } elseif ($hour < 12) {
            echo "Good morning<br>";
        } elseif ($hour < 18) {
            echo "Good day<br>";
        } else {
            echo "Good evening<br>";
        }
    }
}

class HelloWorld {
    use MyFirstTrait;
}

$objTest = new HelloWorld();
$objTest->traitFunction();
$objTest->greeting();


echo "<h2>Завдання 2</h2>";

interface ILoger {
    public function log($message);
}

trait DateTimeTrait {
    public function getDateTime() {
        return date("F j, Y, g:i a");
    }
}

trait FileTrait {
    public function writeToFile($filename, $message) {
        file_put_contents($filename, $message . PHP_EOL, FILE_APPEND);
    }
}

class FileLoger implements ILoger {
    use DateTimeTrait, FileTrait;

    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function log($message) {
        $text = $this->getDateTime() . ": " . $message;
        $this->writeToFile($this->filename, $text);
        echo $text . "<br>";
    }
}

if (isset($_POST["message"]) && $_POST["message"] != "") {
    $logger = new FileLoger("log.txt");
    $logger->log($_POST["message"]);
}

?>

<form method="post">
    <input type="text" name="message" placeholder="Введіть повідомлення">
    <input type="submit" value="Записати">
</form>

<?php

echo "<h2>Завдання 3</h2>";

trait A {
    public function a() {
        echo "Hello ";
    }
}

trait B {
    public function b() {
        echo "world";
    }
}

class Test {
    use A, B;

    public function c() {
        echo "!<br>";
    }
}

$t = new Test();
$t->a();
$t->b();
$t->c();


echo "<h2>Завдання 4</h2>";

trait VehicleInfoTrait {
    public function showVehicleInfo() {
        echo "Марка: " . $this->brand . "<br>";
        echo "Кількість циліндрів: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
    }
}

trait CargoTrait {
    public function showCargoInfo() {
        echo "Вантажопідйомність: " . $this->capacity . " т<br>";
    }
}

trait MovementTrait {
    public function move() {
        echo "Транспортний засіб " . $this->brand . " рухається.<br>";
    }
}

class Truck {
    use VehicleInfoTrait, CargoTrait, MovementTrait;

    public $brand;
    public $cylinders;
    public $power;
    public $capacity;

    public function __construct($brand, $cylinders, $power, $capacity) {
        $this->brand = $brand;
        $this->cylinders = $cylinders;
        $this->power = $power;
        $this->capacity = $capacity;
    }

    public function show() {
        $this->showVehicleInfo();
        $this->showCargoInfo();
        $this->move();
    }
}

$truck = new Truck("Volvo", 6, 450, 20);
$truck->show();

?>
