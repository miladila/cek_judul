<?php $row = $db->get_row("SELECT*FROM tb_user") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Data Mahasiswa</h3>
            <br>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr align="center">
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Nama Lengkap</th>
                            <th style="text-align: center;">NPM</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows = $db->get_results("SELECT * FROM tb_user WHERE level='mahasiswa'");
                        $no = 0;
                        foreach ($rows as $row) :
                        ?>
                            <tr>
                                <td align="center"><?= ++$no ?></td>
                                <td align="center"><?= $row->nama_user ?></td>
                                <td align="center"><?= $row->npm ?></td>
                                <td align="center">
                                    <button style="border:none;"><a type="submit" href="?mod=mahasiswa-edit&ID=<?= $row->id_user ?>" style="color: #00bbd9; text-decoration: none;"><i class="ti-pencil btn-icon-prepend"></i></a></button>
                                    <button style="border:none;"><a onclick="confirmationHapusData('action.php?mod=mahasiswa-hapus&ID=<?= $row->id_user ?>')" style="color: red; text-decoration: none;"><i class="ti-trash btn-icon-prepend"></i></a></button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>