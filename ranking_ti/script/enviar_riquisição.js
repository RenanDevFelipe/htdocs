$(document).ready(function() {
    $('#formLogin').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: '../login/login.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = '../deshboard/index.php'; // Redireciona para o dashboard após o login
                } else {
                    alert(response.error); // Exibe mensagem de erro caso o login falhe
                }
            },
            error: function(xhr, status, error) {
                alert('Erro na requisição AJAX. Status: ' + status);
            }
        });
    });
});