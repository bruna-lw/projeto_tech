<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

$cmd = $pdo->query("SELECT COUNT(*) as total FROM pedido");
$res = $cmd->fetch(PDO::FETCH_ASSOC);
$totalPedidos = $res['total']; // retorna o número de pedidos

require_once 'classes/cliente.php';
// Criação de uma instância da classe Cliente
$cliente = new Cliente("projeto", "localhost", "root", "");
$totalClientes = $cliente->contarClientes();

require_once 'classes/produto.php';
// Criação de uma instância da classe Produto
$produto = new Produto("projeto", "localhost", "root", "");
$totalProdutos = $produto->contarProdutos();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="./assets/css/index.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
</head>

<body>
  <header>
    <?php
      require_once 'header.php';
    ?>
  </header>
  <section class="page-index">
    <div class="container">
      <div class="dash-index">
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Clientes</h2>
              <?php echo "<span>".$totalClientes."</span>"; ?>
            </div>
            <img src="assets/images/icon-users.svg" alt="">
          </div>
          <a href="clientes.php" class="bt-index">Gerenciar clientes</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Produtos</h2>
              <?php echo "<span>".$totalProdutos."</span>"; ?>
            </div>
            <img src="assets/images/icon-product.svg" style="max-width: 76px;" alt="">
          </div>
          <a href="produtos.php" class="bt-index">Gerenciar produto</a>
        </div>
        <div class="blc">
          <div class="d-flex justify-content-between">
            <div>
              <h2>Pedidos</h2>
              <?php echo "<span>".$totalPedidos."</span>"; ?>
            </div>
            <img src="assets/images/icon-pedido.svg" alt="">
          </div>
          <a href="pedidos.php" class="bt-index">Novo pedido</a>
        </div>
      </div>
    </div>
  </section>
</body>

</html>