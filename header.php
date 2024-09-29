<script src="controller/user-image.js"></script>

<div class="container">
      <a href="dashboard.php" class="logo">
        <img src="assets/images/ho.svg" alt="" />
      </a>
      <div class="blc-user">
        <img id="userImage" src="assets/images/icon-feather-user.svg" alt="Imagem do usuário" style="max-width: 40px; height: 40px;" />
        <span>
          Olá, <br />
          <?php if (isset($_SESSION['user_name'])):
            $nomeCompleto = explode(' ', htmlspecialchars($_SESSION['user_name'])); //Quebra o nome em array de palavras separadas por espaço
            echo $nomeCompleto[0]; ?>
          <?php else: ?>
            visitante
          <?php endif; ?>
        </span>
        <img src="assets/images/arrow-down.svg" alt="" />
        <div class="menu-drop">
          <a href="clientes.php">Gerenciar clientes</a>
          <a href="produtos.php">Gerenciar produtos</a>
          <a href="estoques.php">Relatório de estoque</a>
          <a href="vendas.php">Relatório de vendas</a>
          <a href="cadastro-cliente.php">Cadastrar cliente</a>
          <!-- <a href="cadastro-usuario.php">Cadastrar usuário</a> -->
          <a href="cadastro-produto.php">Cadastrar produto</a>
          <a href="novo-pedido.php">Novo pedido</a>
          <a href="minha-conta.php">Minha conta</a>
          <a href="controller/logout.php">Sair da conta</a>
        </div>
      </div>

</div>