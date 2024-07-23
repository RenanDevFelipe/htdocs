
// Função para fechar o modal de erro
function closeErrorModal() {
    document.getElementById('errorModal').style.display = 'none';
}

// Função para confirmar a exclusão usando SweetAlert2
$(document).ready(function() {
    $(".delete-btn").click(function() {
        var userId = $(this).data('userid');
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, delete!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Se confirmado, enviar requisição para deletar_usuario.php
                $.ajax({
                    type: "POST",
                    url: "deletar_usuario.php",
                    data: { user_id: userId },
                    success: function(response) {
                        Swal.fire(
                            'Deletado!',
                            'O colaborador foi deletado com sucesso.',
                            'success'
                        ).then(() => {
                            // Atualiza a página ou remove o elemento da lista
                            location.reload(); // recarrega a página após deletar
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Erro!',
                            'Houve um erro ao tentar deletar o colaborador.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
