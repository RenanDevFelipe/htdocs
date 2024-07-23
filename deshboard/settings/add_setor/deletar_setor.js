$(document).ready(function() {
    $('.delete-button').click(function() {
        const itemId = $(this).data('id');

        Swal.fire({
            title: "Você tem certeza?",
            text: "Você não poderá reverter isso!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, delete isso!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: 'delete_setor.php',
                    data: { id: itemId },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire({
                                title: "Deletado!",
                                text: "O item foi deletado.",
                                icon: "success"
                            }).then(() => {
                                location.reload(); // Recarregar a página
                            });
                        } else {
                            Swal.fire({
                                title: "Erro!",
                                text: res.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Erro!",
                            text: "Ocorreu um erro ao tentar deletar o item.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
})
