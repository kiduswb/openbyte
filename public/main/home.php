<?php 
    $pageTitle = 'OpenByte Hosting - FREE and Powerful Web Hosting';
    $activePage = 'home';
    include 'header.php';
?>
<body class="d-flex flex-column min-vh-100 body-bg-space">
    <?php include 'navbar.php'; ?>

    <section class="container text-white py-5 home-hero">
        <div class="row">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start hero" data-aos="fade-up">
                    <h1 class="display-2 fw-bold mb-3">Free & Powerful Web Hosting</h1>
                    <p class="lead mb-4">
                        OpenByte offers industry standard perfomance & applications, at absolutely zero cost,
                        no gimmicks and no hidden terms.
                    </p>
                    <a class="btn btn-lg btn-prussian-blue rounded-0" href="/dashboard">
                        Get Started <span class="fas fa-arrow-right ms-2"></span>
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-up">
                    <img src="/assets/img/hero.svg" alt="OpenByte Launch" class="img-fluid" />
                </div>
            </div>
        </div>
    </section>

    <section class="bg-prussian-blue text-white py-5" data-aos="fade-up">
        <div class="container">
            <div class="row py-4">
                <div class="col-lg-12 text-center">
                    <h2 class="display-5 fw-bold mb-5">Top Features</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-transparent">
                        <div class="card-img feature-icon">
                            <img src="/assets/img/icons/speedo.svg" alt="Performance" class="img-fluid" />
                        </div>
                        <div class="card-body text-white text-center">        
                            <h3 class="card-title">Performance</h3>
                            <p class="card-text">
                                Unlimited bandwidth and site speed on shared hosting servers. 99% uptime guarantee.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-transparent">
                        <div class="card-img feature-icon">
                            <img src="/assets/img/icons/storage.svg" alt="Storage" class="img-fluid" />
                        </div>
                        <div class="card-body text-white text-center">        
                            <h3 class="card-title">Storage</h3>
                            <p class="card-text">
                                Unlimited & safe NVMe SSD storage for your websites and applications.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-transparent">
                        <div class="card-img feature-icon">
                            <img src="/assets/img/icons/apps.svg" alt="Applications" class="img-fluid" />
                        </div>
                        <div class="card-body text-white text-center">        
                            <h3 class="card-title">Applications</h3>
                            <p class="card-text">
                                Install your favorite applications like WordPress, Joomla, and Drupal with a single click.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-transparent">
                        <div class="card-img feature-icon">
                            <img src="/assets/img/icons/ssl.svg" alt="Security" class="img-fluid" />
                        </div>
                        <div class="card-body text-white text-center">        
                            <h3 class="card-title">Security</h3>
                            <p class="card-text">
                                Provision your certificates using Let's Encrypt. Enjoy access to Cloudflare's DDoS protection.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-transparent">
                        <div class="card-img feature-icon">
                            <img src="/assets/img/icons/domains.svg" alt="Domains" class="img-fluid" />
                        </div>
                        <div class="card-body text-white text-center">        
                            <h3 class="card-title">Domains</h3>
                            <p class="card-text">
                                Easy domain and subdomain management via cPanel. Enjoy access to free subdomains.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 bg-transparent">
                        <div class="card-img feature-icon">
                            <img src="/assets/img/icons/noads.svg" alt="No Ads" class="img-fluid" />
                        </div>
                        <div class="card-body text-white text-center">        
                            <h3 class="card-title">No Ads</h3>
                            <p class="card-text">
                                No ads whatsoever anywhere on your site. Enjoy a clean and ad-free experience.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12 text-center">
                    <h3 class="display-6 mb-5">Get Access to Popular Apps & Tools</h3>
                    <div class="d-flex flex-wrap justify-content-center gap-4 mt-4">
                        <img src="/assets/img/icons/php.svg" alt="PHP" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/mysql.svg" alt="MySQL" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/cpanel.svg" alt="cPanel" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/wordpress.svg" alt="WordPress" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/joomla.svg" alt="Joomla" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/drupal.svg" alt="Drupal" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/magento.svg" alt="Magento" class="img-fluid app-icons" />
                        <img src="/assets/img/icons/prestashop.svg" alt="PrestaShop" class="img-fluid app-icons" />
                    </div>
                    <p class="lead mt-4">
                        ...and many more!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="faq text-white py-5">
        <div class="container">
            <div class="row py-3">
                <div class="col-lg-12 text-center">
                    <h2 class="display-5 fw-bold mb-5">Frequently Asked Questions</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-5">
                    <h3>Do you provide domain names?</h3>
                    <p class="lead">
                        No, we do not provide free top-level domains. You can however
                        use a free subdomain whenever you create a new website.
                    </p> 
                </div>

                <div class="col-lg-6 mb-5">
                    <h3>How can I install apps?</h3>
                    <p class="lead">
                        You can use the Softaculous Apps Installer in your cPanel&reg; 
                        to install over 300 available applications on your website.
                    </p> 
                </div>

                <div class="col-lg-6 mb-5">
                    <h3>Can I upgrade my plan?</h3>
                    <p class="lead">
                        Yes, absolutely! If you need more features or resources not available 
                        on the free plan, check out the <a class="link text-dark" href="/premium">Premium</a> page.
                    </p> 
                </div>

                <div class="col-lg-6 mb-5">
                    <h3>How many websites can I host?</h3>
                    <p class="lead">
                        You can host up to 3 websites on the free plan. If you need more, check out the <a class="link text-dark" href="/premium">Premium</a> page.
                    </p> 
                </div>
            </div>
        </div>
    </section>

    <section class="call-to-action text-white">
        <div class="container">
            <div class="row py-5 mb-5">
                <div class="col-lg-12 text-center">
                    <h2 class="display-5 fw-bold mb-2">Ready to get started?</h2>
                    <p class="lead mb-5">
                        Create an account and start building your website today.
                    </p>
                    <a href="/dashboard" class="btn btn-columbia-blue btn-lg rounded-0">Get Started <i class="fas fa-rocket fa-fw ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>