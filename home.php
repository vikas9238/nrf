<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Find A <span class="text-primary">Perfect Platform</span> To Trade With Your Family and Friends With Guaranteed Profit.</h1>
            <p class="animated fadeIn mb-4 pb-2">Welcome to NRF Industry AND Trading Private Limited a premier platform for construction material Trading to India's top construction projects.</p>
            <a href="#tab-1" class="btn btn-primary py-3 px-5 me-3 animated fadeIn">Get Started</a>
        </div>
        <div class="col-md-6 animated fadeIn">
            <div class="owl-carousel header-carousel">
                <div class="owl-carousel-item">
                    <img class="img-fluid" src="<?php echo $_settings->info('carousel_1') ?>" alt="">
                </div>
                <div class="owl-carousel-item">
                    <img class="img-fluid" src="<?php echo $_settings->info('carousel_2') ?>" alt="">
                </div>
                <div class="owl-carousel-item">
                    <img class="img-fluid" src="<?php echo $_settings->info('carousel_3') ?>" loading="lazy" alt="">
                </div>
                <div class="owl-carousel-item">
                    <img class="img-fluid" src="<?php echo $_settings->info('carousel_4') ?>" loading="lazy" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->
<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="about-img position-relative overflow-hidden p-5 pe-0">
                    <img class="img-fluid w-100" src="<?php echo base_url ?>uploads/1.jpg" loading="lazy">
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <h1 class="mb-4">#1 Place To Trade In Construction Material With Your Home</h1>
                <p class="mb-4">NRF Industry AND Trading Private Limited supplies construction materials to projects undertaken by india's top leading construction companies.</p>
                <p><i class="fa fa-check text-primary me-3"></i>Guaranteed Profit</p>
                <p><i class="fa fa-check text-primary me-3"></i>Trusted Platform</p>
                <p><i class="fa fa-check text-primary me-3"></i>100% Transparency</p>
                <a class="btn btn-primary py-3 px-5 mt-3" href="?p=about">Read More</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Property List Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                    <h1 class="mb-3">Material</h1>
                    <!-- <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit eirmod sit diam justo sed rebum.</p> -->
                </div>
            </div>
            <!-- <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary active" data-bs-toggle="pill" href="#tab-1">Featured</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">For Sell</a>
                    </li>
                    <li class="nav-item me-0">
                        <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-3">For Rent</a>
                    </li>
                </ul>
            </div> -->
        </div>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane fade show p-0 active">
                <div class="row g-4">
                    <?php
                    $qur = $conn->query("SELECT b.*,c.category, d.name from `quotation_list` b inner join product c on b.product_id = c.id inner join company_list d on b.company_id = d.id  where b.status = 1");
                    while ($row = $qur->fetch_assoc()) :
                        $upload_path = base_app . '/uploads/' . $row['id'];
                        $img = "/uploads/thumbnails/" . $row['id'] . '.png';
                    ?>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <a class="col mb-5 text-decoration-none text-dark" id="quotation" href=".?p=view_quotation&id=<?php echo md5($row['id']) ?>">
                                <div class="property-item rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <img class="card-img-top w-100 quotation-cover" src="<?php echo validate_image($img) ?>" loading="lazy" alt="">
                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"><?php echo round(($row['po_rate'] - $row['daily_rate']) * 100 / $row['daily_rate'], 2) ?>% Profit</div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"><b><?php echo $row['category'] ?></b></div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <?php if (isset($_SESSION['userdata']['id'])) : ?>
                                            <p class="text-primary mb-3"> <b> &#8377;<?php echo $row['daily_rate'] ?> /<?php if ($row['po_unit'] == 1) : ?> TON<?php else : ?> CFT<?php endif; ?></b></p>
                                        <?php endif; ?>
                                        <p class="d-block h5 mb-2"><?php echo $row['name'] ?></p>
                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo $row['address'] ?></p>
                                    </div>
                                    <div class="d-flex border-top">
                                        <?php if (isset($_SESSION['userdata']['id'])) : ?>
                                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-money-bill-trend-up text-primary me-2"></i><?php echo $row['po_rate'] - $row['daily_rate'] ?></small>
                                        <?php endif; ?>
                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-handshake-angle text-primary me-2"></i><?php echo $row['po_quantity'] ?></small>
                                        <small class="flex-fill text-center py-2"><i class="fa fa-hourglass-start text-primary me-2"></i><?php echo $row['quantity'] ?></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                    <!-- <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                        <a class="btn btn-primary py-3 px-5" href="">Browse More Material</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Property List End -->

