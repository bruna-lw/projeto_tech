let valorSubtotal = 0;

// Função que lida com a entrada do nome do produto e exibe o dropdown de sugestões
$(document).on('input', '.input-produto', function() {
    const query = $(this).val();
    const dropdown = $(this).siblings('.produto-dropdown');

    if (query.length > 0) {
        $.ajax({
            url: 'controller/fetch_produtos.php',
            type: 'GET',
            data: { query: query },
            success: function(data) {
                try {
                    const produtos = JSON.parse(data);
                    dropdown.empty(); // Limpa as opções anteriores
                    
                    if (produtos.length > 0) {
                        produtos.forEach(produto => {
                            const item = $('<div>')
                                .addClass('dropdown-item')
                                .text(produto.nome)
                                .data('id', produto.id_produto)
                                .data('valor', produto.valor) // Armazena o valor do produto
                                .click(function() {
                                    console.log('Produto selecionado:', produto.nome, produto.valor); // Log do produto selecionado

                                    const linha = $(this).closest('tr');
                                    const inputProduto = linha.find('.input-produto');
                                    
                                    inputProduto.val(produto.nome); // Insere o nome do produto no campo
                                    inputProduto.data('valor', produto.valor); // Armazena o valor unitário no input
                                    
                                    const quantidade = parseFloat(linha.find('input[name="produto[quantidade][]"]').val()) || 1; // Quantidade padrão é 1
                                    const valorParcial = quantidade * parseFloat(produto.valor);

                                    linha.find('input[name="valorParcial[]"]').val(valorParcial.toFixed(2)); // Atualiza o valor parcial
                                    dropdown.hide(); // Esconde o dropdown após seleção

                                    calcularSubtotal(); // Atualiza o subtotal
                                });
                            dropdown.append(item);
                        });
                        dropdown.show(); // Mostra o dropdown
                    } else {
                        dropdown.hide(); // Esconde se não houver resultados
                    }
                } catch (error) {
                    console.error("Erro ao processar JSON: ", error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição AJAX: ", status, error);
            }
        });
    } else {
        dropdown.hide(); // Esconde o dropdown se o input estiver vazio
    }
});

// Esconde o dropdown ao clicar fora
$(document).click(function(event) {
    if (!$(event.target).closest('.input-produto').length) {
        $('.produto-dropdown').hide(); // Esconde todos os dropdowns
    }
});

// Função para calcular o valor parcial
function calcularValorParcial(linha) {
    const quantidade = parseFloat(linha.find('input[name="produto[quantidade][]"]').val()) || 0;
    const valorUnitario = parseFloat(linha.find('.input-produto').data('valor')) || 0; // Pega o valor do produto corretamente
    const valorParcial = quantidade * valorUnitario;

    console.log('Calculando valor parcial:', quantidade, valorUnitario, valorParcial); // Log de depuração do cálculo

    // Atualizar o campo valor parcial
    linha.find('input[name="valorParcial[]"]').val(valorParcial.toFixed(2));
}

// Função para calcular o subtotal do pedido
function calcularSubtotal() {
    let subtotal = 0;
    $('#tabela-pedidos tbody tr').each(function() {
        const valorParcial = parseFloat($(this).find('input[name="valorParcial[]"]').val()) || 0;
        subtotal += valorParcial;
    });

    // Atualizar o campo subtotal
    $('input[name="subtotal"]').val(subtotal.toFixed(2));

    valorSubtotal = subtotal;

    // Calcular o valor total com desconto
    calcularValorTotalComDesconto();
}

// Função para calcular o valor total com desconto
function calcularValorTotalComDesconto() {
    const desconto = parseFloat($('#input-desconto').val()) || 0; // Pega o valor do campo desconto
    const valorComDesconto = valorSubtotal - desconto;

    // Atualizar o campo valor total com desconto
    $('#valor-total-hidden').val(valorComDesconto.toFixed(2));
    $('#valor-total').val(valorComDesconto.toFixed(2));
}

// Evento ao alterar a quantidade
$(document).on('input', 'input[name="produto[quantidade][]"]', function() {
    const linha = $(this).closest('tr');
    let quantidade = parseFloat($(this).val()) || 1; // Define 1 como valor padrão se for inválido
    const valorUnitario = parseFloat(linha.find('.input-produto').data('valor')) || 0;
    
    // Valida se a quantidade é maior que 0, caso contrário, define como 1
    if (quantidade <= 0) {
        quantidade = 1;
        $(this).val(1); // Define o valor do input para 1
        alert('A quantidade deve ser maior que 0. O valor foi ajustado para 1.');
    }

    const valorParcial = quantidade * valorUnitario;

    console.log("Calculando valor parcial:", quantidade, valorUnitario, valorParcial);

    // Atualizar o campo valor parcial
    linha.find('input[name="valorParcial[]"]').val(valorParcial.toFixed(2));
    calcularSubtotal(); // Atualiza o subtotal após mudar a quantidade
});

// Evento ao alterar o valor do desconto
$(document).on('input', '#input-desconto', function() {
    calcularValorTotalComDesconto(); // Recalcula o valor total com desconto
});
