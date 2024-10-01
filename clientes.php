<?php
// Inicia a sessão no início do script, se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'classes/cliente.php';
// Criação de uma instância da classe Cliente
$cliente = new Cliente("projeto", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de cliente</title>
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/tvf0cut.css">
  <link rel="stylesheet" href="./assets/css/styles2.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .search-container {
      display: flex;
      flex-direction: column;
    }

    #cliente-input {
      width: 300px;
    }
  </style>
</head>

<body>
  <header>
    <?php
      require_once 'header.php';
    ?>
  </header>
  <section class="page-gerenciamento-cliente paddingBottom50">
    <div class="container">
      <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="link-voltar">
          <img src="assets/images/arrow.svg" alt="">
          <span>Gerenciamento de cliente</span>
        </a>
        <a href="cadastro-cliente.php" class="button-default bt-add">Adicionar novo cliente</a>
      </div>
      <div class="search-container">
        <label for="">Buscar cliente:</label>
        <input type="text" id="cliente-input" placeholder="Digite o nome do cliente" list="cliente-list" autocomplete="off" style="margin: 10px 0; width: 200px; height: 20px;">
        <datalist id="cliente-list"></datalist>
      </div>
      <script src="controller/busca_cliente.js"></script>
      <div class="shadow-table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>E-mail</th>
              <th>Telefone</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $dados = $cliente->buscarDados();
              if(count($dados) > 0){
                  for ($i=0; $i < count($dados); $i++){
                      // abrindo a linha para preencher os dados com <tr> em html
                      echo "<tr>";
                      foreach ($dados[$i] as $k => $v) {
                              // abrindo o campo para preencher a coluna com <td> em html
                              echo "<td>".$v."</td>";
                      }
                      // ultima coluna não é preenchida com dados do banco, pois são links fixos. Por isso fecha o php, deixa o html e volta a abrir php após.
                    ?><td>
                      <a href="editar-cliente.php?id_up=<?php echo $dados[$i]['id_cliente']; ?>" class="edit-button">Editar</a> 
                      <a href="clientes.php?id=<?php echo $dados[$i]['id_cliente']; ?>" class="edit-button">Excluir</a>
                </td><?php
                  }
                      echo "</tr>";
              }
            ?> 
          </tbody>
        </table>
      </div>
    </div>
  </section>
</body>

</html>

<?php
  // Método para excluir cliente a partir do botão Excluir
  if(isset($_GET['id'])){
    $id_cli = addslashes($_GET['id']);
    $cliente->excluirCliente($id_cli);
    header("location: clientes.php");
  }
?>