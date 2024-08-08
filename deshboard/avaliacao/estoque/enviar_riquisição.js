document.addEventListener('DOMContentLoaded', (event) => {
    var formAvaliacaoEstoque = document.getElementById('formAvaliacaoEstoque');

    formAvaliacaoEstoque.addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        $.ajax({
            type: 'POST',
            url: 'update_estoque.php', // O URL do seu script PHP
            data: $(this).serialize(), // Serializa os dados do formulário
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Sucesso',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erro', response.message, 'error'); // Exibe a mensagem de erro detalhada
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Erro', 'Erro ao atualizar os dados: ' + error, 'error');
            }
        });
    });
});
