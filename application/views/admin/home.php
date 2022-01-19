<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Home</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<!-- Small boxes (Stat box) -->
	<div class="row">
		<div class="col-lg-6 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>150</h3>
					<p>Data Produk</p>
				</div>
				<div class="icon">
					<i class="ion ion-bag"></i>
				</div>
				<a href="<?= base_url($this->router->fetch_class().'/product') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-6 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3>53<sup style="font-size: 20px">%</sup></h3>
					<p>Data Pembelian</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?= base_url($this->router->fetch_class().'/order') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
	</div>
</section>
