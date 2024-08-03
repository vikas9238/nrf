<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Compose New Message</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <input class="form-control" name="subject" placeholder="Subject:">
        </div>
        <div class="form-group">
            <textarea id="compose-textarea" class="form-control">

            </textarea>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button type="submit" id="send" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.select2').select2({
            placeholder: "To",
            width: "relative"
        })
        $('#compose-textarea').summernote({
            height: 200
        })
        $('#send').click(function() {
            $('#compose-textarea').val($('#compose-textarea').summernote('code'))
            var subject = $('input[name="subject"]').val();
            var message = $('#compose-textarea').val();
            var formData = new FormData();
            formData.append('subject', subject);
            formData.append('message', message);
            start_loader()
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=all_user_mail",
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