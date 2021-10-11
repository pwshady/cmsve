<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "app\lib\Basic.php";
require_once "app\lib\Router.php";
require_once "app\lib\Database.php";
require_once "app\lib\Modul.php";

use app\lib\router;
use app\lib\database;
use app\lib\modul;
use app\lib\basic;

session_start();


$router = new Router($_SERVER["REQUEST_URI"]);





