<?php
require_once('../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
$qry = $conn->query("SELECT q.*,c.firstname,c.lastname,c.email,c.contact,c.address,c.gender,co.name,p.category from `quotation_list` q inner join clients c on c.id = q.client_id inner join company_list co on co.id=q.company_id inner join product p on p.id=q.product_id where q.id = '{$_GET['id']}' ");
if ($qry->num_rows > 0) {
    foreach ($qry->fetch_assoc() as $k => $v) {
        $$k = $v;
    }
}
}
?>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">
                <i class="far fa-money-bill-alt"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Total Pending</span>
                <span class="info-box-number">
                    <?php $pending = $gst_amount + $total_profit + $total_investment - $paid_amount;
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

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1">
                <i class="far fa-money-bill-alt"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Gst Amount</span>
                <?php echo $gst_amount ?>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1">
                <i class="far fa-money-bill-alt"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Total Profit</span>
                <?php echo $total_profit ?>
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
                            <a class="nav-link" href="{{ route('fa.members.accounts.loan.transaction', ['memberId' => $memberId, 'id' => $loan->id]) }}">
                                <i class="far fa-chart-bar"></i> Transactions
                            </a>
                        </li>
                        <!-- @if($loanModel::STATUS_OPEN==$loan->loan_status) -->
                        <li class="nav-item">
                            <a class="nav-link close_account" href="javascript:void(0)" data-id="<?php echo $_GET['id'] ?>">
                                <i class="fas fa-ban"></i> Close Account
                            </a>
                        </li>
                        <!-- @endif -->
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
                                    Rate
                                </th>
                                <td>
                                    <?php echo $daily_rate ?>
                                </td>
                                <th>
                                    Quantity
                                </th>
                                <td>
                                    <?php echo $quantity ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Status
                                </th>
                                <td>
                                    <?php if ($status == 1) {
                                        echo "<span class='badge badge-success'>Active</span>";
                                    } else {
                                        echo "<span class='badge badge-danger'>Inactive</span>";
                                    } ?>
                                </td>
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
        </div>
    </div>
</div>
<script>
    $('.close_account').click(function() {
        _conf("Are you sure to close this account permanently?", "close_account",[$(this).attr('data-id')])

    })

    function close_account($id){
        // if($pending=='0'){
		start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=close_account",
                method:"POST",
                data:{id: $id,
                    status: 0
                },
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured.",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp== 'object' && resp.status == 'success'){
                        location.reload();
                    }else{
                        alert_toast("An error occured.",'error');
                        end_loader();
                    }
                }
            })
        // }
        // else{
        //     alert("You need to clear total pending balance");
        //     location.reload();
        // }
	}
</script>