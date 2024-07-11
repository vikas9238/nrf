<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Compose New Message</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group">
            <select name="email" id="email" class="custom-select select2" required>
                <option value=""></option>
                <?php
                $qry = $conn->query("SELECT * FROM `clients` where status = 1  order by firstname asc");
                while ($row = $qry->fetch_assoc()) :
                ?>
                    <option value="<?php echo $row['email'] ?>"><?php echo $row['email'] ?> (<?php echo $row['firstname'] . $row['lastname'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <input class="form-control" name="subject" placeholder="Subject:">
        </div>
        <div class="form-group">
            <textarea id="compose-textarea" class="form-control">

            </textarea>
        </div>
        <!-- <div class="form-group">
            <div class="btn btn-default btn-file">
                <i class="fas fa-paperclip"></i> Attachment
                <input type="file" name="attachment">
            </div>
            <p class="help-block">Max. 32MB</p>
        </div> -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="float-right">
            <!-- <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button> -->
            <button type="submit" id="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
        </div>
        <!-- <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button> -->
    </div>
    <!-- /.card-footer -->
</div>
<!-- /.card -->
<script>
    $(function() {
        //Add text editor
        $('.select2').select2({
            placeholder: "To",
            width: "relative"
        })
        $('#compose-textarea').summernote({
            height: 200
        })
        $('#send').click(function() {
            $('#compose-textarea').val($('#compose-textarea').summernote('code'))
            var to = $('#email').val();
            var subject = $('input[name="subject"]').val();
            var message = $('#compose-textarea').val();
            // var attachment = $('input[name="attachment"]').val();
            // var _attachment = $('input[name="attachment"]')[0].files[0];
            var formData = new FormData();
            formData.append('to', to);
            formData.append('subject', subject);
            formData.append('message', message);
            // formData.append('attachment', _attachment);
            start_loader()
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=custom_mail",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Email successfully sent.", 'success')
                        setTimeout(function() {
                            location.reload()
                        }, 1500)
                    } else {
                        alert_toast("An error occured", 'error')
                        end_loader()
                    }
                }
            })
        })
    })
</script>