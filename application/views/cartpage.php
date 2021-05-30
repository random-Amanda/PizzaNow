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
    <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
</head>
<div id="body">
    <?php
    $total = 0.00;
    echo '<div class=" flex-column bg-transparent text-light m-auto" style="width: 50%;">
    <span class="display-3">Cart</span>    
    <div id="message"></div>';
    if (!is_null($this->session->userdata('tempItem'))) {
        $item = $this->session->userdata('tempItem');
        echo '<div class="card bg-transparent m-3 ">
            <div class="row no-gutters border border-light m-3 text-light">
              <div class="col-sm-3 m-auto">
                <img  src="' . img_asset_url() . $item['IMG'] . '" class="card-img" alt="' . $item['IMG'] . '">
                <input type=hidden id="image" value=' . $item['IMG']  . '>
              </div>
              <div class="col-sm-5">
                <div class="card-body">';
        if (isset($item['SIZE'])) {
            echo '<h5 class="card-title" id="prodName">' . $item['NAME'] . '   (' . $item['SIZE'] . ')</h5>';
        } else {
            echo '<h5 class="card-title" id="prodName">' . $item['NAME'] . '</h5>';
        }
        echo '<span class="card-text">Unit price:  <span id="price">' . $item['PRICE'] . '</span></span><br>
                  <span class="card-text">Quantity:  <span id="qty">' . $item['QTY'] . '</span></span><br>';
        if (isset($item['TOPPING_PRICE'])) {
            echo '<span class="card-text text-muted"> Topping : <span id="topping">' . $item['TOPPING_NAME'] . '</span></span><br>
                    <span class="card-text text-muted"> Topping Price:  <span id="toppingPrice">' . $item['TOPPING_PRICE'] . '</span></span><br>
                    <input type=hidden id="toppingId" value=' . $item['TOPPING_ID']  . '>';
        }
        echo '<p class="card-text">Total Price:  <span id="total">' . $item['itemPrice'] . '</span></p>';
        if (isset($item['PROD_ID'])) {
            echo '<input type=hidden id="prodId" value=' . $item['PROD_ID'] . '>';
        }
        if (isset($item['DEAL_ID'])) {
            echo '<input type=hidden id="dealId" value=' . $item['DEAL_ID'] . '>';
        }
        if (isset($item['PROD_DETAIL_ID'])) {
            echo '<input type=hidden id="prodDetailId" value=' . $item['PROD_DETAIL_ID'] . '>';
        }
        if (isset($item['SIZE'])) {
            echo '<input type=hidden id="size" value=' . $item['SIZE']  . '>';
        }
        echo '</div>
            </div>
            <div class="col-sm-3 m-auto">
            <button type="button" id="add" class="btn btn-sm btn-outline-success">Confirm Additiion</button>
            </div>
            </div>';
    }
    if (!is_null($this->session->userdata('order'))) {
        echo '<div class="card bg-transparent m-3 ">';
        foreach ($this->session->userdata('order') as $index => $cartitem) {
            $total += $cartitem['TOTAL'];
            echo ' 
            <div class="row no-gutters border border-light m-3 text-light">
              <div class="col-sm-3 m-auto">
                <img  src="' . img_asset_url() . $cartitem['IMG'] . '" class="card-img" alt="' . $cartitem['IMG'] . '">
              </div>
              <div class="col-sm-5">
                <div class="card-body">
                  <h5 class="card-title">' . $cartitem['NAME'] . '';
            echo '
                  </h5>
                  <span class="card-text">Unit price:  ' . $cartitem['PRICE'] . '</span><br>
                  <span class="card-text">Quantity:  ' . $cartitem['QTY'] . '</span><br>';
            if (isset($cartitem['TOPPING_PRICE'])) {
                echo '<span class="card-text text-muted"> Topping : ' . $cartitem['TOPPING_NAME'] . '</span><br>
                    <span class="card-text text-muted"> Topping Price:  ' . $cartitem['TOPPING_PRICE'] . '</span><br>';
            }
            echo '<p class="card-text">Total Price:  ' . $cartitem['TOTAL'] . '</p>
            </div>
            </div>
            <div class="col-sm-3 m-auto">
            <form action="' . site_url('Cart/remove') . '" method="POST">
                        <input type=hidden name="index" value=' . $index . '>
                        <button type="submit" class="remove btn btn-danger">Remove from cart</button>
                    </form>
            </div>
            </div>';
        }
    }
    if (!$this->session->userdata('order') && is_null($this->session->userdata('tempItem'))) {
        echo "<p class='m-2 text-secondary'>Cart is EMPTY ....<p>";
    }
    echo '</div>';
    echo '<div class=" bg-transparent text-light lead" style="position: fixed; top:50%;left:10%;">';
    log_message("info", "REFERRER ::: " . $this->session->referrer_url);
    if ($this->session->referrer_url) {
        log_message("info", "REFERRER ::: " . $this->session->referrer_url);
        echo '<a href="' . $this->session->userdata('referrer_url') . '" class="p-2 btn  btn-outline-secondary my-2 enable">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-bar-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5zM10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5z"/>
        </svg>
        Back to Menu</a>';
    }
    echo '</div>';
    echo '<div class=" bg-transparent text-light lead container" style="position: fixed; top:40%;left:80%;">
          <div class="row"><p class=" lead" style="font-size:30px">Net Total: RS. ' . $total . '</p></div>';
    echo '<div class="row">';
    if (!$this->session->custId) {
        echo '<a href="' . site_url('Home/signUp') . '" class="p-2 btn  btn-success my-2 enable">        
        Checkout
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-bar-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8zm-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5z"/>
        </svg></a>';
    } else {
        echo '<button type="button" id="checkout" class="btn btn-sm btn-outline-success">
        Checkout
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-bar-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8zm-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5z"/>
        </svg></button>';
    }
    echo '</div></div>';
    ?>
