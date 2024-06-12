<?php $row = $db->get_row("SELECT*FROM tb_user") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Data Prodi</h3>
            <br>
            <div class="table-responsive">
                <div class="col-lg-2 col-sm-4 col-xs-12">
                    <a href="?mod=prodi-tambah" class="btn btn-block btn-success"> Tambah Data</a>
                </div>
                <br> <br> <br>
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr align="center">
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Nama Lengkap</th>
                            <th style="text-align: center;">Username</th>
                            <th style="text-align: center;">Level</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows = $db->get_results("SELECT * FROM tb_user WHERE level!='Mahasiswa'");
                        $no = 0;
                        foreach ($rows as $row) :
                        ?>
                            <tr>
                                <td align="center"><?= ++$no ?></td>
                                <td align="center"><?= $row->nama_user ?></td>
                                <td align="center"><?= $row->user ?></td>
                                <td align="center">
                                    <?php
                                    if ($row->level == 'Admin') {
                                        echo "<span class='label label-warning'>Admin</span>";
                                    } elseif ($row->level == 'Prodi') {
                                        echo "<span class='label label-info'>Prodi</span>";
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php if ($row->level == 'Admin') {
                                        echo "Tidak Ada Aksi";
                                    } else {
                                        echo "
                                        <button style='border:none;'><a type='submit' href='?mod=prodi-edit&ID=$row->id_user' style='color: #00bbd9; text-decoration: none;'><i class='ti-pencil btn-icon-prepend'></i></a></button>
                                        <button style='border:none;'><a onclick='confirmationHapusData(\"action.php?mod=prodi-hapus&ID=$row->id_user\")' style='color: red; text-decoration: none;'><i class='ti-trash btn-icon-prepend'></i></a></button>";
                                    } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>