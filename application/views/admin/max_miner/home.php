<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Administrator<small>Max Miner</small></h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Max Miner</h3>
		</div>
		<div class="box-body">
			<table class="table table-hover table-striped">
				<thead>
					<th>No</th>
					<th>Rule</th>
					<th>Support</th>
					<th>Confidence</th>
				</thead>
				<tbody>
					<?php foreach ($associator->getRules() as $key => $data): ?>
					<tr>
						<td><?= $key+1 ?></td>
						<td><?= 'Jika membeli <b>'.implode(' dan ', $data['antecedent']).'</b> maka membeli '.implode(' dan ', $data['consequent']) ?></td>
						<td><?= $data['support'] ?></td>
						<td><?= $data['confidence'] ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
