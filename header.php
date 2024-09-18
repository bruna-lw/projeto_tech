<div class="container">
      <a href="dashboard.php" class="logo">
        <img src="assets/images/ho.svg" alt="" />
      </a>
      <div class="blc-user">
        <img src="assets/images/icon-feather-user.svg" alt="" />
        <span>
          Olá, <br />
          <?php if (isset($_SESSION['user_name'])): ?>
            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
          <?php else: ?>
            visitante
          <?php endif; ?>
        </span>
        <img src="assets/images/arrow-down.svg" alt="" />
        <div class="menu-drop">
          <a href="clientes.php">Gerenciar clientes</a>
          <a href="produtos.php">Gerenciar produtos</a>
          <a href="estoques.php">Estoque de produtos</a>
          <a href="cadastro-cliente.php">Cadastrar cliente</a>
          <!-- <a href="cadastro-usuario.php">Cadastrar usuário</a> -->
          <a href="cadastro-produto.php">Cadastrar produto</a>
          <a href="pedidos.php">Novo pedido</a>
          <a href="minha-conta.php">Minha conta</a>
          <a href="controller/logout.php">Sair da conta</a>
        </div>
      </div>

</div>