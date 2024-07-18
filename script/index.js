var passShow = document.getElementById('passShow');

function showPass(){
    var inputPass = document.getElementById('senhaLogin')

    if(inputPass.type == 'password'){
        inputPass.type = 'text'
    }else{
        inputPass.type = 'password'
    }
}

passShow.addEventListener('click', showPass)