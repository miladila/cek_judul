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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css" />
</head>
<?php session_start(); ?>

<body class="mini-sidebar">
    <div class="accountbg"></div>
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box1">
                <div class="brand-logo">
                    <h2 style="text-align:center"><strong>Silakan Registrasi</strong></h2>
                </div>
                <form class="form-horizontal form-material" id="loginform" action="?mod=register" method="POST">
                    <?php if ($_POST) include 'action.php' ?>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Nama Lengkap" name="nama">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="number" required="" placeholder="NPM" name="npm">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Username" name="user">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Password" name="pass">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" name="upload" type="submit">Daftar</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Sudah mempunyai akun? <a href="login.php" class="text-primary m-l-5"><b>Masuk</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="assets/plugins/components/jquery/dist/jquery.min.js"></script>
    <script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
    <?php if (@$_SESSION['message_swal']) { ?>
        <?php echo $_SESSION['message_swal']; ?>
    <?php unset($_SESSION['message_swal']);
    } ?>
</body>

</html>