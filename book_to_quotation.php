<?php
require_once('config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `quotation_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<div class="container-fluid">
    <h3 class="text-center book">Material Booking</h3>
    <hr class='book'>
    <form action="" id="book-form">
        <input type="hidden" id="quotation_id" value="<?php echo $_GET['id'] ?>">
        <p>Quantity</p>
        <input type="number" id="quantity" value="1" class="form-control text-center form-conrtrol-sm rounded-0">
        <p class="text-decoration-underline text-primary">Price Details</p>
        <div>
            <span>Price (PO)*(<span id='item'>1</span><?php if($po_unit==1): ?> TON<?php else: ?> CFT<?php endif; ?>)</span>
                                
            <span class="float-right text-right" id="po"><?php echo $po_rate ?></span>
        </div>
        <div class="mt-2">
            <span>Margin</span>
            <span class="float-right text-right" id="margin">-<?php echo $po_rate - $daily_rate ?></span>
        </div>
        <hr>
        <div class="bg-warning">
            <span class="text-bold">Total Amount</span>
            <span id="amount" class="float-right text-right text-bold"><?php echo $daily_rate ?></span>
        </div><hr>
        <p class="text-decoration-underline text-primary">Profit Details</p>
        <div>
            <span>Total Profit</span>
            <span class="float-right text-right" id="profit"><?php echo $po_rate - $daily_rate ?></span>
        </div>
        <div class="mt-2">
            <span>NRF Charges(50% Of Profit)</span>
            <span class="float-right text-right" id="nrf_charge">-<?php echo ($po_rate - $daily_rate)/2 ?></span>
        </div>
        <hr>
        <div>
            <span>Investor Profit</span>
            <span id="investor_profit" class="float-right text-right"><?php echo ($po_rate - $daily_rate)/2 ?></span>
        </div>
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
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="aggrement" class="custom-control-input" id="customCheck1" required>
                <label class="custom-control-label" for="customCheck1">I agree to the <a href="javascript:void(0)">Terms and Conditions</a></label>
            </div>
        </div>
    </form>
    <div class="modal-footer book">
        <button type="button" id="next" class="btn btn-sm btn-flat btn-primary">Next</button>
        <button type="button" class="btn btn-secondary btn-sm btn-flat" data-dismiss="modal">Close</button>
    </div>
    <div class="payment mt-2">
        <h3 class="text-center">Payment</h3>
        <hr>
        <p class='text-primary text-decoration-underline'>Payment Mode:</p>
        <div class="mode">
         <input type="radio" id="ac" name="payment" value="Account">
         <label for="ac">Account/ NEFT/ RTGS/ IMPS Payment</label><br>
         <input type="radio" id="qr" name="payment" value="UPI" checked>
         <label for="qr">UPI/QR Payment</label><br>
        </div>
         <hr>
        <div class="upi">
            <p class="text-primary">Scan the QR Code with any UPI App and pay the amount then download the source code.</p>
            <center><img src="" alt="QR CODE" class="get_qr mt-1"></center>
            <div class="upi-id-content">
                <div>
                <strong id="upi-id">nrfindustry@ybl</strong>
                <button id="copy-button" class="copy-button">Copy</button>
                </div>
                <lottie-player 
                    src="https://lottie.host/2b51d7af-7099-49f5-93df-f8190dde11bb/WU9eejAueC.json"
                    background="#FFFFFF"
                    speed="1.5"
                    loop
                    autoplay
                    direction="1"
                    mode="normal" class="upi-icon"
                ></lottie-player>
            </div>
        </div>
        <div class="account">
            <p class="text-primary">Account Details</p>
            <div class="account-content">
                <div>
                <strong>Account Number: </strong>
                <span id="account-no">201003171098</span>
                <button id="copy-account" class="copy-button">Copy</button>
                </div>
                <div>
                <strong>IFSC: </strong>
                <span id="ifsc">INDB0000393</span>
                <button id="copy-ifsc" class="copy-button">Copy</button>
                </div>
                <div>
                <strong>Account Holder Name: </strong>
                <span id="name">Nrf Industry And Trading Pvt Ltd</span>
                <button id="copy-name" class="copy-button">Copy</button>
                </div>
                <div>
                <strong>Branch Address: </strong>
                <span>Boring Road, Patna-800013,Bihar</span>
                </div>
                <lottie-player 
                    src="https://lottie.host/2b51d7af-7099-49f5-93df-f8190dde11bb/WU9eejAueC.json"
                    background="#FFFFFF"
                    speed="1.5"
                    loop
                    autoplay
                    direction="1"
                    mode="normal" class="upi-icon"
                ></lottie-player>
            </div>
        </div><hr>
        <div class="flex mt-2">
            <label class="text-primary">UTR/REFERENCE/TRANSACTION ID**</label>
            <input type="number" name="transaction" id="transaction" placeholder="UTR/REFERENCE/TRANSACTION ID**" class="mt-2 id form-control form-conrtrol-sm rounded-0" require>
        </div>
        <div class="form-group">
            <label for="" class="control-label text-primary">Screen Shot**</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input rounded-circle" id="customFile" name="screenshot" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))" required>
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="submit" class="btn btn-sm btn-flat btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary btn-sm btn-flat" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<style>
    #uni_modal>.modal-dialog>.modal-content>.modal-footer,#uni_modal .modal-content>.modal-header {
        display:none;
    }
    #uni_modal .modal-body{
        padding:0;
    }
    .get_qr {
        height: 200px;
        width: 200px;
        border: 1px solid #999;
        background: #efefef;
    }
    .payment {
        width: 100%;
        height: 100%;
        display: none;
    }
    .flex {
        display: flex;
        flex-direction: column;
    }
    #upi-id {
    margin-top: 20px;
    text-align: center;
    }

    .upi-id-content{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 10px; 
    }
        #upi-id strong {
        color: #007bff;
        user-select: text;
        display: inline-block;
        margin-right: 10px;
    }

    .copy-button {
        display: inline-block;
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        margin-top: 10px;
        border-radius: 5px;
        height: min-content;
        cursor: pointer;
    }
