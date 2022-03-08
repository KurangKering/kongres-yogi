<aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="<?= base_url('templates/backend/index3.html') ?>" class="brand-link">
                <img src="<?= base_url('templates/backend/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('templates/backend/dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="<?= base_url('backend/data-validasi') ?>" class="nav-link">
                                <i class="nav-icon fas fa-circle    "></i>
                                <p>
                                    Data Validasi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/data-pendaftaran') ?>" class="nav-link">
                                <i class="nav-icon fas fa-circle    "></i>
                                <p>
                                    Data Pendaftaran
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/data-event-simposium') ?>" class="nav-link">
                                <i class="nav-icon fas fa-circle    "></i>
                                <p>
                                    Data Event Simposium
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/data-simposium') ?>" class="nav-link">
                                <i class="nav-icon fas fa-circle    "></i>
                                <p>
                                    Data Master Simposium
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backend/data-workshop') ?>" class="nav-link">
                                <i class="nav-icon fas fa-circle    "></i>
                                <p>
                                    Data Workshop
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('logout') ?>" class="nav-link">
                                <i class="nav-icon fas fa-circle    "></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>