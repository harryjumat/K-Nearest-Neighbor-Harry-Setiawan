<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"> Hasil Filtering Dan Stemming</h6>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover" id="example1">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tweet</th>
            <th>Hasil Filtering & Stemming</th>
          </tr>
        </thead>
        <tbody id="list-data">
          <?php
          $query = mysqli_query($koneksi, "select * from documents ") or die(mysqli_error());
          while ($row = mysqli_fetch_array($query)) {
            $doc_id = $row['doc_id'];
          ?>
            <tr>
              <td><?php echo $row['doc_id']; ?></td>
              <td><?php echo $row['document']; ?></td>
              <td>
                <?php
                $query_stemming = mysqli_query($koneksi, "select * from stemming where doc_id = '$doc_id'") or die(mysqli_error());
                while ($row_stemming = mysqli_fetch_array($query_stemming)) {
                ?>
                  <?php echo $row_stemming['term']; ?>
                <?php } ?>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {

      $('#example1').dataTable();
    });
  </script>