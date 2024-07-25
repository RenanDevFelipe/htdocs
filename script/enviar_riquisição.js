const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});


$(document).ready(function () {
    $('#formLogin').submit(function (e) {
        e.preventDefault();
        var loginP = document.querySelector('.loginP')
        var loadLogin = document.querySelector('.load-login')
        loadLogin.style.display = 'block'
        loginP.style.display = 'none'
        $.ajax({
            type: 'POST',
            url: '../login/login.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: "success",
                        title: response.success
                    });
                    window.location.href = '../deshboard/index.php'; // Redireciona para o dashboard após o login
                } else {
                    Toast.fire({
                        icon: "error",
                        title: response.error
                    })

                    loadLogin.style.display = 'none'
                    loginP.style.display = 'block'
                }
            },
            error: function (xhr, status, error) {
                alert('Erro na requisição AJAX. Status: ' + status);
            }
        });
    });
});