<?php
require_once('../../config.php');
?>
<?php
if (!isset($_GET['id'])) {
    $_settings->set_flashdata('error', 'No Booking ID Provided.');
    redirect('admin/?page=bookings');
}
$booking = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client,c.address,c.email,c.contact,c.account from `booking_list` r inner join clients c on c.id = r.client_id where r.id = '{$_GET['id']}' ");
if ($booking->num_rows > 0) {
    foreach ($booking->fetch_assoc() as $k => $v) {
        $$k = $v;
    }
} else {
    $_settings->set_flashdata('error', 'Booking ID provided is Unknown');
    redirect('admin/?page=bookings');
}
if (isset($quotation_id)) {
    $qur = $conn->query("SELECT b.*,c.category, bb.name from `quotation_list` b inner join product c on b.product_id = c.id inner join company_list bb on b.company_id = bb.id where b.id = '{$quotation_id}' ");
    if ($qur->num_rows > 0) {
        foreach ($qur->fetch_assoc() as $k => $v) {
            $quotation_meta[$k] = stripslashes($v);
        }
    }
}
?>
<div class="conitaner-fluid px-3 py-2">
    <div class="row">
        <div class="col-md-6">
            <p><b>Client Name:</b> <?php echo $client ?></p>
            <p><b>Client Email:</b> <?php echo $email ?></p>
            <p><b>Client Contact:</b> <?php echo $contact ?></p>
            <p><b>Client Address:</b> <?php echo $address ?></p>
            <p><b>Transaction ID:</b> <?php echo $transaction ?></p>
            <img src="<?php echo base_url . 'uploads/screenshot/' . $transaction . '.png' ?>" alt="screenshot" height="250" width="300"><br>
            <?php if (!isset($_GET['view'])) : ?>
                <?php if ($transaction_status == 0 or $transaction_status == 3) : ?>
                    <a id='verify' class='btn btn-sm btn-flat btn-primary'>Verify</a>
                    <a id='cancel' class='btn btn-sm btn-flat btn-danger'>Cancel</a>
                    <?php if ($transaction_status != 3) : ?>
                        <a id='hold' class='btn btn-sm btn-flat btn-warning'>Hold</a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($transaction_status == 1) : ?>
                <p><b>Payment Verification:</b> <span class="badge badge-success">Pass</span></p>
            <?php elseif ($transaction_status == 2) : ?>
                <p><b>Payment Verification:</b> <span class="badge badge-danger">Fail</span></p>
            <?php elseif ($transaction_status == 3) : ?>
                <p><b>Payment Verification:</b> <span class="badge badge-warning">Hold</span></p>
            <?php else : ?>
                <p><b>Payment Verification:</b> <span class="badge badge-info">Pending</span></p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <p><b>Product:</b> <?php echo $quotation_meta['category'] ?></p>
            <p><b>Company:</b> <?php echo $quotation_meta['name'] ?></p>
            <p><b>PO Rate:</b> <?php echo $quotation_meta['po_rate'] ?></p>
            <p><b>Daily Rate:</b> <?php echo number_format($daily_rate) ?></p>
            <p><b>Order Quantity:</b> <?php echo $quantity ?> <?php if ($quotation_meta['po_unit'] == 1) : ?> TON<?php else : ?> CFT<?php endif; ?></p>
            <p><b>Investe Amount:</b> <?php echo $daily_rate * $quantity ?></p>
            <p><b>Payment Mode:</b> <?php echo $mode ?></p>
            <p><b>Client Profit:</b> <?php echo ($po_rate - $daily_rate) * $quantity / 2 ?></p>
            <hr>
            <p><b>Approved Quantity:</b> <?php echo $approved_quantity ?> <?php if ($quotation_meta['po_unit'] == 1) : ?> TON<?php else : ?> CFT<?php endif; ?></p>
            <p><b>Investe Amount:</b> <?php echo $daily_rate * $approved_quantity ?></p>
            <p><b>Client Profit:</b> <?php echo ($po_rate - $daily_rate) * $approved_quantity / 2 ?></p>
            <?php if ($status == 4 or $status == 2) : ?>
                <?php if ($transaction_status != 2) : ?>
                    <p class="bg-primary"><b>Refund Remaining Amount:</b> <?php echo ($daily_rate * $quantity) - ($daily_rate * $approved_quantity) ?></p><br>
                    <?php if ($status == 2) : ?>
                        <p><b>Reason For Cancellation:</b> <?php echo $reason ?></p>
                    <?php endif; ?>
                    <p><b>Refund Paid:</b> <?php
                                            switch ($refund_status) {
                                                case '0':
                                                    echo '<span class="badge badge-warning text-dark">Not</span>';
                                                    break;
                                                case '1':
                                                    echo '<span class="badge badge-success">Yes</span>';
                                                    break;
                                            }
                                            ?></p>
                    <?php if ($refund_status == 1) : ?>
                        <p><b>Transaction ID:</b> <?php echo $paid_txt_id ?></p>
                        <p><b>Transaction Date:</b> <?php echo $paid_date ?></p>
                    <?php endif; ?>
                    <?php if (!isset($_GET['view'])) : ?>
                        <?php if ($refund_status == 0) : ?>
                            <a id='paid' class='btn btn-sm btn-flat btn-primary'>Paid</a><br>
                            <div class="form-group paid_txt_id">
                                <label for="paid_txt_id" class="control-label">Transaction Id</label>
                                <input id="paid_txt_id" name='paid_txt_id' class="form-control form no-resize" required>
                                <label for="date">Paid Date</label>
                                <input type="date" name="paid_date" id="" class="form-control form no-resize" required>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-3">Booking Status:</div>
        <div class="col-auto">
            <?php
            switch ($status) {
                case '0':
                    echo '<span class="badge badge-light text-dark">Pending</span>';
                    break;
                case '1':
                    echo '<span class="badge badge-primary">Confirmed</span>';
                    break;
                case '2':
                    echo '<span class="badge badge-danger">Cancelled</span>';
                    break;
                case '3':
                    echo '<span class="badge badge-success">Active</span>';
                    break;
                case '4':
                    echo '<span class="badge badge-info">Partial Confirm</span>';
                    break;
            }
            ?>
        </div>

    </div>
