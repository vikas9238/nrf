<?php require_once('../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `clients` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>

<!-- Main content -->
<section class="content  text-dark">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url . 'uploads/clients/' . $id . '/' . 'user.png' ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?php echo $firstname, $lastname ?></h3>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo base_url . 'uploads/clients/' . $id . '/' . 'sign.png' ?>" alt="Signature">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo base_url . 'uploads/clients/' . $id . '/' . 'idfront.png' ?>" alt="Aadhar Front">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo base_url . 'uploads/clients/' . $id . '/' . 'idback.png' ?>" alt="Aadhar Back">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="row">
                    <!-- <div class="row"> -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fa fa-indian-rupee-sign"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Investment</span>
                                <span class="info-box-number">
                                    <?php $investment = $conn->query("SELECT SUM(approved_quantity * daily_rate) AS total_amount from `booking_list` where client_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
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
                                    <?php $profit = $conn->query("SELECT SUM((po_rate-daily_rate)*approved_quantity) AS total_amount from `booking_list` where client_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
                                    ?>
                                    <?php echo $profit / 100 * 90 ?>
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
                                    <?php $paid_amount = $conn->query("SELECT sum(paid_amount) as paid from `booking_list` where client_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['paid'];
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
                                    <?php echo $due = ($profit + $investment) - $paid_amount;
                                    //echo $pending 
                                    ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- </div> -->
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Contact
                                    </th>
                                    <td>
                                        <?php echo $contact ?>
                                    </td>
                                    <th>
                                        Email
                                    </th>
                                    <td>
                                        <?php echo $email ?>
                                    </td>

                                </tr>
                                <tr>
                                    <th>
                                        Address
                                    </th>
                                    <td>
                                        <?php echo $address ?>
                                    </td>
                                    <th>
                                        Pan
                                    </th>
                                    <td>
                                        <?php echo $pan ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                       Nominee Name
                                    </th>
                                    <td>
                                        <?php echo $referral ?>
                                    </td>
                                    <th>
                                        Nominee Relationship
                                    </th>
                                    <td>
                                        <?php echo $referral_relation ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Account Number
                                    </th>
                                    <td>
                                        <?php echo $account ?>
                                    </td>
                                    <th>
                                        IFSCode
                                    </th>
                                    <td>
                                        <?php echo $ifsc ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-block">
                            <div class="card-header">
                                <h3 class="card-title">Quotation Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <colgroup>
                                                <col width="8%">
                                                <col width="8%">
                                                <col width="18%">
                                                <col width="20%">
                                                <col width="25%">
                                                <col width="5%">
                                                <col width="10%">
                                            </colgroup>
                                            <thead>
                                                <tr class="bg-navy disabled">
                                                    <th>#</th>
                                                    <th>Order ID</th>
                                                    <th>Date Created</th>
                                                    <th>Category</th>
                                                    <th>Company</th>
                                                    <th>Quantity</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $qry = $conn->query("SELECT b.*,c.category, d.name,q.description from `booking_list` b inner join quotation_list q on b.quotation_id = q.id inner join product c on q.product_id = c.id inner join company_list d on q.company_id = d.id where b.client_id = '{$_GET['id']}' and (b.status='1' or b.status = '4')");
                                                //("SELECT Orders.OrderID, Customers.CustomerName, Shippers.ShipperName FROM ((Orders INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID)INNER JOIN Shippers ON Orders.ShipperID = Shippers.ShipperID);")
                                                while ($row = $qry->fetch_assoc()) :
                                                    foreach ($row as $k => $v) {
                                                        $row[$k] = trim(stripslashes($v));
                                                    }
                                                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><a href="?page=maintenance/quotation&id=<?php echo $row['id'] ?>"><?php echo $i++ ?></a></td>
                                                        <td class="text-center"><a href="?page=maintenance/quotation&id=<?php echo $row['id'] ?>">#<?php echo $row['id'] ?></a></td>
                                                        <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                                        <td><?php echo $row['category'] ?></td>
                                                        <td class="lh-1"> <?php echo $row['name'] ?></td>
                                                        <td class="text-end"><?php echo number_format($row['approved_quantity']) ?></td>
                                                        <td class="text-center">
                                                            <?php if ($row['booking_status'] == 0) : ?>
                                                                <span class="badge badge-danger">Inactive</span>
                                                            <?php else : ?>
                                                                <span class="badge badge-success">Active</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function() {
        $('.edit_data').click(function() {
            uni_modal("<i class='fa fa-edit'></i> Edit Product's Details", 'maintenance/manage_product.php?id=' + $(this).attr('data-id'))
        })
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this product permanently?", "delete_product", [$(this).attr('data-id')])
        })
        $('.table td,.table th').addClass('px-2 py-1')
        $('.table').dataTable({
            columnDefs: [{
                targets: [4, 5],
                orderable: false
            }],
            initComplete: function(settings, json) {
                $('.table td,.table th').addClass('px-2 py-1')
            }
        });
    })

    function delete_product($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_product",
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

</body>

</html>
