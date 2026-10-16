<?php

header('Content-Type: text/html; charset=utf-8');
echo '<!doctype html><html lang="uk"><meta charset="utf-8"><title>Породжуючі патерни PHP</title><style>body{font:16px Arial;max-width:950px;margin:30px auto;line-height:1.6}section{border:1px solid #ddd;padding:15px;margin:15px 0}h2{color:#18527d}</style><h1>Породжуючі патерни PHP — варіант 3</h1>';
function titleTask($n,$name=''){echo '<section><h2>Завдання '.$n.' '.htmlspecialchars($name,ENT_QUOTES,'UTF-8').'</h2>';}
function endTask(){echo '</section>';}
// 1. Singleton
class SingletonDemo {private static $instance=null;private function __construct(){echo 'Об’єкт Singleton створено.<br>';}private function __clone(){}public function __wakeup(){throw new Exception('Заборонено');}public static function getInstance(){if(self::$instance===null)self::$instance=new self();return self::$instance;}}
titleTask(1,'Singleton');$s1=SingletonDemo::getInstance();$s2=SingletonDemo::getInstance();$s3=SingletonDemo::getInstance();echo 'Усі три посилання на один об’єкт: '.(($s1===$s2&&$s2===$s3)?'Так':'Ні');endTask();
// 2. Singleton trait
trait SingletonTrait {private static $instance=null;private function __construct(){}private function __clone(){}public function __wakeup(){throw new Exception('Заборонено');}public static function getInstance(){if(self::$instance===null)self::$instance=new self();return self::$instance;}}
class AppSettings {use SingletonTrait;public $language='uk';}
titleTask(2,'Singleton через трейт');$a=AppSettings::getInstance();$b=AppSettings::getInstance();$a->language='en';echo 'Один об’єкт: '.($a===$b?'Так':'Ні').'; мова: '.$b->language;endTask();
// 3. Singleton database
class SingletonDB {private static $instance=null;private $connection=null;private function __construct(){if(class_exists('mysqli')){$this->connection=@new mysqli('localhost','root','');if($this->connection->connect_errno){echo 'MySQL недоступний (демонстрація Singleton працює без бази).<br>';$this->connection=null;}else{echo 'Підключення до MySQL створено один раз.<br>';$this->connection->set_charset('utf8');}}else echo 'Розширення mysqli відсутнє.<br>';}private function __clone(){}public function __wakeup(){throw new Exception('Заборонено');}public static function getInstance(){if(self::$instance===null)self::$instance=new self();return self::$instance;}public function getData(){if(!$this->connection)return array();$r=$this->connection->query('SELECT * FROM menu');if(!$r)return array();$rows=array();while($row=$r->fetch_assoc())$rows[]=$row;return $rows;}}
titleTask(3,'Singleton для бази даних');$d1=SingletonDB::getInstance();$d2=SingletonDB::getInstance();$d3=SingletonDB::getInstance();echo 'Єдиний екземпляр підключення: '.(($d1===$d2&&$d2===$d3)?'Так':'Ні');endTask();
titleTask(4,'Висновок Singleton');echo 'Singleton забезпечує єдиний екземпляр класу в межах одного виконання PHP-скрипту та спільну точку доступу до нього. Це корисно для керування налаштуваннями або підключенням до БД, але не слід зловживати глобальним станом.';endTask();
// 5. Factory
class Automobile {private $make;private $model;public function __construct($make,$model){$this->make=$make;$this->model=$model;}public function getMakeAndModel(){return $this->make.' '.$this->model;}}
class AutomobileFactory {public static function create($make,$model){return new Automobile($make,$model);}}
titleTask(5,'Factory');echo AutomobileFactory::create('Bugatti','Veyron')->getMakeAndModel();endTask();
// 6. Factory for lab 1 domain
class LabCar {public $brand;public $cylinders;public $power;private $engineNumber;public function set($brand,$cylinders,$power){$this->brand=$brand;$this->cylinders=$cylinders;$this->power=$power;}public function get($field){if(in_array($field,array('brand','cylinders','power')))return $this->$field;return null;}public function show(){echo 'Марка: '.$this->brand.', циліндри: '.$this->cylinders.', потужність: '.$this->power.' к.с.<br>';}public function search($brand){return $this->brand===$brand;}public function setEngineNumber($n){$this->engineNumber=$n;}public function getEngineNumber(){return $this->engineNumber;}}
class LabCarFactory {public static function create($brand,$cylinders,$power){$c=new LabCar();$c->set($brand,$cylinders,$power);return $c;}}
titleTask(6,'Factory для автомобілів лабораторної №1');$cars=array(LabCarFactory::create('Toyota',4,150),LabCarFactory::create('BMW',6,250),LabCarFactory::create('Audi',4,190));foreach($cars as $car)$car->show();echo 'Пошук BMW: '.($cars[1]->search('BMW')?'Знайдено':'Не знайдено');endTask();
// 7. Vehicle factory
abstract class Vehicle {public $country;public $brand;public $year;public function __construct($country,$brand,$year){$this->country=$country;$this->brand=$brand;$this->year=$year;}abstract public function details();}
class CarVehicle extends Vehicle {public $engine;public $power;public $color;public function __construct($country,$brand,$year,$engine,$power,$color){parent::__construct($country,$brand,$year);$this->engine=$engine;$this->power=$power;$this->color=$color;}public function details(){return 'Автомобіль '.$this->brand.': '.$this->engine.', '.$this->power.' к.с., '.$this->color;}}
class BikeVehicle extends Vehicle {public $weight;public $type;public $wheelDiameter;public function __construct($country,$brand,$year,$weight,$type,$wheelDiameter){parent::__construct($country,$brand,$year);$this->weight=$weight;$this->type=$type;$this->wheelDiameter=$wheelDiameter;}public function details(){return 'Велосипед '.$this->brand.': '.$this->weight.' кг, '.$this->type.', колесо '.$this->wheelDiameter.' дюймів';}}
class MotorcycleVehicle extends Vehicle {public $engine;public $color;public $type;public function __construct($country,$brand,$year,$engine,$color,$type){parent::__construct($country,$brand,$year);$this->engine=$engine;$this->color=$color;$this->type=$type;}public function details(){return 'Мотоцикл '.$this->brand.': '.$this->engine.', '.$this->color.', '.$this->type;}}
class VehicleFactory {public static function create($type,$data){switch(strtolower($type)){case 'car':return new CarVehicle($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);case 'bike':return new BikeVehicle($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);case 'motorcycle':return new MotorcycleVehicle($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);default:throw new InvalidArgumentException('Фабрика не може створити цей транспортний засіб');}}}
titleTask(7,'Фабрика транспортних засобів');foreach(array(VehicleFactory::create('car',array('Японія','Toyota',2020,'бензин',150,'чорний')),VehicleFactory::create('bike',array('Україна','Ardis',2023,14,'гірський',29)),VehicleFactory::create('motorcycle',array('Японія','Honda',2022,'600 см3','червоний','спортивний'))) as $v)echo htmlspecialchars($v->details(),ENT_QUOTES,'UTF-8').'<br>';try{VehicleFactory::create('plane',array());}catch(Exception $e){echo $e->getMessage();}endTask();
titleTask(8,'Висновок Factory');echo 'Factory централізує створення об’єктів і відокремлює клієнтський код від конкретних конструкторів.';endTask();
// 9. Factory Method
interface Product9 {public function getName();}interface Factory9 {public function getProduct();}
class FirstProduct9 implements Product9 {public function getName(){return 'The first product';}}
class SecondProduct9 implements Product9 {public function getName(){return 'Second product';}}
class FirstFactory9 implements Factory9 {public function getProduct(){return new FirstProduct9();}}
class SecondFactory9 implements Factory9 {public function getProduct(){return new SecondProduct9();}}
titleTask(9,'Factory Method');$f1=new FirstFactory9();$f2=new SecondFactory9();echo $f1->getProduct()->getName().'<br>'.$f2->getProduct()->getName();endTask();
// 10. Factory Method lab 1
abstract class CarCreator10 {abstract public function create();}
class ToyotaCreator10 extends CarCreator10 {public function create(){return LabCarFactory::create('Toyota',4,150);}}
class BMWCreator10 extends CarCreator10 {public function create(){return LabCarFactory::create('BMW',6,250);}}
titleTask(10,'Factory Method для предметної області лабораторної №1');$creators=array(new ToyotaCreator10(),new BMWCreator10());foreach($creators as $creator)$creator->create()->show();endTask();
// 11. Abstract Factory
interface Product11 {public function getName();}abstract class AbstractFactory11 {abstract public function getProduct();public static function getFactory($choice){if($choice==1)return new FirstFactory11();if($choice==2)return new SecondFactory11();throw new InvalidArgumentException('Bad config');}}
class FirstProduct11 implements Product11 {public function getName(){return 'The product from the first factory';}}
class SecondProduct11 implements Product11 {public function getName(){return 'The product from second factory';}}
class FirstFactory11 extends AbstractFactory11 {public function getProduct(){return new FirstProduct11();}}
class SecondFactory11 extends AbstractFactory11 {public function getProduct(){return new SecondProduct11();}}
titleTask(11,'Abstract Factory');echo AbstractFactory11::getFactory(1)->getProduct()->getName().'<br>'.AbstractFactory11::getFactory(2)->getProduct()->getName();endTask();
// 12. Abstract Factory car park
abstract class ParkVehicle {protected $brand;protected $origin;public function __construct($brand,$origin){$this->brand=$brand;$this->origin=$origin;}abstract public function category();public function label(){return $this->category().': '.$this->brand.' ('.$this->origin.')';}}
abstract class ParkCar extends ParkVehicle {public function category(){return 'Легкова машина';}}
abstract class ParkTruck extends ParkVehicle {public function category(){return 'Вантажівка';}}
abstract class ParkBus extends ParkVehicle {public function category(){return 'Автобус';}}
class UaCar extends ParkCar {}class UaTruck extends ParkTruck {}class UaBus extends ParkBus {}class ForeignCar extends ParkCar {}class ForeignTruck extends ParkTruck {}class ForeignBus extends ParkBus {}
interface ParkFactory {public function createCar();public function createTruck();public function createBus();}
class UaParkFactory implements ParkFactory {public function createCar(){return new UaCar('ЗАЗ','Україна');}public function createTruck(){return new UaTruck('КрАЗ','Україна');}public function createBus(){return new UaBus('Еталон','Україна');}}
class ForeignParkFactory implements ParkFactory {public function createCar(){return new ForeignCar('Toyota','Японія');}public function createTruck(){return new ForeignTruck('Volvo','Швеція');}public function createBus(){return new ForeignBus('Mercedes-Benz','Німеччина');}}
function buildPark($config){$factory=$config['factory']==='ua'?new UaParkFactory():new ForeignParkFactory();$result=array();foreach(array('carNum'=>'createCar','truckNum'=>'createTruck','busNum'=>'createBus') as $key=>$method){$n=min(100,max(0,(int)$config[$key]));for($i=0;$i<$n;$i++)$result[]=$factory->$method();}return $result;}
titleTask(12,'Автопарк: українська та закордонна фабрики');foreach(array('ua','foreign') as $kind){$config=parse_ini_string("factory=$kind\ncarNum=10\ntruckNum=2\nbusNum=4");echo '<h3>Фабрика: '.$kind.'</h3>';foreach(buildPark($config) as $v)echo htmlspecialchars($v->label(),ENT_QUOTES,'UTF-8').'<br>';}endTask();
// 13. Abstract Factory with traits
trait CarFieldsTrait {public $brand;public $cylinders;public $power;private $engineNumber;public function set($brand,$cylinders,$power){$this->brand=$brand;$this->cylinders=$cylinders;$this->power=$power;}public function get($field){return in_array($field,array('brand','cylinders','power'))?$this->$field:null;}public function setEngineNumber($n){$this->engineNumber=$n;}public function getEngineNumber(){return $this->engineNumber;}}
trait CarActionsTrait {public function show(){echo 'Марка: '.$this->brand.', циліндри: '.$this->cylinders.', потужність: '.$this->power.' к.с.<br>';}public function search($brand){return $this->brand===$brand;}}
abstract class DomainCar13 {use CarFieldsTrait,CarActionsTrait;abstract public function origin();}
class DomesticCar13 extends DomainCar13 {public function origin(){return 'Вітчизняний';}}
class ForeignCar13 extends DomainCar13 {public function origin(){return 'Зарубіжний';}}
interface DomainFactory13 {public function createCar($brand,$cylinders,$power);}
class DomesticFactory13 implements DomainFactory13 {public function createCar($brand,$cylinders,$power){$c=new DomesticCar13();$c->set($brand,$cylinders,$power);return $c;}}
class ForeignFactory13 implements DomainFactory13 {public function createCar($brand,$cylinders,$power){$c=new ForeignCar13();$c->set($brand,$cylinders,$power);return $c;}}
titleTask(13,'Abstract Factory + трейти для автомобілів лабораторної №1');$u=(new DomesticFactory13())->createCar('ЗАЗ',4,100);$f=(new ForeignFactory13())->createCar('Toyota',4,150);echo $u->origin().': ';$u->show();echo $f->origin().': ';$f->show();echo 'Пошук Toyota: '.($f->search('Toyota')?'Знайдено':'Не знайдено');endTask();
titleTask(14,'Загальний висновок');echo 'Factory Method дозволяє підкласам визначати конкретний продукт, а Abstract Factory створює узгоджені сімейства об’єктів. Обидва патерни спрощують розвиток веб-орієнтованих систем, знижуючи залежність коду від конкретних реалізацій.';endTask();echo '</html>';
