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
            <h3 class="box-title">Case Folding Results</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-hover" id="example1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Case Folding</th>
                  <th>Sentiment</th>
                </tr>
              </thead>
              <tbody id="list-data">
                <?php
                $query = mysqli_query($koneksi, "SELECT case_folding.`doc_id`, case_folding.`case_folding`, sentiment.`name_sentiment` FROM case_folding INNER JOIN sentiment ON case_folding.`code_sentiment` = sentiment.`code_sentiment`;") or die(mysqli_error());
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <tr>
                    <td><?php echo $row['doc_id'] ?></td>
                    <td style="text-align: justify;"><?php echo $row['case_folding'] ?></td>
                    <td><?php echo $row['name_sentiment'] ?></td>
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