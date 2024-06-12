<?php
require_once 'function.php';
session_start();

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
?>
<?php
//register akun mahasiswa
if ($modules == 'register') {
    $nama      = esc_field($_POST['nama']);
    $npm       = esc_field($_POST['npm']);
    $user      = esc_field($_POST['user']);
    $pass      = esc_field($_POST['pass']);

    if ($nama == '' || $npm == '' || $user == '' || $pass == '') {
        print_msg("Tidak Boleh Kosong!");
    } else {
        // Check if NPM already exists in tb_user
        $checkNPM = $db->query("SELECT * FROM tb_user WHERE npm = '$npm'");
        if ($checkNPM->num_rows > 0) {
            $_SESSION["message_swal"] = swal("error", "NPM sudah terdaftar. Silakan gunakan NPM lain.", "Registrasi Gagal");
        } else {
            $insert = $db->query("INSERT INTO tb_user VALUES (null,'$nama','$npm','$user','$pass','Mahasiswa')");
            if ($insert) {
                $_SESSION["message_swal"] = alert("Registrasi Berhasil");
                redirect_js("login.php");
            } else {
                $_SESSION["message_swal"] = swal("error", "Registrasi Akun Gagal", "Registrasi Gagal");
            }
        }
    }
}


//login akun
else if ($modules    == 'login') {
    $user       = esc_field($_POST['user']);
    $pass       = esc_field($_POST['pass']);

    $row        = $db->get_row("SELECT * FROM tb_user WHERE user='$user' AND pass='$pass'");
    if ($row) {
        $_SESSION['login']       = $row->id_user;
        $_SESSION['user']       = $row->user;
        $_SESSION['nama_user']       = $row->nama_user;
        $_SESSION['pass']       = $row->pass;
        $_SESSION['level']       = $row->level;
        $_SESSION["message_swal"] = alert("Login Berhasil");
        redirect_js("index.php");
    } else {
        // alert("Salah Kombinasi Usernamae dan Password");
        $_SESSION["message_swal"] = swal("error", "Salah Kombinasi Username dan Password", "Login Gagal");
    }
}

//tambah data data
else if ($modules == 'data-tambah') {
    $nama          = esc_field($_POST['nama']);
    $npm            = esc_field($_POST['npm']);
    $tahun      = esc_field($_POST['tahun']);
    $judul    = esc_field($_POST['judul']);
    $isi    = esc_field($_POST['isi']);

    if ($nama     == '' || $npm == '' || $tahun == '' || $judul == '' || $isi == '')
        print_msg("Tidak Boleh Kosong!");
    else if (isset($_POST['upload'])) {
        $insert   = $db->query("INSERT INTO tb_data_latih VALUES (null,'$nama','$npm','$tahun','$judul','$isi')");
        if ($insert) {
            // $_SESSION["message_swal"] = swal("success", "Data Berhasil Ditambahkan", "Data Latih");
            $_SESSION["message_swal"] = alert("Data Berhasil Ditambahkan");
            redirect_js("?mod=data-latih");
        } else {
            $_SESSION["message_swal"] = swal("error", "Data Gagal Ditambahkan", "Data Latih");
        }
    }
}
//edit data data
else if ($modules == 'data-edit') {
    $nama          = esc_field($_POST['nama']);
    $npm            = esc_field($_POST['npm']);
    $tahun      = esc_field($_POST['tahun']);
    $judul    = esc_field($_POST['judul']);
    $isi    = esc_field($_POST['isi']);

    if ($nama     == '' || $npm == '' || $tahun == '' || $judul == '' || $isi == '')
        print_msg("Tidak Boleh Kosong!");
    else {
        $db->query("UPDATE tb_data_latih SET nama = '$nama', npm = '$npm', tahun = '$tahun', judul = '$judul', isi = '$isi' WHERE id_skripsi = '$_GET[ID]'");
        // swal("success", "Data Berhasil Diupdate", "Data Latih");
        $_SESSION["message_swal"] = alert("Data Berhasil Diupdate");
        redirect_js("?mod=data-latih");
    }
}
//hapus data data latih
else if ($modules == 'data-hapus') {
    $db->query("DELETE FROM tb_data_latih WHERE id_skripsi='$_GET[ID]'");
    // swal("success", "Data Berhasil Dihapus", "Data Latih");
    $_SESSION["message_swal"] = alert("Data Berhasil Dihapus");
    header("location:index.php?mod=data-latih");
}

