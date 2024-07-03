<?php
require_once('../config.php');
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

$qry = $conn->query("SELECT b.*,c.firstname,c.lastname,c.email,c.contact,c.address,c.gender,co.name,p.category,q.address as location from `booking_list` b inner join quotation_list q on q.id=b.quotation_id inner join clients c on c.id = b.client_id inner join company_list co on co.id=q.company_id inner join product p on p.id=q.product_id where b.id = '{$_GET['id']}' ");
if ($qry->num_rows > 0) {
    foreach ($qry->fetch_assoc() as $k => $v) {
        $$k = $v;
    }
}
$html = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
    <style>
      body {
        margin: 0;
        padding: 0;
      }
      .invoice {
        text-align: center;
      }
      .invoice h1 {
        text-transform: uppercase;
        color: #333;
        margin-bottom: 10px;
      }
      .invoice .NRF {
        text-align: center;
        margin-bottom: 20px;
      }
      .invoice .NRF h2 {
        color: #3498db;
        margin-bottom: 5px;
        text-transform: uppercase;
      }
      .invoice .NRF p {
        margin: 5px 0;
        font-weight: bold;
      }
      .details {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 2px solid #333;
      }
      .details p {
        text-transform: capitalize;
      }
      .left {
        text-align: left;
        float: left;
      }
      .right {
        text-align: right;
        float: right;
      }
      .invoice table {
        border-collapse: collapse;
        margin-top: 20px;
      }
      .invoice table th,
      .invoice table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }
      .invoice table th {
        background-color: #f2f2f2;
        color: #333;
        text-transform: uppercase;
      }
      .invoice table td {
        background-color: #fff;
        color: #555;
      }
      .invoice table tbody {
        font-weight: bold;
      }
      .invoice .total {
        text-align: right;
      }
      .invoice .total p {
        color: #333;
        font-weight: bold;
      }
      .signature {
        margin-top: 40px;
        float: right;
      }
      .signature p {
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div class="invoice-container">
      <div class="invoice">
        <h1>Invoice</h1>
        <div class="NRF">
          <h2>NRF INDUSTRY AND TRADING PRIVATE LIMITED</h2>
          <p>
            <strong
              >Ram Nagar, Opp Jakkanpur Thana, Pathar Gali, Patna -
              800001</strong
            >
          </p>
          <p><strong>Email:</strong> contact@nrfindustry.in</p>
          <p><strong>Phone:</strong> +91-9876543210</p>
          <p><strong>GST No:</strong> 10AAGCN1641R1ZE</p>
        </div>
        <div class="details">
          <div class="left">
            <p><strong>Billed To</strong></p>
            <p><strong>Name:</strong> ' .$firstname.$lastname.'</p>
            <p><strong>Address:</strong> '.$address.'</p>
            <p><strong>Contact:</strong> '.$contact.'</p>
            <p><strong>Email:</strong> '.$email.'</p>
          </div>
          <div class="right">
            <p><strong>Order Details</strong></p>
            <p><strong>Order Id:</strong> '.$id.'</p>
            <p><strong>Order Date:</strong> '.$date_created.'</p>
            <p><strong>Order Confirm Date:</strong> '.$confirm_order.'</p>
            <p><strong>Invoice Download Date:</strong> '.date('Y-m-d H:i:sa').'</p>
          </div>
        </div>
        <hr style="clear: both" />
        <table>
          <thead>
            <tr>
              <th>Description</th>
              <th>Quantity</th>
              <th>Po Rate</th>
              <th>Margin</th>
              <th>Unit Price</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>'.$category .' ('.$name.', '.$location.')'.'</td>
              <td>'.$approved_quantity.'</td>
              <td>'.$po_rate.'</td>
              <td>'.($po_rate-$daily_rate).'</td>
              <td>'.$daily_rate.'</td>
              <td>'.$daily_rate*$approved_quantity.'</td>
            </tr>
            <!-- Additional rows can be added here -->
          </tbody>
        </table>
        <div class="total">
          <p>
            <strong>Total Amount:</strong
            ><span style="font-family: DejaVu Sans; sans-serif;"> &#8377;</span>
            '.$daily_rate*$approved_quantity.'
          </p>
        </div>
        <div class="signature">
          <div class="right-signature">
            <p>Authorized Signature:</p>
            <p>________________________</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>';
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice.pdf");
$pdfstring = $dompdf->output();