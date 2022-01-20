<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Produk</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<form action="<?= base_url($this->router->fetch_class().'/product_add') ?>" method="post" enctype="multipart/form-data">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Tambah Produk</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label>Nama Produk</label>
					<input class="form-control" type="text" name="name" placeholder="Nama Produk" value="<?= set_value('name') ?>">
					<?= form_error('name', '<span class="help-block error">', '</span>'); ?>
				</div>
				<div class="form-group">
					<label>Harga Produk</label>
					<input class="form-control" type="text" name="price" placeholder="Harga Produk" value="<?= set_value('price') ?>">
					<?= form_error('price', '<span class="help-block error">', '</span>'); ?>
				</div>
				<div class="form-group">
					<label>Foto Produk</label>
					<input class="form-control" type="file" name="image">
					<?= (isset($upload_error))?$upload_error:'' ?>
				</div>
			</div>
			<div class="box-footer">
				<a class="btn btn-default" href="<?= base_url($this->router->fetch_class().'/product') ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
				<button class="btn btn-success" type="submit">Simpan <i class="fa fa-save"></i></button>
			</div>
		</div>
	</form>
</section>
