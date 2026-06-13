<?php
// Centralized bootstrap / legacy bridge
// This file can still be included by any older or custom scripts
require_once __DIR__ . '/includes/autoloader.php';

$user = "root";
$pass = "";
$server = "localhost";
$db = "covidrecorddatabase";

try {
    $con = mysqli_connect($server, $user, $pass, $db);
} catch (Throwable $e) {
    $con = null;
}
