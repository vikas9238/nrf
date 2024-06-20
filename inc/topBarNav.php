<!-- Spinner Start -->
<!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
<!-- Spinner End -->

<!-- Navbar Start -->
<div class="container-fluid nav-bar bg-transparent">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
        <a href="./" class="navbar-brand d-flex align-items-center text-center">
            <div class="icon p-2 me-2">
                <img class="img-fluid" src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Icon" style="width: 30px; height: 30px;" loading="lazy">
            </div>
            <h1 class="m-0 text-primary"><?php echo $_settings->info('short_name') ?></h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto">
                <a href="./" class="nav-item nav-link active">Home</a>
                <a href="./?p=about" class="nav-item nav-link">About</a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="companyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Company</a>
                    <div class="dropdown-menu" aria-labelledby="brandDropdown">
                        <?php
                        $brand_qry = $conn->query("SELECT * FROM `company_list` where status = 1 order by `name` asc");
                        while ($row = $brand_qry->fetch_assoc()) :
                        ?>
                            <a class="dropdown-item" href="./?p=bikes&s=<?php echo md5($row['id']) ?>"><?php echo $row['name'] ?></a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Error</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <div class="d-flex align-items-center">
                <?php if (!isset($_SESSION['userdata']['id'])) : ?>
                    <button class="btn btn-primary px-3 d-none d-lg-flex" id="login-btn" type="button">Login</button>
                <?php else : ?>
                    <a href="./?p=my_account" class="text-primary nav-link"><b> Hi, <?php echo $_settings->userdata('firstname') ?>!</b></a>
                    <a href="logout.php" class="text-dark  nav-link"><i class="fa fa-sign-out-alt"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End -->
<script>
    $(function() {
        $('#login-btn').click(function() {
            uni_modal("", "login.php")
        })
    })
</script>