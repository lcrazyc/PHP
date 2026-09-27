<?php

echo "<h2>Завдання 1</h2>";

class A {
    function example() {
        echo "This is parent function A::example().<br>";
    }
}

class B extends A {
    function example() {
        echo "This is overriden function B::example().<br>";
        A::example();
    }
}

$b = new B();
$b->example();


echo "<h2>Завдання 2</h2>";

class Car {
    public $brand;
    public $cylinders;
    public $power;

    public function __construct($brand, $cylinders, $power) {
        $this->brand = $brand;
        $this->cylinders = $cylinders;
        $this->power = $power;
    }

    public function show() {
        echo "Марка: " . $this->brand . "<br>";
        echo "Кількість циліндрів: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
    }

    public function __destruct() {
        echo "Об'єкт машини " . $this->brand . " знищено.<br>";
    }
}

class Truck extends Car {
    public $capacity;

    public function __construct($brand, $cylinders, $power, $capacity) {
        parent::__construct($brand, $cylinders, $power);
        $this->capacity = $capacity;
    }

    public function show() {
        parent::show();
        echo "Вантажопідйомність: " . $this->capacity . " т<br><br>";
    }

    public function __destruct() {
        echo "Об'єкт вантажівки " . $this->brand . " знищено.<br>";
    }
}

$car = new Car("Toyota", 4, 150);
$truck1 = new Truck("Volvo", 6, 450, 20);
$truck2 = new Truck("MAN", 6, 480, 25);

$car->show();
echo "<br>";
$truck1->show();
$truck2->show();


echo "<h2>Завдання 3</h2>";

class A3 {
    public static function test() {
        echo 1;
    }

    public static function get() {
        self::test();
    }
}

class B3 extends A3 {
    public static function test() {
        echo 2;
    }
}

B3::get();


echo "<h2>Завдання 4</h2>";

class A4 {
    public static function test() {
        echo 1;
    }

    public static function get() {
        static::test();
    }
}

class B4 extends A4 {
    public static function test() {
        echo 2;
    }
}

B4::get();


echo "<h2>Завдання 5</h2>";

class CarStatic {
    public $brand;
    public $cylinders;
    public $power;
    public static $count = 0;

    public function __construct($brand, $cylinders, $power) {
        $this->brand = $brand;
        $this->cylinders = $cylinders;
        $this->power = $power;
        self::$count++;
    }

    public function show() {
        echo "Марка: " . $this->brand . "<br>";
        echo "Кількість циліндрів: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
    }

    public static function showCount() {
        echo "Кількість створених об'єктів: " . self::$count . "<br>";
    }
}

class TruckStatic extends CarStatic {
    public $capacity;

    public function __construct($brand, $cylinders, $power, $capacity) {
        parent::__construct($brand, $cylinders, $power);
        $this->capacity = $capacity;
    }

    public function show() {
        parent::show();
        echo "Вантажопідйомність: " . $this->capacity . " т<br><br>";
    }
}

$car1 = new CarStatic("Toyota", 4, 150);
$truck3 = new TruckStatic("Volvo", 6, 450, 20);
$truck4 = new TruckStatic("MAN", 6, 480, 25);

$car1->show();
$truck3->show();
$truck4->show();

CarStatic::showCount();

?>
