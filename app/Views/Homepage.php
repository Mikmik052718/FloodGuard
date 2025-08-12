<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Flood chuchu</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icon.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/home_page.css'); ?>">
    </head>
    
    <body id="top">

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <!-- PALINK NGA TO JE SA newlanding -->
                    <a class="navbar-brand" href="<?= base_url('status/newlanding') ?>">
                        <i class="bi-back"></i>
                        <span>Flood</span>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                        <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
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
                                    <li><a class="dropdown-item" href="http://localhost/bit3_ci/index.php/Status">NEWS FEED</a></li>

                                    <li><a class="dropdown-item" href="https://noah.up.edu.ph/know-your-hazards">FLOOD HAZARD MAPS</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="d-none d-lg-block">
                            <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                        </div>
                    </div>
                </div>
            </nav>
            

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">Flood Prediction: Marikina and San Mateo, Rizal</h1>

                            <h6 class="text-center">platform for flood alert</h6>

                            <form id="mapSearchForm" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search" onsubmit="return findNearestCenter();">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">📍</span>
                                    <input name="keyword" type="search" class="form-control" id="keyword" placeholder="Getting your current location..." aria-label="Search for your location">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
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
                                        <h4 class="text-white mb-3">Mark Vincent E. Francisco</h4>

                                        <p class="text-white">CAS BIT3 2022-02191</p>

                                        <div class="icon-holder">
                                          <i class="bi-search"></i>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <h4 class="text-white mb-3">Jerald Dontierro P. Santos</h4>

                                        <p class="text-white">CAS BIT3 2022-00642</p>

                                        <div class="icon-holder">
                                          <i class="bi-bookmark"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">Kurt Harry T. Tallungan</h4>

                                        <p class="text-white">CAS BIT3 2021-01206</p>

                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">Alexis D. Santos</h4>

                                        <p class="text-white">CAS BIT3 2022-00649</p>

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
        { name: "H. Bautista Elementary School", lat: 14.657919798233864, lon: 121.10419709665953 }, 
        { name: "Sto. Nino Elementary School", lat: 14.638044194837592, lon: 121.09640741002192 },  
        { name: "Malanday Elementary School", lat: 14.650209006297997, lon: 121.09451082721736 }, 
        { name: "Marikina High School", lat: 14.647263228783377, lon: 121.10290676584233 }
    ];

    // Get user location on page load
    window.onload = function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    userLat = position.coords.latitude;
                    userLon = position.coords.longitude;
                    
                    // Get location name using Google Maps Geocoding API
                    const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${userLat},${userLon}&key=YOUR_API_KEY`;

                    fetch(geocodeUrl)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "OK") {
                                const place = data.results[0].formatted_address;
                                document.getElementById("keyword").value = place;
                            } else {
                                document.getElementById("keyword").placeholder = "Location";
                            }
                        })
                        .catch(() => {
                            document.getElementById("keyword").placeholder = "Location";
                        });
                },
                function () {
                    document.getElementById("keyword").placeholder = "Unable to get location";
                }
            );
        } else {
            document.getElementById("keyword").placeholder = "Geolocation not supported";
        }
    };

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
        if (userLat === null || userLon === null) {
            alert("Still getting your location. Please wait a moment.");
            return false;
        }

        let nearest = landmarks.reduce((nearest, landmark) => {
            const distance = getDistance(userLat, userLon, landmark.lat, landmark.lon);
            return distance < nearest.distance ? { ...landmark, distance } : nearest;
        }, { distance: Infinity });

        let mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLon}&destination=${nearest.lat},${nearest.lon}&travelmode=driving`;

        // Show modal
        document.getElementById("confirmModal").style.display = "block";
        document.getElementById("modalOverlay").style.display = "block";
        document.getElementById("confirmRedirect").onclick = function () {
            window.open(mapsUrl, "_blank");
        };

        return false; // prevent form submission
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
