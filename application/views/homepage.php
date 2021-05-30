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
</head>
<style>
  body {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: 100%;
  }
</style>

<body>
  <div id="body">
    <main role="main">
      <section class=" text-center bg-transparent mx-5" style="left:60%">
        <div class="container" style="width:50%">
          <img src="<?= img_asset_url(); ?>thelogo.png" class="img-fluid rounded-circle float-top">
          <?php if (is_null($this->session->custId)) {
            echo "
              <p>
              <a href=" . site_url('Home/signUp') . " class=' my-3 mx-3 btn btn-light enable'>Sign-up</a>
              <a href=" . site_url('Home/login') . " class=' my-3 mx-3 btn btn-light enable'>Login</a>
            </p>";
          } else {
            echo "<p class='display-4  text-light'>Signed in as <br>" . $this->session->name .
              "</p>
            <div class='mx-auto  col-sm-6  lead text-light my-5'>       
            <a href=" . site_url('Home/logout') . " class='btn btn-secondary my-2 enable'>Log-out</a>        
            </div>";
          } ?>
        </div>
      </section>
    </main>
  </div>
</body>