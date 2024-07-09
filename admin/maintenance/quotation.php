<?php
require_once('../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    // $qry = $conn->query("SELECT q.*,c.firstname,c.lastname,c.email,c.contact,c.address,c.gender,co.name,p.category from `quotation_list` q inner join clients c on c.id = q.client_id inner join company_list co on co.id=q.company_id inner join product p on p.id=q.product_id where q.id = '{$_GET['id']}' ");
    $qry = $conn->query("SELECT b.*,c.firstname,c.lastname,c.email,c.contact,c.address,c.gender,co.name,p.category,q.address as location from `booking_list` b inner join quotation_list q on q.id=b.quotation_id inner join clients c on c.id = b.client_id inner join company_list co on co.id=q.company_id inner join product p on p.id=q.product_id where b.id = '{$_GET['id']}' ");
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
<style>
    .float-payment-button {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .payment-button {
        margin-top: 16px;
    }
</style>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
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
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1">
                <i class="far fa-money-bill-alt"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Paid Amount</span>
                <?php echo $paid_amount ?>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
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
    <div class="col-12 col-sm-6 col-md-3">
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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>

                    <div class="card-tools">

                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url ?>admin/?page=maintenance/transaction&client_id=<?php echo $client_id ?>&quotation_id=<?php echo $id ?>">
                                <i class="far fa-chart-bar"></i> Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <?php if ($pending = 0) : ?>
                                <a class="nav-link close_account" href="javascript:void(0)" data-id="<?php echo $_GET['id'] ?>">
                                    <i class="fas fa-ban"></i> Close Account
                                </a>
                            <?php endif ?>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    First Name
                                </th>
                                <td>
                                    <?php echo $firstname ?>
                                </td>
                                <th>
                                    Last Name
                                </th>
                                <td>
                                    <?php echo $lastname ?>
                                </td>
                            </tr>
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
                                    Gender
                                </th>
                                <td>
                                    <?php echo $gender ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Company Name
                                </th>
                                <td>
                                    <?php echo $name ?>
                                </td>
                                <th>
                                    Product
                                </th>
                                <td>
                                    <?php echo $category ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Company Location
                                </th>
                                <td>
                                    <?php echo $location ?>
                                </td>
                                <th>
                                    PO Rate
                                </th>
                                <td>
                                    <?php echo $po_rate ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Daily Rate
                                </th>
                                <td>
                                    <?php echo $daily_rate ?>
                                </td>
                                <th>
                                    Approved Quantity
                                </th>
                                <td>
                                    <?php echo $approved_quantity ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    <?php if ($booking_status == 0) : ?>
                                        <span class="badge badge-danger">Inactive</span>
                                    <?php else : ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php endif; ?>
                                <th>
                                    Date Created
                                </th>
                                <td>
                                    <?php echo $date_created ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="justify-content-end">
                    <?php if ($pending > 0) : ?>
                        <a class="float-payment-button" id="payment-button" href="javascript:void(0)" data-id="<?php echo $_GET['id'] ?>">
                            <i class="fas fa-file-invoice payment-button"></i>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.close_account').click(function() {
        _conf("Are you sure to close this account permanently?", "close_account", [$(this).attr('data-id')])

    })
    $('#payment-button').click(function() {
        uni_modal("<i class='fa-regular fa-money-bill-1'></i> Payment", 'maintenance/manage_transaction.php?id=' + $(this).attr('data-id') + '&client_id=' + <?php echo $client_id ?>)
    })

    function close_account($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=close_account",
            method: "POST",
            data: {
                id: $id,
                status: 3
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
    // $('#payment-button').on('click', function () {
    //         var url = $(this).data("payment-url");
    //         $.ajax({
    //             url: url,
    //             beforeSend: function () {
    //                 $('#payment-modal-container').html('');
    //                 $.LoadingOverlay("show");
    //             },
    //             success: function (response) {
    //                 var arrayResponse = jQuery.parseJSON(response);
    //                 if (arrayResponse.status) {
    //                     $('#payment-modal-container').html(arrayResponse.body);
    //                     $.LoadingOverlay("hide");
    //                     $('#modal-payment').modal('toggle');
    //                 } else {
    //                     $.LoadingOverlay("hide");
    //                     alert(arrayResponse.message);
    //                 }
    //             },
    //             error: function (reject) {
    //                 if (reject.status == 403) {
    //                     alert('Oops! Unauthorized Access');
    //                 }
    //                 if(reject.status == 422){

    //                 }
    //                 $.LoadingOverlay("hide");
    //             }
    //         });
    // });
</script>
