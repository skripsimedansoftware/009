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
	<?php if ($this->session->has_userdata('message')): ?>
		<div class="alert alert-info alert-dismissible" role="alert">
			 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?= $this->session->flashdata('message'); ?>
		</div>
	<?php endif; ?>
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Tambah Pesanan</h3>
		</div>
		<div class="box-body">
			<table class="table table-hover">
				<thead>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Produk</th>
					<th>Jumlah</th>
					<th>Subtotal</th>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php
					$i = 1;
					foreach ($this->cart->contents() as $key => $cart): ?>
						<form action="<?= base_url($this->router->fetch_class().'/cart_add') ?>" method="post">
						<tr>
							<td><?= $i ?></td>
							<td><?= $cart['name'] ?></td>
							<td><?= $cart['price'] ?></td>
							<td><input class="form-control input-sm" type="text" name="quantity" value="<?= $cart['qty'] ?>"></td>
							<td>Rp.<?= number_format($cart['subtotal'], 0, ',', '.') ?></td>
							<td>
								<button type="submit" class="btn btn-xs btn-danger" name="remove" value="<?= $cart['rowid'] ?>"><i class="fa fa-trash"></i></button>
								<button type="submit" class="btn btn-xs btn-success" name="update" value="<?= $cart['rowid'] ?>"><i class="fa fa-save"></i></button>
							</td>
						</tr>
						</form>
					<?php
					$i++;
					endforeach;
					?>
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<a class="btn btn-danger" href="<?= base_url($this->router->fetch_class().'/order_cancel') ?>"><i class="fa fa-times"></i> Batalkan Pesanan</a>
			<a class="btn btn-success" href="<?= base_url($this->router->fetch_class().'/order_next') ?>"><i class="fa fa-arrow-right"></i> Buat Pesanan</a>
		</div>
	</div>
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Pilih Produk</h3>
		</div>
		<div class="box-body">
			<table class="table table-hover">
				<thead>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Produk</th>
					<th>Foto</th>
					<th>Opsi</th>
				</thead>
				<tbody>
				<?php foreach ($products->result_array() as $key => $product): ?>
					<form action="<?= base_url($this->router->fetch_class().'/cart_add') ?>" method="post">
					<input type="hidden" name="id" value="<?= $product['id'] ?>">
					<input type="hidden" name="name" value="<?= $product['name'] ?>">
					<input type="hidden" name="price" value="<?= $product['price'] ?>">
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $product['name'] ?></td>
						<td>Rp.<?= number_format($product['price'], 0, ',', '.') ?></td>
						<td><img src="<?= (!empty($product['image']))?$product['image']:base_url('assets/image/no-image.png') ?>" class="img-responsive product-image"></td>
						<td>
							<input class="form-control input-sm" type="text" name="quantity" placeholder="Jumlah" value="1">
							<br>
							<button type="submit" class="btn btn-success"><i class="fa fa-cart-plus"></i> Masukkan Keranjang</button>
						</td>
					</tr>
					</form>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
