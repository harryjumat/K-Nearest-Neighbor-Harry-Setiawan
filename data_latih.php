<!-- Begin Page Content -->
<div class="container-fluid">

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"> Data Latih</h6>
		</div>
		<div class="card-body">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
				<li class="fa fa-plus"></li> Tambah Data
			</button>
			<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import">
				<li class="fa fa-file"></li> Import Data .CSV
			</button> -->
			<a href="index.php?halaman=proses_text" class="btn btn-primary"><span class="fa fa-cog"></span> Pre-Processing Dan Hitung TF-IDF</a>
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Username</th>
						<th>Tweet</th>
						<th>Sentiment</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$sql =  mysqli_query($koneksi, "SELECT * FROM documents join sentiment on documents.code_sentiment = sentiment.code_sentiment ORDER BY doc_id DESC");
					while ($data = mysqli_fetch_array($sql)) {
						$code = $data['code_sentiment'];
					?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $data['user']; ?></td>
							<td><?php echo $data['document']; ?></td>
							<td><?php echo $data['name_sentiment']; ?></td>
						</tr>
					<?php $no++;
					} ?>
				</tbody>
			</table>

		</div>
	</div>

	<!-- Modal Tambah-->
	<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Data Latih</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form action="index.php?halaman=insert_data_latih" method="POST" enctype="multipart/form-data">
					<div class="modal-body">

						<div class="form-group row">
							<label class="col-md-2 col-form-label">Tweet</label>
							<div class="col-md-10">
								<textarea name="document" id="document" class="form-control" rows="3" required="required" placeholder="Tweet"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 col-form-label">Sentiment</label>
							<div class="col-md-10">
								<select class="form-control" name="code_sentiment" id="kat" required="required">
									<option value="0" selected disabled="true">--Pilih sentiment Berita--</option>
									<?php
									$query = mysqli_query($koneksi, "SELECT * FROM sentiment") or die(mysqli_error($koneksi));
									while ($data = mysqli_fetch_array($query)) {
									?>
										<option value="<?php echo $data['code_sentiment']; ?>"><?php echo $data['name_sentiment']; ?>
										</option>
									<?php }  ?>

								</select>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {

			$('#example1').dataTable();
		});
	</script>

	<!-- ModalImport-->
	<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Import Data .CSV</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form action="input_csv_latih.php" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-md-10">
								<input type="file" name="file" id="file" accept=".csv">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>