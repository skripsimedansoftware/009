<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator <small>Analisis Produk - Max Miner</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="row">
		<div class="col-lg-3 col-sm-12">
			<form action="">
				<div class="form-group">
					<label>Nilai Support</label>
					<?php $min_support = (!empty($this->input->get('min-support')))?$this->input->get('min-support'):0.2 ?>
					<input type="text" class="form-control" name="min-support" value="<?= $min_support ?>" placeholder="Nilai Support">
				</div>
				<div class="form-group">
					<button class="btn btn-block btn-flat btn-primary">Perbaharui nilai support</button>
				</div>
			</form>
		</div>
	</div>
	<?php

	$single_item_count = $max_miner->item_count(); // Hitung total item unik beserta jumlah trasaksinya

	$count_support_single_item = $max_miner->count_support($single_item_count); // Menghitung nilai support setiap item

	$single_item_elimination = $max_miner->elimination($count_support_single_item); // Eliminasi data frekuensi item dibawah min-support

	$joined_items = $max_miner->join_item($single_item_elimination); // Kombinasikan item

	$count_joined_items = $max_miner->item_joined_count($joined_items); // Hitung jumlah frekuensi item yang digabungkan

	$count_support_joined_items = $max_miner->count_support($count_joined_items); // Menghitung nilai support setiap item

	$joined_item_elimination = $max_miner->elimination($count_support_joined_items); // Eliminasi data frekuensi item dibawah min-support
	?>

	<div class="row">
		<div class="col-lg-12">
			<h1>Max Miner <small>Snack</small></h1>
		</div>
		<div class="col-lg-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Transaksi Produk</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped table-condensed datatable">
						<thead>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Frekuensi</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($single_item_count as $name => $count): ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= implode(', ', explode('_', $name)) ?></td>
									<td><?= $count ?></td>
								</tr>
							<?php
							$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Support Produk</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped table-condensed datatable">
						<thead>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Support</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($count_support_single_item as $name => $support): ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= implode(', ', explode('_', $name)) ?></td>
									<td><?= ($max_miner->min_support_type == 'int')?($support*100).'%':$support ?></td>
								</tr>
							<?php
							$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Eliminasi Produk</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped table-condensed datatable">
						<thead>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Support</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($single_item_elimination as $name => $support): ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= implode(', ', explode('_', $name)) ?></td>
									<td><?= ($max_miner->min_support_type == 'int')?$support.'%':$support ?></td>
								</tr>
							<?php
							$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Transaksi Produk</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped table-condensed datatable">
						<thead>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Frekuensi</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($count_joined_items as $name => $count): ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= implode(', ', explode('_', $name)) ?></td>
									<td><?= $count ?></td>
								</tr>
							<?php
							$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Support Produk</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped table-condensed datatable">
						<thead>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Support</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($count_support_joined_items as $name => $support): ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= implode(', ', explode('_', $name)) ?></td>
									<td><?= ($max_miner->min_support_type == 'int')?($support*100).'%':$support ?></td>
								</tr>
							<?php
							$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Eliminasi Produk</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped table-condensed datatable">
						<thead>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Support</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($joined_item_elimination as $name => $support): ?>
								<tr>
									<td><?= $i ?></td>
									<td><?= implode(', ', explode('_', $name)) ?></td>
									<td><?= ($max_miner->min_support_type == 'int')?$support.'%':$support ?></td>
								</tr>
							<?php
							$i++;
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Asosiasi</h3>
				</div>
				<div class="box-body">
					<table class="table table-hover table-striped datatable">
						<thead>
							<th>No</th>
							<th>Rule</th>
							<th>Support</th>
							<th>Confidence</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($joined_item_elimination as $joined_item => $item_support)
							{
								$joined_items = explode('_', $joined_item);
								if ($max_miner->min_support_type == 'int')
								{
									$item_support = $item_support/100;
								}

								$support = $count_support_single_item[$joined_items[0]]+$count_support_single_item[$joined_items[1]]-$item_support;

								$confidences = array(
									$joined_items[0] => $count_joined_items[$joined_item]/$single_item_count[$joined_items[0]],
									$joined_items[1] => $count_joined_items[$joined_item]/$single_item_count[$joined_items[1]]
								);

								$recomendation->recomendation_add($joined_items[0], $joined_items[1]);

								?>
								<tr>
									<td><?= $i ?></td>
									<td>
										<?php
										$rule = 'Jika membeli';

										foreach ($joined_items as $key => $name)
										{
											if ($name !== end($joined_items))
											{
												$rule .= ' <b>'.$name.'</b>,';
											}
											else
											{
												$rule .= 'maka membeli <b><u>'.$name.'</u></b>';
											}
										}

										echo $rule;
										?>
									</td>
									<td><?= ($max_miner->min_support_type == 'int')?($item_support*100).'%':$item_support ?></td>
									<td>
										<?php
										foreach ($confidences as $item => $confidence)
										{
											if ($max_miner->min_support_type == 'int')
											{
												echo $item.' ('.round($confidence*100).'%)<br>';
											}
											else
											{
												echo $item.' ('.$confidence.')<br>';
											}
										}
										?>
									</td>
								</tr>
								<?php
								$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
$('.datatable').DataTable({ responsive: true });
</script>
