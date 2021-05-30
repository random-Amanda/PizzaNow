<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PizzaNow</title>
  <!-- Bootstrap core CSS -->
  <link href="<?= css_asset_url(); ?>bootstrap.min.css" rel="stylesheet">
  <!-- Jquery Library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    .page {
      background-color: black;
    }
  </style>
</head>

<body class="page text-center">
  <header>
    <nav class=" sticky-top navbar navbar-dark bg-transparent lead " style="font-size:20px">
      <div class="container d-flex flex-column flex-md-row justify-content-between text-light">
        <a class="py-2 enable" href="<?= site_url('Home') ?>" aria-label="Product">
          <img src="<?= img_asset_url(); ?>logo.png" width="70" height="70" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mx-auto" role="img" viewBox="0 0 24 24" focusable="false">
          <circle cx="12" cy="12" r="10" />
          <path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94" />
          </svg>
        </a>
        <a class="py-2 d-none d-md-inline-block btn btn-outline-light" href="<?= site_url('Product/loadProducts/PIZZA') ?>">Pizza</a>
        <a class="py-2 d-none d-md-inline-block btn btn-outline-light" href="<?= site_url('Product/loadProducts/SIDE') ?>">Sides</a>
        <a class="py-2 d-none d-md-inline-block btn btn-outline-light" href="<?= site_url('Product/loadProducts/DRINK') ?>">Drinks</a>
        <a class="py-2 d-none d-md-inline-block btn btn-outline-light" href="<?= site_url('Deal/loadDeals') ?>">Deals</a>
        <a class="py-2 d-none d-md-inline-block" href="<?= site_url('Cart') ?>"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
          </svg></a>
        <div>
          <a class="py-2 d-none d-md-inline-block" href="<?= site_url('Customer') ?>">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-circle" fill="white" xmlns="http://www.w3.org/2000/svg">
              <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z" />
              <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
              <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z" />
            </svg>
          </a>
          <p>
            <?= $this->session->name ?>
          </p>
        </div>
      </div>
    </nav>
  </header>
  <?php
  ?>