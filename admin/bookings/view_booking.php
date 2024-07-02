<?php 
require_once('../../config.php');
?>
<?php 
if(!isset($_GET['id'])){
    $_settings->set_flashdata('error','No Booking ID Provided.');
    redirect('admin/?page=bookings');
}
$booking = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client,c.address,c.email,c.contact from `booking_list` r inner join clients c on c.id = r.client_id where r.id = '{$_GET['id']}' ");
if($booking->num_rows > 0){
    foreach($booking->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}else{
    $_settings->set_flashdata('error','Booking ID provided is Unknown');
    redirect('admin/?page=bookings');
}
if(isset($quotation_id)){
    $qur = $conn->query("SELECT b.*,c.category, bb.name from `quotation_list` b inner join product c on b.product_id = c.id inner join company_list bb on b.company_id = bb.id where b.id = '{$quotation_id}' ");
    if($qur->num_rows > 0){
        foreach($qur->fetch_assoc() as $k => $v){
            $quotation_meta[$k]=stripslashes($v);
        }
    }
}
?>
<div class="conitaner-fluid px-3 py-2">
    <div class="row">
        <div class="col-md-6">
            <p><b>Client Name:</b> <?php echo $client ?></p>
            <p><b>Client Email:</b> <?php echo $email ?></p>
            <p><b>Client Contact:</b> <?php echo $contact ?></p>
            <p><b>Client Address:</b> <?php echo $address ?></p>
            <img src="<?php echo base_url.'uploads/screenshot/'.$transaction.'.png' ?>" alt="screenshot" height="250" width="300">
        </div>
        <div class="col-md-6">
            <p><b>Product:</b> <?php echo $quotation_meta['category'] ?></p>
            <p><b>Company:</b> <?php echo $quotation_meta['name'] ?></p>
            <p><b>PO Rate:</b> <?php echo $quotation_meta['po_rate'] ?></p>
            <p><b>Daily Rate:</b> <?php echo number_format($daily_rate) ?></p>
            <p><b>Order Quantity:</b> <?php echo $quantity ?> <?php if($quotation_meta['po_unit']==1): ?> TON<?php else: ?> CFT<?php endif; ?></p>
            <p><b>Investe Amount:</b> <?php echo $daily_rate*$quantity ?></p>
            <p><b>Payment Mode:</b> <?php echo $mode ?></p>
            <p><b>Client Profit:</b> <?php echo ($po_rate-$daily_rate)*$quantity/2 ?></p><hr>
            <p><b>Approved Quantity:</b> <?php echo $approved_quantity ?> <?php if($quotation_meta['po_unit']==1): ?> TON<?php else: ?> CFT<?php endif; ?></p>
            <p><b>Investe Amount:</b> <?php echo $daily_rate*$approved_quantity ?></p>
            <p><b>Client Profit:</b> <?php echo ($po_rate-$daily_rate)*$approved_quantity/2 ?>
            <p class="bg-primary"><b>Refund Remaining Amount:</b> <?php echo ($daily_rate*$quantity)-($daily_rate*$approved_quantity) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-3">Booking Status:</div>
        <div class="col-auto">
        <?php 
            switch($status){
                case '0':
                    echo '<span class="badge badge-light text-dark">Pending</span>';
                break;
                case '1':
                    echo '<span class="badge badge-primary">Confirmed</span>';
                break;
                case '2':
                    echo '<span class="badge badge-danger">Cancelled</span>';
                break;
                case '3':
                    echo '<span class="badge badge-success">Active</span>';
                break;
            }
        ?>
        </div>
            
    </div>
</div>
<div class="modal-footer">
    <?php if(!isset($_GET['view'])): ?>
        <?php if($status != 1): ?>
        <button type="button" id="update" class="btn btn-sm btn-flat btn-primary">Edit</button>
        <?php endif; ?>
    <?php endif; ?>
    <button type="button" class="btn btn-secondary btn-sm btn-flat" data-dismiss="modal" onclick="$('.nav-bar').removeClass('d-none')">Close</button>
</div>
<style>
    #uni_modal>.modal-dialog>.modal-content>.modal-footer{
        display:none;
    }
    #uni_modal .modal-body{
        padding:0;
    }
</style>
<script>
    $(function(){
        $('#update').click(function(){
            uni_modal("Edit Booking Details", "./bookings/manage_booking.php?id=<?php echo $id ?>")
        })
    })
</script>