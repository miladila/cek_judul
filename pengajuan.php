<div class="row">
    <?php
    if ($_SESSION['level'] == 'Mahasiswa') :
        include 'pengajuan-mhs.php';
    else :
        include 'pengajuan-adprod.php';
    endif; ?>
</div>