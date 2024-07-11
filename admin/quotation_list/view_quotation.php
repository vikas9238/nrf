<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fa fa-indian-rupee-sign"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Investment</span>
                    <span class="info-box-number">
                        <?php $investment = $conn->query("SELECT SUM(approved_quantity * daily_rate) AS total_amount from `booking_list` where quotation_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
                        if ($investment == null) {
                            echo $investment = 0;
                        } else {
                            echo $investment;
                        }
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fa fa-money-bill-trend-up"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Profit</span>
                    <span class="info-box-number">
                        <?php $profit = $conn->query("SELECT SUM((po_rate-daily_rate)*approved_quantity) AS total_amount from `booking_list` where quotation_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
                        ?>
                        <?php echo $profit / 2 ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fa fa-money-bill-transfer"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Paid Amount</span>
                    <span class="info-box-number">
                        <?php $paid_amount = $conn->query("SELECT sum(paid_amount) as paid from `booking_list` where quotation_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['paid'];
                        if ($paid_amount == null) {
                            echo $paid_amount = 0;
                        } else {
                            echo $paid_amount;
                        }
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>


        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="far fa-money-bill-alt"></i>
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
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-secondary elevation-1">
                    <i class="fa fa-users"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Invester</span>
                    <span class="info-box-number">
                        <?php echo $paid_amount = $conn->query("SELECT count(id) as client from `booking_list` where quotation_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['client'];
                        //echo $pending 
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1">
                    <i class="fa-solid fa-cart-shopping"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Quantity</span>
                    <span class="info-box-number">
                        <?php $paid_amount = $conn->query("SELECT sum(approved_quantity) as quantity from `booking_list` where quotation_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['quantity'];
                        if ($paid_amount == null) {
                            echo $paid_amount = 0;
                        } else {
                            echo $paid_amount;
                        }
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

    </div>
    <div class="card-header">
        <h3 class="card-title">List of Clients</h3>
        <!-- <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary bg-navy border-0"><span class="fas fa-plus"></span> Create New</a>
        </div> -->
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="8%">
                        <col width="8%">
                        <col width="12%">
                        <col width="15%">
                        <col width="20%">
                        <col width="20%">
                        <col width="6%">
                        <col width="6%">
                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th>#</th>
                            <th>Client ID</th>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Order Confirm Date</th>
                            <th>Order Details</th>
                            <th>Client Details</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT b.*,p.category, c.name,q.address,cl.email,cl.contact,concat(cl.firstname,' ',cl.lastname) as client from `booking_list` b inner join clients cl on b.client_id=cl.id inner join quotation_list q on q.id=b.quotation_id inner join product p on q.product_id = p.id inner join company_list c on q.company_id = c.id where b.quotation_id='{$_GET['id']}' and (b.status=1 or b.status=4) order by unix_timestamp(b.confirm_order) desc");
                        while ($row = $qry->fetch_assoc()) :
                            foreach ($row as $k => $v) {
                                $row[$k] = trim(stripslashes($v));
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++ ?></td>
                                <td class="text-center"><?php echo $row['client_id'] ?></td>
                                <td class="text-center">#<?php echo $row['id'] ?></td>
                                <td><?php echo date("Y-m-d H:i", strtotime($row['confirm_order'])) ?></td>
                                <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                <td class="lh-1">
                                    <small><span class="text-muted">Company:</span><?php echo $row['name'] ?></small><br>
                                    <small><span class="text-muted">Address:</span><?php echo $row['address'] ?></small><br>
                                    <small><span class="text-muted">Product: </span><?php echo $row['category'] ?></small><br>
                                    <?php if ($row['status'] == 4) : ?>
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
                                <td class="lh-1">
                                    <small><span class="text-muted">Name: </span><?php echo $row['client'] ?></small><br>
                                    <small><span class="text-muted">Email: </span><?php echo $row['email'] ?></small><br>
                                    <small><span class="text-muted">Contact: </span><?php echo $row['contact'] ?></small>
                                </td>
                                <td class="text-end"><?php echo number_format($row['approved_quantity']) ?></td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View Details</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="?page=maintenance/quotation&id=<?php echo $row['id'] ?>"><span class="fa fa-indian-rupee-sign text-dark"></span> Pay</a>
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
        $('.view_data').click(function() {
            uni_modal('Booking Details', 'bookings/view_booking.php?id=' + $(this).attr('data-id'), 'mid-large')
        })
        $('.table').dataTable();
    })
</script>