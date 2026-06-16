<?php $current_page = basename($_SERVER['PHP_SELF']); ?> <style>
    html,
    body {
        min-height: 100%;
        overflow-x: hidden;
    }

    .flex-grow-1 {
        min-width: 0;
        width: 100%;
    }

    body {
        background-color: #121214;
        color: #e1e1e6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* SIDEBAR */
    .sidebar {
        background-color: #1a1a1e;
        min-height: 100vh;
        width: 250px;
        border-right: 1px solid #29292e;
        flex-shrink: 0;
    }

    .brand-logo {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-link-custom {
        color: #8d8d99;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        text-decoration: none;
        border-radius: 8px;
        margin: 4px 15px;
        font-weight: 500;
        transition: 0.3s;
    }

    .nav-link-custom:hover {
        background-color: #29292e;
        color: #ffffff;
    }

    .nav-link-custom.active {
        background-color: #292440;
        color: #996dff;
    }

    .menu-header {
        color: #6e6e77;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px 30px 5px;
        font-weight: 700;
    }

    .card-custom {
        background-color: #1a1a1e;
        border: 1px solid #29292e;
        border-radius: 12px;
    }

    .topbar {
        background-color: #121214;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        border-bottom: 1px solid #1a1a1e;
    }

    .avatar-circle {
        background-color: #7c4dff;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .table-custom {
        color: #e1e1e6 !important;
    }

    .table-custom th {
        color: #6e6e77 !important;
        border-bottom: 1px solid #29292e !important;
        font-size: 13px;
    }

    .table-custom td {
        border-bottom: 1px solid #1a1a1e !important;
        padding: 12px 8px !important;
    }

    /* TABLE RESPONSIVE */
    .table-responsive {
        overflow-x: auto;
    }

    .desktop-sidebar {
        display: block;
    }

    @media (max-width:991.98px) {
        .desktop-sidebar {
            display: none !important;
        }
    }
</style> <!-- Sidebar Desktop -->
<div class="sidebar desktop-sidebar">
    <div class="d-flex align-items-center gap-3 p-4 mb-3">
        <div class="brand-logo"> <img src="logo3.png" width="60" height="60"> </div>
        <div>
            <h6 class="m-0 fw-bold text-white"> PS Rental </h6> <small style="color:#6e6e77;"> Management System </small>
        </div>
    </div>
    <div class="menu-header"> Menu </div> <a href="index.php" class="nav-link-custom <?= ($current_page == 'index.php') ? 'active' : ''; ?>"> 📊 Dashboard </a> <a href="reservasi.php" class="nav-link-custom <?= ($current_page == 'reservasi.php') ? 'active' : ''; ?>"> 📅 Reservasi </a> <a href="pelanggan.php" class="nav-link-custom <?= ($current_page == 'pelanggan.php') ? 'active' : ''; ?>"> 👥 Pelanggan </a> <a href="unit.php" class="nav-link-custom <?= ($current_page == 'unit.php') ? 'active' : ''; ?>"> 📺 Unit PS </a> <a href="petugas.php" class="nav-link-custom <?= ($current_page == 'petugas.php') ? 'active' : ''; ?>"> 😎 Petugas </a>
</div> <!-- Sidebar Mobile -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"> PS Rental </h5> <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"> </button>
    </div>
    <div class="offcanvas-body"> <a href="index.php" class="nav-link-custom <?= ($current_page == 'index.php') ? 'active' : ''; ?>"> 📊 Dashboard </a> <a href="reservasi.php" class="nav-link-custom <?= ($current_page == 'reservasi.php') ? 'active' : ''; ?>"> 📅 Reservasi </a> <a href="pelanggan.php" class="nav-link-custom <?= ($current_page == 'pelanggan.php') ? 'active' : ''; ?>"> 👥 Pelanggan </a> <a href="unit.php" class="nav-link-custom <?= ($current_page == 'unit.php') ? 'active' : ''; ?>"> 📺 Unit PS </a> <a href="petugas.php" class="nav-link-custom <?= ($current_page == 'petugas.php') ? 'active' : ''; ?>"> 😎 Petugas </a> </div>
</div>