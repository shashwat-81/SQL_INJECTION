<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'bank_portal';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
