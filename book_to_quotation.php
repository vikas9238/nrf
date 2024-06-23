<?php
require_once('config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `quotation_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="book-form">
        <input type="hidden" name="bike_id" value="<?php echo $_GET['id'] ?>">
        <div class="">
            <a id="dec" class="border-[#bfbfbf] border-r-2 pr-5">
                <i class="fa-solid fa-minus"></i>
            </a>
            <input id="counter" type="number" class="font-bold" value="1">
            <a id="inc" class="border-[#bfbfbf] border-l-2 pl-5">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        <p class="text-decoration-underline">Price Details</p>
        <div>
        <span>Price (PO) (<span id='item'>1</span> Ton)</span>
        <span class="float-right text-right" id="po"><?php echo $po_rate?></span>
        </div>
        <div class="mt-2">
        <span>Margin</span>
        <span class="float-right text-right" id="margin">-<?php echo $po_rate-$daily_rate?></span>
        </div><hr>
        <div>
            <span>Total Amount</span>
            <span id="amount" class="float-right text-right"><?php echo $daily_rate ?></span>
        </div>
        <!-- <div class="form-group">
            <label for="date_start" class="control-label">Pick-up Date</label>
            <input type="date" name="date_start" id="date_start" class="form-control form-conrtrol-sm rounded-0" value="" required>
        </div>
        <div class="form-group">
            <label for="date_end" class="control-label">Date to Return</label>
            <input type="date" name="date_end" id="date_end" class="form-control form-conrtrol-sm rounded-0" value="" required>
        </div> -->
        <div id="msg" class="text-danger"></div>
        <div id="check-availability-loader" class="d-none">
            <center>
                <div class="d-flex align-items-center col-md-6">
                    <strong>Checking Availability...</strong>
                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                </div>
            </center>
        </div>
        <!-- <div class="form-group">
            <label for="rent_days" class="control-label">Days to Rent</label>
            <input type="number" name="rent_days" id="rent_days" class="form-control form-conrtrol-sm rounded-0 text-right" value="0" required readonly>
        </div>
        <div class="form-group">
            <label for="daily_rate" class="control-label">Bike Daily Rate</label>
            <input type="text"  id="daily_rate" class="form-control form-conrtrol-sm rounded-0 text-right" value="<?php echo isset($daily_rate) ? number_format($daily_rate,2) : 0.00 ?>" required readonly>
        </div>
        <div class="form-group">
            <label for="amount" class="control-label">Total Amount</label>
            <input type="number" name="amount" id="amount" class="form-control form-conrtrol-sm rounded-0 text-right" value="0" required readonly>
        </div> -->
        <button type="submit">submit</button>
    </form>
</div>

<script>
    var inc = document.querySelector("#inc");
    var dec = document.querySelector("#dec");
    var counter = document.querySelector("#counter");
    var item = document.querySelector("#item");
    var po= document.querySelector("#po");
    var margin= document.querySelector("#margin");
    var amount= document.querySelector("#amount");
    inc.addEventListener("click", () => {
        counter.innerText = parseInt(counter.innerText) + 1;
        item.innerText = parseInt(item.innerText) + 1;
        po.innerText = parseInt(item.innerText)*<?php echo isset($po_rate) ? $po_rate :'' ?>;
        margin.innerText = -parseInt(item.innerText)*<?php echo $po_rate-$daily_rate ?>;
        amount.innerText=parseInt(item.innerText)*<?php echo $daily_rate ?>;    });
    dec.addEventListener("click", () => {
        if (parseInt(counter.innerText) > 1) {
            counter.innerText = parseInt(counter.innerText) - 1;
            item.innerText = parseInt(item.innerText) - 1;
            po.innerText = parseInt(item.innerText)*<?php echo isset($po_rate) ? $po_rate :'' ?>;
            margin.innerText = -parseInt(item.innerText)*<?php echo $po_rate-$daily_rate ?>;
            amount.innerText=parseInt(item.innerText)*<?php echo $daily_rate ?>;
        }
    });
    function calc_rent_days(){
        var ds = new Date($('#date_start').val())
        var de = new Date($('#date_end').val())
        var diff = de- ds;
        var days = (Math.floor((diff)/(1000*60*60*24))) +1
        $('#rent_days').val(days)
        if(days > 0){
            calc_amount()
        }
    }
    function calc_amount(){
        var dr = "<?php echo isset($daily_rate) ? $daily_rate :'' ?>";
        var days = $('#rent_days').val()
        var amount  = dr * days;
        console.log(amount)
        $('#amount').val(amount)
    }
    $(function(){
        $('#date_start, #date_end').change(function(){
            $('#msg').text('')
            $('#date_start, #date_end').removeClass('border-success border-danger')
            var ds = $('#date_start').val()
            var de = $('#date_end').val()
            var bike_id = "<?php echo isset($id) ? $id :'' ?>";
            var max_unit = "<?php echo isset($quantity) ? $quantity :'' ?>";
            if(ds == '' || de == '' || bike_id == '' || max_unit == '')
            return false;
            if(de < ds){
                $('#date_start, #date_end').addClass('border-danger')
                $('#msg').text("Invalid Selected Dates")
                return false;
            }
            $('#check-availability-loader').removeClass('d-none')
            $('#uni_modal button').attr('disabled',true)
            $.ajax({
                url:'classes/Master.php?f=rent_avail',
                method:"POST",
                data:{ds:ds,de:de,bike_id:bike_id,max_unit:max_unit},
                dataType:'json',
                error:err=>{
                    console.log(err)
                    alert_toast('An error occured while checking availability','error')
                    $('#check-availability-loader').addClass('d-none')
                    $('#uni_modal button').attr('disabled',false)
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        $('#date_start, #date_end').addClass('border-success')
                    }else if(resp.status == 'not_available'){
                        $('#date_start, #date_end').addClass('border-danger')
                        $('#msg').text(resp.msg)
                    }else{
                        alert_toast('An error occured while checking availability','error')
                    }
                    $('#check-availability-loader').addClass('d-none')
                    $('#uni_modal button').attr('disabled',false)
                    calc_rent_days()
                }
            })
            
        })
        $('#book-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            if(_this.find('.border-danger').length > 0){
                alert_toast('Can\'t proceed submission due to invalid inputs in some fields.','warning')
                return false;
            }
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_booking",
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
                        end_loader()
                        $('#uni_modal').modal('hide')
                        setTimeout(() => {
                            uni_modal('','success_booking.php')
                        }, 500);
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