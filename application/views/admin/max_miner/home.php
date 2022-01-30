<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator <small>Analisis Produk - Max Miner</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<?php
	$iteration = 1;
	for (;;)
	{
		if ($iteration == 1)
		{
			$item_count = $max_miner->item_count();

			$count_support = $max_miner->count_support($item_count);

			$elimination = $max_miner->elimination($count_support);
		}
		else
		{
			$item_count = $max_miner->item_joined_count($max_miner->join_item($elimination));

			$count_support = $max_miner->count_support($item_count);

			$elimination = $max_miner->elimination($count_support);
		}

		?>
			<div class="row">
				<div class="col-lg-12">
					<h1>Max Miner <small>Iterasi <?= $iteration ?></small></h1>
				</div>
				<div class="col-lg-4">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Transaksi Produk</h3>
						</div>
						<div class="box-body">
							<table class="table table-hover table-striped table-condensed">
								<thead>
									<th>No</th>
									<th>Nama Produk</th>
									<th>Jumlah Pembelian</th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($item_count as $name => $count): ?>
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
							<table class="table table-hover table-striped table-condensed">
								<thead>
									<th>No</th>
									<th>Nama Produk</th>
									<th>Jumlah Support</th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($count_support as $name => $support): ?>
										<tr>
											<td><?= $i ?></td>
											<td><?= implode(', ', explode('_', $name)) ?></td>
											<td><?= $support ?></td>
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
							<table class="table table-hover table-striped table-condensed">
								<thead>
									<th>No</th>
									<th>Nama Produk</th>
									<th>Jumlah Support</th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($elimination as $name => $support): ?>
										<tr>
											<td><?= $i ?></td>
											<td><?= implode(', ', explode('_', $name)) ?></td>
											<td><?= $support ?></td>
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
		<?php

		if (count($elimination) < 1)
		{
			?>
			<div class="row">
				<div class="col-lg-12">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Asosiasi</h3>
						</div>
						<div class="box-body">
							<table class="table table-hover table-striped">
								<thead>
									<th>No</th>
									<th>Rule</th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($count_support as $item => $support)
									{
										?>
										<tr>
											<td><?= $i ?></td>
											<td>
												<?php
												$items = explode('_', $item);
												$rule = 'Jika membeli';

												foreach ($items as $key => $name)
												{
													if ($name !== end($items))
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
			<?php
			break;
		}

		$iteration++;
	}
	?>
</section>
