<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>PizzaNow</title>
  <!-- Bootstrap core CSS -->
  <link href="<?= css_asset_url(); ?>bootstrap.min.css" rel="stylesheet">
  <!-- load Jquery -->
  <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
  </script>
  <style>
    .page {
      background-color: black;
    }
  </style>
</head>

<body class="page">
  <div class="d-flex flex-wrap justify-content-center text-secondary my-3 lead">
    <?php
    foreach ($deals as $row) {
      echo '
        <div class="p-2 mr-5 deal" style="width: 20%;height:25%;">
            <img src="' . img_asset_url() . $row->IMG . '" class="img-fluid rounded image" alt="Deal">            
            <p class="name h3">' . $row->NAME . '</p>      
            <p>' . $row->DEAL_DESC . '</p>
            <p> Price: <span class="price">' . $row->UNIT_PRICE . '</span></p>
            <input type=hidden class="dealId" value=' .  $row->DEAL_ID . '>
            <input type=hidden class="unitPrice" value=' .   $row->UNIT_PRICE  . '>
            <input type=hidden class="dealimage" value=' .   $row->IMG   . '>
            <div class="actions btn-group mb-2">
              <button type="button" class=" plus btn btn-sm btn-outline-secondary">+</button>
              <div class="qty ml-4"></div>
              <button type="button" class=" minus btn btn-sm btn-outline-secondary ml-4">-</button>
              <form action="' . site_url('Cart/loadCart') . '" method="POST">
                <button type="submit" class="add btn btn-sm btn-outline-secondary ml-4">Add to cart</button>
              </form>
            </div>         
        </div> 
        ';
    }
    ?>
  </div>
</body>
<script>
  var qty = 1;
  var price = 0.00;
  $('.actions').hide();

  $('.deal').click(function() {
    $('.deal').removeAttr('id');
    $('.actions').hide();
    $(this).attr('id', "selectedDeal");
    price = $('#selectedDeal .unitPrice').val();
    $('#selectedDeal .actions').show();
    $('#selectedDeal .qty').text(qty);
  });

  $(".plus").click(function() {
    if (qty < 5) {
      $('#selectedDeal .qty').text(++qty);
      $('#selectedDeal .price').text(qty * price);
    }
  });

  $(".minus").click(function() {
    if (qty > 1) {
      $('#selectedDeal .qty').text(qty -= 1);
      $('#selectedDeal .price').text(qty * price);
    }
  });

  $(".deal").hover(function() {
      $(this).addClass('border border-light rounded text-light');
    },
    function() {
      $(this).removeClass('border border-light rounded text-light');
    }
  );

  $('.add').click(function() {
    var dealData = {
      'DEAL_ID': $('#selectedDeal .dealId').val(),
      'QTY': qty,
      'PRICE': $("#selectedDeal .unitPrice").val(),
      'IMG': $("#selectedDeal .dealimage").val(),
      'NAME': $("#selectedDeal .name").text()
    };
    $.each(dealData, function(key, data) {
      $('<input />').attr('type', 'hidden')
        .attr('name', key)
        .attr('value', data)
        .appendTo('.add');
    });

    return true;
  });
</script>