</style>

<script>
    function displayImg(input,_this) {
        var fnames = []
        Object.keys(input.files).map(k=>{
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(JSON.stringify(fnames))
	}
    const copyButton = document.getElementById("copy-button");
    const copyname = document.getElementById("copy-name");
    const copyaccount = document.getElementById("copy-account");
    const copyifsc = document.getElementById("copy-ifsc");
    const upiIdText = document.getElementById("upi-id");
    const nameText = document.getElementById("name");
    const accountText = document.getElementById("account-no");
    const ifscText = document.getElementById("ifsc");

    copyButton.addEventListener("click", function () {
        const textToCopy = upiIdText.textContent;
        const tempInput = document.createElement("input");
        tempInput.value = textToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        copyButton.textContent = "Copied!";
        setTimeout(function () {
            copyButton.textContent = "Copy";
        }, 2500);
    });
    copyname.addEventListener("click", function () {
        const textToCopy = nameText.textContent;
        const tempInput = document.createElement("input");
        tempInput.value = textToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        copyname.textContent = "Copied!";
        setTimeout(function () {
            copyname.textContent = "Copy";
        }, 2500);
    });
    copyaccount.addEventListener("click", function () {
        const textToCopy = accountText.textContent;
        const tempInput = document.createElement("input");
        tempInput.value = textToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        copyaccount.textContent = "Copied!";
        setTimeout(function () {
            copyaccount.textContent = "Copy";
        }, 2500);
    });
    copyifsc.addEventListener("click", function () {
        const textToCopy = ifscText.textContent;
        const tempInput = document.createElement("input");
        tempInput.value = textToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        copyifsc.textContent = "Copied!";
        setTimeout(function () {
            copyifsc.textContent = "Copy";
        }, 2500);
    });
    var today_quantity=<?php echo $quantity ?>;
    var item = document.querySelector("#item");
    var po = document.querySelector("#po");
    var margin = document.querySelector("#margin");
    var amount = document.querySelector("#amount");
    var profit = document.querySelector("#profit");
    var investor_profit = document.querySelector("#investor_profit");
    var nrf_charge = document.querySelector("#nrf_charge");
  
    $('#quantity').change(function(){
        var quantity = $('#quantity').val()
        if(quantity <= 0){
            alert_toast("Invalid Quantity", 'warning');
            return false;
        }
        if(quantity > today_quantity){
            alert_toast("Stock not available for the quantity you entered", 'warning');
            return false;
        }
        item.innerText = quantity;
        po.innerText = quantity * <?php echo isset($po_rate) ? $po_rate : '' ?>;
        margin.innerText = -quantity * <?php echo $po_rate - $daily_rate ?>;
        profit.innerText = quantity * <?php echo $po_rate - $daily_rate ?>;
        nrf_charge.innerText = -quantity * <?php echo ($po_rate - $daily_rate)/2 ?>;
        investor_profit.innerText = quantity * <?php echo ($po_rate - $daily_rate)/2 ?>;
        amount.innerText = quantity * <?php echo $daily_rate ?>;
    })
    $('#next').click(function(e) {
        e.preventDefault();
        if(!document.querySelector('input[name="aggrement"]').checked){
            alert_toast("Please agree to the terms and conditions", 'warning');
            return false;
        }
        $('.err-msg').remove();
        var quotation_id = $('#quotation_id').val()
        var quantity = document.querySelector('#item').innerText;
        var po_rate =<?php echo $po_rate ?>;
        var daily_rate = <?php echo $daily_rate ?>;
        var amount = quantity * daily_rate;
        $("#book-form").hide();
        $(".book").hide();
        $(".payment").show();
        $(".account").hide();
        var num = <?php echo $_settings->userdata('contact') ?>;
        var link = "upi://pay?pa=nrfindustry@ybl%26am="+amount+"%26tr=" + num;
        var upi = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" + link;
        console.log(upi);
        $(".get_qr").attr("src", upi);
    })
    $('.mode').click(function () {
        $('input:radio[name=payment]:checked').change(function () {
            if ($("input[name='payment']:checked").val() == 'Account') {
                $(".upi").hide();
                $(".account").show();
            }
            if ($("input[name='payment']:checked").val() == 'UPI') {
                $(".account").hide();
                $(".upi").show();
            }
        });
    });
    $('#submit').click(function() {
        if(!$('#transaction').val()){
            alert_toast("Please Enter the UTR/REFERENCE/TRANSACTION ID", 'warning');
            return false;
        }
        if(!document.getElementById('customFile').files.length){
            alert_toast("Please Upload the Screen Shot for verification", 'warning');
            return false;
        }
        $('.err-msg').remove();
        var firstname="<?php echo $_settings->userdata('firstname') ?>";
        var lastname="<?php echo $_settings->userdata('lastname') ?>";
        var email="<?php echo $_settings->userdata('email') ?>";
        var quotation_id = $('#quotation_id').val()
        var quantity = document.querySelector('#item').innerText;
        var po_rate =<?php echo $po_rate ?>;
        var daily_rate = <?php echo $daily_rate ?>;
        var fileInput=document.getElementById('customFile');
        var file=fileInput.files[0];
        var formData=new FormData();
        formData.append('quotation_id',quotation_id);
        formData.append('quantity',quantity);
        formData.append('po_rate',po_rate);
        formData.append('daily_rate',daily_rate);
        formData.append('transaction',$('#transaction').val());
        formData.append('screenshot',file);
        formData.append('mode',$('input[name="payment"]:checked').val());
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_booking",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err)
                Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            });
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    end_loader()
                    $('#uni_modal').modal('hide')
                    $('.nav-bar').removeClass('d-none')
                    setTimeout(() => {
                        $.ajax({
                                url: _base_url_+"mail/booking.php",
                                method: 'POST',
                                data: { firstname: firstname,lastname:lastname, email: email},
                                dataType: 'json',
                            });
                        uni_modal('', 'success_booking.php')
                    }, 500);
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
</script>