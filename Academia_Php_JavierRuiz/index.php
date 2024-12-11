<?php
session_start();
require "vendor/autoload.php";
require_once "config/config.php";

use Controllers\FrontController;
FrontController::main();

?>