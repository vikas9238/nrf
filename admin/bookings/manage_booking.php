<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `booking_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
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
<div class="container-fluid">
    <form action="" id="book-form">
        <p><b>Product:</b> <?php echo $quotation_meta['category'] ?></p>
        <p><b>Company:</b> <?php echo $quotation_meta['name'] ?></p>
        <!-- <p><b>Bike Model:</b> <?php //echo $quotation_meta['bike_model'] 
                                    ?></p> -->
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <input type="hidden" name="quotation_id" id="quotation_id" value="<?php echo isset($quotation_id) ? $quotation_id : ''  ?>">
        <input type="hidden" name="client_id" value="<?php echo isset($client_id) ? $client_id : ''  ?>">
        <div id="msg" class="text-danger"></div>
        <div id="check-availability-loader" class="d-none">
            <center>
                <div class="d-flex align-items-center col-md-6">
                    <strong>Checking Availability...</strong>
                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                </div>
            </center>
        </div>
        <div class="form-group">
            <label for="quantity" class="control-label">Quantity/<?php if ($quotation_meta['po_unit'] == 1) : ?> TON<?php else : ?> CFT<?php endif; ?></label>
            <input type="number" name="quantity" id="quantity" class="form-control form-conrtrol-sm rounded-0 text-right" value="<?php echo isset($quantity) ? $quantity : 0 ?>" required>
        </div>
        <div class="form-group">
            <label for="daily_rate" class="control-label">Daily Rate</label>
            <input type="text" class="form-control form-conrtrol-sm rounded-0 text-right" value="<?php echo isset($daily_rate) ? $daily_rate : 0.00 ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="amount" class="control-label">Total Amount</label>
            <input type="number" class="form-control form-conrtrol-sm rounded-0 text-right amount" value="<?php echo isset($daily_rate) * $quantity ? $daily_rate * $quantity : 0 ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Status</label>
            <select name="status" id="" class="custom-select custol-select-sm">
                <option value="0" <?php echo $status == 0 ? "selected" : '' ?>>Pending</option>
                <option value="1" <?php echo $status == 1 ? "selected" : '' ?>>Confirmed</option>
                <option value="2" <?php echo $status == 2 ? "selected" : '' ?>>Cancelled</option>
            </select>
        </div>
    </form>
</div>

<script>
    // function calc_rent_days(){
    //     var quantity = new Date($('#quantity').val())
    //     var daily_rate = <?php echo isset($daily_rate) ? $daily_rate : '' ?>;
    //     var days = (Math.floor((diff)/(1000*60*60*24))) +1
    //     $('#rent_days').val(days)
    //     if(days > 0){
    //         calc_amount()
    //     }
    // }
    function calc_amount() {
        var daily_rate = "<?php echo isset($daily_rate) ? $daily_rate : '' ?>";
        var quantity = $('#quantity').val()
        var amount = daily_rate * quantity;
        console.log(amount)
        $('.amount').val(amount)
    }
    $(function() {
        var today_quantity = <?php echo $quotation_meta['quantity'] ?>;
        var quotation_id = $('#quotation_id').val()
        var id = $('#id').val()
        $('#quantity').change(function() {
            $('#msg').text('')
            $('#quantity').removeClass('border-success border-danger')
            var quantity = $('#quantity').val()
            if (quantity <= 0) {
                $('#quantity').addClass('border-danger')
                $('#msg').text("Invalid Quantity")
                return false;
            }
            if(quantity >= today_quantity){
                $('#quantity').addClass('border-danger')
                $('#msg').text("Stock not available for the quantity you entered.")            
                return false;
            }
            // $('#check-availability-loader').removeClass('d-none')
            // $('#uni_modal button').attr('disabled', true)
            calc_amount()
            // $.ajax({
            //     url: _base_url_ + "classes/Master.php?f=rent_avail",
            //     data: {
            //         quantity: quantity,
            //         quotation_id: quotation_id,
            //         id: id
            //     },
            //     method: 'POST',
            //     dataType: 'json',
            //     error: err => {
            //         console.log(err)
            //         alert_toast('An error occured while checking availability', 'error')
            //         $('#check-availability-loader').addClass('d-none')
            //         $('#uni_modal button').attr('disabled', false)
            //     },
            //     success: function(resp) {
            //         if (resp.status == 'success') {
            //             $('#quantity').addClass('border-success')
            //         } else if (resp.status == 'not_available') {
            //             $('#quantity').addClass('border-danger')
            //             $('#msg').text(resp.msg)
            //         } else {
            //             alert_toast('An error occured while checking availability', 'error')
            //         }
            //         $('#check-availability-loader').addClass('d-none')
            //         $('#uni_modal button').attr('disabled', false)
            //         calc_amount()
            //     }
            // })

        })
        $('#book-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            if (_this.find('.border-danger').length > 0) {
                alert_toast('Can\'t proceed submission due to invalid inputs in some fields.', 'warning')
                return false;
            }
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_booking",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload()
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({
                            scrollTop: _this.closest('.card').offset().top
                        }, "fast");
                        end_loader()
                    } else {
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })
    })
</script>