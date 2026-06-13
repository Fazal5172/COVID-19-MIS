<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::logout();
header("Location: index.php");
exit();
