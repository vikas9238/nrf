<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Transaction Details</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hovered table-striped">
				<colgroup>
					<col width="10%">
					<col width="20%">
					<col width="15%">
					<col width="20%">
					<col width="25%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled">
						<th>#</th>
						<th>Date Created</th>
						<th>Payment Mode</th>
						<th>Cheque/Referance Number</th>
						<th>Description</th>
                        <th>Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `transaction` where client_id='{$_GET['client_id']}' and quotation_id='{$_GET['quotation_id']}' order by `date_created` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php if($row['payment_mode'] == 1): ?>
                                    <span class="badge badge-success rounded-pill">Online</span>
                                <?php else: ?>
                                    <span class="badge badge-warning rounded-pill">Cash</span>
                                <?php endif; ?></td>
							<td ><p class="truncate-1 m-0"><?php echo $row['reference_number'] ?></p></td>
							<td ><p class="truncate-1 m-0"><?php echo $row['description'] ?></p></td>
							<td class="text-center"><?php echo $row['amount'] ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>