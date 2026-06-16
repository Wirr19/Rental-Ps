<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    @media (max-width:768px) {

        .topbar {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        .topbar h4 {
            font-size: 1.2rem;
        }

    }
</style>
<div class="topbar d-flex justify-content-between align-items-center px-3 py-3 w-100" style="border:0; box-shadow:none;">

    <!-- Kiri -->
    <div class="d-flex align-items-center">

        <button
            class="btn btn-outline-light d-lg-none me-2"
            data-bs-toggle="offcanvas"
            data-bs-target="#mobileSidebar">
            <i class="bi bi-list"></i>
        </button>

        <h4 class="m-0 fw-bold text-white">
            <?= isset($page_title) ? $page_title : 'Dashboard'; ?>
        </h4>

    </div>

    <!-- Kanan -->
    <div class="dropdown">

        <button
            class="btn p-2 d-flex align-items-center justify-content-center bg-dark text-white rounded-circle dropdown-toggle no-arrow"
            id="dropdownMenuUser"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            style="width:40px;height:40px;border:1px solid #27272a;">

            <i class="bi bi-person" style="font-size:1.3rem;"></i>

        </button>

        <ul
            class="dropdown-menu dropdown-menu-end border-0 shadow mt-2 p-2"
            aria-labelledby="dropdownMenuUser"
            style="border-radius:12px; min-width:160px; background-color:#ffffff;">

            <li class="px-3 py-2 text-secondary small" style="font-weight:600;">
                Halo, <?= isset($_SESSION['nama_petugas']) ? htmlspecialchars($_SESSION['nama_petugas']) : 'Admin'; ?>
            </li>

            <li>
                <a class="dropdown-item rounded text-danger py-2"
                    href="logout.php"
                    onclick="return confirm('Apakah Anda yakin ingin keluar?')">

                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout

                </a>
            </li>

        </ul>

    </div>

</div>