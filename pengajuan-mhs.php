<div class="col-sm-12 white-box">
    <h3 class="box-title m-b-0 m-t-0">Data Pengajuan Judul</h3>
    <div class="table-responsive">
        <table id="example23" class="table table-responsive table-stripped">
            <thead>
                <tr>
                    <th style="text-align: center;">#</th>
                    <th style="text-align: center;">NPM</th>
                    <th style="text-align: center;">Nama Lengkap</th>
                    <th style="text-align: center;">Judul</th>
                    <th style="text-align: center;">Tahun</th>
                    <th style="text-align: center;">Tingkat Kemiripan</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row = $db->get_results("SELECT 
                tb_user.id_user,
                tb_user.npm,
                tb_user.nama_user as mahasiswa,
                tb_user.level,
                tb_proses_pengajuan.judul,
                tb_proses_pengajuan.latar_belakang,
                tb_proses_pengajuan.lokasi_penelitian,
                tb_proses_pengajuan.tahun,
                tb_pengajuan.id_pengajuan,
                tb_pengajuan.hasil_nilai,
                tb_pengajuan.status,
                tb_pengajuan.keterangan,
                tb_data_latih.judul as judul_latih,
                tb_data_latih.isi as latar_belakang_latih
                FROM tb_proses_pengajuan
                INNER JOIN tb_user
                ON tb_proses_pengajuan.mahasiswa = tb_user.id_user
                INNER JOIN tb_pengajuan
                ON tb_proses_pengajuan.id_proses_pengajuan = tb_pengajuan.proses_judul
                INNER JOIN tb_data_latih
                ON tb_data_latih.id_skripsi = tb_pengajuan.judul_mirip
                WHERE tb_user.id_user = '$_SESSION[login]'
                ORDER BY tb_pengajuan.id_pengajuan DESC");
                $no = 0;
                foreach ($row as $rw) :
                ?>
                    <tr>
                        <td align="center"><?= ++$no ?></td>
                        <td align="center"><?= $rw->npm ?></td>
                        <td align="center"><?= $rw->mahasiswa ?></td>
                        <td align="center"><?= $rw->judul ?></td>
                        <td align="center"><?= $rw->tahun ?></td>
                        <td align="center">
                            <?= $rw->hasil_nilai ?>%
                        </td>
                        <td align="center">
                            <?php
                            if ($_SESSION['level'] == 'Mahasiswa') : ?>
                                <?php if ($rw->status == 0) : ?>
                                    <span class="label label-warning">Menunggu Persetujuan Prodi</span>
                                <?php elseif ($rw->status == 1) : ?>
                                    <label class="badge light badge-success">Layak Konsul</label>
                                <?php elseif ($rw->status == 2) : ?>
                                    <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                endforeach; ?>
            </tbody>
        </table>
    </div>
</div>