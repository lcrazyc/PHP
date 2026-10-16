<?php

namespace {
echo "<!doctype html><html lang='uk'><head><meta charset='utf-8'><title>Породжуючі патерни PHP</title><style>body{font:16px/1.5 Arial,sans-serif;max-width:960px;margin:35px auto;padding:0 18px;color:#222}section{padding:15px 20px;margin:18px 0;border:1px solid #ddd;border-radius:10px}h2{margin-top:0;color:#184b7a}p{margin:8px 0}</style></head><body><h1>Лабораторна робота: Породжуючі патерни PHP</h1><p>Варіант 3 — автомобілі</p>";
}
namespace LabTask01 {
echo "<section><h2>Завдання 1</h2>";
class SingletonExample {
    private static ?self $instance = null;
    private function __construct() { echo "Singleton створено один раз.<br>"; }
    public static function getInstance(): self { return self::$instance ??= new self(); }
    private function __clone() {}
    public function __wakeup(): void { throw new \Exception("Unserialize заборонено"); }
}
$a=SingletonExample::getInstance(); $b=SingletonExample::getInstance(); $c=SingletonExample::getInstance();
echo "Три звернення повертають той самий об'єкт: " . (($a === $b && $b === $c) ? 'Так' : 'Ні');
// new SingletonExample() викличе помилку: приватний конструктор.
echo "</section>";
}
namespace LabTask02 {
echo "<section><h2>Завдання 2</h2>";
trait SingletonTrait {
    private static ?self $instance = null;
    private function __construct() {}
    private function __clone() {}
    public function __wakeup(): void { throw new \Exception("Unserialize заборонено"); }
    public static function getInstance(): self { return self::$instance ??= new self(); }
}
class AppSettings { use SingletonTrait; public string $language='uk'; }
$a=AppSettings::getInstance(); $b=AppSettings::getInstance();
$a->language='en'; echo "Спільний стан: {$b->language}<br>Один об'єкт: ".($a===$b?'Так':'Ні');
echo "</section>";
}
namespace LabTask03 {
echo "<section><h2>Завдання 3</h2>";
class DatabaseSingleton {
    private static ?self $instance = null;
    private ?\mysqli $db = null;
    private function __construct() {
        if (!extension_loaded('\mysqli')) { echo 'Розширення \mysqli не встановлено.<br>'; return; }
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->db = new \mysqli('localhost', 'root', '');
            $this->db->set_charset('utf8mb4');
            echo 'Connecting with database (один раз)<br>';
        } catch (\Throwable $e) { echo 'Підключення недоступне: перевірте MySQL та облікові дані.<br>'; }
    }
    public static function getInstance(): self { return self::$instance ??= new self(); }
    private function __clone() {}
    public function __wakeup(): void { throw new \Exception('Unserialize заборонено'); }
    public function getData(): array {
        if (!$this->db) return [];
        try {
            $result=$this->db->query('SELECT * FROM menu');
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (\Throwable $e) { return []; }
    }
}
$a=DatabaseSingleton::getInstance(); $b=DatabaseSingleton::getInstance(); $c=DatabaseSingleton::getInstance();
echo 'Одна інстанція БД: '.(($a===$b && $b===$c)?'Так':'Ні');
echo "</section>";
}
namespace LabTask04 {
echo "<section><h2>Завдання 4</h2>";
echo '<p>Singleton забезпечує одну інстанцію сервісу в межах PHP-запиту. Він корисний для централізованого доступу до конфігурації чи підключення, але глобальний стан ускладнює тестування. Між різними HTTP-запитами об’єкт не зберігається.</p>';
echo "</section>";
}
namespace LabTask05 {
echo "<section><h2>Завдання 5</h2>";
class Automobile { public function __construct(private string $make, private string $model) {} public function getMakeAndModel(): string { return "$this->make $this->model"; } }
class AutomobileFactory { public static function create(string $make, string $model): Automobile { return new Automobile($make,$model); } }
$veyron=AutomobileFactory::create('Bugatti','Veyron'); echo $veyron->getMakeAndModel();
echo "</section>";
}
namespace LabTask06 {
echo "<section><h2>Завдання 6</h2>";
class LabCar { public string $brand=''; public int $cylinders=0; public int $power=0; private string $engineNumber='';
 public function set(string $brand,int $cylinders,int $power): void {$this->brand=$brand;$this->cylinders=$cylinders;$this->power=$power;}
 public function get(string $field): mixed {return in_array($field,['brand','cylinders','power'],true)?$this->$field:null;}
 public function show(): void {echo "Марка: {$this->brand}, циліндри: {$this->cylinders}, потужність: {$this->power} к.с.<br>";}
 public function search(string $brand): bool {return $this->brand===$brand;}
 public function setEngineNumber(string $n): void {$this->engineNumber=$n;}
 public function getEngineNumber(): string {return $this->engineNumber;}
}
class LabCarFactory { public static function create(string $brand,int $cylinders,int $power): LabCar {$car=new LabCar();$car->set($brand,$cylinders,$power);return $car;} }
$cars=[LabCarFactory::create('Toyota',4,150),LabCarFactory::create('BMW',6,250),LabCarFactory::create('Audi',4,190)];
foreach($cars as $car) $car->show(); echo 'BMW знайдено: '.($cars[1]->search('BMW')?'Так':'Ні');
echo "</section>";
}
namespace LabTask07 {
echo "<section><h2>Завдання 7</h2>";
abstract class Vehicle {public function __construct(public string $country,public string $brand,public int $year) {} abstract public function details(): string;}
class Car extends Vehicle {public function __construct(string $country,string $brand,int $year,public string $engine,public int $power,public string $color){parent::__construct($country,$brand,$year);} public function details(): string {return "Автомобіль $this->brand ($this->country, $this->year): $this->engine, $this->power к.с., $this->color";}}
class Bike extends Vehicle {public function __construct(string $country,string $brand,int $year,public float $weight,public string $type,public int $wheelDiameter){parent::__construct($country,$brand,$year);} public function details(): string {return "Велосипед $this->brand ($this->country, $this->year): $this->weight кг, $this->type, $this->wheelDiameter дюймів";}}
class Motorcycle extends Vehicle {public function __construct(string $country,string $brand,int $year,public string $engine,public string $color,public string $type){parent::__construct($country,$brand,$year);} public function details(): string {return "Мотоцикл $this->brand ($this->country, $this->year): $this->engine, $this->color, $this->type";}}
class VehicleFactory {public static function create(string $type,array $data): Vehicle {return match(strtolower($type)) {
 'car'=>new Car(...$data), 'bike'=>new Bike(...$data), 'motorcycle'=>new Motorcycle(...$data),
 default=>throw new \InvalidArgumentException("Фабрика не може створити транспортний засіб: $type")};}}
foreach ([['car',['Japan','Toyota',2022,'бензин',150,'синій']],['bike',['Ukraine','Ardis',2024,13.5,'гірський',27]],['motorcycle',['Japan','Honda',2023,'600 см³','червоний','спорт']]] as [$type,$args]) echo VehicleFactory::create($type,$args)->details().'<br>';
try {VehicleFactory::create('plane',[]);} catch(\InvalidArgumentException $e) {echo htmlspecialchars($e->getMessage());}
echo "</section>";
}
namespace LabTask08 {
echo "<section><h2>Завдання 8</h2>";
echo '<p>Factory централізує створення об’єктів, прибирає дублювання коду та дозволяє перевіряти допустимі типи. Для вебсистем це полегшує розширення каталогу та зміну реалізації без переписування клієнтського коду.</p>';
echo "</section>";
}
namespace LabTask09 {
echo "<section><h2>Завдання 9</h2>";
interface Product {public function getName(): string;}
interface Factory {public function getProduct(): Product;}
class FirstProduct implements Product {public function getName(): string{return 'The first product';}}
class SecondProduct implements Product {public function getName(): string{return 'Second product';}}
class FirstFactory implements Factory {public function getProduct(): Product{return new FirstProduct();}}
class SecondFactory implements Factory {public function getProduct(): Product{return new SecondProduct();}}
foreach([new FirstFactory(),new SecondFactory()] as $factory) echo $factory->getProduct()->getName().'<br>';
echo "</section>";
}
namespace LabTask10 {
echo "<section><h2>Завдання 10</h2>";
interface CarProduct {public function set(string $brand,int $cylinders,int $power): void;public function get(string $field): mixed;public function show(): void;public function search(string $brand): bool;}
class FactoryCar implements CarProduct {public string $brand='';public int $cylinders=0;public int $power=0;private string $engineNumber='';
 public function set(string $brand,int $cylinders,int $power): void {$this->brand=$brand;$this->cylinders=$cylinders;$this->power=$power;}
 public function get(string $field): mixed {return in_array($field,['brand','cylinders','power'],true)?$this->$field:null;}
 public function show(): void {echo "Автомобіль $this->brand: $this->cylinders циліндри, $this->power к.с.<br>";}
 public function search(string $brand): bool {return $this->brand===$brand;}
}
abstract class CarCreator {abstract public function create(): CarProduct;}
class ToyotaCreator extends CarCreator {public function create(): CarProduct {$c=new FactoryCar();$c->set('Toyota',4,150);return $c;}}
class BMWCreator extends CarCreator {public function create(): CarProduct {$c=new FactoryCar();$c->set('BMW',6,250);return $c;}}
foreach([new ToyotaCreator(),new BMWCreator()] as $creator) $creator->create()->show();
echo "</section>";
}
namespace LabTask11 {
echo "<section><h2>Завдання 11</h2>";
interface DemoProduct {public function getName(): string;}
abstract class DemoAbstractFactory {abstract public function getProduct(): DemoProduct;public static function getFactory(int $choice): self {return match($choice){1=>new DemoFirstFactory(),2=>new DemoSecondFactory(),default=>throw new \InvalidArgumentException('Bad config')};}}
class DemoFirstProduct implements DemoProduct {public function getName(): string {return 'The product from the first factory';}}
class DemoSecondProduct implements DemoProduct {public function getName(): string {return 'The product from second factory';}}
class DemoFirstFactory extends DemoAbstractFactory {public function getProduct(): DemoProduct {return new DemoFirstProduct();}}
class DemoSecondFactory extends DemoAbstractFactory {public function getProduct(): DemoProduct {return new DemoSecondProduct();}}
echo DemoAbstractFactory::getFactory(1)->getProduct()->getName().'<br>';echo DemoAbstractFactory::getFactory(2)->getProduct()->getName();
echo "</section>";
}
namespace LabTask12 {
echo "<section><h2>Завдання 12</h2>";
abstract class ParkVehicle {public function __construct(public string $brand,public string $origin) {} abstract public function category(): string; public function label(): string {return $this->category().': '.$this->brand.' ('.$this->origin.')';}}
abstract class ParkCar extends ParkVehicle {public function category(): string{return 'Легкова машина';}}
abstract class ParkTruck extends ParkVehicle {public function category(): string{return 'Вантажівка';}}
abstract class ParkBus extends ParkVehicle {public function category(): string{return 'Автобус';}}
class UaCar extends ParkCar {} class UaTruck extends ParkTruck {} class UaBus extends ParkBus {}
class ForeignCar extends ParkCar {} class ForeignTruck extends ParkTruck {} class ForeignBus extends ParkBus {}
interface ParkFactory {public function createCar(): ParkCar;public function createTruck(): ParkTruck;public function createBus(): ParkBus;}
class UaFactory implements ParkFactory {public function createCar(): ParkCar{return new UaCar('ЗАЗ','Україна');}public function createTruck(): ParkTruck{return new UaTruck('КрАЗ','Україна');}public function createBus(): ParkBus{return new UaBus('Еталон','Україна');}}
class ForeignFactory implements ParkFactory {public function createCar(): ParkCar{return new ForeignCar('Toyota','Японія');}public function createTruck(): ParkTruck{return new ForeignTruck('Volvo','Швеція');}public function createBus(): ParkBus{return new ForeignBus('Mercedes-Benz','Німеччина');}}
function buildPark(array $cfg): array {$factory=match($cfg['factory']??''){ 'ua'=>new UaFactory(),'foreign'=>new ForeignFactory(),default=>throw new \InvalidArgumentException('Невідома фабрика')};$park=[];foreach(['carNum'=>'createCar','truckNum'=>'createTruck','busNum'=>'createBus'] as $key=>$method){$count=max(0,(int)($cfg[$key]??0));if($count>100)throw new \InvalidArgumentException('Завелика кількість');for($i=0;$i<$count;$i++)$park[]=$factory->$method();}return $park;}
foreach(['ua','foreign'] as $kind){$cfg=parse_ini_string($kind === 'ua' ? "factory=ua\ncarNum=10\ntruckNum=2\nbusNum=4" : "factory=foreign\ncarNum=3\ntruckNum=2\nbusNum=1");echo '<h3>Фабрика: '.htmlspecialchars($kind).'</h3>';foreach(buildPark($cfg) as $vehicle) echo htmlspecialchars($vehicle->label()).'<br>';}
echo "</section>";
}
namespace LabTask13 {
echo "<section><h2>Завдання 13</h2>";
trait CarFieldsTrait {public string $brand='';public int $cylinders=0;public int $power=0;private string $engineNumber='';
 public function set(string $brand,int $cylinders,int $power): void {$this->brand=$brand;$this->cylinders=$cylinders;$this->power=$power;}
 public function get(string $field): mixed {return in_array($field,['brand','cylinders','power'],true)?$this->$field:null;}
 public function setEngineNumber(string $n): void {$this->engineNumber=$n;}
 public function getEngineNumber(): string{return $this->engineNumber;}}
trait CarActionsTrait {public function show(): void {echo "Марка: {$this->brand}, циліндри: {$this->cylinders}, потужність: {$this->power} к.с.<br>";}
 public function search(string $brand): bool{return $this->brand===$brand;}}
interface DomainCar {public function set(string $brand,int $cylinders,int $power): void;public function show(): void;}
class DomesticDomainCar implements DomainCar {use CarFieldsTrait,CarActionsTrait;}
class ForeignDomainCar implements DomainCar {use CarFieldsTrait,CarActionsTrait;}
interface DomainFactory {public function createCar(string $brand,int $cylinders,int $power): DomainCar;}
class DomesticDomainFactory implements DomainFactory {public function createCar(string $brand,int $cylinders,int $power): DomainCar {$c=new DomesticDomainCar();$c->set($brand,$cylinders,$power);return $c;}}
class ForeignDomainFactory implements DomainFactory {public function createCar(string $brand,int $cylinders,int $power): DomainCar {$c=new ForeignDomainCar();$c->set($brand,$cylinders,$power);return $c;}}
$ua=(new DomesticDomainFactory())->createCar('ЗАЗ',4,100);$foreign=(new ForeignDomainFactory())->createCar('Toyota',4,150);
$ua->show();$foreign->show();echo 'Пошук Toyota: '.($foreign->search('Toyota')?'Знайдено':'Не знайдено');
echo "</section>";
}
namespace LabTask14 {
echo "<section><h2>Завдання 14</h2>";
echo '<p>Factory Method делегує створення конкретного продукту підкласам фабрики. Abstract Factory забезпечує створення узгоджених сімейств продуктів (наприклад, вітчизняних і зарубіжних транспортних засобів). Обидва патерни знижують залежність вебсистеми від конкретних класів, хоча додають більше абстракцій.</p>';
echo "</section>";
}
namespace { echo "</body></html>"; }
