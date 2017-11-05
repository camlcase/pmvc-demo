<?php
// Optional: Display all errors when APPLICATION_ENV is in development mode
if (isset($_SERVER['APPLICATION_ENV']) 
    && $_SERVER['APPLICATION_ENV'] == 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Include the pMVC application file
require_once 'lib/pMVC/Application.php';

// Run application
Application::run();