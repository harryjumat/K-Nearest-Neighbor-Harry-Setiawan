<!-- Begin Page Content -->
<div class="container-fluid">

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Hasil Klasifikasi</h6>
		</div>
		<div class="card-body">

			<table class="table table-bordered table-hover" id="example1">
				<thead>
					<tr>
						<th width=""> ID</th>
						<th width="500px">Tweet</th>
						<th>Klasifikasi Manual</th>
						<th width="">Klasifikasi Sistem</th>
					</tr>
				</thead>
				<tbody id="list-data">
					<?php
					$query = mysqli_query($koneksi, "SELECT*FROM hasil_klasifikasi join data_uji on hasil_klasifikasi.id_uji = data_uji.id_uji") or die(mysqli_error($koneksi));
					$no = 1;
					while ($row = mysqli_fetch_array($query)) {
					?>
						<tr>
							<td><?php echo $row['id_uji'] ?></td>
							<td style="text-align: justify;"><?php echo $row['document'] ?></td>
							<td>
								<?php
								if ($row['klasifikasi_manual'] == 's1') {
									echo "Positif";
								} else if ($row['klasifikasi_manual'] == 's2') {
									echo "Negatif";
								} else {
									echo "Netral";
								}
								?>
							</td>
							<td>
								<?php
								if ($row['sentiment'] == 's1') {
									echo "Positif";
								} else if ($row['sentiment'] == 's2') {
									echo "Negatif";
								} else {
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


			<script type="text/javascript">
				$(document).ready(function() {

					$('#example1').dataTable();
				});
			</script>




			<div class="box-body">
				<canvas id="pieChart" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
			</div>
			<?php

			$positif_uji = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE hasil_klasifikasi.sentiment = 's1'")  or die(mysqli_error($koneksi));
			$sum_positif_uji = mysqli_num_rows($positif_uji);
			$positif_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's1'")  or die(mysqli_error($koneksi));
			$sum_positif_latih = mysqli_num_rows($positif_latih);
			$positif = $sum_positif_uji + $sum_positif_latih;

			$negatif_uji = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE hasil_klasifikasi.sentiment = 's2'")  or die(mysqli_error($koneksi));
			$sum_negatif_uji = mysqli_num_rows($negatif_uji);
			$negatif_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's2'")  or die(mysqli_error($koneksi));
			$sum_negatif_latih = mysqli_num_rows($negatif_latih);
			$negatif = $sum_negatif_uji + $sum_negatif_latih;

			$netral_uji = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE hasil_klasifikasi.sentiment = 's3'")  or die(mysqli_error($koneksi));
			$sum_netral_uji = mysqli_num_rows($netral_uji);
			$netral_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's3'")  or die(mysqli_error($koneksi));
			$sum_netral_latih = mysqli_num_rows($netral_latih);
			$netral = $sum_netral_uji + $sum_netral_latih;

			$sum_all = $positif + $negatif + $netral;
			$percentage_positif = $positif / $sum_all * 100;
			$percentage_negatif = $negatif / $sum_all * 100;
			$percentage_netral = $netral / $sum_all * 100;

			?>
			<b>Total Data Per Kategori Data Latih + Hasil Klasifikasi Data Uji</b>
			<br><br>

			<!-- Project Card Example -->

			<h4 class="small font-weight-bold">Positif <span class="float-right"><?php echo $positif; ?> Data</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar" role="progressbar" <?php echo "style='width:$percentage_positif%; background-color:#36A2EB;'"; ?> aria-valuenow="<?php echo $positif; ?>" aria-valuemin="0" aria-valuemax="<?php echo $sum_all; ?>"></div>
			</div>
			<h4 class="small font-weight-bold">Negatif <span class="float-right"><?php echo $negatif; ?> Data</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar" role="progressbar" <?php echo "style='width:$percentage_negatif%; background-color:#FF6384;'"; ?> aria-valuenow="<?php echo $negatif; ?>" aria-valuemin="0" aria-valuemax="<?php echo $sum_all; ?>"></div>
			</div>
			<h4 class="small font-weight-bold">Netral <span class="float-right"><?php echo $netral; ?> Data</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar" role="progressbar" <?php echo "style='width:$percentage_netral%; background-color:#1aeb7b;'"; ?> aria-valuenow="<?php echo $netral; ?>" aria-valuemin="0" aria-valuemax="<?php echo $sum_all; ?>"></div>
			</div>

			<!-- Akhir dari Konten-->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
			<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

			<?php

			$positif_data_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's1'")  or die(mysqli_error($koneksi));
			$sum_positif_data_latih = mysqli_num_rows($positif_data_latih);
			$negatif_data_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's2'")  or die(mysqli_error($koneksi));
			$sum_negatif_data_latih = mysqli_num_rows($negatif_data_latih);

			$netral_data_latih = mysqli_query($koneksi, "SELECT*FROM documents WHERE code_sentiment = 's3'")  or die(mysqli_error($koneksi));
			$sum_netral_data_latih = mysqli_num_rows($netral_data_latih);

			$positif_data_uji = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE hasil_klasifikasi.sentiment = 's1'")  or die(mysqli_error($koneksi));
			$sum_positif_data_uji = mysqli_num_rows($positif_data_uji);
			$negatif_data_uji = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE hasil_klasifikasi.sentiment = 's2'")  or die(mysqli_error($koneksi));
			$sum_negatif_data_uji = mysqli_num_rows($negatif_data_uji);
			$netral_data_uji = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE hasil_klasifikasi.sentiment = 's3'")  or die(mysqli_error($koneksi));
			$sum_netral_data_uji = mysqli_num_rows($netral_data_uji);

			$total_positif = $sum_positif_data_latih + $sum_positif_data_uji;
			$total_negatif = $sum_negatif_data_latih + $sum_negatif_data_uji;
			$total_netral = $sum_netral_data_latih + $sum_netral_data_uji;

			?>
			<!-- page script -->
			<script>
				var canvas = document.getElementById('pieChart');
				new Chart(canvas, {
					type: 'pie',
					data: {
						labels: ['Positif', 'Negatif', 'Netral'],
						datasets: [{
							data: [<?php echo $total_positif; ?>, <?php echo $total_negatif; ?>, <?php echo $total_netral; ?>],
							backgroundColor: ['#36A2EB', '#FF6384', '#1aeb7b']
						}]
					},
					options: {
						maintainAspectRatio: false,
						responsive: true,
						plugins: {
							labels: {
								render: 'percentage',
								fontColor: ['green', 'white', 'red'],
								precision: 3
							}
						},
					}
				});
			</script>
		</div>
	</div>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Akurasi Metode Improved K-NN</h6>
		</div>
		<div class="card-body">

			<h3>Table Confussion Matrix</h3>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th></th>
						<th>Klasifikasi Positif</th>
						<th>Klasifikasi Negatif</th>
						<th>Klasifikasi Netral</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$positif_positif = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's1' && hasil_klasifikasi.sentiment = 's1'")  or die(mysqli_error($koneksi));
					$sum_positif_positif = mysqli_num_rows($positif_positif);

					$positif_negatif = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's1' && hasil_klasifikasi.sentiment = 's2'")  or die(mysqli_error($koneksi));
					$sum_positif_negatif = mysqli_num_rows($positif_negatif);

					$positif_netral = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's1' && hasil_klasifikasi.sentiment = 's3'")  or die(mysqli_error($koneksi));
					$sum_positif_netral = mysqli_num_rows($positif_netral);



					$negatif_negatif = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's2' && hasil_klasifikasi.sentiment = 's2'")  or die(mysqli_error($koneksi));
					$sum_negatif_negatif = mysqli_num_rows($negatif_negatif);

					$negatif_positif = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's2' && hasil_klasifikasi.sentiment = 's1'")  or die(mysqli_error($koneksi));
					$sum_negatif_positif = mysqli_num_rows($negatif_positif);

					$negatif_netral = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's2' && hasil_klasifikasi.sentiment = 's3'")  or die(mysqli_error($koneksi));
					$sum_negatif_netral = mysqli_num_rows($negatif_netral);


					$netral_negatif = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's3' && hasil_klasifikasi.sentiment = 's2'")  or die(mysqli_error($koneksi));
					$sum_netral_negatif = mysqli_num_rows($netral_negatif);

					$netral_positif = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's3' && hasil_klasifikasi.sentiment = 's1'")  or die(mysqli_error($koneksi));
					$sum_netral_positif = mysqli_num_rows($netral_positif);

					$netral_netral = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = 's3' && hasil_klasifikasi.sentiment = 's3'")  or die(mysqli_error($koneksi));
					$sum_netral_netral = mysqli_num_rows($netral_netral);

					?>

					<tr>
						<td>Aktual Positif</td>
						<td><?php echo $sum_positif_positif; ?></td>
						<td><?php echo $sum_positif_negatif; ?></td>
						<td><?php echo $sum_positif_netral; ?></td>
					</tr>
					<tr>
						<td>Aktual Negatif</td>
						<td><?php echo $sum_negatif_positif; ?></td>
						<td><?php echo $sum_negatif_negatif; ?></td>
						<td><?php echo $sum_negatif_netral; ?></td>
					</tr>
					<tr>
						<td>Aktual Netral</td>
						<td><?php echo $sum_netral_positif; ?></td>
						<td><?php echo $sum_netral_negatif; ?></td>
						<td><?php echo $sum_netral_netral; ?></td>
					</tr>

				</tbody>
			</table>

			<div class="box-body">
				<h3>Akurasi</h3>
				<!-- <div id="Akurasi" style="height: 300px;"></div> -->
				<div class="box-body">
					<canvas id="Akurasi" style="min-height: 400px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
				</div>
			</div>

			<?php
			$true = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual = hasil_klasifikasi.sentiment")  or die(mysqli_error($koneksi));
			$sum_true = mysqli_num_rows($true);
			$false = mysqli_query($koneksi, "SELECT*FROM data_uji join hasil_klasifikasi on data_uji.id_uji = hasil_klasifikasi.id_uji WHERE data_uji.klasifikasi_manual != hasil_klasifikasi.sentiment")  or die(mysqli_error($koneksi));
			$sum_false = mysqli_num_rows($false);
			?>
			<!-- page script -->
			<script>
				var canvas = document.getElementById('Akurasi');
				new Chart(canvas, {
					type: 'pie',
					data: {
						labels: ['Sesuai', 'Tidak Sesuai'],
						datasets: [{
							data: [<?php echo $sum_true; ?>, <?php echo $sum_false; ?>],
							backgroundColor: ['#36A2EB', '#FF6384']
						}]
					},
					options: {
						maintainAspectRatio: false,
						responsive: true,
						plugins: {
							labels: {
								render: 'percentage',
								fontColor: ['green', 'white', 'red'],
								precision: 2
							}
						},
					}
				});
			</script>




			<script>
				$(function() {

					/*
					 * DONUT CHART
					 * -----------
					 */

					var donutData = [{
							label: 'Sesuai',
							data: <?php echo $sum_true; ?>,
							color: '#3c8dbc'
						},
						{
							label: 'Tidak Sesuai',
							data: <?php echo $sum_false; ?>,
							color: '#DC143C'
						}
					]
					$.plot('#donut-chart', donutData, {
						series: {
							pie: {
								show: true,
								radius: 1,
								innerRadius: 0.5,
								label: {
									show: true,
									radius: 2 / 3,
									formatter: labelFormatter,
									threshold: 0.1
								}

							}
						},
						legend: {
							show: false
						}
					})
					/*
					 * END DONUT CHART
					 */

				})

				/*
				 * Custom Label formatter
				 * ----------------------
				 */
				function labelFormatter(label, series) {
					return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
						label +
						'<br>' +
						Math.round(series.percent) + '%</div>'
				}
			</script>


		</div>
	</div>