<?php include 'function.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/uhm.png">
    <title>Universitas Handayani Makassar</title>
    <link href="assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/colors/default.css" id="theme" rel="stylesheet">
    <link href="assets/plugins/components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css" />
</head>
<?php session_start(); ?>

<body class="mini-sidebar" style="background: url('assets/img/bg1.png'); background-size: cover">
    <div class="accountbg"></div>
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box1">
                <div class="brand-logo">
                    <h2 style="text-align:center"><strong>Selamat Datang</strong></h2>
                </div>
                <div class="form-group"></div>
                <form class="form-horizontal form-material" id="loginform" action="?mod=login" method="POST">
                    <?php if ($_POST) include 'action.php' ?>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Username" name="user">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Password" name="pass">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-6">
                            <button class="btn btn-info btn-sm btn-block waves-effect waves-light" type="submit">Login</button>
                        </div>
                        <div class="col-xs-6">
                            <button class="btn btn-primary btn-sm btn-block waves-effect waves-light" data-toggle="modal" data-target=".list-judul" type="button">Daftar Judul</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Belum mempunyai akun? <a href="register.php" class="text-primary m-l-5"><b>Daftar</b></a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade list-judul" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Data Pengajuan Judul</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3" style="margin-bottom: 20px">
                            <label for="">Filter berdasarkan Tahun</label>
                            <select id="filter-tahun" class="form-control filter">
                                <option>Pilih Tahun</option>
                                <option value="">Semua</option>
                                <?php
                                foreach (range(2006, (int)date("Y")) as $year) {
                                    echo "\t<option value='" . $year . "'>" . $year . "</option>\n\r";
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-lg-12 table-responsive">
                            <table id="tb_hasilPengajuan" class="table table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th style="text-align: center;">#</th> -->
                                        <th style="text-align: center;">NPM</th>
                                        <th style="text-align: center;">Nama Lengkap</th>
                                        <th style="text-align: center;">Judul</th>
                                        <th style="text-align: center;">Tahun</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rows = $db->get_results("SELECT 
                                        tb_user.npm,
                                        tb_user.nama_user as mahasiswa,
                                        tb_proses_pengajuan.judul,
                                        tb_proses_pengajuan.latar_belakang,
                                        tb_proses_pengajuan.tahun,
                                        tb_pengajuan.id_pengajuan,
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
                                        ORDER BY tb_pengajuan.tgl_pengajuan DESC");
                                    $no = 0;
                                    foreach ($rows as $row) :
                                    ?>
                                        <?php if ($row->status != 0) : ?>
                                            <tr>
                                                <!-- <td align="center"><?= ++$no ?></td> -->
                                                <td align="center"><?= $row->npm ?></td>
                                                <td align="center"><?= $row->mahasiswa ?></td>
                                                <td align="center"><?= $row->judul ?></td>
                                                <td align="center"><?= $row->tahun ?></td>
                                                <td align="center">
                                                    <?php if ($row->status == 1) : ?>
                                                        <label class="badge light badge-danger">Tidak Layak Konsul</label>
                                                    <?php elseif ($row->status == 2) : ?>
                                                        <label class="badge light badge-success">Layak Konsul</label>
                                                    <?php endif; ?>
                                                </td>
                                                <td align="center"><?= $row->keterangan ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php if (@$_SESSION['message_swal']) { ?>
        <?php echo $_SESSION['message_swal']; ?>
    <?php unset($_SESSION['message_swal']);
    } ?>
    <script src="assets/plugins/components/jquery/dist/jquery.min.js"></script>
    <script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="assets/plugins/components/datatables/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script>
        // filter data datables berdasarkan tahun
        $('#filter-tahun').change(function() {
            var value = $(this).val();
            $('#tb_hasilPengajuan').DataTable().columns(3).search(value).draw();
        });

        $(document).ready(function() {
            var table = $('#tb_hasilPengajuan').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 4, 5] // kolom yang ingin dicetak, misalnya kolom 0, 1, dan 2
                    },
                    customize: function(win) {
                        $(win.document.body).find('th').addClass('display').css('text-align', 'center');
                        $(win.document.body).find('table').addClass('display').css('font-size', '16px');
                        $(win.document.body).find('table').addClass('display').css('text-align', 'center');
                        $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                            $(this).css('background-color', '#D0D0D0');
                        });
                        $(win.document.body).find('h1').html('Universitas Handayani Makassar').css('float', 'center', 'margin-right', '10px', 'margin-left', '10px', 'margin-top', '10px', 'margin-bottom', '10px');
                        var logo = '<img src="https://upload.wikimedia.org/wikipedia/id/0/0b/Logo_Universitas_Handayani_Makassar.png" style="float: center; height: 70px; margin-right: 10px;">';
                        $(win.document.body).find('h1').prepend(logo);

                        //mengganti judul dokumen
                    }
                }]
            });
        });
    </script>
</body>

</html>