<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Homepage</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icon.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/home_page.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css'); ?>">
    </head>
    <body id="top">
        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a href="<?= site_url('home') ?>" class="logo">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke-width="3">
                       
                        <path d="M20 40a12 12 0 0 1 0-24 14 14 0 0 1 28 4h2a10 10 0 0 1 0 20H20z" fill="none"/>
                      
                        <line x1="24" y1="44" x2="20" y2="54"/>
                        <line x1="32" y1="44" x2="28" y2="54"/>
                        <line x1="40" y1="44" x2="36" y2="54"/>
                       
                        <path d="M16 58q4 4 8 0t8 0 8 0 8 0" fill="none"/>
                        </svg>

                        <div class="divider"></div>

                        <div class="logo-text">AlertoMarikeno</div>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                    </div>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_1">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_2">Flood Updates</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_3">Developers</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_4">FAQs</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_5">Contact</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="<?= site_url('forum') ?>">Newsfeed</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('flood/hazard-maps') ?>">Flood Hazard Map</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('flood/hourly') ?>">Prediction Table</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('flood/river-status') ?>">River Status</a></li>
                                </ul>
                                </ul>
                            </li>
                        </ul>

                        <div class="d-none d-lg-block">
                        </div>
                    </div>
                </div>
            </nav>
            

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">Flood Prediction Marikina City</h1>
                            <h6 class="text-center">platform for flood alert</h6>
                            <div style="display: flex; justify-content: center; margin-top: 1rem;">
                                <button type="button" class="btn btn-primary btn-lg" onclick="findNearestCenter()">Find Nearest Evacuation Center</button>
                            </div>
                        </div>                      
                    </div>
                </div>
            </section>


            <section class="featured-section">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <a href="topics-detail.html">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Flood Predict.</h5>

                                            <p class="mb-0">Stay alert, stay safe prepare today to protect tomorrow from floods.</p>
                                        </div>

                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                    </div>

                                    <img src="<?= base_url('assets/images/Floodwarning.png') ?>" class="custom-block-image img-fluid" alt="Flood Warning">

                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="custom-block custom-block-overlay">
                                <div class="d-flex flex-column h-100">
                                    <img src="images/businesswoman-using-tablet-analysis.jpg" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">Purpose of this project</h5>

                                            <p class="text-white">This project uses machine learning and data analytics to deliver accurate flood predictions and evacuation guidance for San Mateo, Rizal, and Marikina City, improving preparedness and public safety.</p>

                                            <a href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3">Learn More</a>
                                        </div>

                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                    </div>

                                    <div class="social-share d-flex">
                                        <p class="text-white me-4">Share:</p>

                                        <!--<ul class="social-icon">
                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-facebook"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-pinterest"></a>
                                            </li>
                                        </ul> -->

                                        <a href="#" class="custom-icon bi-bookmark ms-auto"></a>
                                    </div>

                                    <div class="section-overlay"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="explore-section section-padding" id="section_2">
                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="mb-4">Flood Updates</h1>
                        </div>

                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="design-tab" data-bs-toggle="tab" data-bs-target="#design-tab-pane" type="button" role="tab" aria-controls="design-tab-pane" aria-selected="true">Temperature</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="false">Precipitation</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance-tab-pane" type="button" role="tab" aria-controls="finance-tab-pane" aria-selected="false">Flood Warnings</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="music-tab" data-bs-toggle="tab" data-bs-target="#music-tab-pane" type="button" role="tab" aria-controls="music-tab-pane" aria-selected="false">Flood control</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education-tab-pane" type="button" role="tab" aria-controls="education-tab-pane" aria-selected="false">Preparedness</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="<?= site_url('status/summary') ?>">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Weather Code</h5>

                                                            <p class="mb-0">Codes representing various weather conditions.</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                                    </div>

                                                    <img src="<?= base_url('assets/images/weathercode.jpg'); ?>" class="custom-block-image img-fluid" alt="Weather Code">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="<?= site_url('status/summary') ?>">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Min Temperature</h5>

                                                                <p class="mb-0">The minimum temperature forecast for the day.</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="<?= base_url('assets/images/mintemp.jpg'); ?>" class="custom-block-image img-fluid" alt="Weather Code">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Max Temperature</h5>

                                                                <p class="mb-0">The maximum temperature forecast for the day</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">100</span>
                                                    </div>

                                                    <img src="<?= base_url('assets/images/maxtemp.jpg'); ?>" class="custom-block-image img-fluid" alt="Weather Code">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.html">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Precipitation Sum</h5>

                                                                <p class="mb-0">Total rainfall measured during the last 24 hours in millimeters.</p>
                                                            </div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">30</span>
                                                        </div>

                                                        <img src="images/topics/undraw_online_ad_re_ol62.png" class="custom-block-image img-fluid" alt="">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.html">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Precipitation Hours</h5>

                                                                <p class="mb-0">Total hours with rainfall recorded in the last week.</p>
                                                            </div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">65</span>
                                                        </div>

                                                        <img src="images/topics/undraw_Group_video_re_btu7.png" class="custom-block-image img-fluid" alt="">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.html">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Precipitation Probability</h5>

                                                                <p class="mb-0">Chance of rain occurring in the next 24 hours.</p>
                                                            </div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">50</span>
                                                        </div>

                                                        <img src="images/topics/undraw_viral_tweet_gndb.png" class="custom-block-image img-fluid" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                  </div>

                                <div class="tab-pane fade" id="finance-tab-pane" role="tabpanel" aria-labelledby="finance-tab" tabindex="0">   <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Flood Prediction</h5>

                                                            <p class="mb-0">A possible flood hase been detected in your area. Please take necessary precautions and proceed to the nearest evacuation center.</p>
                                                        </div>

                                                        <span class="badge bg-finance rounded-pill ms-auto">30</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Finance_re_gnv2.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block custom-block-overlay">
                                                <div class="d-flex flex-column h-100">
                                                    <img src="images/businesswoman-using-tablet-analysis-graph-company-finance-strategy-statistics-success-concept-planning-future-office-room.jpg" class="custom-block-image img-fluid" alt="">

                                                    <div class="custom-block-overlay-text d-flex">
                                                        <div>
                                                            <h5 class="text-white mb-2">When ?</h5>

                                                            <p class="text-white">There is a potential flood event predicted within the next 7 days. Stay updated with the latest alerts and take necessary precautions.</p>

                                                            <a href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3">Learn More</a>
                                                        </div>

                                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                                    </div>

                                                    <div class="social-share d-flex">
                                                        <p class="text-white me-4">Share:</p>

                                                        <ul class="social-icon">
                                                            <li class="social-icon-item">
                                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                                            </li>

                                                            <li class="social-icon-item">
                                                                <a href="#" class="social-icon-link bi-facebook"></a>
                                                            </li>

                                                            <li class="social-icon-item">
                                                                <a href="#" class="social-icon-link bi-pinterest"></a>
                                                            </li>
                                                        </ul>

                                                        <a href="#" class="custom-icon bi-bookmark ms-auto"></a>
                                                    </div>

                                                    <div class="section-overlay"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="music-tab-pane" role="tabpanel" aria-labelledby="music-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Composing Song</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Compose_music_re_wpiw.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Online Music</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/undraw_happy_music_g6wc.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Podcast</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">20</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Podcast_audience_re_4i5q.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="education-tab-pane" role="tabpanel" aria-labelledby="education-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Graduation</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">80</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Graduation_re_gthn.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Educator</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Educator_re_ju47.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </section>


            <section class="timeline-section section-padding" id="section_3">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="text-white mb-4">Developers</h2>
                        </div>

                        <div class="col-lg-10 col-12 mx-auto">
                            <div class="timeline-container">
                                <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline">
                                    <div class="list-progress">
                                        <div class="inner"></div>
                                    </div>

                                    <li>
                                        <h4 class="text-white mb-3">name1</h4>

                                        <p class="text-white">section1</p>

                                        <div class="icon-holder">
                                          <i class="bi-search"></i>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <h4 class="text-white mb-3">name1</h4>

                                        <p class="text-white">section1</p>

                                        <div class="icon-holder">
                                          <i class="bi-bookmark"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">name1</h4>

                                        <p class="text-white">section1</p>

                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">name1</h4>

                                        <p class="text-white">section1</p>
                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-5">
                            <p class="text-white">
                                Want to learn more?
                                <!--<a href="#" class="btn custom-btn custom-border-btn ms-3">Check out Youtube</a> -->
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="faq-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <h2 class="mb-4">Frequently Asked Questions</h2>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-lg-5 col-12">
                                <img src="<?php echo base_url('assets/images/faqs.jpg'); ?>" class="topics-detail-block-image img-fluid" alt="Tumana Image">
                        </div>

                        <div class="col-lg-6 col-12 m-auto">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What is the Flood Prediction System?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