//tambah data prodi
else if ($modules == 'prodi-tambah') {
    $nama_prodi  = esc_field($_POST['nama']);
    $username = esc_field($_POST['username']);
    $password = esc_field($_POST['password']);

    if ($nama_prodi     == '' || $username == '' || $password == '')
        print_msg("Tidak Boleh Kosong!");
    else if (isset($_POST['upload'])) {
        $insert   = $db->query("INSERT INTO tb_user  VALUES (null,'$nama_prodi',null,'$username','$password','Prodi')");
        if ($insert) {
            // $_SESSION["message_swal"] = swal("success", "Data Berhasil Ditambahkan", "Data Prodi");
            $_SESSION["message_swal"] = alert("Data Berhasil Ditambahkan");
            redirect_js("?mod=data-prodi");
        } else {
            $_SESSION["message_swal"] = swal("error", "Data Gagal Ditambahkan", "Data Prodi");
        }
    }
}

//edit data prodi
else if ($modules == 'prodi-edit') {
    $nama_prodi  = esc_field($_POST['nama']);
    $username = esc_field($_POST['username']);
    $password = esc_field($_POST['password']);

    if ($nama_prodi     == '' || $username == '' || $password == '')
        print_msg("Tidak Boleh Kosong!");
    else {
        $db->query("UPDATE tb_user SET nama_user = '$nama_prodi', user = '$username', pass = '$password' WHERE id_user = '$_GET[ID]'");
        // swal("success", "Data Berhasil Diupdate", "Data Latih");
        $_SESSION["message_swal"] = alert("Prodi Berhasil Diupdate");
        redirect_js("?mod=data-prodi");
    }
}

//hapus data prodi
else if ($modules == 'prodi-hapus') {
    $db->query("DELETE FROM tb_user WHERE id_user='$_GET[ID]'");
    // swal("success", "Data Berhasil Dihapus", "Data Latih");
    $_SESSION["message_swal"] = alert("Prodi Berhasil Dihapus");
    header("location:index.php?mod=data-prodi");
}

//edit data mahasiswa
else if ($modules == 'mahasiswa-edit') {
    $nama          = esc_field($_POST['nama']);
    $npm            = esc_field($_POST['npm']);

    if ($nama     == '' || $npm == '')
        print_msg("Tidak Boleh Kosong!");
    else {
        $db->query("UPDATE tb_user SET nama_user = '$nama', npm = '$npm' WHERE id_user = '$_GET[ID]'");
        // swal("success", "Mahaiswa Berhasil Diupdate", "Mahasiswa");
        $_SESSION["message_swal"] = alert("Mahaiswa Berhasil Diupdate");
        redirect_js("?mod=data-mahasiswa");
    }
}

//hapus data mahasiswa
else if ($modules == 'mahasiswa-hapus') {
    $db->query("DELETE FROM tb_user WHERE id_user='$_GET[ID]'");
    // swal("success", "Mahasiswa Berhasil Dihapus", "Mahasiswa");
    $_SESSION["message_swal"] = alert("Mahasiswa Berhasil Dihapus");
    header("location:index.php?mod=data-mahasiswa");
}

