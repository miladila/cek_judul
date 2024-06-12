<?php
include 'function.php';
if (empty($_SESSION['login']))
    header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/uhm.png">
    <title>Universitas Handayani Makassar</title>
    <link href="assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/opensans.css" rel="stylesheet">
    <link href="assets/css/colors/default.css" id="theme" rel="stylesheet">
    <link href="assets/plugins/components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css" />
</head>
<?php session_start(); ?>

<body class="mini-sidebar">
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <?php include 'partials/navbar.php' ?>
        <?php include 'partials/sidebar.php' ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <?php
                if (file_exists($modules . '.php'))
                    include $modules . '.php';
                else
                    include 'partials/home.php';
                ?>
            </div>
            <?php include 'partials/footer.php' ?>
        </div>
    </div>
    <?php if (@$_SESSION['message_swal']) { ?>
        <?php echo $_SESSION['message_swal']; ?>
    <?php unset($_SESSION['message_swal']);
    } ?>
    <script type="text/javascript">
        function confirmationHapusData(url) {
            Swal.fire({
                title: 'Anda Yakin Untuk Menghapus Data Ini ?',
                text: 'Anda Tidak Dapat Melihat Data Ini Lagi!!!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Hapus',
                closeOnConfirm: false
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire('Success.', 'Data Berhasil Dihapus', 'success', {
                        timer: 3000
                    });
                    window.location.href = url
                }
            });
        };
    </script>
    <script src="assets/plugins/components/jquery/dist/jquery.min.js"></script>
    <script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/plugins/components/chartist-js/dist/chartist.min.js"></script>
    <script src="assets/plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/plugins/components/sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/plugins/components/sparkline/jquery.charts-sparkline.js"></script>
    <script src="assets/plugins/components/knob/jquery.knob.js"></script>
    <script src="assets/plugins/components/easypiechart/dist/jquery.easypiechart.min.js"></script>
    <script src="assets/plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="assets/plugins/components/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/components/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="assets/plugins/components/bootstrap-table/dist/bootstrap-table.ints.js"></script>
    <script src="assets/plugins/components/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#myTable').DataTable();

            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#tabelhitung').DataTable({
            scrollX: true,
            scrollY: 200,
            scrollCollapse: true,
            scroller: true,
            // columns: [{
            //     width: '500px',
            // }]
        });
        $('#tabelProses').DataTable({
            order: [
                [5, 'desc']
            ],
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All'],
            ],
        });
        $('#tableProsesAcc').DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All'],
            ],
        });
        $('#tabelLayak').DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All'],
            ],
        });
        $('#tabelTidakLayak').DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All'],
            ],
        });
    </script>
    <script>
        const statusJudul = document.getElementById('status_judul');
        const tampilkanBtn = document.querySelector('.input-group-btn button');
        const prosesStatus = document.getElementById('prosesStatus');
        const layakKonsul = document.getElementById('layakKonsul');
        const tidakLayakKonsul = document.getElementById('tidakLayak');
        const semua = document.getElementById('dataPengajuan');
        tampilkanBtn.addEventListener('click', function() {
            if (statusJudul.value === '0') {
                prosesStatus.style.display = 'block';
                layakKonsul.style.display = 'none';
                tidakLayakKonsul.style.display = 'none';
                semua.style.display = 'none';
            } else if (statusJudul.value === '1') {
                prosesStatus.style.display = 'none';
                layakKonsul.style.display = 'block';
                tidakLayakKonsul.style.display = 'none';
                semua.style.display = 'none';
            } else if (statusJudul.value === '2') {
                prosesStatus.style.display = 'none';
                layakKonsul.style.display = 'none';
                tidakLayakKonsul.style.display = 'block';
                semua.style.display = 'none';
            } else if (statusJudul.value === 'semuaPeng') {
                prosesStatus.style.display = 'none';
                layakKonsul.style.display = 'none';
                tidakLayakKonsul.style.display = 'none';
                semua.style.display = 'block';
            }
        });
    </script>
</body>

</html>