<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link href="<?= css_asset_url(); ?>bootstrap.min.css" rel="stylesheet">
    <!-- load Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <h1 class="display-4 float-left m-5 text-light">Login</h1>
    <div class="mx-auto  col-sm-6  lead text-light my-5">
        <form action="<?= site_url('Customer/login') ?>" method="POST">
            <div id="name" class="form-group row">
                <label for="name" class="col-sm-6 col-form-label">Username(Emial)</label>
                <div class="col-sm-10">
                    <input id="username" type="text" class="form-control" name="name" placeholder="e.g. janedoe@example.com" required>
                </div>
            </div>
            <div id="password" class="form-group row">
                <label for="password" class="col-sm-6 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input id="psw" type="password" class="form-control" name="password" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-success">Login <span class="fa fa-arrow-right"></span></button>
        </form>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.form-group').removeClass('has-error');
        $('.form-text').remove();
        $('#username').change(function(event) {
            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
        });
        $("#psw").change(function() {
            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
        });
        $('form').submit(function(event) {

            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
            var formData = {
                'USERNAME': $('#username').val(),
                'PASSWORD': $('#psw').val()
            };
            $.ajax({
                    type: 'POST',
                    url: '<?= site_url('Customer/login') ?>',
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                .done(function(data) {
                    if (data.userExists) {
                        if (data.loggedin) {
                            location.href = "<?= site_url('Cart') ?>";
                        } else {
                            $('#password').addClass('has-error');
                            $('#password').append('<br><small class="form-text text-danger">' + "Incorrect password." + '</small>');
                        }
                    } else {
                        $('#name').addClass('has-error');
                        $('#name').append('<br><small class="form-text text-danger">' + "Invalid username." + '</small>');
                    }
                })
                .fail(function(data) {
                    $('form').html('<br><small class="form-text text-danger">' + "Could not reach server. Please, try again later." + '</small>');
                });
            event.preventDefault();
        });

    });
</script>