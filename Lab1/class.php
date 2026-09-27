<?php
header("Content-Type: text/html; charset=UTF-8");
echo "<h1>Лабораторна робота. Класи та об'єкти PHP</h1>";
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 1
   ========================================================= */
echo "<h2>Завдання 1</h2>";
class Coor1 {
    private $name;
    public function Setname($text) {
        $this->name = $text;
    }
    public function Getname() {
        return $this->name;
    }
}
$object1 = new Coor1();
$object1->Setname("Nick");
echo "Ім'я: " . $object1->Getname();
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 2
   Масив із трьох об'єктів
   ========================================================= */
echo "<h2>Завдання 2</h2>";
class Coor2 {
    private $name;
    public function Setname($text) {
        $this->name = $text;
    }
    public function Getname() {
        return $this->name;
    }
}
$works = array();
$works[0] = new Coor2();
$works[0]->Setname("Nick");

$works[1] = new Coor2();
$works[1]->Setname("Nick 1");
$works[2] = new Coor2();
$works[2]->Setname("Nick 2");
for ($i = 0; $i < 3; $i++) {
    echo $works[$i]->Getname() . "<br>";
}
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 3
   ========================================================= */
echo "<h2>Завдання 3. Варіант 3 - Машина</h2>";
class Car {
    public $brand;
    public $cylinders;
    public $power;
    private $engineNumber;
    public function set($brand, $cylinders, $power) {
        $this->brand = $brand;
        $this->cylinders = $cylinders;
        $this->power = $power;
    }
    public function get($field) {
        if ($field == "brand") {
            return $this->brand;
        }
        if ($field == "cylinders") {
            return $this->cylinders;
        }
        if ($field == "power") {
            return $this->power;
        }
        return null;
    }
    public function show() {
        echo "Марка: " . $this->brand . "<br>";
        echo "Кількість циліндрів: " . $this->cylinders . "<br>";
        echo "Потужність: " . $this->power . " к.с.<br>";
        $this->showMessage();
        echo "<br>";
    }
    public function search($brand) {
        return $this->brand == $brand;
    }
    private function showMessage() {
        echo "Автомобіль: " . $this->brand . "<br>";
    }
    public function setEngineNumber($number) {
        $this->engineNumber = $number;
    }
    public function getEngineNumber() {
        return $this->engineNumber;
    }
}
$car1 = new Car();
$car1->set("Toyota", 4, 150);
$car2 = new Car();
$car2->set("BMW", 6, 250);
$car3 = new Car();
$car3->set("Audi", 4, 190);
echo "<h3>Три об'єкти класу:</h3>";
$car1->show();
$car2->show();
$car3->show();
echo "<h3>Робота методу get():</h3>";
echo "Марка першої машини: " . $car1->get("brand") . "<br>";
echo "Потужність: " . $car1->get("power") . " к.с.<br>";
echo "<h3>Робота методу search():</h3>";
if ($car2->search("BMW")) {
    echo "Автомобіль BMW знайдено!<br>";
} else {
    echo "Автомобіль не знайдено!<br>";
}
echo "<h3>Інкапсуляція:</h3>";
$car1->setEngineNumber("ABC123456");
echo "Номер двигуна: " . $car1->getEngineNumber();
$cars = array();
$cars[0] = new Car();
$cars[0]->set("Toyota", 4, 150);
$cars[1] = new Car();
$cars[1]->set("BMW", 6, 250);
$cars[2] = new Car();
$cars[2]->set("Audi", 4, 190);
$cars[3] = new Car();
$cars[3]->set("Mercedes", 6, 300);
$cars[4] = new Car();
$cars[4]->set("Ford", 4, 170);
function show_objects($objects) {
    foreach ($objects as $object) {
        $object->show();
    }
}
echo "<h3>Масив із 5 об'єктів:</h3>";
show_objects($cars);
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 4
   Конструктор, unset, деструктор
   ========================================================= */
echo "<h2>Завдання 4</h2>";
class Coor4 {
    private $name;
    private $login;
    private $password;
    public function __construct($name, $login = "", $password = "") {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }
    public function Getname() {
        return $this->name;
    }
    public function show() {
        echo "Name: " . $this->name . "<br>";
        echo "Login: " . $this->login . "<br>";
        echo "Password: " . $this->password . "<br><br>";
    }
    public function __destruct() {
        echo "Object " . $this->name . " is deleted!<br>";
    }
}
$object4 = new Coor4("Nick");
echo "Ім'я: " . $object4->Getname() . "<br>";
$tempObject = new Coor4("Temporary");
unset($tempObject);
echo "Object is deleted!<br><br>";
$user1 = new Coor4("Nick", "nick01", "12345");
$user2 = new Coor4("Ivan", "ivan02", "qwerty");
$user3 = new Coor4("Anna", "anna03", "pass123");
echo "<h3>Три об'єкти Coor:</h3>";
$user1->show();
$user2->show();
$user3->show();
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 5
   Робота з count.txt
   ========================================================= */
