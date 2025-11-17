<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");


function getCarByID(){
    global $connection;
    
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $car = Car::find($connection, $id);
        echo ResponseService::response(200, $car->toArray());
        return;
    }

    function getCarByID(){
        global $connection;
        echo ResponseService::response(200, $car->toArray());
        return;
    }
}

function createCar(){
    global $connection;
    Car::create($connection, ['name' => 'BMW', 'color' => 'black', 'year' => 2015]);
}

function updateCar(){
    global $connection;
    car::update($connection, ['name' => 'Mercedes', 'color' => 'Navy', 'year' => 2021]);
}

function static deleteCar(){
    global $connection;
    Car::delete($connection);
}

?>