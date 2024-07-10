<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-solid fa-indian-rupee-sign"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Booking</span>
        <span class="info-box-number">
          <?php
          $category = $conn->query("SELECT count(id) as total FROM booking_list  where po_rate > '0'")->fetch_assoc()['total'];
          echo number_format($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-solid fa-indian-rupee-sign"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Today Booking</span>
        <span class="info-box-number">
          <?php
          $today = date("Y-m-d");
          // //echo $today;
          $category = $conn->query("SELECT count(id) as total FROM booking_list  where Date(date_created) = '{$today}'")->fetch_assoc()['total'];
          // echo date("Y-m-d", strtotime($row['date_created']));
          echo number_format($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-solid fa-indian-rupee-sign"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Booking Approval Pending</span>
        <span class="info-box-number">
          <?php
          $category = $conn->query("SELECT count(id) as total FROM booking_list  where status = '0'")->fetch_assoc()['total'];
          echo number_format($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-th-list"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Complete Quotation</span>
        <span class="info-box-number">
          <?php
          $category = $conn->query("SELECT count(id) as total FROM `quotation_list`  where status = '0'")->fetch_assoc()['total'];
          echo number_format($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="nav-icon fa-solid fa-hand-holding-hand"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Available Quotation</span>
        <span class="info-box-number">
          <?php
          $bike = $conn->query("SELECT count(id) as total FROM `quotation_list` where status = '1' ")->fetch_assoc()['total'];
          echo number_format($bike);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Clients</span>
        <span class="info-box-number">
          <?php
          $clients = $conn->query("SELECT count(id) as total FROM `clients`")->fetch_assoc()['total'];
          echo number_format($clients);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Client Pending For Approval</span>
        <span class="info-box-number">
          <?php
          $clients = $conn->query("SELECT count(id) as total FROM `clients` where status=2")->fetch_assoc()['total'];
          echo number_format($clients);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fa-regular fa-money-bill-1"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Collection</span>
        <span class="info-box-number">
          <?php
          $total_collection = $conn->query("SELECT SUM(approved_quantity * daily_rate) AS total_amount from `booking_list` where (status = 1 or status=4) ")->fetch_assoc()['total_amount'];
          echo number_format($total_collection);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-secondary elevation-1"><i class="fa-regular fa-money-bill-1"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Today Collection</span>
        <span class="info-box-number">
          <?php
          $today = date("Y-m-d");
          $today_collection = $conn->query("SELECT SUM(approved_quantity * daily_rate) AS total_amount from `booking_list` where Date(date_created) = '{$today}' ")->fetch_assoc()['total_amount'];
          echo number_format($today_collection);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fa-regular fa-money-bill-1"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Pay</span>
        <span class="info-box-number">
          <?php
          $total_pay = $conn->query("SELECT SUM(amount) AS amount from `transaction` ")->fetch_assoc()['amount'];
          echo number_format($total_pay);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-secondary elevation-1"><i class="fa-regular fa-money-bill-1"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Today Pay</span>
        <span class="info-box-number">
          <?php
          $today = date("Y-m-d");
          $today_pay = $conn->query("SELECT SUM(amount) AS amount from `transaction` where Date(date_created) = '{$today}' ")->fetch_assoc()['amount'];
          echo number_format($today_pay);
          ?>
        </span>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-info elevation-1"><i class="fa-regular fa-money-bill-1"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Fund Available</span>
        <span class="info-box-number">
          <?php
          $total_fund = $total_collection - $total_pay;
          echo number_format($total_fund);
          ?>
        </span>
      </div>
    </div>
  </div>
  <!-- <div>
    <div class="form-group col-md-3">
    <label for="date_start">Month</label>
    <input type="month" class="form-control form-control-sm" name="month">
    </div>
    <canvas id="myChart"></canvas>
  </div> -->
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  $(document).ready(function() {
    $('input[name="month"]').on('change', function() {
      var month = $(this).val();
      $.ajax({
        url: _base_url_ + 'classes/Master.php?f=chart_data',
        method: 'POST',
        data: {
          month: month
        },
        dataType: 'json',
        success: function(resp) {
          console.log(resp)
          var ctx = document.getElementById('myChart');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: resp.label,
              datasets: [{
                label: 'Total Collection',
                data: resp.data,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 205, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                  'rgb(255, 99, 132)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                  'rgb(54, 162, 235)',
                  'rgb(153, 102, 255)',
                  'rgb(201, 203, 207)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        }
      })
    })
  })
  // const ctx = document.getElementById('myChart');

  // new Chart(ctx, {
  //   type: 'bar',
  //   data: {
  //     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
  //     datasets: [{
  //       label: '# of Votes',
  //       data: [12, 19, 3, 5, 2, 3],
  //       backgroundColor: [
  //         'rgba(255, 99, 132, 0.2)',
  //         'rgba(255, 159, 64, 0.2)',
  //         'rgba(255, 205, 86, 0.2)',
  //         'rgba(75, 192, 192, 0.2)',
  //         'rgba(54, 162, 235, 0.2)',
  //         'rgba(153, 102, 255, 0.2)',
  //         'rgba(201, 203, 207, 0.2)'
  //       ],
  //       borderColor: [
  //         'rgb(255, 99, 132)',
  //         'rgb(255, 159, 64)',
  //         'rgb(255, 205, 86)',
  //         'rgb(75, 192, 192)',
  //         'rgb(54, 162, 235)',
  //         'rgb(153, 102, 255)',
  //         'rgb(201, 203, 207)'
  //       ],
  //       borderWidth: 1
  //     }]
  //   },
  //   options: {
  //     scales: {
  //       y: {
  //         beginAtZero: true
  //       }
  //     }
  //   }
  // });
</script>