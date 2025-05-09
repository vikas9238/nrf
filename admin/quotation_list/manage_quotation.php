<style>
    #thumbnail-img {
        max-height: 35vh
    }

    .img-display {
        width: calc(100%);
        height: 20vh;
        object-fit: scale-down;
        object-position: center center
    }
</style>
<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `quotation_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?>Quotation</h3>
    </div>
    <div class="card-body">
        <form action="" id="quotation-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <label for="product_id" class="control-label">Products</label>
                <select name="product_id" id="product_id" class="custom-select select2" required>
                    <option value=""></option>
                    <?php
                    $qry = $conn->query("SELECT * FROM `product` where status = 1 " . (isset($product_id) ? "or id = '{$product_id}'" : "") . " order by category asc");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($product_id) && $product_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['category'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="company_id" class="control-label">Company</label>
                <select name="company_id" id="company_id" class="custom-select select2" required>
                    <option value="" selected="" disabled="">Select Category First</option>
                    <?php
                    $qry = $conn->query("SELECT * FROM `company_list` where status = 1 " . (isset($company_id) ? "or id = '{$company_id}'" : "") . " order by `name` asc");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($company_id) && $company_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                    <?php
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="po_quantity" class="control-label">PO Quantity</label>
                <input type="text" pattern="[0-9]+" name="po_quantity" id="po_quantity" class="form-control form no-resize text-right" value="<?php echo isset($po_quantity) ? $po_quantity : 0; ?>" required>
            </div>
            <div class="form-group">
                <label for="po_rate" class="control-label">PO Rate</label>
                <input type="text" pattern="[0-9]+" name="po_rate" id="po_rate" class="form-control form no-resize text-right" value="<?php echo isset($po_rate) ? $po_rate : 0; ?>" required>
            </div>
            <div class="form-group">
                <label for="po_unit" class="control-label">PO Unit</label>
                <select name="po_unit" id="po_unit" class="custom-select selevt">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>TON</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>CFT</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sold" class="control-label">Unit Sold</label>
                <input type="text" pattern="[0-9]+" name="" id="sold" class="form-control form no-resize text-right" value="<?php echo $paid_amount = $conn->query("SELECT sum(approved_quantity) as quantity from `booking_list` where quotation_id = '{$_GET['id']}' and (status = 1 or status=4) ")->fetch_assoc()['quantity']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="quantity" class="control-label">Available Unit</label>
                <input type="text" pattern="[0-9]+" name="quantity" id="quantity" class="form-control form no-resize text-right" value="<?php echo isset($quantity) ? $quantity : 0; ?>" required>
            </div>
            <div class="form-group">
                <label for="daily_rate" class="control-label">Daily Rate</label>
                <input type="text" pattern="[0-9]+" name="daily_rate" id="daily_rate" class="form-control form no-resize text-right" value="<?php echo isset($daily_rate) ? $daily_rate : 0; ?>" required>
            </div>
            <div class="form-group">
                <label for="address" class="control-label">Address</label>
                <input type="text" name="address" id="address" class="form-control form no-resize" value="<?php echo isset($address) ? $address : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Complete</option>
                </select>
            </div>
            <!-- <div class="form-group">
                <label for="" class="control-label">Upload PO</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="upload_po" name="upload_po" accept=".pdf" value="<?php echo base_url . 'uploads/' . $id . '/' . $id . '.pdf' ?>">
                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                </div>
            </div> -->

            <div class="form-group">
                <label for="" class="control-label">Thumbnail</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="thumbnail" accept="image/png,image/jpeg" onchange="displaythmb(this,$(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="form-group text-center mt-2 col-md-8">
                <img src="<?php echo validate_image(isset($id) ? 'uploads/thumbnails/' . $id . '.png' : '') ?>" class="bg-dark bg-gradient img-fluid border border-dark" id="thumbnail-img" alt="Thumbnail">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Images</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="images[]" accept="image/png,image/jpeg" onchange="displayImg(this,$(this))" multiple="multiple">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="form-group my-1 row mx-0 row row-cols-4 row cols-sm-1 gx-2 gy-2" id="image-holder"></div>
            <?php
            if (isset($id)) :
                $upload_path = "uploads/" . $id;
                if (is_dir(base_app . $upload_path)) :
            ?>
                    <?php

                    $file = scandir(base_app . $upload_path);
                    foreach ($file as $img) :
                        if (in_array($img, array('.', '..')))
                            continue;


                    ?>
                        <div class="d-flex w-100 align-items-center img-item">
                            <span><img src="<?php echo base_url . $upload_path . '/' . $img ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
                            <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app . $upload_path . '/' . $img ?>"><i class="fa fa-trash"></i></button></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="quotation-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=quotation_list">Cancel</a>
    </div>
</div>
<script>
    function displaythmb(input, _this) {
        var fnames = []
        Object.keys(input.files).map(k => {
            fnames.push(input.files[k].name)
        })
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnail-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
        _this.siblings('.custom-file-label').html(JSON.stringify(fnames))

    }

    function displayImg(input, _this) {
        var fnames = []
        Object.keys(input.files).map(k => {
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(JSON.stringify(fnames))
        $('#image-holder').html('')
        for (var i = 0; i < input.files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var el = $('<div class="col">')
                el.append('<img class="lazyload img-display bg-dark bg-gradient" src="' + e.target.result + '">')
                $('#image-holder').append(el)
            }

            reader.readAsDataURL(input.files[i]);
        }

    }

    function delete_img($path) {
        start_loader()

        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=delete_img',
            data: {
                path: $path
            },
            method: 'POST',
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured while deleting an Image", "error");
                end_loader()
            },
            success: function(resp) {
                $('.modal').modal('hide')
                if (typeof resp == 'object' && resp.status == 'success') {
                    $('[data-path="' + $path + '"]').closest('.img-item').hide('slow', function() {
                        $('[data-path="' + $path + '"]').closest('.img-item').remove()
                    })
                    alert_toast("Image Successfully Deleted", "success");
                } else {
                    console.log(resp)
                    alert_toast("An error occured while deleting an Image", "error");
                }
                end_loader()
            }
        })
    }
    $(document).ready(function() {
        $('.rem_img').click(function() {
            _conf("Are You sure to delete this image permanently?", 'delete_img', ["'" + $(this).attr('data-path') + "'"])
        })
        $('.select2').select2({
            placeholder: "Please Select here",
            width: "relative"
        })
        $('#quotation-form').submit(function(e) {
            e.preventDefault();
            var quantity = $('#quantity').val();
            var po_quantity = $('#po_quantity').val();
            var sold = $('#sold').val();
            var total = parseInt(quantity) + parseInt(sold);
            if (parseInt(po_quantity) < parseInt(total)) {
                alert_toast("PO Quantity is smaller than available quantity", 'error');
                quantity = $('#quantity').val(po_quantity - sold);
                return false;
            }
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_quotation",
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
                        location.href = "./?page=quotation_list";
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