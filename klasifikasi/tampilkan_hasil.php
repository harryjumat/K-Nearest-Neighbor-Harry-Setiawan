<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-fw fa-chart-o"></span>Hasil Klasifikasi</h6>
    </div>
    <div class="card-body">

      <table class="table table-bordered table-hover" id="example1">
        <thead>
          <tr>
            <th width=""> ID</th>
            <th width="500px">Document</th>
            <th>Klasifikasi Manual</th>
            <th width="">Klasifikasi Sistem</th>
          </tr>
        </thead>
        <tbody id="list-data">
         <?php 
         $query=mysqli_query($koneksi,"SELECT*FROM hasil_klasifikasi join data_uji on hasil_klasifikasi.id_uji = data_uji.id_uji") or die(mysqli_error($koneksi));
         $no = 1;
         while($row=mysqli_fetch_array($query))
         {
          ?>
          <tr>
            <td><?php echo $row['id_uji'] ?></td>
            <td style="text-align: justify;"><?php echo $row['document']?></td>
            <td>
              <?php 
              if ($row['klasifikasi_manual'] == 's1') {
               echo "Positif";
             }else if ($row['klasifikasi_manual'] == 's2') {
               echo "Negatif";
             }else{
              echo "Netral";
            }
            ?>   
          </td>
          <td>
            <?php 
             if ($row['sentiment'] == 's1') {
               echo "Positif";
             }else if ($row['sentiment'] == 's2') {
               echo "Negatif";
             }else{
              echo "Netral";
            }
          ?>   
        </td>
      </tr>
      <?php
      $no++; 
    } 
    ?>
  </tbody>
</table>

</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    $('#example1').dataTable();
  });
</script>