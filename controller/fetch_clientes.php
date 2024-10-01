<?php
$dsn = "mysql:dbname=projeto;host=localhost";
$user = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o parâmetro de busca foi passado
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($search)) {
        // Busca clientes com base no parâmetro de pesquisa
        $cmd = $pdo->prepare("SELECT * FROM cliente WHERE nome LIKE :search ORDER BY nome");
        $cmd->bindValue(':search', "%$search%");
        $cmd->execute();
        $clientes = $cmd->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Retorna array vazio se não houver pesquisa
        $clientes = [];
    }

    // Retorna como JSON
    echo json_encode($clientes);
    } catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    }
?>
