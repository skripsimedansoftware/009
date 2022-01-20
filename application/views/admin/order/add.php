<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Pesanan</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<form action="<?= base_url($this->router->fetch_class().'/product_add') ?>" method="post" enctype="multipart/form-data">
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
						<th>Foto</th>
						<th>Opsi</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="box-footer">
				<a class="btn btn-default" href="<?= base_url($this->router->fetch_class().'/product') ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
				<button class="btn btn-success" type="submit">Buat pesanan <i class="fa fa-save"></i></button>
			</div>
		</div>
	</form>
</section>
