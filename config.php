<?php
// config.php

// Autoload classes
// Autoload classes and tests
spl_autoload_register(function ($class_name) {
    $class_file = '';

    // Check if the class is in the classes folder
    $class_file = './classes/' . $class_name . '.php';
    if (file_exists($class_file)) {
        include $class_file;
        return;
    }

    // Check if the class is in the tests folder
    $class_file = './tests/' . $class_name . '.php';
    if (file_exists($class_file)) {
        include $class_file;
        return;
    }
});


// Database configuration
$host = 'localhost'; // Change this to your database host
$dbname = 'Vjezba1'; // Change this to your database name
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password

try {
    // Establish database connection using PDO
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $db = new PDO($dsn, $username, $password, $options);
    //echo "Connected successfully";
} catch (PDOException $e) {
    // If connection fails, handle the error
    echo "Connection failed: " . $e->getMessage();
}
?>
