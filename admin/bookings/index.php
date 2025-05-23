<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<?php if ($_settings->chk_flashdata('error')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('error') ?>", 'error')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Bookings</h3>
		<div class="card-tools">
			<!-- <a href="?page=order/manage_order" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a> -->
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<colgroup>
						<col width="5%">
						<col width="10%">
						<col width="15%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr class="bg-navy text-white">
							<th>#</th>
							<th>Order ID</th>
							<th>Date Booked</th>
							<th>Order Details</th>
							<th>Client</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client,c.email,c.contact,co.name,pr.category,q.address from `booking_list` r inner join clients c on c.id = r.client_id inner join quotation_list q on q.id=r.quotation_id inner join company_list co on co.id=q.company_id inner join product pr on pr.id=q.product_id order by unix_timestamp(r.date_created) desc ");
						while ($row = $qry->fetch_assoc()) :
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class="text-center">#<?php echo $row['id'] ?></td>
								<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
								<td>
									<small><span class="text-muted">Company:</span><?php echo $row['name'] ?></small><br>
									<small><span class="text-muted">Address:</span><?php echo $row['address'] ?></small><br>
									<small><span class="text-muted">Product: </span><?php echo $row['category'] ?></small><br>
									<?php if ($row['transaction_status'] == 1) : ?>
										<small><span class="text-muted">Payment Verification:</span> <span class="badge badge-success">Pass</span></small><br>
									<?php elseif ($row['transaction_status'] == 2) : ?>
										<small><span class="text-muted">Payment Verification:</span> <span class="badge badge-danger">Fail</span></small><br>
									<?php elseif ($row['transaction_status'] == 3) : ?>
										<small><span class="text-muted">Payment Verification:</span> <span class="badge badge-warning">Hold</span></small><br>
									<?php else : ?>
										<small><span class="text-muted">Payment Verification:</span> <span class="badge badge-info">Pending</span></small><br>
									<?php endif; ?>
									<?php if ($row['status'] == 4 or $row['status'] == 2) : ?>
										<small><span class="text-muted">Refund:</span> <?php
																						switch ($row['refund_status']) {
																							case '0':
																								echo '<span class="badge badge-warning text-dark">Not Paid</span>';
																								break;
																							case '1':
																								echo '<span class="badge badge-success">Paid</span>';
																								break;
																						}
																						?></small>
									<?php endif; ?>
								</td>
								<td>
									<small><span class="text-muted">Name: </span><?php echo $row['client'] ?></small><br>
									<small><span class="text-muted">Email: </span><?php echo $row['email'] ?></small><br>
									<small><span class="text-muted">Contact: </span><?php echo $row['contact'] ?></small>
								</td>
								<td class="text-center">
									<?php if ($row['status'] == 0) : ?>
										<span class="badge badge-light">Pending</span>
									<?php elseif ($row['status'] == 1) : ?>
										<span class="badge badge-primary">Confirmed</span>
									<?php elseif ($row['status'] == 2) : ?>
										<span class="badge badge-danger">Cancelled</span>
									<?php elseif ($row['status'] == 3) : ?>
										<span class="badge badge-success">Active</span>
									<?php elseif ($row['status'] == 4) : ?>
										<span class="badge badge-info">Partial Confirm</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Action
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View Details</a>
										<!-- <div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a> -->
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this booking permanently?", "delete_booking", [$(this).attr('data-id')])
		})
		$('.view_data').click(function() {
			uni_modal('Booking Details', 'bookings/view_booking.php?id=' + $(this).attr('data-id'), 'mid-large')
		})
		$('.table').dataTable();
	})

	function delete_booking($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_booking",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>