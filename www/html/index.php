<?php
$host = 'mariadb';
$db = 'intermodular';
$user = 'laravel_user';
$password = 'laravel_password';
try {
 $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
 echo "<h1>Conexión exitosa a MariaDB</h1>";
} catch (PDOException $e) {
 echo "<h1>Error: " . $e->getMessage() . "</h1>";
}
?>