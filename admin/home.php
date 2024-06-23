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
                     $category = $conn->query("SELECT count(id) as total FROM booking_list  where amount > '0'")->fetch_assoc()['total'];
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
                      $category = $conn->query("SELECT count(id) as total FROM booking_list  where date_created = '{$today}'")->fetch_assoc()['total'];
                  //   echo date("Y-m-d",strtotime($row['date_created']));
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
        </div>