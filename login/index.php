<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="/style/login.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script/enviar_riquisição.js"></script>
    <title>Login - Ranking</title>
</head>
<body>
    <section class="login-section">
        <div class="title">
            <h1>Login</h1>
        </div>
        <form id="formLogin" >
            <div class="box-login">
                <label for="email_login">E-mail</label>
                <input type="email" name="email_login" id="emailLogin">
            </div>

            <div class="box-login">
                <label for="senha_login">Senha</label>
                <input type="password" name="senha_login" id="senhaLogin">
            </div>

            <div class="passShow">
                <input type="checkbox" name="checkbox" id="passShow">
                <label for="checbox">Mostrar senha</label>
            </div>

            <div >
                <button type="submit" class="button-login">Login</button>
            </div>
        </form>
    </section>
</body>
<script src="../script/index.js"></script>
</html>