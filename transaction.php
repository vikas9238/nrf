<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `booking_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
$all_profit = ($po_rate - $daily_rate) * $approved_quantity;
$profit = $all_profit / 2;
$total_investment = $daily_rate * $approved_quantity;
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class=" col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="far fa-money-bill-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Pending</span>
                                    <span class="info-box-number">
                                        <?php $pending = $profit + $total_investment - $paid_amount;
                                        echo $pending ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class=" col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1">
                                    <i class="far fa-money-bill-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Receive Amount</span>
                                    <?php echo $paid_amount ?>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <!-- /.col -->
                        <div class=" col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="far fa-money-bill-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Profit</span>
                                    <?php echo $profit ?>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class=" col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="far fa-money-bill-alt"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Investment</span>
                                    <?php echo $total_investment ?>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Transaction Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="table-responsive">
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
                                        $qry = $conn->query("SELECT * from `transaction` where client_id='{$_settings->userdata('id')}' and quotation_id='{$_GET['id']}' order by `date_created` asc ");
                                        while ($row = $qry->fetch_assoc()) :
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                                <td><?php if ($row['payment_mode'] == 1) : ?>
                                                        <span class="badge badge-success rounded-pill">Online</span>
                                                    <?php else : ?>
                                                        <span class="badge badge-warning rounded-pill">Cash</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <p class="truncate-1 m-0"><?php echo $row['reference_number'] ?></p>
                                                </td>
                                                <td>
                                                    <p class="truncate-1 m-0"><?php echo $row['description'] ?></p>
                                                </td>
                                                <td class="text-center"><?php echo $row['amount'] ?></td>
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
</section>