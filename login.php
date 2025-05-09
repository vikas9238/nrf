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
            <h3 class="text-center">Login</h3>
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form" name="email" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form" name="password" required>
                </div>
                <div class="link forget-pass text-left"><a href="javascript:void()" id="forgot">Forgot password?</a></div>

                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="create_account">Create Account</a>
                    <button class="btn btn-primary btn-flat">Login</button>
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
        $('#forgot').click(function(){
            uni_modal("","forgot.php","mid-large")
        })
        $('#login-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Login.php?f=login_user",
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
                                    title: "Login Successfully",
                                    // text: "You can now login!",
                                    icon: "success"
                                    }).then(function(){
                                        location.reload();
                                    });
                        // alert_toast("Login Successfully",'success')
                        // setTimeout(function(){
                        //     location.reload()
                        // },2000)
                    }else if(resp.status == 'incorrect'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else if(resp.status == 'inactive'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-info err-msg").text("Your account are inactive, Please Contact Admin.")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else if(resp.status == 'pending'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-warning err-msg").text("Your Account are waiting for approvel, Please Wait....")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })
</script>