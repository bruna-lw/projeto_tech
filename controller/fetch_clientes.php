
<?php
$dsn = "mysql:dbname=projeto;host=localhost";
$user = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar clientes
    $cmd = $pdo->query("SELECT id_cliente, nome FROM cliente ORDER BY nome");
    $clientes = $cmd->fetchAll(PDO::FETCH_ASSOC);

    // Retornar como JSON
    echo json_encode($clientes);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
