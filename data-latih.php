<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Data Latih</h3>
            <br>
            <div class="table-responsive">
                <div class="col-lg-2 col-sm-4 col-xs-12">
                    <a data-toggle="modal" data-target="#exportDataJudul" class="btn btn-block btn-info"> Template Excel</a>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-12">
                    <a data-toggle="modal" data-target="#impotDataJudul" class="btn btn-block btn-primary"> Upload Data</a>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-12">
                    <a href="?mod=data-tambah" class="btn btn-block btn-success"> Tambah Data</a>
                </div>
                <br> <br> <br>
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">Nama Lengkap</th>
                            <th style="text-align: center;">NPM</th>
                            <th style="text-align: center;">Judul</th>
                            <th style="text-align: center;">Latar Belakang</th>
                            <th style="text-align: center;">Tahun</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rows = $db->get_results("SELECT * FROM tb_data_latih");
                        $no = 0;
                        foreach ($rows as $row) :
                        ?>
                            <tr>
                                <td align="center"><?= ++$no ?></td>
                                <td align="center"><?= $row->nama ?></td>
                                <td align="center"><?= $row->npm ?></td>
                                <td><?= $row->judul ?></td>
                                <td><?= substr($row->isi, 0, 50) . '...'; ?></td>
                                <td align="center"><?= $row->tahun ?></td>
                                <td align="center">
                                    <button style="border:none;"><a type="submit" href="?mod=data-edit&ID=<?= $row->id_skripsi ?>" style="color: #00bbd9; text-decoration: none;"><i class="ti-pencil btn-icon-prepend"></i></a></button>
                                    <button style="border:none;"><a onclick="confirmationHapusData('action.php?mod=data-hapus&ID=<?= $row->id_skripsi ?>')" style="color: red; text-decoration: none;"><i class="ti-trash btn-icon-prepend"></i></a></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="impotDataJudul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="action.php?mod=upload-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="col-sm">
                        <label>File Excel</label>
                        <input type="file" name="fileExcel" class="form-control" required accept=".xls, .xlsx, .csv" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" name="import_excel_btn" type="submit">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exportDataJudul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download Template Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="action.php?mod=template-excel">
                <div class="modal-body">
                    <div class="col-sm">
                        <div class="form-group">
                            <label class="control-label col-sm">Pilih Format File</label>
                            <div class="col-sm">
                                <select name="export_file_type" class="form-control">
                                    <option value="xlsx">XLSX</option>
                                    <option value="xls">XLS</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" name="export_excel_btn" type="submit">Download</button>
                    </div>
                </div>
            </form>
        </div>
    </div>