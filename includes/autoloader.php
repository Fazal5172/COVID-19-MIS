<?php
spl_autoload_register(function ($class) {
    // Standard autoloader for our classes folder
    $file = __DIR__ . '/../classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
