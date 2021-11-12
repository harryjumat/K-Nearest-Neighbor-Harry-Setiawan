<?php
$sql =  mysqli_query($koneksi, "SELECT * FROM documents");
$jumlah_latih = mysqli_num_rows($sql);

$sql1 =  mysqli_query($koneksi, "SELECT * FROM data_uji");
$jumlah_uji = mysqli_num_rows($sql1);

$kv =  mysqli_query($koneksi, "SELECT * FROM kvalues_baru order by id_kvalues DESC LIMIT 1");
$kv_data = mysqli_fetch_array($kv);

$nilai_k = $kv_data['nilai_k'];
$n_positif = $kv_data['n_positif'];
$n_negatif = $kv_data['n_negatif'];
$n_netral = $kv_data['n_netral'];

$q_ket = mysqli_query($koneksi, "SELECT*FROM pengujian order by nilai_k")  or die(mysqli_error($koneksi));
while ($pengujian = mysqli_fetch_array($q_ket)) {
  $data_ket[] =  "Nilai-K " . $pengujian['nilai_k'];
  $data_akurasi[] =  $pengujian['akurasi'];
}
json_encode($data_akurasi);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <!-- <h1 class="h3 mb-0 text-gray-800">Cosine Similiarity</h1> -->
  </div>

  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Latih</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_latih; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-table fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Data Uji</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_uji; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-table fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row">


    <div class="col-md-6">

      <!-- Basic Card Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Implementasi Metode Klasifikasi Improved K-NN</h6>
        </div>
        <div class="card-body">
          <!-- MODAL EDIT -->
          <form id="form_edit" action="index.php?halaman=insert_kvalues" enctype="multipart/form-data" method="POST">

            <div class="form-group row">
              <label class="col-md-2 col-form-label">Nilai K</label>
              <div class="col-md-10">
                <input type="text" name="nilai_k" id="name_event" class="form-control" placeholder="Nilai K" required="required" value="<?php echo $nilai_k; ?>">
              </div>
            </div>

            <!--    <div class="form-group row">
        <label class="col-md-2 col-form-label">N Positif</label>
        <div class="col-md-10">
          <input type="text" name="n_positif" id="name_event" class="form-control" placeholder="N Positif" required="required" value="<?php echo $n_positif; ?>">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label">N Negatif</label>
        <div class="col-md-10">
          <input type="text" name="n_negatif" id="name_event" class="form-control" placeholder="N Negatif" required="required" value="<?php echo $n_negatif; ?>">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label">N Netral</label>
        <div class="col-md-10">
          <input type="text" name="n_netral" id="name_event" class="form-control" placeholder="N Netral" required="required" value="<?php echo $n_netral; ?>">
        </div>
      </div> -->



            <button type="submit" class="btn btn-primary">Update K-Values</button>
            <!-- <button type="reset" class="btn btn-danger">Reset</button> -->
          </form>
          <!--END MODAL EDIT-->

          <br><br>

          <div class="row">

            <!-- Border Left Utilities -->
            <div class="col-lg-4">

              <div class="card border-bottom-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-center font-weight-bold text-success text-uppercase mb-1">N Positif</div>
                      <div class="h2 text-center mb-0 font-weight-bold text-success"><?php echo $n_positif; ?></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Border Left Utilities -->
            <div class="col-lg-4">

              <div class="card border-bottom-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-center font-weight-bold text-danger text-uppercase mb-1">N Negatif</div>
                      <div class="h2 text-center mb-0 font-weight-bold text-danger"><?php echo $n_negatif; ?></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Border Left Utilities -->
            <div class="col-lg-4">

              <div class="card border-bottom-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-center font-weight-bold text-primary text-uppercase mb-1">N Netral</div>
                      <div class="h2 text-center mb-0 font-weight-bold text-primary"><?php echo $n_netral; ?></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>


          </div>

        </div>
      </div>
    </div>
    <!-- Pie Chart -->
    <div class="col-md-6">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Grafik Data Latih</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-pie pt-4 pb-4">
            <canvas id="myPieChart"></canvas>
          </div><br>
          <div class="mt-4 text-center small">
            <span class="mr-2">
              <i class="fas fa-circle text-success"></i> Positif
            </span>
            <span class="mr-2">
              <i class="fas fa-circle text-danger"></i> Negatif
            </span>
            <span class="mr-2">
              <i class="fas fa-circle text-primary"></i> Netral
            </span>
          </div>
        </div>
      </div>
    </div>

  </div>


  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-7 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Presentasi Pengujian Akurasi</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-5 col-lg-6">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Pengujian Sistem Berdasarkan Nilai K</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
          <table class="table table-bordered table-hover text-center table-responsive" id="example1">
            <thead>
              <tr>
                <th rowspan="2"> Nilai K</th>
                <th colspan="3">n(K-Values Baru)</th>
                <th rowspan="2">Akurasi</th>
              </tr>
              <tr>
                <th>Positf</th>
                <th>Negatif</th>
                <th>Netral</th>
              </tr>
            </thead>
            <tbody id="list-data">
              <?php
              $query = mysqli_query($koneksi, "SELECT*FROM pengujian join kvalues_baru on pengujian.nilai_k = kvalues_baru.nilai_k order by pengujian.nilai_k ") or die(mysqli_error($koneksi));
              $no = 1;
              while ($row = mysqli_fetch_array($query)) {
              ?>
                <tr>
                  <td><?php echo $row['nilai_k']; ?></td>
                  <td><?php echo $row['n_positif']; ?></td>
                  <td><?php echo $row['n_negatif']; ?></td>
                  <td><?php echo $row['n_netral']; ?></td>
                  <td><?php echo $row['akurasi']; ?>%</td>
                </tr>
              <?php
                $no++;
              }
              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>



  <!-- Page level plugins -->
  <script src="assets/sbadmin/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <!--     <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>
  -->

  <?php

  $positif_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's1'")  or die(mysqli_error($koneksi));
  $sum_positif_latih = mysqli_num_rows($positif_latih);

  $negatif_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's2'")  or die(mysqli_error($koneksi));
  $sum_negatif_latih = mysqli_num_rows($negatif_latih);

  $netral_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's3'")  or die(mysqli_error($koneksi));
  $sum_netral_latih = mysqli_num_rows($netral_latih); ?>
  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Positif", "Negatif", "Netral"],
        datasets: [{
          data: [<?php echo $sum_positif_latih; ?>, <?php echo $sum_negatif_latih; ?>, <?php echo $sum_netral_latih; ?>],
          backgroundColor: ['#1cc88a', '#e74a3b', '#4e73df'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });


    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($data_ket); ?>,
        datasets: [{
          label: "Akurasi",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: <?php echo json_encode($data_akurasi); ?>,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return number_format(value) + '%';
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + '%';
            }
          }
        }
      }
    });
  </script>