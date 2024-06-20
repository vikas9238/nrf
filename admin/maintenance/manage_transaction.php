<?php
require_once '../../config.php';
// if(isset($_GET['id']) && $_GET['id'] > 0){
//     $qry = $conn->query("SELECT * from `company_list` where id = '{$_GET['id']}' ");
//     if($qry->num_rows > 0){
//         foreach($qry->fetch_assoc() as $k => $v){
//             $$k=$v;
//         }
//     }
// }
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
			<option value="0">Cash</option>
			<option value="1">Online</option>
			</select>
		</div>
        <div class="form-group">
			<label for="reference_number" class="control-label">Reference Number</label>
			<input name="reference_number" id="reference_number"  class="form-control form-control-sm rounded-0" />
		</div>
		
	</form>
</div>

<script>
  
	$(document).ready(function(){
		$('#transaction-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
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
        $("#reference_number").attr('disabled', 'disabled');
        $('#payment_mode').trigger('change');
        $(document).on('change', '#payment_mode', function () {
            var payMode = $(this).val();
            if (payMode != 0) {
                $("#reference_number").removeAttr('disabled');
            } else {
                $("#reference_number").attr('disabled', 'disabled');
            }
        });
	})
</script>