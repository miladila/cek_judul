<!-- ===== Left-Sidebar ===== -->
<aside class="sidebar">
    <div class="scroll-sidebar">
        <div class="user-profile">
        </div>
        <nav class="sidebar-nav">
            <ul id="side-menu">
                <?php if ($_SESSION['login']) : ?>
                    <li>
                        <a href="index.php" aria-expanded="false"><i class="icon-screen-desktop fa-fw"></i> <span class="hide-menu">Dashboard</span></a>
                    </li>
                    <hr>
                    <?php if ($_SESSION['level'] == 'Admin') : ?>
                        <li>
                            <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i class="icon-user fa-fw"></i>
                                <span class="hide-menu"> Management User </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="?mod=data-prodi">Prodi</a>
                                </li>
                                <li>
                                    <a href="?mod=data-mahasiswa">Mahasiswa</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?mod=data-latih" aria-expanded="false"><i class="icon-speech fa-fw"></i> <span class="hide-menu">Data Latih</span></a>
                        </li>
                        <hr>
                        <li>
                            <a href="?mod=pengajuan" aria-expanded="false"><i class="icon-notebook fa-fw"></i> <span class="hide-menu">Data Pengajuan</span></a>
                        </li>
                    <?php elseif ($_SESSION['level'] == 'Prodi') : ?>
                        <li>
                            <a href="?mod=pengajuan" aria-expanded="false"><i class="icon-notebook fa-fw"></i> <span class="hide-menu">Data Pengajuan</span></a>
                        </li>
                    <?php else : ?>
                        <li>
                            <a href="?mod=konsultasi" aria-expanded="false"><i class="icon-speech fa-fw"></i> <span class="hide-menu">Konsultasi</span></a>
                        </li>
                        <hr>
                        <li>
                            <a href="?mod=pengajuan" aria-expanded="false"><i class="icon-notebook fa-fw"></i> <span class="hide-menu">Data Pengajuan</span></a>
                        </li>
                    <?php endif ?>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</aside>
<!-- ===== Left-Sidebar-End ===== -->