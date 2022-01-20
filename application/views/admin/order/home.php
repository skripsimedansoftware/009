<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Pesanan</small></h1>
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
			<h3 class="box-title">Daftar Pesanan</h3>
		</div>
		<div class="box-body">
			<table class="table table-hover table-striped">
				<thead>
					<th>No</th>
					<th>Invoice</th>
					<th>Total</th>
					<th>Tanggal</th>
					<th>Jam</th>
					<th>Opsi</th>
				</thead>
				<tbody>
					<?php foreach ($orders->result_array() as $key => $order): ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td>#<?= $order['uid'] ?></td>
						<td>Rp.<?= number_format($order['total'], 0, ',', '.') ?></td>
						<td><?= nice_date($order['date'], 'd-m-Y') ?></td>
						<td><?= nice_date($order['date'], 'H:i') ?></td>
						<td>
							<a href="<?= base_url($this->router->fetch_class().'/order_edit/'.$order['id']) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
							<a onclick="confirm('Press a button!');" href="<?= base_url($this->router->fetch_class().'/order_delete/'.$order['id']) ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="box-footer">
			<a class="btn btn-primary" href="<?= base_url($this->router->fetch_class().'/order_add') ?>"><i class="fa fa-plus"></i> Tambah Pesanan</a>
		</div>
	</div>
</section>
