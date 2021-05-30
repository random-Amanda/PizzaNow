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
    <h1 class="display-4 float-left m-5 text-light">Create <br>Account</h1>
    <div class="mx-auto  col-sm-6  lead text-light my-5">
        <form action="<?= site_url('Customer/add') ?>" method="POST">
            <div id="name" class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="e.g. Jane Doe" required>
                </div>
            </div>
            <div id="email" class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input id="username" type="email" name="email" class="form-control" placeholder="e.g. janedoe@example.com" required>
                </div>
            </div>
            <div id="password-group" class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input id="psw" type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
            </div>
            <div id="re-password-group" class="form-group row">
                <label for="re-password" class="col-sm-2 col-form-label">Re-enter Password</label>
                <div class="col-sm-10">
                    <input id="re-psw" type="password" name="re-password" class="form-control" placeholder="Re-enter password" required>
                </div>
            </div>
            <div id="address" class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" name="address" class="form-control" placeholder="Enter your Address" required>
                </div>
            </div>
            <div id="contact-group" class="form-group row">
                <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                <div class="col-sm-10">
                    <input type="text" id="contact" name="contact" class="form-control" placeholder="e.g. 071 234 567 8" required>
                </div>
            </div>

            <button type="submit" id="submit" class="btn btn-success">Sign-Up <span class="fa fa-arrow-right"></span></button>

        </form>

        Do you already Have an account? <a href="<?= site_url('Home/login') ?>" class="btn btn-primary my-2 enable">Login</a>

    </div>
</body>
<script>
    var error = false;
    var regex = /^\d*[.]?\d*$/;
    $(document).ready(function() {
        $('.form-group').removeClass('has-error');
        $('.form-text').remove();
        $('#username').change(function(event) {
            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
        });
        $("#contact").change(function() {
            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
            if (!regex.test($(this).val())) {
                $('#contact-group').addClass('has-error');
                $('#contact-group').append('<small class="form-text text-danger">' + "Invalid number." + '</small>');
                error = true;
            } else {
                error = false;
            }
        });
        $('#contact').change(function(event) {
            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
            if ($('#contact').val().length != 10) {
                $('#contact-group').addClass('has-error');
                $('#contact-group').append('<small class="form-text text-danger">' + "Invalid contact number." + '</small>');
                error = true;
            } else {
                error = false;
            }
        });
        $('#re-psw').change(function(event) {
            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
            if ($('#re-psw').val() != $('#psw').val()) {
                $('#re-password-group').addClass('has-error');
                $('#re-password-group').append('<small class="form-text text-danger">' + "Passwords do not match." + '</small>');
                error = true;
            } else {
                error = false;
            }
        });
        $('.form-group').change(function(event) {
            if (error) {
                $('#submit').prop("disabled", true);
            } else {
                $('#submit').prop("disabled", false);
            }
        });

        $('form').submit(function(event) {

            $('.form-group').removeClass('has-error');
            $('.form-text').remove();
            var userData = {
                'NAME': $('input[name=name]').val(),
                'USERNAME': $('input[name=email]').val(),
                'ADDRESS': $('input[name=address]').val(),
                'PASSWORD': $('#psw').val(),
                'CONTACT': $('#contact').val()
            };

            $.ajax({
                    type: 'POST',
                    url: '<?= site_url('Customer/add') ?>',
                    data: userData,
                    dataType: 'json',
                    encode: true
                })
                .done(function(data) {
                    if (data.userExists) {
                        if (data.creds) {
                            location.href = "<?= site_url('Cart') ?>";
                        } else {
                            $('#email').addClass('has-error');
                            $('#email').append('<small class="form-text text-danger">' + "An account with this email address already exists." + '</small>');
                        }
                    } else {
                        $('form').html('<small class="form-text text-danger">' + "Account creation was unsuccessful." + '</small>');
                    }

                })
                .fail(function(data) {
                    $('form').html('<small class="form-text text-danger">' + "Could not reach server. Try again later." + '</small>');
                });
            event.preventDefault();
        });

    });
</script>