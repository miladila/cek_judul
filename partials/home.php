<?php
$query1 = $db->get_count("SELECT * FROM tb_data_latih");
$query2 = $db->get_count("SELECT * FROM tb_pengajuan");
$query3 = $db->get_count("SELECT * FROM tb_user WHERE level='Mahasiswa'");
?>
<h2>Selamat Datang, <?= $_SESSION['nama_user'] ?></h2>
<h5>Aplikasi Pengajuan Judul Skripsi</h5>
<div class="row">
    <div class="col-md-4">
        <div class="white-box ecom-stat-widget">
            <div class="row">
                <div class="col-xs-6">
                    <span class="text-blue font-light"><?= $query3 ?></span>
                    <p class="font-12">Data Mahasiswa</p>
                </div>
                <div class="col-xs-6">
                    <span class="icoleaf bg-primary text-white"><i class="mdi mdi-plus"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="white-box ecom-stat-widget">
            <div class="row">
                <div class="col-xs-6">
                    <span class="text-blue font-light"><?= $query1 ?></span>
                    <p class="font-12">Data Latih</p>
                </div>
                <div class="col-xs-6">
                    <span class="icoleaf bg-danger text-white"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="white-box ecom-stat-widget">
            <div class="row">
                <div class="col-xs-6">
                    <span class="text-blue font-light"><?= $query2 ?></i></span>
                    <p class="font-12">Pengajuan</p>
                </div>
                <div class="col-xs-6">
                    <span class="icoleaf bg-success text-white"><i class="mdi mdi-comment-text-outline"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>