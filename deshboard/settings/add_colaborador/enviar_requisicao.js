document.addEventListener('DOMContentLoaded', (event) => {
    var addSetorButton = document.getElementById('addColaborador');

    addSetorButton.addEventListener('click', () => {
        Swal.fire({
            title: "Adicionar Colaborador?",
            icon: "question",
            confirmButtonText: "Sim",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById('formColaborador');
                var nomeColaborador = document.getElementById('nome_colaborador').value.trim();
                var idIxc = document.getElementById('id_ixc').value.trim();

                if (nomeColaborador === ''&& idIxc === '') {
                    Swal.fire('Erro', 'Preencha todos os campos por favor!', 'error');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'inserir_colaborador.php',
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
