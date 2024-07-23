var buttonCancelar = document.getElementById('buttonCancelarEdit');

buttonCancelar.addEventListener('click', () => {
    location.reload()
})

document.addEventListener('DOMContentLoaded', (event) => {
    var editButtons = document.querySelectorAll('.buttonEditar');

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            var userId = button.getAttribute('data-id');
            var ButtonAdd = document.querySelector('.button-add-colaboradores');
            ButtonAdd.style.display = 'none'
            editUser(userId);
        });
    });
});

function editUser(userId) {
    var PageSection = document.querySelector(".list-colaboradores");
    var PageEdit = document.querySelector(".edit-colaborador");

    $.ajax({
        type: 'GET',
        url: 'get_colaborador.php',
        data: { id: userId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                document.getElementById('editUserId').value = response.data.id_colaborador;
                document.getElementById('editNome').value = response.data.nome_colaborador;
                document.getElementById('editSetor').value = response.data.setor_colaborador;
                document.getElementById('editId').value = response.data.id_ixc;

                PageSection.classList.add('hidden');
                PageEdit.style.display = 'flex';
            } else {
                Swal.fire('Erro', 'Erro ao carregar os dados do usuário', 'error');
            }
        },
        error: function (xhr, status, error) {
            Swal.fire('Erro', 'Erro ao carregar os dados do usuário', 'error');
        }
    });
}


document.addEventListener('DOMContentLoaded', (event) => {
    var addSetorButton = document.getElementById('formEditColaborador');

    addSetorButton.addEventListener('click', () => {
        event.preventDefault();
        var form = document.getElementById('formSetorEdit');
        var nomeSetor = document.getElementById('editNome').value.trim();

        if (nomeSetor === '') {
            Swal.fire('Erro', 'Preencha todos os campos por favor!', 'error');
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'update_setor.php',
            data: $(form).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Setor atualizado com sucesso!',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erro', response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Erro', 'Erro ao atualizar o setor', 'error');
            }
        });
    })


});

