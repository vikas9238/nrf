<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `clients` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="card-body">
	<form action="" id="category-form">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="firstname" class="control-label">First Name</label>
			<input name="firstname" id="firstname" class="form-control form no-resize" value="<?php echo isset($firstname) ? $firstname : ''; ?> " required>
		</div>
		<div class="form-group">
			<label for="lastname" class="control-label">Last Name</label>
			<input name="lastname" id="lastname" class="form-control form no-resize" value="<?php echo isset($lastname) ? $lastname : ''; ?> " required>
		</div>
		<div class="form-group">
			<label for="email" class="control-label">Email</label>
			<input name="email" id="email" type="email" class="form-control form no-resize" value="<?php echo isset($email) ? $email : ''; ?> " required>
		</div>
		<div class="form-group">
			<label for="contact" class="control-label">Contact</label>
			<input name="contact" id="" class="form-control form no-resize" value="<?php echo isset($contact) ? $contact : ''; ?>">
		</div>
		<div class="form-group status">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="custom-select selevt">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
		</div>
		<div class="form-group reason">
			<label for="reason" class="control-label">Reason</label>
			<textarea id="reason" class="form-control form no-resize" required></textarea>
		</div>
	</form>
</div>
<style>
	.reason {
		display: none;
	}
</style>
<script>
	$(document).ready(function() {
		$(".status").change(function() {
			var status = $(this).find('[name="status"]').val();
			if (status == 0) {
				$(".reason").show();
			} else {
				$(".reason").hide();
			}
		});
		$('#category-form').submit(function(e) {
			e.preventDefault();
			var firstname = $('#firstname').val();
			var lastname = $('#lastname').val();
			var email = $('#email').val();
			var _this = $(this)
			var status = $(this).find('[name="status"]').val();
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_client",
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
						if (status == 1) {
							var check = confirm("Do you want to send mail to the client?");
							if (check == true) {
								$.ajax({
									url: _base_url_ + "mail/welcome.php",
									method: 'POST',
									data: {
										firstname: firstname,
										lastname: lastname,
										email: email
									},
									dataType: 'json',
								});
								alert_toast("Mail Send Successfully", 'success');
							}
						} else if (status == 0) {
							var reason = $('#reason').val();
							var check = confirm("Do you want to send mail to the client?");
							if (check == true) {
								$.ajax({
									url: _base_url_ + "mail/reject.php",
									method: 'POST',
									data: {
										firstname: firstname,
										lastname: lastname,
										email: email,
										reason: reason
									},
									dataType: 'json',
								});
								alert_toast("Mail Send Successfully", 'success');
							}
						}
						location.reload()
					} else if (resp.status == 'failed' && !!resp.msg) {
						var _err_el = $('<div>')
						_err_el.addClass("alert alert-danger err-msg").text(resp.msg)
						$('[name="email"]').after(_err_el)
						end_loader()
					} else {
						alert_toast("An error occured", 'error');
						end_loader();
						console.log(resp)
					}
				}
			})
		})

		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ol', 'ul', 'paragraph', 'height']],
				['table', ['table']],
				['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
			]
		})
	})
</script>