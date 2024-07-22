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
                      Toast.fire({
                        icon: "success",
                        title: response.success
                      })
                    window.location.href = '/deshboard/';
                } else {
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
                          Toast.fire({
                            icon: "error",
                            title: response.error
                          });
                }
            },
            error: function(xhr, status, error) {
                alert('Erro na requisição AJAX. Status: ' + status);
            }
        });
    });
});