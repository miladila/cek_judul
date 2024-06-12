<div class="row">
    <div class="col-md-8">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tambah Data Latih</h3>
            <form class="form-horizontal" action="?mod=data-tambah" method="POST" enctype="multipart/form-data">
                <?php if ($_POST) include 'action.php' ?>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Nama Lengkap" name="nama">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">NPM</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="inputEmail3" placeholder="NPM" name="npm">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Tahun <br>
                        <p style="color:red; font-size:10px;">*Berupa angka 4 digit*</p>
                    </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="inputEmail3" placeholder="Tahun" name="tahun">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Judul</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Judul" name="judul">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Latar Belakang</label>
                    <div class="col-sm-9">
                        <textarea name="isi" id="" cols="30" rows="10" class="form-control" placeholder="..."></textarea>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info btn-rounded waves-effect waves-light" name="upload">Submit</button>
                        <a href="?mod=data-latih" class="btn btn-danger btn-rounded waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>