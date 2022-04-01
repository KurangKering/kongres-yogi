<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?= base_url('templates/backend/index.html') ?>" class="brand-link">
        <img src="<?= base_url('templates/backend/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">KOGI 2022</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 text-center">
            <div class="info">
                <a href="javascript:void(0)" class="d-block">Admin</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= base_url('backend') ?>" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('backend/pendaftaran') ?>" class="nav-link">
                        <i class="nav-icon fas fa-edit "></i>
                        <p>
                            Data Pendaftaran
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/belum-bayar') ?>" class="nav-link">
                        <i class="nav-icon fa fa-thumbs-down    "></i>
                        <p>
                            Data Belum Bayar
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('backend/validasi') ?>" class="nav-link">
                        <i class="nav-icon fa fa-check-square-o    "></i>
                        <p>Data Validasi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('backend/event-simposium') ?>" class="nav-link">
                        <i class="nav-icon fa fa-file-text    "></i>
                        <p>
                            Data Event Simposium
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/simposium') ?>" class="nav-link">
                        <i class="nav-icon fa fa-file-text    "></i>
                        <p>
                            Master Simposium
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/workshop') ?>" class="nav-link">
                        <i class="nav-icon fa fa-file-text    "></i>
                        <p>
                            Master Workshop
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('backend/event') ?>" class="nav-link">
                        <i class="nav-icon fa fa-file-text   "></i>
                        <p>
                            Master Event
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('logout') ?>" class="nav-link">
                        <i class="nav-icon fa fa-power-off    "></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
