<?php

echo "<h2>Завдання 1</h2>";

abstract class Coor {
    private $firstName = "";
    private $lastName = "";

    public function setName($firstName, $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getName() {
        return $this->firstName . " " . $this->lastName;
    }

    abstract public function showWelcomeMessage();
}

class Visitor extends Coor {
    public function showWelcomeMessage() {
        echo "Hi " . $this->getName() . ", welcome to our shop! To buy something, please, register!<br>";
    }

    public function newMessage($subject) {
        echo "Creating new message: " . $subject . "<br>";
    }
}

class Shopper extends Coor {
    public function showWelcomeMessage() {
        echo "Hi " . $this->getName() . ", welcome to our online store!<br>";
    }

    public function addToCart($item) {
        echo "Adding " . $item . " to cart<br>";
    }
}

$visitor = new Visitor();
$visitor->setName("Valeriia", "Vasylieva");
$visitor->showWelcomeMessage();
$visitor->newMessage("Registration");

echo "<br>";

$shopper = new Shopper();
$shopper->setName("Anna", "Vasylieva");
$shopper->showWelcomeMessage();
$shopper->addToCart("Laptop");


echo "<h2>Завдання 2</h2>";

abstract class Figure2 {
    protected $x;
    protected $y;

    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    abstract public function area();

    public function showCenter() {
        echo "Координати центру: (" . $this->x . ", " . $this->y . ")<br>";
    }
}

class Circle2 extends Figure2 {
    private $radius;

    public function __construct($x, $y, $radius) {
        parent::__construct($x, $y);
        $this->radius = $radius;
    }

    public function area() {
        return pi() * $this->radius * $this->radius;
    }
}

class Rectangle2 extends Figure2 {
    private $width;
    private $height;

    public function __construct($x, $y, $width, $height) {
        parent::__construct($x, $y);
        $this->width = $width;
        $this->height = $height;
    }

    public function area() {
        return $this->width * $this->height;
    }
}

$circle = new Circle2(5, 5, 4);
echo "Коло:<br>";
$circle->showCenter();
echo "Площа: " . round($circle->area(), 2) . "<br><br>";

$rectangle = new Rectangle2(10, 10, 6, 4);
echo "Прямокутник:<br>";
$rectangle->showCenter();
echo "Площа: " . $rectangle->area() . "<br>";


echo "<h2>Завдання 3</h2>";

abstract class Vehicle3 {
    public $brand;
    public $cylinders;
    public $power;

    public function __construct($brand, $cylinders, $power) {
        $this->brand = $brand;
        $this->cylinders = $cylinders;
        $this->power = $power;
    }

    abstract public function show();
}

class Car3 extends Vehicle3 {
    public function show() {
        echo "Машина: " . $this->brand . "<br>";
        echo "Циліндри: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
    }
}

class Truck3 extends Vehicle3 {
    public $capacity;

    public function __construct($brand, $cylinders, $power, $capacity) {
        parent::__construct($brand, $cylinders, $power);
        $this->capacity = $capacity;
    }

    public function show() {
        echo "Вантажівка: " . $this->brand . "<br>";
        echo "Циліндри: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
        echo "Вантажопідйомність: " . $this->capacity . " т<br>";
    }
}

$car3 = new Car3("Toyota", 4, 150);
$truck3 = new Truck3("Volvo", 6, 450, 20);

$car3->show();
echo "<br>";
$truck3->show();


echo "<h2>Завдання 4</h2>";

interface ILoger {
    public function log($message);
}

class FileLoger implements ILoger {
    private $file;
    private $logFile;

    public function __construct($filename, $mode = "a") {
        $this->logFile = $filename;
        $this->file = fopen($filename, $mode) or die("Could not open the log file");
    }

    public function log($message) {
        $message = date("F j, Y, H:i:s") . ": " . $message . "\n";
        fwrite($this->file, $message);
        echo "Повідомлення записано: " . $message . "<br>";
    }

    public function __destruct() {
        if ($this->file) {
            fclose($this->file);
        }
    }
}

$FLog = new FileLoger("./log.txt", "w");
$FLog->log("log message");
$FLog->log("another log message");


echo "<h2>Завдання 5</h2>";

class DbLoger implements ILoger {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli("localhost", "root", "");

        if ($this->connection->connect_error) {
            die("Помилка підключення: " . $this->connection->connect_error);
        }

        $this->connection->query("CREATE DATABASE IF NOT EXISTS php_lab");
        $this->connection->select_db("php_lab");
        $this->connection->query("CREATE TABLE IF NOT EXISTS logs (id INT AUTO_INCREMENT PRIMARY KEY, log_date DATETIME, message TEXT)");
    }

    public function log($message) {
        $stmt = $this->connection->prepare("INSERT INTO logs (log_date, message) VALUES (NOW(), ?)");
        $stmt->bind_param("s", $message);
        $stmt->execute();
        echo "Повідомлення записано в базу даних: " . $message . "<br>";
        $stmt->close();
    }

    public function __destruct() {
        $this->connection->close();
    }
}

$dbLog = new DbLoger();
$dbLog->log("First database message");
$dbLog->log("Second database message");


echo "<h2>Завдання 6</h2>";

interface Figure {
    public function draw();
    public function erase();
    public function move();
    public function getColor();
    public function setColor($color);
}

class Circle implements Figure {
    public $color = "red";

    public function draw() {
        echo "Circle: draw()<br>";
    }

    public function erase() {
        echo "Circle: erase()<br>";
    }

    public function move() {
        echo "Circle: move()<br>";
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }
}

class Square implements Figure {
    public $color = "blue";

    public function draw() {
        echo "Square: draw()<br>";
    }

    public function erase() {
        echo "Square: erase()<br>";
    }

    public function move() {
        echo "Square: move()<br>";
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }
}

class Triangle implements Figure {
    public $color = "green";

    public function draw() {
        echo "Triangle: draw()<br>";
    }

    public function erase() {
        echo "Triangle: erase()<br>";
    }

    public function move() {
        echo "Triangle: move()<br>";
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }
}

$circle = new Circle();
$square = new Square();
$triangle = new Triangle();

$circle->draw();
$circle->erase();

$square->draw();
$square->erase();

$triangle->draw();
$triangle->erase();

echo "<h2>Завдання 7</h2>";

interface Int1 {
    public function func1();
}

interface Int2 {
    public function func2();
}

class MyClass implements Int1, Int2 {
    public function func1() {
        echo "Метод першого інтерфейсу: 1<br>";
    }

    public function func2() {
        echo "Метод другого інтерфейсу: 2<br>";
    }
}

$obj = new MyClass();
$obj->func1();
$obj->func2();


echo "<h2>Завдання 8</h2>";

interface VehicleInfo {
    public function showInfo();
}

interface CargoInfo {
    public function showCapacity();
}

interface VehicleMovement {
    public function move();
}

class Truck8 implements VehicleInfo, CargoInfo, VehicleMovement {
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

    public function showInfo() {
        echo "Марка: " . $this->brand . "<br>";
        echo "Кількість циліндрів: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
    }

    public function showCapacity() {
        echo "Вантажопідйомність: " . $this->capacity . " т<br>";
    }

    public function move() {
        echo "Вантажівка " . $this->brand . " рухається.<br>";
    }
}

$truck8 = new Truck8("Volvo", 6, 450, 20);
$truck8->showInfo();
$truck8->showCapacity();
$truck8->move();

?>
