<?php
require_once '../../config.php';
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `booking_list` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
	$all_profit = ($po_rate - $daily_rate) * $approved_quantity;
	$profit = $all_profit / 2;
	$total_investment = $daily_rate * $approved_quantity;
	$pending = $profit + $total_investment - $paid_amount;
}
?>
<div class="container-fluid">
	<form action="" id="transaction-form">
		<input type="hidden" name ="quotation_id" value="<?php echo $_GET['id'] ?>">
		<input type="hidden" name ="client_id" value="<?php echo $_GET['client_id'] ?>">
		<div class="form-group">
			<label for="amount" class="control-label">Amount</label>
			<input name="amount" id="amount" type="number"  class="form-control form-control-sm rounded-0"  required/>
		</div>
		<div class="form-group">
			<label for="payment_mode" class="control-label">Payment Mode</label>
			<select name="payment_mode" id="payment_mode" class="custom-select selevt">
			<option value="1">Online</option>
			</select>
		</div>
        <div class="form-group">
			<label for="reference_number" class="control-label">Reference Number</label>
			<input name="reference_number" id="reference_number"  class="form-control form-control-sm rounded-0" required/>
		</div>
        <div class="form-group">
			<label for="description" class="control-label">Description</label>
			<input name="description" id="description" type="text" class="form-control form-control-sm rounded-0"/>
		</div>
		
	</form>
</div>

<script>
  
	$(document).ready(function(){
		$('#amount').change(function(){
			var amount = $(this).val();
			if(amount > <?php echo $pending ?>){
				alert_toast("Amount must be less than or equal to <?php echo $pending ?>",'warning');
				$(this).val(<?php echo $pending ?>)
			}
		})
		// $("#transaction-form").validate();
		$('#transaction-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			 var $form = $(this);
			 if($form[0].checkValidity() === false){
				//  $form.addClass('was-validated')
				alert_toast("Need To Fill Required Details",'warning');
				 return false;
			 }
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_transaction",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
</script>