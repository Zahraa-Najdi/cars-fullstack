<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");


function getCarByID(){
    global $connection;
    
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $car = Car::find($connection, $_GET["id"]);
        echo ResponseService::response(200, $car->toArray());
        return;
    }

    function getCarByID(){
        global $connection;
        echo ResponseService::response(200, $car->toArray());
        return;
    }
}

function createcar(){
    global $connection;
    Car::create($connection, ['name' => 'BMW', 'color' => 'black', 'year' => 2015]);
}

function updatecar(){
    global $connection;
    car::update($connection, 6, ['name' => 'Mercedes', 'color' => 'Navy', 'year' => 2021]);
}

function deletecar(){
    global $connection;
    Car::delete($connection, 7);
}

?>