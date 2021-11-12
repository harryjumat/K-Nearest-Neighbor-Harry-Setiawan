 <!-- Awal dari Konten-->
  <div class="content-wrapper">
    <section class="content">
      <div class="alert alert-danger alert-dismissible" id="alert-error" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      </div>
      <div class="row" id="content-customer">
        <div class="col-md-12 col-xs-12" id="content-customer-body">
          <div class="box">
              <div class="box-header with-border" id="load-data">
                <h3 class="box-title">Basic Word List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Basic Word</th>
                    <th>Type Basic Word</th>
                  </tr>
                  </thead>
                  <tbody id="list-data">
                   <?php 
                      $query=mysqli_query($koneksi,"select * from kata_dasar") or die(mysqlii_error());
                      while($row=mysqli_fetch_array($query))
                      {
                      ?>
                      <tr>
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['kata_dasar']?></td>
                        <td><?php echo $row['type_kata_dasar']?></td>
                      </tr>
                      <?php 
                      } 
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
                <ul class="pagination pagination-xs no-margin pull-right">
                 
                </ul>
              </div>
            </div>    
        </div>
      </div>
    </section>
  </div>
  <!-- Akhir dari Konten-->