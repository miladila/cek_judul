<div class="row">
    <div class="col-md-8">
        <div class="white-box">
            <h3 class="box-title m-b-0">Tambah Data Prodi</h3>
            <form class="form-horizontal" action="?mod=prodi-tambah" method="POST" enctype="multipart/form-data">
                <?php if ($_POST) include 'action.php' ?>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Nama Lengkap" name="nama">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Username" name="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="passwords" class="form-control" id="inputEmail3" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info btn-rounded waves-effect waves-light" name="upload">Submit</button>
                        <a href="?mod=data-prodi" class="btn btn-danger btn-rounded waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>