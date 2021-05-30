<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <!-- Bootstrap core CSS -->
  <link href="<?= css_asset_url(); ?>bootstrap.min.css" rel="stylesheet">
  <!-- load JQuery -->
  <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
  </script>
  <style>
    a {
      font-size: 20px;
    }

    a:hover {
      font-size: 30px;
    }
  </style>
</head>
<div class="float-left m-5">
  <span class="m-2"><a class="lead text-light" style="text-decoration: none;" href="<?= site_url('Product/loadProducts/' . $product->TYPE) ?>">
      <?= $product->TYPE ?></a></span>
  <span class="m-2"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
      <path d="M12.14 8.753l-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
    </svg>
  </span>
  <span class="lead text-danger " style="font-size:40px"><?= $product->NAME ?></span>
</div>

<table class="lead text-light table-responsive m-auto" style="width:80%">
  <td style="width:50%">
    <img src="<?= img_asset_url() . $product->IMG ?>" class="img-fluid rounded" alt="Deal">
    <input type=hidden id="prodId" value='<?= $product->ID ?>'>
    <p><?= $product->DESCRIPTION ?></p>

    <?php
    if ($product->TYPE == "PIZZA") {
      echo '
    <div class="my-3 mb-5 h2">
      Selected topping: <span id="topping"></span>
    </div>';
    }
    ?>
  </td>
  <td>
    <table>
      <tr>
        <div class="d-flex text-center justify-content-center">
          <?php
          foreach ($details as $row) {
            echo '
                <div class="p-2 mx-3 flex-wrap text-light bg-transparent prod-detail"  >
                  <input type=hidden class="detailId" value=' . $row->DETAIL_ID . '>';
            if ($product->TYPE == "PIZZA") {
              echo
                '<img src="' . img_asset_url() . $row->SIZE . '.png" class="img-fluid rounded-circle" alt="' . $row->SIZE . '" style="width: 50%;">';
            }
            echo
              '<p class="size">' . $row->SIZE . '</p>      
                  <p class="price">' . $row->UNIT_PRICE . '</p>                         
                 </div>';
          }
          ?>
        </div>
      </tr>
      <tr>
        <div class=" pl-5 d-flex flex-wrap text-center justify-content-center">
          <?php
          if (!is_null($toppings)) {
            foreach ($toppings as $row) {
              echo '
                 <div class="p-2 mt-3 mb-1 text-light bg-transparent toppings "  >
                  <input type=hidden class="toppingId" value=' . $row->ID . '>
                  <img src="' . img_asset_url() . $row->IMG . '" class="rounded-circle" alt="' . $row->NAME . '" style="width:50px">
                  <p class="name" style="font-size:15px">' . $row->NAME . '</p>      
                  <p class="price">' . $row->UNIT_PRICE . '</p>                         
                </div>';
            }
          }
          ?>
        </div>
        <div class="my-5">
          <?php
          if ($product->TYPE == "PIZZA") {
            echo '
            Add topping?
            <input type="checkbox" id="addTopping">';
          }
          ?>
        </div>
      </tr>
    </table>
    <div class="d-flex mb-4 flex-row justify-content-center">
      <div class="p-2"><button type="button" id="qtyplus" class="btn btn-sm btn-outline-secondary">+</button></div>
      <div class="p-2">
        <div id="qty"></div>
      </div>
      <div class="p-2"><button type="button" id="qtyminus" class="btn btn-sm btn-outline-secondary">-</button></div>
    </div>
    <form action="<?= site_url('Cart/loadCart') ?>" method="POST">
      <button type="submit" id="add" class=" btn btn-sm btn-outline-secondary p-3">Add to cart</button>
    </form>
  </td>
</table>
<script>
  var qty = 1;
  var addTopping = false;
  $('#qty').text(qty);
  $('button').prop("disabled", true);
  $("#addTopping").attr("disabled", true);
  $('.toppings').hide();

  $("#qtyplus").click(function() {
    if (qty < 99) {
      $('#qty').text(++qty);
    }
  });

  $("#qtyminus").click(function() {
    if (qty > 1) {
      $('#qty').text(qty -= 1);
    }
  });

  $('.prod-detail').click(function() {
    $('.prod-detail').removeAttr('id');
    $('.prod-detail').removeClass('border border-light rounded text-light');
    $(this).attr('id', "selectedSize");
    $(this).addClass('border border-light rounded');
    $("#addTopping").removeAttr("disabled");
    if (!addTopping) {
      $('button').prop("disabled", false);
    }
  });

  $("#addTopping").change(function() {
    if (this.checked) {
      $('.toppings').show();
      addTopping = true;
      $('button').prop("disabled", true);
    } else {
      $('.toppings').hide();
      addTopping = false;
      $('.toppings').removeAttr('id');
      $('button').prop("disabled", false);
      $('#topping').text(null);
    }
  });

  $('.toppings').click(function() {
    $('.toppings').removeAttr('id');
    $('.toppings').removeClass('border border-light rounded text-light');
    $(this).attr('id', "selectedTopping");
    $(this).addClass('border border-light rounded');
    $('button').prop("disabled", false);
    $('#topping').text($("#selectedTopping .name").text());
  });

  $('#add').click(function() {
    var oderItemData = {
      'PROD_DETAIL_ID': $('#selectedSize .detailId').val(),
      'QTY': qty,
      'PROD_ID': $('#prodId').val(),
      'SIZE': $('#selectedSize .size').text(),
      'PRICE': $("#selectedSize .price").text(),
      'IMG': '<?= $product->IMG ?>',
      'NAME': '<?= $product->NAME ?>'
    };
    if (addTopping) {
      oderItemData['TOPPING_ID'] = $('#selectedTopping .toppingId').val();
      oderItemData['TOPPING_PRICE'] = $("#selectedTopping .price").text();
      oderItemData['TOPPING_NAME'] = $("#selectedTopping .name").text();
    }
    $.each(oderItemData, function(key, data) {
      $('<input />').attr('type', 'hidden')
        .attr('name', key)
        .attr('value', data)
        .appendTo('#add');
    });

    return true;
  });
</Script>