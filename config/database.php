<!-- config\database.php -->
<?php

$host = 'localhost';
$db   = 'school-pcs'; // 使用するデータベース名
$user = 'root'; // XAMPPのデフォルトユーザー名
$pass = ''; // XAMPPのデフォルトではパスワードは空

// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// PDO達
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