</div>
<script>
    $('#add').click(function(event) {
        var oderItemData = {
            'QTY': $('#qty').text(),
            'PRICE': $('#price').text(),
            'IMG': $('#image').val(),
            'NAME': $('#prodName').text(),
            'TOTAL': $('#total').text()
        };
        if ($('#prodId').length) {
            oderItemData['PROD_DETAIL_ID'] = $('#prodDetailId').val(),
                oderItemData['PROD_ID'] = $('#prodId').val(),
                oderItemData['SIZE'] = $('#size').val()
        }
        if ($('#dealId').length) {
            oderItemData['DEAL_ID'] = $('#dealId').val()
        }
        if ($('#topping').length) {
            oderItemData['TOPPING_ID'] = $('#toppingId').val();
            oderItemData['TOPPING_PRICE'] = $('#toppingPrice').text();
            oderItemData['TOPPING_NAME'] = $('#topping').text();
        }
        $.ajax({
                type: 'POST',
                url: '<?= site_url('Cart/add') ?>',
                data: oderItemData,
                dataType: 'json',
                encode: true
            })
            .done(function(data) {
                if (data.error) {
                    $('#message').addClass('has-error');
                    $('#message').append('<div class="help-block alert-danger">' + "Could not add to cart." + '</div>');
                } else {
                    location.href = "<?= site_url('Cart') ?>";
                }
            })
            .fail(function(data) {
                $('#message').html('<div class="alert alert-danger">Could not reach server, please try again later.</div>');
            });
        event.preventDefault();
    });
    $('#checkout').click(function(event) {
        $.ajax({
                type: 'GET',
                url: '<?= site_url('Cart/checkout') ?>',
                dataType: 'json',
                encode: true
            })
            .done(function(data) {
                if (data.error) {
                    $('#message').addClass('has-error');
                    $('#message').append('<div class="help-block alert-danger">' + data.error + '</div>');
                } else {
                    location.href = "<?= site_url('Order/viewReceipt/') ?>" + data.orderId;
                }
            })
            .fail(function(data) {
                $('#message').html('<div class="alert alert-danger">Could not reach server, please try again later.</div>');
            });
        event.preventDefault();
    });
    $('form').submit(function() {
        $("#body").fadeOut(800, function() {
            $this.html().fadeIn();

        });
    });
</script>