<?php
 if(isset($_GET['key'])){
    $key = $_GET['key'];
    $qry = $conn->query("SELECT * FROM `clients` where `reset_key` = '$key' ");
    if($qry->num_rows > 0){
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }else{
        redirect('index.php');
    }
}else{  
    redirect('index.php');
}
?>
<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
            <h3 class="text-center">Change Password</h3>
            <hr>
            <form action="" id="change-form">
                <input type="hidden" name="key" value="<?php echo $key ?>">
                <div class="form-group">
                    <label for="" class="control-label">New Password</label>
                    <input type="password" class="form-control form" placeholder="Enter New Password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Confirm Password</label>
                    <input type="cpassword" class="form-control form" placeholder="Enter Confirm Password" name="cpassword" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="login-show">Login</a>
                    <button class="btn btn-primary btn-flat">Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#login-show').click(function() {
            uni_modal("", "login.php")
        })
        $('#change-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            if($('input[name="password"]').val() != $('input[name="cpassword"]').val()){
                var _err_el = $('<div>')
                    _err_el.addClass("alert alert-danger err-msg").text("Password did not match.")
                $('#change-form').prepend(_err_el)
                end_loader()
                return false;
            }
            $.ajax({
                url:_base_url_+"classes/Login.php?f=change_password",
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
                                    title: "Password changed successfully!",
                                    text: "You can now login!",
                                    icon: "success"
                                    }).then(function(){
                                        location.reload();
                                    });
                    }else if(resp.status == 'incorrect'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                        $('#change-form').prepend(_err_el)
                        end_loader()
                    }else{
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })
</script>