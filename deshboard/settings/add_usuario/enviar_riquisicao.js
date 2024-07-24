document.addEventListener('DOMContentLoaded', (event) => {
    var addSetorButton = document.getElementById('addUser');

    addSetorButton.addEventListener('click', () => {
        Swal.fire({
            title: "Adicionar usuário?",
            icon: "question",
            confirmButtonText: "Sim",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById('formUser');

                $.ajax({
                    type: 'POST',
                    url: 'add_usuario.php',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Sucesso',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Recarrega a página após o sucesso
                            });
                        } else {
                            Swal.fire('Erro', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Erro', 'Erro na Riquisição: ' + status, 'error');
                    }
                });
            }
        });
    });
});