document.addEventListener("DOMContentLoaded", function() {
  // URL do PHP que retorna a imagem do usuário
  var imageUrl = 'controller/get-user-image.php'; 

  // ID da imagem que você quer alterar
  var userImageElement = document.getElementById('userImage');

  // Fazer a requisição para obter a imagem do usuário
  fetch(imageUrl)
    .then(response => response.json())
    .then(data => {
      if (data.image) {
        // Caso o usuário tenha uma imagem, converte o base64 para o formato esperado e define como src
        userImageElement.src = `data:image/jpg;base64,${data.image}`;
      } else {
        // Se não tiver imagem, mantém a imagem padrão (ou você pode setar outra imagem padrão aqui)
        userImageElement.src = 'assets/images/icon-feather-user.svg';
      }
    })
    .catch(error => {
      console.error('Erro ao carregar a imagem do usuário:', error);
      // Defina a imagem padrão se houver um erro
      userImageElement.src = 'assets/images/icon-feather-user.svg';
    });
});

