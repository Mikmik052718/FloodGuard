<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Topic Detail Page</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        
        <!-- Your CSS Files -->
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icon.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/landingpage.css'); ?>">

        <!-- Sidebar Navigation CSS -->
        <style>
            :root {
                --font-base: 'Open Sans', sans-serif;
                --color-primary: #2C3E50;
                --color-secondary: #18BC9C;
                --color-bg: #ECF0F1;
                --color-bg-dark: #34495E;
                --color-text: #2C3E50;
                --color-text-light: #FFFFFF;
                --transition: .3s cubic-bezier(.4,0,.2,1);
                --sidebar-width: 5em;
                --sidebar-width-expanded: 16em;
            }
            body {
                font-family: var(--font-base);
                background-color: var(--color-bg);
                color: var(--color-text);
                margin: 0;
                padding: 0;
            }
            #navbar {
                position: fixed;
                top: 0;
                left: 0;
                width: var(--sidebar-width);
                height: 100vh;
                background-color: #1f1f1f;
                transition: width var(--transition);
                overflow: hidden;
                box-shadow: 2px 0 8px rgba(0,0,0,0.1);
                z-index: 2000;
                display: flex;
                flex-direction: column;
            }
            #navbar:hover {
                width: var(--sidebar-width-expanded);
            }
            .navbar-items {
                list-style: none;
                margin-top: 1rem;
                padding-left: 0;
                padding-right: 0;
            }
            .navbar-logo {
                height: 5em;
                background: #2c2f33;
                margin-bottom: 2rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .navbar-logo svg {
                height: 2.5em;
                fill: var(--color-text-light);
            }
            .navbar-item {
                margin-bottom: .5rem;
            }
            .navbar-item-inner {
                display: flex;
                align-items: center;
                color: var(--color-text-light);
                text-decoration: none;
                padding: .75rem 1rem;
                border-radius: .5rem;
                transition: background var(--transition), color var(--transition);
            }
            .navbar-item-inner:hover {
                background: var(--color-secondary);
                color: var(--color-text-light);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .icon-wrapper {
                width: 2.5em;
                text-align: center;
                font-size: 1.3rem;
            }
            .link-text {
                margin-left: .5rem;
                white-space: nowrap;
                opacity: 0;
                transition: opacity var(--transition);
            }
            #navbar:hover .link-text {
                opacity: 1;
            }
            main {
                transition: margin-left var(--transition);
                margin-left: var(--sidebar-width);
                padding: 0;
                min-height: 100vh;
                background: var(--color-bg);
            }
            #navbar:hover ~ main,
            body.sidebar-expanded main {
                margin-left: var(--sidebar-width-expanded);
            }
            @media (max-width: 991px) {
                #navbar {
                    position: static;
                    width: 100vw;
                    height: auto;
                    flex-direction: row;
                    box-shadow: none;
                    z-index: 1;
                }
                .navbar-items {
                    flex-direction: row;
                    margin-top: 0;
                }
                .navbar-logo {
                    margin-bottom: 0;
                }
                .link-text {
                    display: none !important;
                }
                main {
                    margin-left: 0 !important;
                }
            }
        </style>

        <!-- Ionicons for sidebar icons -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </head>

    <body id="top">
        <!-- Sidebar Navigation Bar -->
        <nav id="navbar">
            <ul class="navbar-items flex-column">
                <li class="navbar-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1438.88 1819.54">
                        <polygon points="925.79 318.48 830.56 0 183.51 1384.12 510.41 1178.46 925.79 318.48"/>
                        <polygon points="1438.88 1663.28 1126.35 20.91 1250.57 1123.78 1471.02 783.64 1663.28 1438.88 1663.28"/>
                    </svg>
                </li>
                <li class="navbar-item">
                    <a href="<?= site_url('auth/adlogin'); ?>" class="navbar-item-inner">
                        <div class="icon-wrapper"><ion-icon name="lock-closed-outline"></ion-icon></div>
                        <span class="link-text">Admin Login</span>
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="<?= site_url('auth/uslogin'); ?>" class="navbar-item-inner">
                        <div class="icon-wrapper"><ion-icon name="person-circle-outline"></ion-icon></div>
                        <span class="link-text">User Login</span>
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="<?= site_url('/auth/register'); ?>" class="navbar-item-inner">
                        <div class="icon-wrapper"><ion-icon name="person-add-outline"></ion-icon></div>
                        <span class="link-text">User Register</span>
                    </a>
                </li>
                <li class="navbar-item">
                    <a href="<?= site_url('/landing'); ?>" class="navbar-item-inner">
                        <div class="icon-wrapper"><ion-icon name="home-outline"></ion-icon></div>
                        <span class="link-text">Home</span>
                    </a>
                </li>
            </ul>
        </nav>

        <main>
            <header class="site-header d-flex flex-column justify-content-center align-items-center">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-5 col-12 mb-5">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">FloodPredict</li>
                                </ol>
                            </nav>

                            <h2 class="text-white">Welcome to <br> Flood Prediction Project</h2>

                            <div class="d-flex align-items-center mt-5">
                                <a href="#topics-detail" class="btn custom-btn custom-border-btn smoothscroll me-4">Read More</a>
                                <a href="#top" class="custom-icon bi-bookmark smoothscroll"></a>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12">
                            <div class="topics-detail-block bg-white shadow-lg">
                                <img src="<?= base_url('assets/images/floodlogo.jpg'); ?>" class="topics-detail-block-image img-fluid" alt="Tumana Image">
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="topics-detail-section section-padding" id="topics-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-12 m-auto">
                            <h3 class="mb-4">Introduction to our Project</h3>
                            <p>This project develops a web-based flood prediction application for Marikina City and San Mateo, Rizal. Leveraging historical weather and river data combined with machine learning models, the system provides accurate flood forecasts, real-time alerts, and automated evacuation routing through an intuitive web interface.</p>
                            <p>Designed for accessibility across devices, the platform fosters community engagement with a live status forum and supports local authorities in disaster preparedness and response. Built using Agile methodology, the application ensures reliability, scalability, and user-centered design to enhance flood resilience in vulnerable areas.</p>
                            <blockquote>
                                Data-Driven Safety for Every Flood-Prone Neighborhood.
                            </blockquote>

                            <div class="row my-4">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <img src="<?= base_url('assets/images/tumana.jpg'); ?>" class="topics-detail-block-image img-fluid" alt="Tumana Image">
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mt-4 mt-lg-0 mt-md-0">
                                    <img src="<?= base_url('assets/images/aftercarina.jpg'); ?>" class="topics-detail-block-image img-fluid" alt="Tumana Image">
                                </div>
                            </div>
                            <p>The left image shows residents of Brgy. Tumana, Marikina City, wading through rising floodwaters to reach safer ground amid heavy rains intensified by Typhoon Carina on July 24, 2024. The right image captures the aftermath in Marikina, where residents return to their flooded homes following the severe southwest monsoon and typhoon, highlighting the community’s resilience amid repeated flooding events.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="index.html">
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
                            <a href="mailto:CAS@sanbeda.edu.ph" class="site-footer-link">
                                CAS@sanbeda.edu.ph
                            </a>
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            English</button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Thai</button></li>
                                <li><button class="dropdown-item" type="button">Myanmar</button></li>
                                <li><button class="dropdown-item" type="button">Arabic</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JAVASCRIPT FILES -->
        <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?= base_url('assets/js/jquery.sticky.js'); ?>"></script>
        <script src="<?= base_url('assets/js/click-scroll.js'); ?>"></script>
        <script src="<?= base_url('assets/js/custom.js'); ?>"></script>
        
        <script>
            // Sidebar hover: when hovered, add a class to <body> so <main> shifts over.
            document.addEventListener('DOMContentLoaded', function () {
                const navbar = document.getElementById('navbar');
                if (navbar) {
                    navbar.addEventListener('mouseenter', () => {
                        document.body.classList.add('sidebar-expanded');
                    });
                    navbar.addEventListener('mouseleave', () => {
                        document.body.classList.remove('sidebar-expanded');
                    });
                }
            });
        </script>
    </body>
</html>
