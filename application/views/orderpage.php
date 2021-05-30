<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <!-- Bootstrap core CSS -->
  <link href="<?= css_asset_url(); ?>bootstrap.min.css" rel="stylesheet">
</head>
<?php
echo '
<table>
<td style="width:40%">
<p class="display-4 text-light">Invoice<p>
<div class="bg-transparent border border-secondary rounded text-left p-2 m-auto text-secondary lead " style="width:50%;font-size:17px">';
foreach ($order as $key => $value) {
  echo '<p>' . $key . '   :     <span>' . $value . '</span></p>';
}
echo '<p class="text-light">The time is ' . date("H:i:s", strtotime("now")) . ',
the order willl be delivered by ' . date("H:i:s", strtotime("+30 minutes")) . '</p>';
echo '</div></td>
<td>
<table class="table text-light lead float-left">
  <thead>
    <tr>
      <th scope="col">Product Name</th>
      <th scope="col">Size</th>
      <th scope="col">Quantity</th>
      <th scope="col">Unit Price</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>';
foreach ($orderItems as $row) {
  echo '
    <tr>
      <th scope="row">' . $row['NAME'] . '</th>
      <td>' . $row['SIZE'] . '</td>
      <td>' . $row['QTY'] . '</td>
      <td>' . $row['UNIT_PRICE'] . '</td>
      <td>' . "Rs. " . $row['TOTAL'] . '</td>';
  if (isset($row['topping'])) {
    echo '<tr class="text-secondary">
<td>Topping: ' . $row['topping']['NAME'] . '</td>
<td>Unit price: ' . $row['topping']['PRICE'] . '<td>
<td>Total price: ' . $row['topping']['PRICE'] * $row['QTY'] . '</td></tr>';
  }
  echo '</tr>';
}
echo '
  </tbody>
</table>
    <p class="display-4 text-light">Net Total = Rs. ' . $order['Total Bill Value   Rs.'] . '</p>
</td>
</table>
';
?>