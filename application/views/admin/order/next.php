<section class="invoice">
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-papers"></i> <?= $this->config->item('app_name'); ?>
				<small class="pull-right"><b>Pesanan #<?= $code ?> </b> Date: <?= date('d/m/Y') ?></small>
			</h2>
		</div>
		<!-- /.col -->
	</div>
	<!-- Table row -->
	<div class="row">
		<div class="col-xs-12 table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Produk</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($order as $value) :?>
						<tr>
							<td><?= $value['name'] ?></td>
							<td>Rp.<?= number_format($value['price'], 0, ',', '.') ?></td>
							<td><?= $value['qty'] ?></td>
							<td>Rp.<?= number_format($value['subtotal'], 0, ',', '.') ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<!-- /.col -->
	</div>
<!-- /.row -->
	<div class="row">
		<!-- accepted payments column -->
		<!-- /.col -->
		<div class="col-xs-6">
			<p class="lead"><?= date('l, d F Y') ?></p>
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th style="width:50%">Total :</th>
						<td>Rp.<?= number_format($this->cart->total(), 0, ',', '.') ?></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<!-- this row will not appear when printing -->
	<div class="row no-print">
		<div class="col-xs-12">
			<form action="<?= base_url($this->router->fetch_class().'/order_next') ?>" method="post">
				<input type="hidden" name="order_uid" value="<?= $code ?>">
				<button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Buat Pesanan</button>
			</form>
		</div>
	</div>
</section>
<!-- /.content -->
<div class="clearfix"></div>
</div>
