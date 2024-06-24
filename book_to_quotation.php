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
    <form action="" id="book-form">
        <input type="hidden" id="quotation_id" value="<?php echo $_GET['id'] ?>">
        <p>Quantity</p>
        <div class="d-flex">
            <a id="dec" class="border-[#bfbfbf] border-r-2 pr-5">
                <i class="fa-solid fa-minus"></i>
            </a>
            <p id="counter" class="font-bold text-bold">1</p>
            <a id="inc" class="border-[#bfbfbf] border-l-2 pl-5">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div><hr>
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
        <input type="checkbox" name="aggrement" id="" required><a href=""> Aggrement </a>
    </form>
</div>

<script>
    var inc = document.querySelector("#inc");
    var dec = document.querySelector("#dec");
    var counter = document.querySelector("#counter");
    var item = document.querySelector("#item");
    var po = document.querySelector("#po");
    var margin = document.querySelector("#margin");
    var amount = document.querySelector("#amount");
    var profit = document.querySelector("#profit");
    var investor_profit = document.querySelector("#investor_profit");
    var nrf_charge = document.querySelector("#nrf_charge");
    inc.addEventListener("click", () => {
        counter.innerText = parseInt(counter.innerText) + 1;
        item.innerText = parseInt(item.innerText) + 1;
        po.innerText = parseInt(item.innerText) * <?php echo $po_rate ?>;
        margin.innerText = -parseInt(item.innerText) * <?php echo $po_rate - $daily_rate ?>;
        profit.innerText = parseInt(item.innerText) * <?php echo $po_rate - $daily_rate ?>;
        nrf_charge.innerText = -parseInt(item.innerText) * <?php echo ($po_rate - $daily_rate)/2 ?>;
        investor_profit.innerText = parseInt(item.innerText) * <?php echo ($po_rate - $daily_rate)/2 ?>;
        amount.innerText = parseInt(item.innerText) * <?php echo $daily_rate ?>;
    });
    dec.addEventListener("click", () => {
        if (parseInt(counter.innerText) > 1) {
            counter.innerText = parseInt(counter.innerText) - 1;
            item.innerText = parseInt(item.innerText) - 1;
            po.innerText = parseInt(item.innerText) * <?php echo isset($po_rate) ? $po_rate : '' ?>;
            margin.innerText = -parseInt(item.innerText) * <?php echo $po_rate - $daily_rate ?>;
            profit.innerText = parseInt(item.innerText) * <?php echo $po_rate - $daily_rate ?>;
            nrf_charge.innerText = -parseInt(item.innerText) * <?php echo ($po_rate - $daily_rate)/2 ?>;
            investor_profit.innerText = parseInt(item.innerText) * <?php echo ($po_rate - $daily_rate)/2 ?>;
            amount.innerText = parseInt(item.innerText) * <?php echo $daily_rate ?>;
        }
    });
    $('#book-form').submit(function(e) {
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
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_booking",
            data: {
                quotation_id: quotation_id,
                quantity: quantity,
                po_rate: po_rate,
                daily_rate: daily_rate
            },
            method: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err)
                alert_toast("An error occured", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    end_loader()
                    $('#uni_modal').modal('hide')
                    $('.nav-bar').removeClass('d-none')
                    setTimeout(() => {
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
    // function calc_rent_days(){
    //     var ds = new Date($('#date_start').val())
    //     var de = new Date($('#date_end').val())
    //     var diff = de- ds;
    //     var days = (Math.floor((diff)/(1000*60*60*24))) +1
    //     $('#rent_days').val(days)
    //     if(days > 0){
    //         calc_amount()
    //     }
    // }
    // function calc_amount(){
    //     var dr = "<?php echo isset($daily_rate) ? $daily_rate : '' ?>";
    //     var days = $('#rent_days').val()
    //     var amount  = dr * days;
    //     console.log(amount)
    //     $('#amount').val(amount)
    // }
    // $(function(){
    //     $('#date_start, #date_end').change(function(){
    //         $('#msg').text('')
    //         $('#date_start, #date_end').removeClass('border-success border-danger')
    //         var ds = $('#date_start').val()
    //         var de = $('#date_end').val()
    //         var bike_id = "<?php echo isset($id) ? $id : '' ?>";
    //         var max_unit = "<?php echo isset($quantity) ? $quantity : '' ?>";
    //         if(ds == '' || de == '' || bike_id == '' || max_unit == '')
    //         return false;
    //         if(de < ds){
    //             $('#date_start, #date_end').addClass('border-danger')
    //             $('#msg').text("Invalid Selected Dates")
    //             return false;
    //         }
    //         $('#check-availability-loader').removeClass('d-none')
    //         $('#uni_modal button').attr('disabled',true)
    //         $.ajax({
    //             url:'classes/Master.php?f=rent_avail',
    //             method:"POST",
    //             data:{ds:ds,de:de,bike_id:bike_id,max_unit:max_unit},
    //             dataType:'json',
    //             error:err=>{
    //                 console.log(err)
    //                 alert_toast('An error occured while checking availability','error')
    //                 $('#check-availability-loader').addClass('d-none')
    //                 $('#uni_modal button').attr('disabled',false)
    //             },
    //             success:function(resp){
    //                 if(resp.status == 'success'){
    //                     $('#date_start, #date_end').addClass('border-success')
    //                 }else if(resp.status == 'not_available'){
    //                     $('#date_start, #date_end').addClass('border-danger')
    //                     $('#msg').text(resp.msg)
    //                 }else{
    //                     alert_toast('An error occured while checking availability','error')
    //                 }
    //                 $('#check-availability-loader').addClass('d-none')
    //                 $('#uni_modal button').attr('disabled',false)
    //                 calc_rent_days()
    //             }
    //         })

    //     })
    //     $('#book-form').submit(function(e){
    //         e.preventDefault();
    //         var _this = $(this)
    //         if(_this.find('.border-danger').length > 0){
    //             alert_toast('Can\'t proceed submission due to invalid inputs in some fields.','warning')
    //             return false;
    //         }
    //         $('.err-msg').remove();
    //         start_loader();
    //         $.ajax({
    //             url:_base_url_+"classes/Master.php?f=save_booking",
    //             data: new FormData($(this)[0]),
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             method: 'POST',
    //             type: 'POST',
    //             dataType: 'json',
    //             error:err=>{
    //                 console.log(err)
    //                 alert_toast("An error occured",'error');
    //                 end_loader();
    //             },
    //             success:function(resp){
    //                 if(typeof resp =='object' && resp.status == 'success'){
    //                     end_loader()
    //                     $('#uni_modal').modal('hide')
    //                     setTimeout(() => {
    //                         uni_modal('','success_booking.php')
    //                     }, 500);
    //                 }else if(resp.status == 'failed' && !!resp.msg){
    //                     var el = $('<div>')
    //                         el.addClass("alert alert-danger err-msg").text(resp.msg)
    //                         _this.prepend(el)
    //                         el.show('slow')
    //                         $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
    //                         end_loader()
    //                 }else{
    //                     alert_toast("An error occured",'error');
    //                     end_loader();
    //                     console.log(resp)
    //                 }
    //             }
    //         })
    //     })
    // })
</script>