<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Pesanan</small></h1>
</section>

<style type="text/css">
img.product-image {
	height: 120px;
}
</style>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Detail Pesanan #<?= $order['uid'] ?> | <small><?= nice_date($order['date'], 'd-m-Y').' '.nice_date($order['time'], 'H:i A') ?></small></h3>
		</div>
		<div class="box-body">
			<table class="table table-hover">
				<thead>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Produk</th>
					<th>Jumlah</th>
					<th>Subtotal</th>
				</thead>
				<tbody>

					<?php foreach ($detail as $key => $product) : ?>
						<tr>
							<td><?= $key+1 ?></td>
							<td><?= $product['name'] ?></td>
							<td>Rp.<?= number_format($product['price'], 0, ',', '.') ?></td>
							<td><?= $product['quantity'] ?></td>
							<td>Rp.<?= number_format($product['subtotal'], 0, ',', '.') ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="3"></td>
						<td><?= array_sum(array_column($detail, 'quantity')) ?></td>
						<td>Rp.<?= number_format($order['total'], 0, ',', '.') ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<a class="btn btn-default" href="<?= base_url($this->router->fetch_class().'/order') ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
</section>
