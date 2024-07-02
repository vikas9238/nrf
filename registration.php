<style>
    #uni_modal .modal-content>.modal-footer,
    #uni_modal .modal-content>.modal-header {
        display: none;
    }
</style>
<div class="container-fluid">
    <form action="" id="registration">
        <div class="row">

            <h3 class="text-center">Create New Account
                <span class="float-right">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.nav-bar').removeClass('d-none')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </span>
            </h3>
            <hr>
        </div>
        <div class="row  align-items-center h-100">

            <div class="col-lg-5 border-right">

                <div class="form-group">
                    <label for="" class="control-label">First Name</label>
                    <input type="text" class="form-control form-control-sm form" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Last Name</label>
                    <input type="text" class="form-control form-control-sm form" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Gender</label>
                    <select name="gender" id="" class="custom-select select" required>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Contact</label>
                    <input type="text" class="form-control form-control-sm form" name="contact" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form-control-sm form" name="email" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form-control-sm form" name="password" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Address</label>
                    <textarea class="form-control form" rows='3' name="address" required></textarea>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="form-group">
                    <label for="" class="control-label">Account Number</label>
                    <input type="text" class="form-control form-control-sm form" name="account" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">IFSCode</label>
                    <input type="text" class="form-control form-control-sm form" name="ifsc" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Pan Number</label>
                    <input type="text" class="form-control form-control-sm form" name="pan" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Images</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="user" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Signature</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="sign" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Upload Aadhar Card (Front Side)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="idfront" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Upload Aadhar Card (Back Side)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="idback" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="login-show">Already have an Account</a>
                    <button class="btn btn-primary btn-flat">Register</button>
                </div>
            </div>
        </div>
    </form>

</div>
<script>
     function displayImg(input,_this) {
        var fnames = []
        Object.keys(input.files).map(k=>{
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(JSON.stringify(fnames))
	}
    $(function() {
        $('#login-show').click(function() {
            uni_modal("", "login.php")
        })
        $('#registration').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=register",
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
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Account succesfully registered", 'success')
                        setTimeout(function() {
                            location.reload()
                        }, 2000)
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var _err_el = $('<div>')
                        _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('[name="password"]').after(_err_el)
                        end_loader()

                    } else {
                        console.log(resp)
                        alert_toast("an error occured", 'error')
                        end_loader()
                    }
                }
            })
        })

    })
</script>