document.addEventListener('DOMContentLoaded', (event) => {
    var addSetorButton = document.getElementById('addSetor');

    addSetorButton.addEventListener('click', () => {
        Swal.fire({
            title: "Adicionar Setor?",
            icon: "question",
            confirmButtonText: "Sim",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById('formSetor');
                var nomeSetor = document.getElementById('nome_setor').value.trim();

                if (nomeSetor === '') {
                    Swal.fire('Erro', 'Preencha todos os campos por favor!', 'error');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'add_setor.php',
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
                        Swal.fire('Erro', 'Erro pior ainda: ' + status, 'error');
                    }
                });
            }
        });
    });
});
