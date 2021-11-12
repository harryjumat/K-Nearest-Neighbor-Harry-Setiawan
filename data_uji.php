<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"> Data Uji</h6>
    </div>
    <div class="card-body">

      <a href="index.php?halaman=scraping" button type="button" class="btn btn-primary">
        <li class="fa fa-plus"></li> Ambil Data
      </a>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
        <li class="fa fa-plus"></li> Add Data
      </button>
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import">
        <li class="fa fa-file"></li> Import Data csv
      </button> -->

      <form method="post" enctype="multipart/form-data" action="proses_import.php">
        <div class="form-group">
          <input type="file" name="berkas_excel" class="form-control" id="exampleInputFile"> <button type="submit" class="btn btn-primary">Import</button>
        </div>
        <!-- <button type="submit" class="btn btn-primary">Import</button> -->
      </form>

      <br><br>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Tweet</th>
            <th>Klasifikasi Manual</th>
            <th>Klasifikasi Sistem</th>
            <th>Option</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $sql =  mysqli_query($koneksi, "SELECT * FROM data_uji join sentiment on data_uji.klasifikasi_manual = sentiment.code_sentiment order by id_uji DESC");
          while ($data = mysqli_fetch_array($sql)) {
            $code = $data['klasifikasi_manual'];
          ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $data['document']; ?></td>
              <td><?php echo $data['name_sentiment']; ?></td>
              <td>Belum Diketahui</td>
              <td>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#delete-<?php echo $data['id_uji']; ?>" title="Delete data_uji"><span class="fa fa-trash"></span></a> <br><br>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#edit-<?php echo $data['id_uji']; ?>" title="Delete data_latih"><span class="fa fa-edit"></span></a>
              </td>
            </tr>

            <!-- Modal edit -->
            <div class="modal fade" id="edit-<?php echo $data['id_uji']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Uji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="index.php?halaman=edit_data&type=uji" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">

                      <input type="hidden" name="id_uji" value="<?php echo $data['id_uji']; ?>">
                      <div class="form-group row">
                        <label class="col-md-2 col-form-label">Text</label>
                        <div class="col-md-10">
                          <textarea name="document" id="document" class="form-control" rows="3" required="required" placeholder="document"><?php echo $data['document']; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-2 col-form-label">Sentimend</label>
                        <div class="col-md-10">
                          <select class="form-control" name="code_sentiment" id="kat" required="required">
                            <option value="<?php echo $data['klasifikasi_manual']; ?>"><?php echo $data['name_sentiment']; ?></option>
                            <?php
                            $query_s = mysqli_query($koneksi, "SELECT * FROM sentiment") or die(mysqli_error());
                            while ($data_s = mysqli_fetch_array($query_s)) {
                              if ($code == $data_s['code_sentiment']) {
                                continue;
                              }
                            ?>
                              <option value="<?php echo $data_s['code_sentiment']; ?>"><?php echo $data_s['name_sentiment']; ?>
                              </option>
                            <?php } ?>

                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="delete-<?php echo $data['id_uji']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Data Uji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="index.php?halaman=delete_data&type=uji" method="POST">
                    <div class="modal-body">
                      <h5>Are You Sure You Want To Delete This Data?</h5>
                      <input type="hidden" name="id_uji" value="<?php echo $data['id_uji']; ?>">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


          <?php $no++;
          } ?>
        </tbody>
      </table>

      <!-- Modal -->
      <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Import Data CSV</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="input_csv.php" method="POST" enctype="multipart/form-data">
              <div class="modal-body">

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">File CSV</label>
                  <div class="col-md-10">
                    <input type="file" name="file" id="file" accept=".csv">
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Data Uji</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="index.php?halaman=insert_data_uji" method="POST" enctype="multipart/form-data">
              <div class="modal-body">

                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Text</label>
                  <div class="col-md-10">
                    <textarea name="document" id="document" class="form-control" rows="3" required="required" placeholder="document"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 col-form-label">Klasifikasi Manual</label>
                  <div class="col-md-10">
                    <select class="form-control" name="code_sentiment" id="kat" required="required">
                      <option value="0" selected disabled="true">--Pilih sentiment Tweet--</option>
                      <?php
                      $query = mysqli_query($koneksi, "SELECT * FROM sentiment") or die(mysqli_error());
                      while ($data = mysqli_fetch_array($query)) {
                      ?>
                        <option value="<?php echo $data['code_sentiment']; ?>"><?php echo $data['name_sentiment']; ?>
                        </option>
                      <?php } ?>

                    </select>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {

      $('#example1').dataTable();
    });
  </script>