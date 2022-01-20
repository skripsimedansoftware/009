<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Produk</small></h1>
</section>

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
			<h3 class="box-title">Daftar Produk</h3>
		</div>
		<div class="box-body">
			<table class="table table-hover table-striped">
				<thead>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Harga Produk</th>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php foreach ($products->result_array() as $key => $product): ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= $product['name'] ?></td>
						<td>Rp.<?= number_format($product['price'], 0, ',', '.') ?></td>
						<td>
							<a href="<?= base_url($this->router->fetch_class().'/product_edit/'.$product['id']) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
							<a data_id="<?= $product['id'] ?>" class="btn btn-xs btn-danger btn-delete-product"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<a class="btn btn-primary" href="<?= base_url($this->router->fetch_class().'/product_add') ?>"><i class="fa fa-plus"></i> Tambah Produk</a>
		</div>
	</div>
</section>

<script type="text/javascript">
$(document).on('click', '.btn-delete-product', function(e) {
	e.preventDefault();
	var data_id = $(this).attr('data_id');
})
</script>