</div>
<div class="modal-footer">
    <?php if (!isset($_GET['view'])) : ?>
        <?php if ($status == 0 || $status == 3) : ?>
            <?php if ($transaction_status == 1) : ?>
                <button type="button" id="update" class="btn btn-sm btn-flat btn-primary">Edit</button>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <button type="button" class="btn btn-secondary btn-sm btn-flat" data-dismiss="modal" onclick="$('.nav-bar').removeClass('d-none')">Close</button>
</div>
<style>
    #uni_modal>.modal-dialog>.modal-content>.modal-footer {
        display: none;
    }

    #uni_modal .modal-body {
        padding: 0;
    }

    .paid_txt_id {
        display: none;
    }
</style>
<script>
    $(function() {
        $('#update').click(function() {
            uni_modal("Edit Booking Details", "./bookings/manage_booking.php?id=<?php echo $id ?>")
        })
        $('#verify').click(function() {
            var id = '<?php echo $id ?>';
            var amount = '<?php echo $daily_rate * $quantity ?>';
            var name = '<?php echo $client ?>';
            var email = '<?php echo $email ?>';
            start_loader()
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=verify_payment',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("An error occured.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        var check = confirm("Do you want to send mail to the client?");
                        if (check == true) {
                            $.ajax({
                                url: _base_url_ + "mail/payment.php",
                                method: 'POST',
                                data: {
                                    name: name,
                                    email: email,
                                    amount: amount
                                },
                                dataType: 'json',
                            });
                            alert_toast("Mail Send Successfully", 'success');
                        }
                        location.reload();
                    } else {
                        alert_toast("An error occured.", 'error');
                        end_loader();
                    }
                }
            })
        })
        $('#cancel').click(function() {
            var id = '<?php echo $id ?>';
            var name = '<?php echo $client ?>';
            var email = '<?php echo $email ?>';
            start_loader()
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=payment_cancel',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("An error occured.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        var check = confirm("Do you want to send mail to the client?");
                        if (check == true) {
                            $.ajax({
                                url: _base_url_ + "mail/payment_cancel.php",
                                method: 'POST',
                                data: {
                                    name: name,
                                    email: email
                                },
                                dataType: 'json',
                            });
                            alert_toast("Mail Send Successfully", 'success');
                        }
                        location.reload();
                    } else {
                        alert_toast("An error occured.", 'error');
                        end_loader();
                    }
                }
            })
        })
        $('#hold').click(function() {
            var id = '<?php echo $id ?>';
            var name = '<?php echo $client ?>';
            var email = '<?php echo $email ?>';
            start_loader()
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=payment_hold',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("An error occured.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        var check = confirm("Do you want to send mail to the client?");
                        if (check == true) {
                            $.ajax({
                                url: _base_url_ + "mail/payment_hold.php",
                                method: 'POST',
                                data: {
                                    name: name,
                                    email: email
                                },
                                dataType: 'json',
                            });
                            alert_toast("Mail Send Successfully", 'success');
                        }
                        location.reload();
                    } else {
                        alert_toast("An error occured.", 'error');
                        end_loader();
                    }
                }
            })
        })
        $('#paid').click(function() {
            var id = '<?php echo $id ?>';
            var name = '<?php echo $client ?>';
            var email = '<?php echo $email ?>';
            var amount = '<?php echo ($daily_rate * $quantity) - ($daily_rate * $approved_quantity) ?>';
            var product = '<?php echo $quotation_meta['category'] ?>';
            var company = '<?php echo $quotation_meta['name'] ?>';
            var account = '<?php echo $account ?>';
            $(".paid_txt_id").show();
            var paid_txt_id = $('#paid_txt_id').val();
            var paid_date = $('[name="paid_date"]').val();
            if (paid_txt_id == '') {
                alert_toast("Transaction Id is required", 'warning');
                return false;
            }
            if (paid_date == '') {
                alert_toast("Paid Date is required", 'warning');
                return false;
            }
            start_loader()
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=payment_paid',
                method: 'POST',
                data: {
                    id: id,
                    paid_txt_id: paid_txt_id,
                    paid_date: paid_date
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("An error occured.", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        var check = confirm("Do you want to send mail to the client?");
                        if (check == true) {
                            $.ajax({
                                url: _base_url_ + "mail/refund_paid.php",
                                method: 'POST',
                                data: {
                                    name: name,
                                    email: email,
                                    amount: amount,
                                    paid_txt_id: paid_txt_id,
                                    paid_date: paid_date,
                                    product: product,
                                    company: company,
                                    account: account
                                },
                                dataType: 'json',
                            });
                            alert_toast("Mail Send Successfully", 'success');
                        }
                        location.reload();
                    } else {
                        alert_toast("An error occured.", 'error');
                        end_loader();
                    }
                }
            })
        })
    })
</script>