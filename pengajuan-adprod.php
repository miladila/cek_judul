<div class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title">Pilih Status Pengajuan Judul</h3>
        <label class="m-t-20">Pilih Status</label>
        <div class="input-group">
            <select class="form-control" id="status_judul" name="status_judul">
                <option value="" selected disabled>--Status Pengajuan--</option>
                <option value="semuaPeng">Tampilkan Keseluruhan</option>
                <option value="0">Menunggu Persetujuan</option>
                <option value="1">Layak Konsul</option>
                <option value="2">Tidak Layak Konsul</option>
            </select>
            <span class="input-group-btn">
                <button type="button" class="btn waves-effect waves-light btn-primary">Tampilkan</button>
            </span>
        </div>
    </div>
</div>
<div class="col-sm-12" id="dataPengajuan" style="display:none;">
    <div class="white-box">
        <h3 class="box-title m-b-10">Data Pengajuan Judul</h3>
        <div class="table-reponsive">
            <table class="table table-responsive table-stripped" id="example23">
                <thead>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">NPM</th>
                        <th style="text-align: center;">Nama Lengkap</th>
                        <th style="text-align: center;">Judul</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">Kemiripan Judul</th>
                        <th style="text-align: center;">Kemiripan Latar Belakang</th>
                        <th style="text-align: center;">Tingkat Kemiripan</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = $db->get_results("SELECT
                    tb_user.id_user,
                    tb_user.npm,
                    tb_user.nama_user as mahasiswa,
                    tb_user.level,
                    tb_proses_pengajuan.id_proses_pengajuan as id_proses,
                    tb_proses_pengajuan.judul,
                    tb_proses_pengajuan.latar_belakang,
                    tb_proses_pengajuan.lokasi_penelitian,
                    tb_proses_pengajuan.tahun,
                    tb_pengajuan.id_pengajuan,
                    tb_pengajuan.proses_judul,
                    tb_pengajuan.nilai_judul,
                    tb_pengajuan.nilai_latar_belakang,
                    tb_pengajuan.hasil_nilai,
                    tb_pengajuan.status,
                    tb_pengajuan.keterangan,
                    tb_data_latih.npm as npm_latih,
                    tb_data_latih.nama as mahasiswa_latih,
                    tb_data_latih.judul as judul_latih,
                    tb_data_latih.isi as latar_belakang_latih,
                    tb_data_latih.tahun as tahun_latih
                    FROM tb_proses_pengajuan
                    INNER JOIN tb_user
                    ON tb_proses_pengajuan.mahasiswa = tb_user.id_user
                    INNER JOIN tb_pengajuan
                    ON tb_proses_pengajuan.id_proses_pengajuan = tb_pengajuan.proses_judul
                    INNER JOIN tb_data_latih
                    ON tb_data_latih.id_skripsi = tb_pengajuan.judul_mirip
                    ORDER BY tb_pengajuan.tgl_pengajuan DESC");
                    $no = 0;
                    foreach ($row as $rw) :
                    ?>
                        <tr>
                            <td align="center"><?= ++$no ?></td>
                            <td align="center"><?= $rw->npm ?></td>
                            <td align="center"><?= $rw->mahasiswa ?></td>
                            <td align="center"><?= $rw->judul ?></td>
                            <td align="center"><?= $rw->tahun ?></td>
                            <td align="center"> <?= $rw->nilai_judul ?>% </td>
                            <td align="center"> <?= $rw->nilai_latar_belakang ?>% </td>
                            <td align="center">
                                <a href="" data-toggle="modal" data-target="#ModalViewMiripS<?= $rw->id_pengajuan ?>" style="color:#8d9498"><?= $rw->hasil_nilai ?>%</a>
                                <div class="modal fade" id="ModalViewMiripS<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Kemiripan Judul Alumni</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="30%">NPM</td>
                                                            <td width="70%"><?= $rw->npm_latih ?></td>
                                                        <tr>
                                                            <td width="30%">Nama Alumni</td>
                                                            <td width="70%"><?= $rw->mahasiswa_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Judul</td>
                                                            <td width="70%"><?= $rw->judul_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Judul</td>
                                                            <td width="70%"><?= $rw->nilai_judul ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Latar Belakang</td>
                                                            <td width="70%"><?= $rw->latar_belakang_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Latar Belakang</td>
                                                            <td width="70%"><?= $rw->nilai_latar_belakang ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Hasil Kemiripan</td>
                                                            <td width="70%"><?= $rw->hasil_nilai ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Alumni Angkatan</td>
                                                            <td width="70%"><?= $rw->tahun_latih ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td align="center">
                                <?php
                                if ($_SESSION['level'] == 'Prodi') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <form action="action.php?mod=update-status&ID=<?= $rw->id_pengajuan ?>" method="POST">
                                            <select class="form-control" onchange="this.form.submit()" name="status_judul">
                                                <option disabled selected>Pilih Status</option>
                                                <option value="1">Layak Konsul</option>
                                                <option value="2">Tidak Layak Konsul</option>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rw->status == 1) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php endif; ?>
                                <?php } else if ($_SESSION['level'] == 'Admin') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <span class="label label-warning">Menunggu Persetujuan Prodi</span>
                                    <?php elseif ($rw->status == 1) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php endif; ?>
                                <?php }
                                ?>
                            </td>
                            <td align="center">
                                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalViewS<?= $rw->id_pengajuan ?>"><i class="fa fa-eye"></i></a>
                                <div class="modal fade" id="ModalViewS<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Judul</h4>
                                            </div>
                                            <?php if (($rw->keterangan == NULL) and ($_SESSION['level'] == 'Prodi')) : ?>
                                                <form action="action.php?mod=update-keterangan" method="post" class="form-horizontal form-bordered">
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <input type="hidden" name="id_pengajuan" value="<?= $rw->id_pengajuan ?>">
                                                                <tr>
                                                                    <td width="30%">NPM</td>
                                                                    <td width="70%"><?= $rw->npm ?></td>
                                                                <tr>
                                                                    <td width="30%"><label>Nama</label></td>
                                                                    <td width="70%"><?= $rw->mahasiswa ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Judul</label></td>
                                                                    <td width="70%"><?= $rw->judul ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Latar Belakang</label></td>
                                                                    <td width="70%"><?= $rw->latar_belakang ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                    <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Keterangan</label></td>
                                                                    <td width="70%">
                                                                        <textarea class="form-control" style="min-width: 100%" name="keterangan"></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" name="upload">Submit</button>
                                                    </div>
                                                </form>
                                            <?php else : ?>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td width="30%">NPM</td>
                                                                <td width="70%"><?= $rw->npm ?></td>
                                                            <tr>
                                                                <td width="30%"><label>Nama</label></td>
                                                                <td width="70%"><?= $rw->mahasiswa ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Judul</label></td>
                                                                <td width="70%"><?= $rw->judul ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Latar Belakang</label></td>
                                                                <td width="70%"><?= $rw->latar_belakang ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Keterangan</label></td>
                                                                <td width="70%">
                                                                    <?php if ($rw->keterangan == NULL) : ?>
                                                                        Tidak ada keterangan
                                                                    <?php else : ?>
                                                                        <?= $rw->keterangan ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($_SESSION['level'] == 'Admin') { ?>
                                    <a onclick="confirmationHapusData('action.php?mod=hapus-pengajuan&ID=<?= $rw->proses_judul ?>&IP=<?= $rw->id_proses ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <?php }; ?>
                            </td>
                        <?php endforeach; ?>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12" id="prosesStatus" style="display:none;">
    <div class="white-box">
        <h3 class="box-title m-b-10">Data Pengajuan Judul Menunggu Persetujuan</h3>
        <div class="table-responsive">
            <table id="tableProsesAcc" class="table table-responsive table-stripped">
                <thead>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">NPM</th>
                        <th style="text-align: center;">Nama Lengkap</th>
                        <th style="text-align: center;">Judul</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">Kemiripan Judul</th>
                        <th style="text-align: center;">Kemiripan Latar Belakang</th>
                        <th style="text-align: center;">Tingkat Kemiripan</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = $db->get_results("SELECT 
                        tb_user.id_user,
                        tb_user.npm,
                        tb_user.nama_user as mahasiswa,
                        tb_user.level,
                        tb_proses_pengajuan.id_proses_pengajuan as id_proses,
                        tb_proses_pengajuan.judul,
                        tb_proses_pengajuan.latar_belakang,
                        tb_proses_pengajuan.lokasi_penelitian,
                        tb_proses_pengajuan.tahun,
                        tb_pengajuan.id_pengajuan,
                        tb_pengajuan.proses_judul,
                        tb_pengajuan.nilai_judul,
                        tb_pengajuan.nilai_latar_belakang,
                        tb_pengajuan.hasil_nilai,
                        tb_pengajuan.status,
                        tb_pengajuan.keterangan,
                        tb_data_latih.npm as npm_latih,
                        tb_data_latih.nama as mahasiswa_latih,
                        tb_data_latih.judul as judul_latih,
                        tb_data_latih.isi as latar_belakang_latih,
                        tb_data_latih.tahun as tahun_latih
                        FROM tb_proses_pengajuan
                        INNER JOIN tb_user
                        ON tb_proses_pengajuan.mahasiswa = tb_user.id_user
                        INNER JOIN tb_pengajuan
                        ON tb_proses_pengajuan.id_proses_pengajuan = tb_pengajuan.proses_judul
                        INNER JOIN tb_data_latih
                        ON tb_data_latih.id_skripsi = tb_pengajuan.judul_mirip
                        WHERE tb_pengajuan.status = '0'
                        ORDER BY tb_pengajuan.tgl_pengajuan DESC");
                    $no = 0;
                    foreach ($row as $rw) :
                    ?>
                        <tr>
                            <td align="center"><?= ++$no ?></td>
                            <td align="center"><?= $rw->npm ?></td>
                            <td align="center"><?= $rw->mahasiswa ?></td>
                            <td align="center"><?= $rw->judul ?></td>
                            <td align="center"><?= $rw->tahun ?></td>
                            <td align="center"> <?= $rw->nilai_judul ?>% </td>
                            <td align="center"> <?= $rw->nilai_latar_belakang ?>% </td>
                            <td align="center">
                                <a href="" data-toggle="modal" data-target="#ModalViewMiripP<?= $rw->id_pengajuan ?>" style="color:#8d9498"><?= $rw->hasil_nilai ?>%</a>
                                <div class="modal fade" id="ModalViewMiripP<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Kemiripan Judul Alumni</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="30%">NPM</td>
                                                            <td width="70%"><?= $rw->npm_latih ?></td>
                                                        <tr>
                                                            <td width="30%">Nama Alumni</td>
                                                            <td width="70%"><?= $rw->mahasiswa_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Judul</td>
                                                            <td width="70%"><?= $rw->judul_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Judul</td>
                                                            <td width="70%"><?= $rw->nilai_judul ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Latar Belakang</td>
                                                            <td width="70%"><?= $rw->latar_belakang_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Latar Belakang</td>
                                                            <td width="70%"><?= $rw->nilai_latar_belakang ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Hasil Kemiripan</td>
                                                            <td width="70%"><?= $rw->hasil_nilai ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Alumni Angkatan</td>
                                                            <td width="70%"><?= $rw->tahun_latih ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td align="center">
                                <?php
                                if ($_SESSION['level'] == 'Prodi') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <form action="action.php?mod=update-status&ID=<?= $rw->id_pengajuan ?>" method="POST">
                                            <select class="form-control" onchange="this.form.submit()" name="status_judul">
                                                <option disabled selected>Pilih Status</option>
                                                <option value="1">Layak Konsul</option>
                                                <option value="2">Tidak Layak Konsul</option>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rw->status == 1) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php endif; ?>
                                <?php } else if ($_SESSION['level'] == 'Admin') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <span class="label label-warning">Menunggu Persetujuan Prodi</span>
                                    <?php elseif ($rw->status == 1) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php endif; ?>
                                <?php }
                                ?>
                            </td>
                            <td align="center">
                                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalViewP<?= $rw->id_pengajuan ?>"><i class="fa fa-eye"></i></a>
                                <div class="modal fade" id="ModalViewP<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Judul</h4>
                                            </div>
                                            <?php if (($rw->keterangan == NULL) and ($_SESSION['level'] == 'Prodi')) : ?>
                                                <form action="action.php?mod=update-keterangan" method="post" class="form-horizontal form-bordered">
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <input type="hidden" name="id_pengajuan" value="<?= $rw->id_pengajuan ?>">
                                                                <tr>
                                                                    <td width="30%">NPM</td>
                                                                    <td width="70%"><?= $rw->npm ?></td>
                                                                <tr>
                                                                    <td width="30%"><label>Nama</label></td>
                                                                    <td width="70%"><?= $rw->mahasiswa ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Judul</label></td>
                                                                    <td width="70%"><?= $rw->judul ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Latar Belakang</label></td>
                                                                    <td width="70%"><?= $rw->latar_belakang ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                    <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Keterangan</label></td>
                                                                    <td width="70%">
                                                                        <textarea class="form-control" style="min-width: 100%" name="keterangan"></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" name="upload">Submit</button>
                                                    </div>
                                                </form>
                                            <?php else : ?>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td width="30%">NPM</td>
                                                                <td width="70%"><?= $rw->npm ?></td>
                                                            <tr>
                                                                <td width="30%"><label>Nama</label></td>
                                                                <td width="70%"><?= $rw->mahasiswa ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Judul</label></td>
                                                                <td width="70%"><?= $rw->judul ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Latar Belakang</label></td>
                                                                <td width="70%"><?= $rw->latar_belakang ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Keterangan</label></td>
                                                                <td width="70%">
                                                                    <?php if ($rw->keterangan == NULL) : ?>
                                                                        Tidak ada keterangan
                                                                    <?php else : ?>
                                                                        <?= $rw->keterangan ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($_SESSION['level'] == 'Admin') { ?>
                                    <a onclick="confirmationHapusData('action.php?mod=hapus-pengajuan&ID=<?= $rw->proses_judul ?>&IP=<?= $rw->id_proses ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <?php }; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12" id="layakKonsul" style="display:none;">
    <div class="white-box">
        <h3 class="box-title m-b-10">Data Pengajuan Judul Layak Konsul</h3>
        <div class="table-responsive">
            <table id="tabelLayak" class="table table-responsive table-stripped">
                <thead>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">NPM</th>
                        <th style="text-align: center;">Nama Lengkap</th>
                        <th style="text-align: center;">Judul</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">Kemiripan Judul</th>
                        <th style="text-align: center;">Kemiripan Latar Belakang</th>
                        <th style="text-align: center;">Tingkat Kemiripan</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = $db->get_results("SELECT 
                        tb_user.id_user,
                        tb_user.npm,
                        tb_user.nama_user as mahasiswa,
                        tb_user.level,
                        tb_proses_pengajuan.id_proses_pengajuan as id_proses,
                        tb_proses_pengajuan.judul,
                        tb_proses_pengajuan.latar_belakang,
                        tb_proses_pengajuan.lokasi_penelitian,
                        tb_proses_pengajuan.tahun,
                        tb_pengajuan.id_pengajuan,
                        tb_pengajuan.proses_judul,
                        tb_pengajuan.nilai_judul,
                        tb_pengajuan.nilai_latar_belakang,
                        tb_pengajuan.hasil_nilai,
                        tb_pengajuan.status,
                        tb_pengajuan.keterangan,
                        tb_data_latih.npm as npm_latih,
                        tb_data_latih.nama as mahasiswa_latih,
                        tb_data_latih.judul as judul_latih,
                        tb_data_latih.isi as latar_belakang_latih,
                        tb_data_latih.tahun as tahun_latih
                        FROM tb_proses_pengajuan
                        INNER JOIN tb_user
                        ON tb_proses_pengajuan.mahasiswa = tb_user.id_user
                        INNER JOIN tb_pengajuan
                        ON tb_proses_pengajuan.id_proses_pengajuan = tb_pengajuan.proses_judul
                        INNER JOIN tb_data_latih
                        ON tb_data_latih.id_skripsi = tb_pengajuan.judul_mirip
                        WHERE tb_pengajuan.status = '2'
                        ORDER BY tb_pengajuan.tgl_pengajuan DESC");
                    $no = 0;
                    foreach ($row as $rw) :
                    ?>
                        <tr>
                            <td align="center"><?= ++$no ?></td>
                            <td align="center"><?= $rw->npm ?></td>
                            <td align="center"><?= $rw->mahasiswa ?></td>
                            <td align="center"><?= $rw->judul ?></td>
                            <td align="center"><?= $rw->tahun ?></td>
                            <td align="center"> <?= $rw->nilai_judul ?>% </td>
                            <td align="center"> <?= $rw->nilai_latar_belakang ?>% </td>
                            <td align="center">
                                <a href="" data-toggle="modal" data-target="#ModalViewMiripL<?= $rw->id_pengajuan ?>" style="color:#8d9498"><?= $rw->hasil_nilai ?>%</a>
                                <div class="modal fade" id="ModalViewMiripL<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Kemiripan Judul Alumni</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="30%">NPM</td>
                                                            <td width="70%"><?= $rw->npm_latih ?></td>
                                                        <tr>
                                                            <td width="30%">Nama Alumni</td>
                                                            <td width="70%"><?= $rw->mahasiswa_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Judul</td>
                                                            <td width="70%"><?= $rw->judul_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Judul</td>
                                                            <td width="70%"><?= $rw->nilai_judul ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Latar Belakang</td>
                                                            <td width="70%"><?= $rw->latar_belakang_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Latar Belakang</td>
                                                            <td width="70%"><?= $rw->nilai_latar_belakang ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Hasil Kemiripan</td>
                                                            <td width="70%"><?= $rw->hasil_nilai ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Alumni Angkatan</td>
                                                            <td width="70%"><?= $rw->tahun_latih ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td align="center">
                                <?php
                                if ($_SESSION['level'] == 'Prodi') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <form action="action.php?mod=update-status&ID=<?= $rw->id_pengajuan ?>" method="POST">
                                            <select class="form-control" onchange="this.form.submit()" name="status_judul">
                                                <option disabled selected>Pilih Status</option>
                                                <option value="1">Layak Konsul</option>
                                                <option value="2">Tidak Layak Konsul</option>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rw->status == 1) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php endif; ?>
                                <?php } else if ($_SESSION['level'] == 'Admin') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <span class="label label-warning">Menunggu Persetujuan Prodi</span>
                                    <?php elseif ($rw->status == 1) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php endif; ?>
                                <?php }
                                ?>
                            </td>
                            <td align="center">
                                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalViewL<?= $rw->id_pengajuan ?>"><i class="fa fa-eye"></i></a>
                                <div class="modal fade" id="ModalViewL<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Judul</h4>
                                            </div>
                                            <?php if (($rw->keterangan == NULL) and ($_SESSION['level'] == 'Prodi')) : ?>
                                                <form action="action.php?mod=update-keterangan" method="post" class="form-horizontal form-bordered">
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <input type="hidden" name="id_pengajuan" value="<?= $rw->id_pengajuan ?>">
                                                                <tr>
                                                                    <td width="30%">NPM</td>
                                                                    <td width="70%"><?= $rw->npm ?></td>
                                                                <tr>
                                                                    <td width="30%"><label>Nama</label></td>
                                                                    <td width="70%"><?= $rw->mahasiswa ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Judul</label></td>
                                                                    <td width="70%"><?= $rw->judul ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Latar Belakang</label></td>
                                                                    <td width="70%"><?= $rw->latar_belakang ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                    <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Keterangan</label></td>
                                                                    <td width="70%">
                                                                        <textarea class="form-control" style="min-width: 100%" name="keterangan"></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" name="upload">Submit</button>
                                                    </div>
                                                </form>
                                            <?php else : ?>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td width="30%">NPM</td>
                                                                <td width="70%"><?= $rw->npm ?></td>
                                                            <tr>
                                                                <td width="30%"><label>Nama</label></td>
                                                                <td width="70%"><?= $rw->mahasiswa ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Judul</label></td>
                                                                <td width="70%"><?= $rw->judul ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Latar Belakang</label></td>
                                                                <td width="70%"><?= $rw->latar_belakang ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Keterangan</label></td>
                                                                <td width="70%">
                                                                    <?php if ($rw->keterangan == NULL) : ?>
                                                                        Tidak ada keterangan
                                                                    <?php else : ?>
                                                                        <?= $rw->keterangan ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($_SESSION['level'] == 'Admin') { ?>
                                    <a onclick="confirmationHapusData('action.php?mod=hapus-pengajuan&ID=<?= $rw->proses_judul ?>&IP=<?= $rw->id_proses ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <?php }; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12" id="tidakLayak" style="display:none;">
    <div class="white-box">
        <h3 class="box-title m-b-0">Data Pengajuan Judul Tidak Layak Konsul</h3>
        <br><br>
        <div class="table-responsive">
            <table id="tabelTidakLayak" class="table table-responsive table-stripped">
                <thead>
                    <tr>
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">NPM</th>
                        <th style="text-align: center;">Nama Lengkap</th>
                        <th style="text-align: center;">Judul</th>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">Kemiripan Judul</th>
                        <th style="text-align: center;">Kemiripan Latar Belakang</th>
                        <th style="text-align: center;">Tingkat Kemiripan</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = $db->get_results("SELECT 
                        tb_user.id_user,
                        tb_user.npm,
                        tb_user.nama_user as mahasiswa,
                        tb_user.level,
                        tb_proses_pengajuan.id_proses_pengajuan as id_proses,
                        tb_proses_pengajuan.judul,
                        tb_proses_pengajuan.latar_belakang,
                        tb_proses_pengajuan.lokasi_penelitian,
                        tb_proses_pengajuan.tahun,
                        tb_pengajuan.id_pengajuan,
                        tb_pengajuan.proses_judul,
                        tb_pengajuan.nilai_judul,
                        tb_pengajuan.nilai_latar_belakang,
                        tb_pengajuan.hasil_nilai,
                        tb_pengajuan.status,
                        tb_pengajuan.keterangan,
                        tb_data_latih.npm as npm_latih,
                        tb_data_latih.nama as mahasiswa_latih,
                        tb_data_latih.judul as judul_latih,
                        tb_data_latih.isi as latar_belakang_latih,
                        tb_data_latih.tahun as tahun_latih
                        FROM tb_proses_pengajuan
                        INNER JOIN tb_user
                        ON tb_proses_pengajuan.mahasiswa = tb_user.id_user
                        INNER JOIN tb_pengajuan
                        ON tb_proses_pengajuan.id_proses_pengajuan = tb_pengajuan.proses_judul
                        INNER JOIN tb_data_latih
                        ON tb_data_latih.id_skripsi = tb_pengajuan.judul_mirip
                        WHERE tb_pengajuan.status = '1'
                        ORDER BY tb_pengajuan.tgl_pengajuan DESC");
                    $no = 0;
                    foreach ($row as $rw) :
                    ?>
                        <tr>
                            <td align="center"><?= ++$no ?></td>
                            <td align="center"><?= $rw->npm ?></td>
                            <td align="center"><?= $rw->mahasiswa ?></td>
                            <td align="center"><?= $rw->judul ?></td>
                            <td align="center"><?= $rw->tahun ?></td>
                            <td align="center"> <?= $rw->nilai_judul ?>% </td>
                            <td align="center"> <?= $rw->nilai_latar_belakang ?>% </td>
                            <td align="center">
                                <a href="" data-toggle="modal" data-target="#ModalViewMiripT<?= $rw->id_pengajuan ?>" style="color:#8d9498"><?= $rw->hasil_nilai ?>%</a>
                                <div class="modal fade" id="ModalViewMiripT<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Kemiripan Judul Alumni</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="30%">NPM</td>
                                                            <td width="70%"><?= $rw->npm_latih ?></td>
                                                        <tr>
                                                            <td width="30%">Nama Alumni</td>
                                                            <td width="70%"><?= $rw->mahasiswa_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Judul</td>
                                                            <td width="70%"><?= $rw->judul_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Judul</td>
                                                            <td width="70%"><?= $rw->nilai_judul ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Latar Belakang</td>
                                                            <td width="70%"><?= $rw->latar_belakang_latih ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Kemiripan Latar Belakang</td>
                                                            <td width="70%"><?= $rw->nilai_latar_belakang ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nilai Hasil Kemiripan</td>
                                                            <td width="70%"><?= $rw->hasil_nilai ?>%</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Alumni Angkatan</td>
                                                            <td width="70%"><?= $rw->tahun_latih ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td align="center">
                                <?php
                                if ($_SESSION['level'] == 'Prodi') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <form action="action.php?mod=update-status&ID=<?= $rw->id_pengajuan ?>" method="POST">
                                            <select class="form-control" onchange="this.form.submit()" name="status_judul">
                                                <option disabled selected>Pilih Status</option>
                                                <option value="1">Tidak Layak Konsul</option>
                                                <option value="2">Layak Konsul</option>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rw->status == 1) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php endif; ?>
                                <?php } else if ($_SESSION['level'] == 'Admin') { ?>
                                    <?php if ($rw->status == 0) : ?>
                                        <span class="label label-warning">Menunggu Persetujuan Prodi</span>
                                    <?php elseif ($rw->status == 1) : ?>
                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                    <?php elseif ($rw->status == 2) : ?>
                                        <label class="badge light badge-success">Layak Konsul</label>
                                    <?php endif; ?>
                                <?php }
                                ?>
                            </td>
                            <td align="center">
                                <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalViewT<?= $rw->id_pengajuan ?>"><i class="fa fa-eye"></i></a>
                                <div class="modal fade" id="ModalViewT<?= $rw->id_pengajuan ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" align="left">Detail Judul</h4>
                                            </div>
                                            <?php if (($rw->keterangan == NULL) and ($_SESSION['level'] == 'Prodi')) : ?>
                                                <form action="action.php?mod=update-keterangan" method="post" class="form-horizontal form-bordered">
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <input type="hidden" name="id_pengajuan" value="<?= $rw->id_pengajuan ?>">
                                                                <tr>
                                                                    <td width="30%">NPM</td>
                                                                    <td width="70%"><?= $rw->npm ?></td>
                                                                <tr>
                                                                    <td width="30%"><label>Nama</label></td>
                                                                    <td width="70%"><?= $rw->mahasiswa ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Judul</label></td>
                                                                    <td width="70%"><?= $rw->judul ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Latar Belakang</label></td>
                                                                    <td width="70%"><?= $rw->latar_belakang ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                    <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="30%"><label>Keterangan</label></td>
                                                                    <td width="70%">
                                                                        <textarea class="form-control" style="min-width: 100%" name="keterangan"></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" name="upload">Submit</button>
                                                    </div>
                                                </form>
                                            <?php else : ?>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td width="30%">NPM</td>
                                                                <td width="70%"><?= $rw->npm ?></td>
                                                            <tr>
                                                                <td width="30%"><label>Nama</label></td>
                                                                <td width="70%"><?= $rw->mahasiswa ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Judul</label></td>
                                                                <td width="70%"><?= $rw->judul ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Latar Belakang</label></td>
                                                                <td width="70%"><?= $rw->latar_belakang ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Lokasi Penelitian</label></td>
                                                                <td width="70%"><?= $rw->lokasi_penelitian ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="30%"><label>Keterangan</label></td>
                                                                <td width="70%">
                                                                    <?php if ($rw->keterangan == NULL) : ?>
                                                                        Tidak ada keterangan
                                                                    <?php else : ?>
                                                                        <?= $rw->keterangan ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($_SESSION['level'] == 'Admin') { ?>
                                    <a onclick="confirmationHapusData('action.php?mod=hapus-pengajuan&ID=<?= $rw->proses_judul ?>&IP=<?= $rw->id_proses ?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <?php }; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>