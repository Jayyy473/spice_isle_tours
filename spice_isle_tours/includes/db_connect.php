<?php
$isLocal = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;

if ($isLocal) {
    // Local MAMP setup
    $host = 'localhost';
    $user = 'root';
    $password = 'root'; // your MAMP MySQL password
    $database = 'spice_isle_tours';
    $port = 3306; // default MySQL port
} else {
    // Production (Render + Aiven)
    $host = getenv('DB_HOST') ?: 'mysql-34b1fc3e-queenb70-0513.i.aivencloud.com';
    $user = getenv('DB_USER') ?: 'avnadmin';
    $password = getenv('DB_PASSWORD') ?: '';
    $database = getenv('DB_NAME') ?: 'defaultdb';
    $port = getenv('DB_PORT') ?: 15515;
    $ssl_ca = '/etc/secrets/ca.pem';

    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);
    mysqli_real_connect($conn, $host, $user, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL);
}

if (!isset($conn)) {
    $conn = new mysqli($host, $user, $password, $database, $port);
}

if ($conn->connect_errno) {
    die("❌ Database connection failed: " . $conn->connect_error);
}
?>
