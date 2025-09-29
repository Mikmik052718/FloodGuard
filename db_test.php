<?php
// Fetch environment variables matching CI4 config keys
$host = getenv('database.default.hostname') ?: getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('database.default.database') ?: getenv('DB_NAME') ?: 'test';
$user = getenv('database.default.username') ?: getenv('DB_USER') ?: 'root';
$pass = getenv('database.default.password') ?: getenv('DB_PASSWORD') ?: '';
$port = getenv('database.default.port') ?: getenv('DB_PORT') ?: 3306;
$dbdriver = getenv('database.default.DBDriver') ?: 'mysqli'; // default to mysqli

// Create connection based on driver
if (strtolower($dbdriver) === 'mysqli') {
    $mysqli = new mysqli($host, $user, $pass, $dbname, $port);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    echo 'MySQLi connection successful!';
    $mysqli->close();
} elseif (strtolower($dbdriver) === 'pdo') {
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'PDO connection successful!';
    } catch (PDOException $e) {
        die('PDO Connection failed: ' . $e->getMessage());
    }
} else {
    die('Unsupported DB driver: ' . $dbdriver);
}
?>