//download template excel
else if ($modules == 'template-excel') {

    if (isset($_POST['export_excel_btn'])) {
        $spreadsheet = new Spreadsheet();
        $file_ext = esc_field($_POST['export_file_type']);
        $nama_file = "template_data_latih";

        $writer = new Xlsx($spreadsheet);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NPM');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Judul');
        $sheet->setCellValue('D1', 'Latar Belakang');
        $sheet->setCellValue('E1', 'Tahun');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $i = 2;
        $sheet->getStyle('A1:E20')->applyFromArray($styleArray);
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(65);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getStyle("A1:E1")->getFont(20)->setBold(true);

        if ($file_ext == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
            $filename = $nama_file . '.xlsx';
        } elseif ($file_ext == 'xls') {
            $writer = new Xls($spreadsheet);
            $filename = $nama_file . '.xls';
        } elseif ($file_ext == 'csv') {
            $writer = new Csv($spreadsheet);
            $filename = $nama_file . '.csv';
        }

        header('Cache-Control: max-age=0');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attactment; filename="' . urlencode($filename) . '"');
        $writer->save('php://output');
        exit();
    } else {
        $_SESSION['message'] = swal("error", "File Tidak Ditemukan", "Template Excel");
        header('Location: index.php');
        exit(0);
    }
}

//upload template excel
else if ($modules == 'upload-data') {
    if (isset($_POST['import_excel_btn'])) {

        $file_mimes = [
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (isset($_FILES['fileExcel']['name']) && in_array($_FILES['fileExcel']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['fileExcel']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ('xlsx' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }

            $spreadsheet = $reader->load($_FILES['fileExcel']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            for ($i = 1; $i < count($sheetData); $i++) {
                $npm     = $sheetData[$i]['0'];
                $nama    = $sheetData[$i]['1'];
                $judul     = $sheetData[$i]['2'];
                $isi = $sheetData[$i]['3'];
                $tahun = $sheetData[$i]['4'];

                $insert = $db->query("INSERT INTO tb_data_latih (nama, npm, tahun, judul, isi) VALUES ('$nama', '$npm', '$tahun', '$judul', '$isi')");
            }
            $_SESSION["message_swal"] = alert("Data Berhasil Diupload");
            // $_SESSION["message_swal"] = swal("success", "Data Berhasil Ditambahkan", "Data Latih");
            header("location:index.php?mod=data-latih");
        }
    }
}

//batalkan pengajuan
else if ($modules == 'batalkan-pengajuan') {
    $test = $db->query("DELETE FROM tb_proses_pengajuan WHERE id_proses_pengajuan='$_GET[ID]'");
    // echo $test;
    header("location:index.php");
}

//update status judul
else if ($modules == 'update-status') {
    $status = $_POST['status_judul'];
    $id = $_GET['ID'];
    $db->query("UPDATE tb_pengajuan SET status='$status' WHERE id_pengajuan='$id'");
    $_SESSION["message_swal"] = alert("Status Judul Telah Diupdate");
    header("location:index.php?mod=pengajuan");
}


//update keterangan judul
else if ($modules == 'update-keterangan') {
    $id = $_POST['id_pengajuan'];
    $keterangan = esc_field($_POST['keterangan']);

    if (isset($_POST['upload'])) {
        $db->query("UPDATE tb_pengajuan SET keterangan='$keterangan' WHERE id_pengajuan='$id'");
        $_SESSION["message_swal"] = alert("Keterangan Judul Telah Diupdate");
        header("location:index.php?mod=pengajuan");
    }
}

//hapus data pengajuan
else if ($modules == 'hapus-pengajuan') {
    $db->query("DELETE tb_pengajuan.*, tb_proses_pengajuan.*
                FROM tb_pengajuan
                INNER JOIN tb_proses_pengajuan ON tb_pengajuan.proses_judul = tb_proses_pengajuan.id_proses_pengajuan 
                WHERE (tb_pengajuan.proses_judul)='$_GET[ID]' AND (tb_proses_pengajuan.id_proses_pengajuan)='$_GET[IP]'");
    $_SESSION["message_swal"] = alert("Data Pengajuan Berhasil Dihapus");
    header("location:index.php?mod=pengajuan");
}
?>