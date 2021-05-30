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
</head>
<div class="my-3 text-center">
  <h class="display-3 text-danger"><?= $products[0]->PROD_TYPE ?></h>
</div>
<div class="d-flex flex-wrap mx-auto justify-content-center">
  <?php
  foreach ($products as $row) {
    echo '
        <div class=" item p-4 m-md-5 text-secondary" style="width: 25%; height:auto;">
        <div>
          <img  src="' . img_asset_url() . $row->IMG . '" class="img-fluid rounded" alt="' . $row->IMG . '">
        </div>         
          <p class=" text-center h3">' . $row->PROD_NAME . '</p>      
          <p class=" text-center lead">' . $row->PROD_DESC . '</p>
              <div class="d-flex justify-content-between align-items-center ">
              <a class="btn btn-outline-secondary mx-auto" href=' . site_url('Detail/loadProductDetails/' . $row->PROD_ID . '') . '>Select</a>                
              </div>            
         </div> 
        ';
  }
  ?>
</div>
<script>
  $(".item").hover(function() {
      $(this).addClass('border border-light rounded text-light');
    },
    function() {
      $(this).removeClass('border border-light rounded text-light');
    }
  );
</script>