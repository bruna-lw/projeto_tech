$(document).ready(function() {
    // Função para buscar clientes com base na consulta
    function fetchClientes(query) {
        $.ajax({
            url: 'controller/fetch_clientes.php',
            type: 'GET',
            data: { search: query },  // Passa o termo de busca
            success: function(data) {
                const clientes = JSON.parse(data);
                const dropdown = $('#cliente-dropdown');
                dropdown.empty(); // Limpa opções anteriores

                if (clientes.length > 0) {
                    clientes.forEach(cliente => {
                        const item = $('<div>')
                            .addClass('dropdown-item')
                            .text(cliente.nome)
                            .data('id', cliente.id_cliente)
                            .click(function() {
                                $('#input-cliente').val(cliente.nome); // Preenche o input
                                dropdown.hide(); // Esconde o dropdown
                            });
                        dropdown.append(item);
                    });
                    dropdown.show(); // Mostra o dropdown se houver resultados
                } else {
                    dropdown.hide(); // Esconde o dropdown se não houver resultados
                }
            },
            error: function() {
                console.error('Erro ao buscar clientes.');
            }
        });
    }

    // Evento ao digitar no input
    $('#input-cliente').on('input', function() {
        const query = $(this).val().trim(); // Obtém o valor digitado

        // Verifica se há caracteres digitados
        if (query.length > 0) {
            fetchClientes(query); // Busca clientes com base na consulta
        } else {
            $('#cliente-dropdown').hide(); // Esconde o dropdown se não houver texto
        }
    });

    // Esconder o dropdown ao clicar fora
    $(document).click(function(event) {
        if (!$(event.target).closest('#input-cliente, #cliente-dropdown').length) {
            $('#cliente-dropdown').hide(); // Esconde o dropdown
        }
    });
});
