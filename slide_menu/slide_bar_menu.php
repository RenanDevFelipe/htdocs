<link rel="stylesheet" href="../style/dashboard.css?v=1">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name=" viewport" content="width=device-width, initial-scale=1.0">



<div class="sidebar showMenu">
    <div class="logo-details">
        <i class='bx bxl-audible'></i>
        <span class="logo_name">T.I Connect</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/deshboard/">
                <i class='bx bx-star'></i>
                <span class="link_name">Avaliar</span>
            </a>
            <ul class="sub-menu">
                <li><a class="link_name" href="/deshboard/">Avaliar</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Ranking</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Ranking</a></li>
                <li><a href="#">Mensal</a></li>
                <li><a href="#">Anual</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="link_name">Ranking por Setor</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Ranking por Setor</a></li>
            </ul>
        </li>

        <li>
            <a href="#">
                <i class='bx bx-history'></i>
                <span class="link_name">O.S Aberta</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">O.S Aberta</a></li>
            </ul>
        </li>
        <li>
            <a href="/deshboard/settings/">
                <i class='bx bx-cog'></i>
                <span class="link_name">Setting</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/deshboard/settings/">Setting</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <!--<img src="image/profile.jpg" alt="profileImg">-->
                </div>
                <div class="name-job">
                    <div class="profile_name"><?php echo $_SESSION['user_name'] ?></div>
                    <div class="job"><?php echo $_SESSION['user_setor'] ?></div>
                </div>

                <i class='bx bx-log-out' id="logout"></i>
            </div>
        </li>
    </ul>
</div>

<script>
    var Logout = document.getElementById('logout');

    Logout.addEventListener('click', () => {
            Swal.fire({
                title: "Deseja realmente sair?",
                icon: "question",
                confirmButtonText: "Sim",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                showCloseButton: true
            }).then((result) => {
                if(result.isConfirmed) {
                    window.location.href = '../logout.php';
                }
            })

    });
</script>