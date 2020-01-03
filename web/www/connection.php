<?php
// composer.json conf /vendor/autoload.php packages

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

function openMysql()
{
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $db = $_ENV['DB_DATABASE'];
    $port = intval($_ENV['DB_PORT']);
    $connection = new mysqli($host, $user, $password, $db, $port, "/var/lib/mysql/mysql.sock");

    // failed connection
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    return $connection;
}

function closeMysql($connection)
{
    $connection->close();
}
?>

