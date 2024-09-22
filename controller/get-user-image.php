<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Conexão com o banco de dados usando PDO
$dsn = "mysql:dbname=projeto;host=localhost";
$user = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => "Erro com o banco de dados: " . $e->getMessage()]);
    exit;
}

// Verificar se o usuário está logado e existe um ID de usuário na sessão
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Consulta para obter a imagem do usuário
    $query = "SELECT imagem FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['imagem']) {
        // Codifica a imagem em base64
        $imageBase64 = base64_encode($result['imagem']);
        echo json_encode(['image' => $imageBase64]);
    } else {
        echo json_encode(['image' => null]);
    }
} else {
    echo json_encode(['image' => null]);
}

?>