Our Flood Prediction System is a web-based application designed to provide accurate flood prediction, alerts, and evacuation routing for flood-prone areas like Marikina City and San Mateo, Rizal. It uses historical weather and river data combined with machine learning algorithms to help communities prepare and respond effectively.                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How does the system predict floods?
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
The system analyzes historical weather patterns and river discharge data using machine learning models Support Vector Machine and Random Forest to generate reliable flood risk forecasts.                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Who can use the application?
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
Anyone with a stable internet connection and a device with a web browser can use the application. Users create accounts to receive personalized alerts and access features like evacuation routes and community status updates.                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="contact-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">Get in touch</h2>
                        </div>

                        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                            <iframe 
                            class="google-map"
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1930.4305114004453!2d120.9929!3d14.5998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sph!4v1684340239744!5m2!1sen!2sph" 
                            width="100%" 
                            height="250" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                          </iframe>
                                                  </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">San Beda University Manila</h4>

                            <p>638 Mendiola St, San Miguel, Manila, 1005 Metro Manila</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 305-240-9671" class="site-footer-link">
                                    305-240-9671
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:CAS@sanbeda.edu.ph" class="site-footer-link">
                                    CAS@sanbeda.edu.ph
                                </a>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">San Beda University Rizal</h4>

                            <p>H46X+WJP, Taytay, 1920 Rizal</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 110-220-3400" class="site-footer-link">
                                    110-220-3400
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:CAS@sanbeda.edu.ph" class="site-footer-link">
                                    CAS@sanbeda.edu.ph
                                </a>
                            </p>
                        </div>

                        

                    </div>
                </div>
            </section>
        </main>

<footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="FloodPredict.html">
                            <i class="bi-back"></i>
                            <span>Topic</span>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Resources</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">How it works</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">FAQs</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Information</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: (02) 8726 2332" class="site-footer-link">
                                (02) 8726 2332
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:CAS@sanbeda.edu.ph  " class="site-footer-link">
                                CAS@sanbeda.edu.ph
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                            <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            English</button>

                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Tagalog</button></li>

                                <li><button class="dropdown-item" type="button">BLANK</button></li>

                                <li><button class="dropdown-item" type="button">BLANK</button></li>
                            </ul>
                        </div>
                        
                    </div>

                </div>
            </div>
        </footer>

<!-- Confirmation Modal -->
<div id="confirmModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);
     background:white; padding:20px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.3);
     text-align:center; z-index:1000;">
    <p style="font-size: 16px; color: black;">Do you want to open directions in Google Maps?</p>
    <button id="confirmRedirect" style="margin:10px; padding:8px 16px; border:none; background:#4CAF50; color:white;
            border-radius:5px; cursor:pointer;">Yes</button>
    <button onclick="closeModal()" style="margin:10px; padding:8px 16px; border:none; background:#f44336; color:white;
            border-radius:5px; cursor:pointer;">No</button>
</div>

<!-- Background Overlay -->
<div id="modalOverlay" onclick="closeModal()" style="display:none; position:fixed; top:0; left:0; width:100%;
     height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

        <!-- JAVASCRIPT FILES -->
        
        <script src="<?= base_url('assets/javascript/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('assets/javascript/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?= base_url('assets/javascript/jquery.sticky.js'); ?>"></script>
        <script src="<?= base_url('assets/javascript/click-scroll.js'); ?>"></script>
        <script src="<?= base_url('assets/javascript/custom.js'); ?>"></script>

        <!-- Get Location -->
        <script>
            function openGoogleMaps() {
                const keyword = document.getElementById("keyword").value.trim();
                if (keyword !== "") {
                    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(keyword)}`;
                    window.open(mapsUrl, '_blank'); // open in new tab
                } else {
                    alert("Please enter a location to search.");
                }
                return false; // prevent default form submission
            }
        </script>

<script>
    let userLat = null;
    let userLon = null;

    // Predefined evacuation centers
const landmarks = [
  { name: "MALANDAY ELEMENTARY SCHOOL", lat: 14.65028, lon: 121.09441 },
  { name: "H. BAUTISTA ELEMENTARY SCHOOL", lat: 14.65778, lon: 121.10417 },
  { name: "NANGKA ELEMENTARY SCHOOL", lat: 14.67278, lon: 121.10833 },
  { name: "CONCEPCION INTEGRATED SCHOOL ES", lat: 14.65056, lon: 121.10167 },
  { name: "CONCEPCION INTEGRATED SCHOOL SL", lat: 14.65056, lon: 121.10167 },
  { name: "CONCEPCION ELEMENTARY SCHOOL", lat: 14.64778, lon: 121.10361 },
  { name: "STO. NIÑO ELEMENTARY SCHOOL", lat: 14.63833, lon: 121.09611 },
  { name: "STO. NIÑO NATIONAL HIGH SCHOOL", lat: 14.63901, lon: 121.09625 },
  { name: "LEODEGARIO VICTORINO ELEMENTARY SCHOOL", lat: 14.63541, lon: 121.09021 },
  { name: "FILIPINAS GYM", lat: 14.649, lon: 121.093 },
  { name: "SAMPAGUITA GYM", lat: 14.64899, lon: 121.09375 },
  { name: "MARIKINA ELEMENTARY SCHOOL", lat: 14.63113, lon: 121.09769 },
  { name: "STA. ELENA HIGH SCHOOL", lat: 14.63268, lon: 121.09648 },
  { name: "NANGKA GYM", lat: 14.67247, lon: 121.10841 },
  { name: "KALUMPANG ELEMENTARY SCHOOL", lat: 14.62222, lon: 121.09000 },
  { name: "KALUMPANG NHS", lat: 14.62222, lon: 121.09000 },
  { name: "SAN ROQUE ELEMENTARY SCHOOL", lat: 14.62306, lon: 121.09694 },
  { name: "SAN ROQUE HIGH SCHOOL", lat: 14.62299, lon: 121.09657 },
  { name: "BARANGKA ELEMENTARY SCHOOL", lat: 14.63333, lon: 121.08167 },
  { name: "TANONG HIGH SCHOOL", lat: 14.63418, lon: 121.08533 },
  { name: "PLMAR (GREENHEIGHTS)", lat: 14.65826, lon: 121.10604 },
  { name: "IVS COVERED COURT", lat: 14.63461, lon: 121.09842 },
  { name: "JESUS DELA PEÑA NATIONAL HIGH SCHOOL", lat: 14.6352, lon: 121.09002 },
  { name: "MARIKINA HIGH SCHOOL", lat: 14.64712, lon: 121.10343 },
  { name: "PARANG ELEMENTARY SCHOOL", lat: 14.65722, lon: 121.11167 },
  { name: "PARANG HIGH SCHOOL", lat: 14.6635, lon: 121.11237 },
  { name: "FORTUNE ELEMENTARY SCHOOL", lat: 14.65917, lon: 121.12639 },
  { name: "FORTUNE HIGH SCHOOL", lat: 14.65944, lon: 121.12694 },
  { name: "ST. MARY ELEMENTARY SCHOOL", lat: 14.66861, lon: 121.11361 },
  { name: "SSS VILLAGE ELEMENTARY SCHOOL", lat: 14.64000, lon: 121.12111 },
  { name: "SSS NATIONAL HIGH SCHOOL", lat: 14.64000, lon: 121.12111 },
  { name: "KAP. MOY ELEMENTARY SCHOOL", lat: 14.64944, lon: 121.11833 },
  { name: "MARIKINA HIGH SCHOOL", lat: 14.64667, lon: 121.10306 },
  { name: "MARIKINA HEIGHTS HIGH SCHOOL", lat: 14.64806, lon: 121.11806 }
];



    // Geolocation request is deferred and will only be triggered on button click

    // Haversine distance function
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLon = (lon2 - lon1) * (Math.PI / 180);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function findNearestCenter() {
        const proceedWith = (lat, lon) => {
            userLat = lat;
            userLon = lon;

            let nearest = landmarks.reduce((nearest, landmark) => {
                const distance = getDistance(lat, lon, landmark.lat, landmark.lon);
                return distance < nearest.distance ? { ...landmark, distance } : nearest;
            }, { distance: Infinity });

            let mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${lat},${lon}&destination=${nearest.lat},${nearest.lon}&travelmode=driving`;

            // Show modal
            document.getElementById("confirmModal").style.display = "block";
            document.getElementById("modalOverlay").style.display = "block";
            document.getElementById("confirmRedirect").onclick = function () {
                window.open(mapsUrl, "_blank");
                closeModal();
            };
        };

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    proceedWith(position.coords.latitude, position.coords.longitude);
                },
                function (error) {
                    alert("Unable to access your location. Please allow location access and try again.");
                }
            );
        } else {
            alert("Geolocation is not supported by your browser.");
        }

        return false; // prevent default behavior
    }
</script>

<script>
    function closeModal() {
        document.getElementById("confirmModal").style.display = "none";
        document.getElementById("modalOverlay").style.display = "none";
    }
</script>

    </body>
</html>