echo "<h2>Завдання 5</h2>";
class WorkWithFile {
    public $buff;
    public $filename;
    public function __construct($filename) {
        $this->filename = "./" . $filename;
        if (!file_exists($this->filename)) {
            echo "Файл " . $filename . " не існує.<br>";
            $this->buff = "";
            return;
        }
        $fd = fopen($this->filename, "r");
        if (!$fd) {
            echo "Помилка відкриття файлу.<br>";
            return;
        }
        $size = filesize($this->filename);
        if ($size > 0) {
            $this->buff = fread($fd, $size);
        } else {
            $this->buff = "";
        }
        fclose($fd);
    }
    public function getContent() {
        return $this->buff;
    }
    public function getSize() {
        if (file_exists($this->filename)) {
            return filesize($this->filename);
        }
        return 0;
    }
    public function getCount() {
        if (file_exists($this->filename)) {
            $arr = file($this->filename);
            return count($arr);
        }
        return 0;
    }
}
$first = new WorkWithFile("count.txt");
echo "<b>Вміст файлу:</b><br>";
echo nl2br(htmlspecialchars($first->getContent()));
echo "<br><br>";
echo "Розмір файлу: " . $first->getSize() . " байт<br>";
echo "Кількість рядків: " . $first->getCount();
echo "<hr>";

/* =========================================================
   ЗАВДАННЯ 6
   ВАРІАНТ 3

   10 чисел записано у стовпчик.
   Записати їх в інший файл у рядок.
   ========================================================= */
echo "<h2>Завдання 6. Варіант 3</h2>";
class NumbersFile {
    private $inputFile;
    private $outputFile;
    public function __construct($inputFile, $outputFile) {
        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;
    }
    public function convert() {
        if (!file_exists($this->inputFile)) {
            echo "Файл " . $this->inputFile . " не знайдено.";
            return;
        }
        $numbers = file(
            $this->inputFile,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );
        $result = implode(" ", $numbers);
        file_put_contents($this->outputFile, $result);
        echo "Числа успішно записані у файл "
            . $this->outputFile . "<br>";
        echo "Результат: " . $result;
    }
}
$numbersFile = new NumbersFile("numbers.txt", "numbers_result.txt");
$numbersFile->convert();
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 7
   Робота з CSV
   ========================================================= */
echo "<h2>Завдання 7</h2>";
class CSV {
    private $_csv_file = null;
    public function __construct($csv_file) {
        if (file_exists($csv_file)) {
            $this->_csv_file = $csv_file;
        } else {
            throw new Exception("File not found");
        }
    }
    public function setCSV($csv) {
        $handle = fopen($this->_csv_file, "a");
        foreach ($csv as $value) {
            fputcsv($handle, explode(";", $value), ";",  '"', "\\");
        }
        fclose($handle);
    }
    public function getCSV() {
        $handle = fopen($this->_csv_file, "r");
        $array_line_full = array();
        while (($line = fgetcsv($handle,0,";",'"', "\\")) !== false) {
            $array_line_full[] = $line;
        }
        fclose($handle);
        return $array_line_full;
    }
}
try {
    $csv = new CSV("file.csv");
    $get_csv = $csv->getCSV();
    echo "<h3>Вміст CSV-файлу:</h3>";
    foreach ($get_csv as $value) {
        if (count($value) < 4) {
            continue;
        }
        echo "Last name: " . htmlspecialchars($value[0]) . "<br>";
        echo "First name: " . htmlspecialchars($value[1]) . "<br>";
        echo "Position: " . htmlspecialchars($value[2]) . "<br>";
        echo "Salary: " . htmlspecialchars($value[3]) . "<br>";
        echo "----------------<br>";
    }
    $arr = array(
        "Ponomarenko;Ivan;Programmer;12000"
    );
    $csv->setCSV($arr);
    echo "<br>Новий запис додано у file.csv.";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage();
}
echo "<hr>";
/* =========================================================
   ЗАВДАННЯ 8
   Зберігання машин у CSV
   ========================================================= */
echo "<h2>Завдання 8. Машини у CSV</h2>";
class CarCSV {
    private $filename;
    public function __construct($filename) {
        $this->filename = $filename;
        if (!file_exists($this->filename)) {
            file_put_contents( $this->filename,"Марка;Циліндри;Потужність\n" );
        }
    }
    public function addCar($brand, $cylinders, $power) {
        $handle = fopen($this->filename, "a");
        fputcsv($handle,array($brand, $cylinders, $power), ";",'"', "\\");
        fclose($handle);
    }
    public function showCars() {
        $handle = fopen($this->filename, "r");
        echo "<table border='1' cellpadding='8'>";
        echo "<tr>";
        echo "<th>Марка</th>";
        echo "<th>Кількість циліндрів</th>";
        echo "<th>Потужність</th>";
        echo "</tr>";
        $firstLine = true;
        while (
            ($data = fgetcsv(
                $handle,
                1000,
                ";",
                '"',
                "\\"
            )) !== false
        ) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            if (count($data) < 3) {
                continue;
            }
            echo "<tr>";
            echo "<td>" .
                htmlspecialchars($data[0]) .
                "</td>";
            echo "<td>" .
                htmlspecialchars($data[1]) .
                "</td>";
            echo "<td>" .
                htmlspecialchars($data[2]) .
                " к.с.</td>";
            echo "</tr>";
        }
        echo "</table>";
        fclose($handle);
    }
}
$carCSV = new CarCSV("cars.csv");
if (filesize("cars.csv") < 100) {
    $carCSV->addCar("Toyota", 4, 150);
    $carCSV->addCar("BMW", 6, 250);
    $carCSV->addCar("Audi", 4, 190);
}
echo "<h3>Дані предметної області:</h3>";
$carCSV->showCars();
echo "<hr>";
echo "<h2>Усі завдання виконано</h2>";
?>
