<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    
    <div class="row">
    <h3 class="float-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.nav-bar').removeClass('d-none')">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
        <div class="col-lg-12">
            <h3 class="text-center">Forgot Password</h3>
            <hr>
            <form action="" id="forgot-form">
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form" placeholder="Enter email address" name="email" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="create_account">Create Account</a>
                    <button class="btn btn-primary btn-flat">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#create_account').click(function(){
            uni_modal("","registration.php","mid-large")
        })
        $('#forgot-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Login.php?f=forgot_password",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            });
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        end_loader()
                        Swal.fire({
                                    title: "Password reset link sent to your email!",
                                    text: "Check Your email for the reset link!",
                                    icon: "success"
                                    }).then(function(){
                                        location.reload();
                                    });
                        // alert_toast("Password reset link sent to your email",'success')
                        // setTimeout(function(){
                        //     location.reload()
                        // },1500)
                    }else if(resp.status == 'incorrect'){
                        $('#forgot-form').prepend('<div class="alert alert-danger err-msg">Email not found.</div>')
                        end_loader()
                    }else{
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })