<?php
$dsn = "mysql:dbname=projeto;host=localhost";
$user = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "Erro com o banco de dados: " . $e->getMessage();
    exit;
  }

  ?>
