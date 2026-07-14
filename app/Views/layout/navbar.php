<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center text-center" style="padding-top: 40px;">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('Assets/img/download.png') ?>" alt="Kominfo Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mt-auto font-weight-bold">Kominfo</div>
    </a>

    <!-- Ambil Nama User yang Sedang Login -->
    <?php $namaUser = session()->get('username') ?? 'Guest'; ?>

    <!-- User Info Dropdown -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle"></i>
            <span class="ml-2"><?= esc($namaUser); ?></span> <!-- Nama User -->
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= base_url('auth/ganti_password') ?>">
                <i class="fas fa-key fa-sm fa-fw mr-2"></i>
                Ganti Password
            </a>
            <!-- <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?= base_url('/auth/logout') ?>">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
            Logout
        </a> -->
        </div>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('AnggaranController/index') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <?php if (session()->get('role') == 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/auth/register') ?>">
                <i class="fas fa-fw fa-user-plus"></i>
                <span>Tambah User</span>
            </a>
        </li>
    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/auth/logout') ?>">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
            
    </div>

</ul>