<!-- Company Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Our Client!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            <?php
            $qur = $conn->query("SELECT * from `company_list` where status = 1");
            while ($ro = $qur->fetch_assoc()) :
                $img = base_url . "uploads/company/" . $ro['id'] . '.png';
            ?>
                <div class="testimonial-item bg-light rounded">
                    <div class="bg-white border rounded p-4">
                        <img class="img-fluid flex-shrink-0 rounded mx-auto d-block" src="<?php echo $img ?>" loading="lazy" style="width: 150px; height: 150px;">
                        <div class="text-center">
                            <h6 class="fw-bold mb-1"><?php echo $ro['name'] ?></h6>
                            <small><?php echo $ro['description'] ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<!-- Company End -->

<!-- Call to Action Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-light rounded p-3">
            <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <img class="img-fluid rounded w-100" src="<?php echo base_url ?>uploads/call-to-action.jpg" loading="lazy" alt="">
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="mb-4">
                            <h1 class="mb-3">Contact With Our Support Team</h1>
                            <!-- <p>Eirmod sed ipsum dolor sit rebum magna erat. Tempor lorem kasd vero ipsum sit sit diam justo sed vero dolor duo.</p> -->
                        </div>
                        <a href="tel:<?php echo $_settings->info('mobile') ?>" class="btn btn-primary py-3 px-4 me-2"><i class="fa fa-phone-alt me-2"></i>Make A Call</a>
                        <a href="?p=contact" class="btn btn-dark py-3 px-4"><i class="fa fa-calendar-alt me-2"></i>Get Appoinment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call to Action End -->


<!-- Team Start -->
<!-- <div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">NRF Agents</h1>
            <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit eirmod sit. Ipsum diam justo sed rebum vero dolor duo.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item rounded overflow-hidden">
                    <div class="position-relative">
                        <img class="img-fluid" src="<?php echo base_url ?>uploads/team-4.jpg" loading="lazy" alt="">
                        <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="text-center p-4 mt-3">
                        <h5 class="fw-bold mb-0">Full Name</h5>
                        <small>Designation</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Team End -->

<!-- Our Vision start-->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Our Vision</h1>
        </div>
        <div class="bg-light rounded p-3">
            <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <img class="img-fluid rounded w-60" src="<?php echo base_url ?>uploads/vision.jpg" loading="lazy" alt="">
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <!-- <div class=""> -->
                        <p class="fs-5 mb-4">Our vision is to revolutionize the construction industry by offering unparalleled Trading opportunities that yield substantial Profit.</p>
                        <p class="fs-5 mb-4">To Enable Individuals Across India To Become Construction Material Trader From Their Home Through Our Platform Without Any Financial Risk, Thus Significantly Reducing Unemployment Of India.</p>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Vision End -->


<!-- Partner Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Our Partner Say!</h1>
            <!-- <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit eirmod sit. Ipsum diam justo sed rebum vero dolor duo.</p> -->
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            <div class="testimonial-item bg-light rounded p-3">
                <div class="bg-white border rounded p-4">
                    <p>I am impressed with NRF's transparency and their ability to navigate market challenges effectively. They are a trusted partner.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="uploads/team-4.jpg" loading="lazy" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Rakesh Sah</h6>
                            <small> Partner</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-3">
                <div class="bg-white border rounded p-4">
                    <p>Partnering with NRF has been rewarding both financially and strategically. Their expertise in the construction sector is invaluable.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="uploads/testimonial1.jpeg" loading="lazy" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Amit Yadav</h6>
                            <small> Partner</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-3">
                <div class="bg-white border rounded p-4">
                    <p>I appreciate NRF's transparency it has been a profitable addition to my portfolio.</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="uploads/testimonial2.jpg" loading="lazy" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">Sanjay Singh</h6>
                            <small>Partner</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Partner End -->
<script>
    //     $(document).ready(function(){
    //     $('#quotation').click(function() {
    //         if ('<?php //echo $_settings->userdata('id') 
                    ?>' <= 0) {
    //             uni_modal("", "login.php");
    //             return false;
    //         }
    //         uni_modal("Booking Material", "book_to_quotation.php?id=<?php //echo isset($id) ? $id : '' 
                                                                        ?>", 'mid-large')
    //     })
    // })
</script>