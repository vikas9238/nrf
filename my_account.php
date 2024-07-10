    <style>
        .badge-light {
            color: black
        }
    </style>
    <section class="py-2">
        <div class="container">
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fas fa-solid fa-indian-rupee-sign"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Investment</span>
                                    <?php echo $investment = $conn->query("SELECT approved_quantity,daily_rate,SUM(approved_quantity * daily_rate) OVER () AS total_amount from `booking_list` where client_id = '{$_settings->userdata('id')}' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
                                    ?>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="fas fa-solid fa-indian-rupee-sign"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Profit</span>
                                    <?php $profit = $conn->query("SELECT approved_quantity,po_rate,daily_rate ,SUM((po_rate-daily_rate)*approved_quantity) OVER () AS total_amount from `booking_list` where client_id = '{$_settings->userdata('id')}' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
                                    ?>
                                    <?php echo $profit / 2 ?>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1">
                                    <i class="fas fa-solid fa-indian-rupee-sign"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Receive Amount</span>
                                    <?php echo $paid_amount = $conn->query("SELECT sum(paid_amount) as paid from `booking_list` where client_id = '{$_settings->userdata('id')}' and (status = 1 or status=4) ")->fetch_assoc()['paid'];
                                    ?>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <!-- <div class="clearfix hidden-md-up"></div> -->


                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fas fa-solid fa-indian-rupee-sign"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Dues</span>
                                    <span class="info-box-number">
                                        <?php echo $due = ($profit / 2) + $investment - $paid_amount;
                                        //echo $pending 
                                        ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                    <div class="w-100 justify-content-between d-flex">
                        <h4><b>My Bookings</b></h4>
                        <a href="./?p=edit_account" class="btn btn btn-dark btn-flat">
                            <div class="fa fa-user-cog"></div> Manage Account
                        </a>
                    </div>
                    <hr class="border-warning">
                    <div class="table-responsive">
                        <table class="table table-stripped text-dark">
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
                                    <th>Booking Details</th>
                                    <th>Company Details</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $qry = $conn->query("SELECT r.*,q.address,q.description,c.name,p.category from `booking_list` r inner join quotation_list q on q.id = r.quotation_id inner join company_list c on q.company_id=c.id inner join product p on p.id=q.product_id where client_id = '{$_settings->userdata('id')}' order by unix_timestamp(r.date_created) desc ");
                                while ($row = $qry->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++; ?></td>
                                        <td class="text-center">#<?php echo $row['id']; ?></td>
                                        <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                        <td>
                                            <small><span class="text-muted">PO Rate: </span><?php echo number_format($row['po_rate']) ?></small><br>
                                            <small><span class="text-muted">Daily Rate: </span><?php echo number_format($row['daily_rate']) ?></small><br>
                                            <small><span class="text-muted">Quantity: </span><?php echo number_format($row['quantity']) ?></small><br>
                                            <small><span class="text-muted">Approved Quantity: </span><?php echo number_format($row['approved_quantity']) ?></small>
                                        </td>
                                        <td>
                                            <small><span class="text-muted">Product: </span><?php echo $row['category'] ?></small><br>
                                            <small><span class="text-muted">Company: </span><?php echo $row['name'] ?></small><br>
                                            <small><span class="text-muted">Address: </span><?php echo $row['address'] ?></small><br>
                                            <small><span class="text-muted">Description: </span><?php echo strip_tags(stripslashes(html_entity_decode($row['description']))) ?></small>
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
                                                <?php if ($row['status'] == 1) : ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="?p=transaction&id=<?php echo $row['id'] ?>"><span class="fa fa-indian-rupee-sign text-dark"></span> View Transaction</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item download" href="pdf/invoice.php?id=<?php echo $row['id'] ?>" target="_blank"><span class="fa fa-download text-dark"></span> Download Invoice</a>
                                                <?php endif; ?>
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
    </section>
    <script>
        $(function() {
            $('.view_data').click(function() {
                uni_modal("Order Details", "./admin/bookings/view_booking.php?view=user&id=" + $(this).attr('data-id'), 'large')
            })
            $('table').dataTable();

        })
    </script>