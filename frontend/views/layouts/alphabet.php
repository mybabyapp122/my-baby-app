<?php
/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Html;

$this->beginPage();
$assetsUrl = '/themes/alphabet/html/';
$isEnglish = strpos(Yii::$app->language, 'en') !== false;

?>

    <head>
        <meta charset="utf-8">
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Page title -->
        <title><?=$this->title?></title>
        <!--[if lt IE 9]>
        <script src="<?=$assetsUrl?>js/respond.js"></script>
        <![endif]-->
        <!-- Bootstrap Core CSS -->
        <link href="<?=$assetsUrl?>css/bootstrap.css" rel="stylesheet" type="text/css">
        <!-- Icon fonts -->
        <link href="<?=$assetsUrl?>fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="<?=$assetsUrl?>fonts/flaticons/flaticon.css" rel="stylesheet" type="text/css">
        <!-- Google fonts -->
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700,800%7CAlegreya+Sans:700,900' rel='stylesheet' type='text/css'>
        <!-- Theme CSS -->
        <?php if ($isEnglish) : ?>
        <link href="<?=$assetsUrl?>css/style.css" rel="stylesheet">
        <?php else :?>
        <link href="<?=$assetsUrl?>css/style_ar.css" rel="stylesheet">
        <?php endif ?>
        <!-- Color Style CSS -->
        <link href="<?=$assetsUrl?>styles/nanny-mb.css" rel="stylesheet">
        <!-- Plugins -->
        <link rel="stylesheet" href="<?=$assetsUrl?>css/plugins.css">
        <!-- LayerSlider stylesheet -->
        <link rel="stylesheet" href="<?=$assetsUrl?>layerslider/css/layerslider.css">
        <!-- Favicons-->
        <link rel="apple-touch-icon" sizes="72x72" href="<?=$assetsUrl?>/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=$assetsUrl?>/apple-touch-icon-114x114.png">
        <link rel="shortcut icon" href="<?=$assetsUrl?>favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
    </head>

    <body id="page-top" class="full" data-bs-spy="scroll" data-bs-target=".navbar-nav">
    <?php $this->beginBody() ?>

    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-xl fixed-top">
        <div class="container">
            <!-- Logo mobile-->
            <a class="navbar-brand-small page-scroll my-auto d-xl-none" href="#page-top">
                <img src="<?=$assetsUrl?>img/logo.png" alt="">
            </a>
            <div class="justify-content-lg-end">
                <!-- hamburger menu -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-alphabet" aria-controls="nav-alphabet" aria-expanded="false" aria-label="<?=Yii::t('app', 'Toggle navigation');?>">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="nav-alphabet">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item home">
                        <a class="nav-link active" href="#layerslider"><?=Yii::t('app', 'Home');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services"><?=Yii::t('app', 'Services');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about"><?=Yii::t('app', 'About');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features"><?=Yii::t('app', 'Features');?></a>
                    </li>
                    <!--desktop logo -->
                    <li class="nav-item d-none d-xl-block navbar-brand-centered">
                        <a href="#page-top">
                            <img src="<?=$assetsUrl?>img/logo.png" alt="">
                        </a>
                    </li>
                    <!--/desktop logo -->
                    <li class="nav-item" hidden="hidden">
                        <a class="nav-link" href="#gallery"><?=Yii::t('app', 'Gallery');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#prices"><?=Yii::t('app', 'Prices');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact"><?=Yii::t('app', 'Contact');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://dash.mybabyapp.net"><?=Yii::t('app', 'Login/Register');?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle page-dropdown" href="#" id="sub-menu2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?=Yii::t('app', 'Language');?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="sub-menu2">
                            <li><a class="dropdown-item" href="/site/index?lang=ar"><?=Yii::t('app', 'Arabic');?></a></li>
                            <li><a class="dropdown-item" href="/site/index?lang=en"><?=Yii::t('app', 'English');?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--/navbar ends-->

    <?php echo $content; ?>

    <!-- Footer -->
    <div id="footer-divider" class="container-fluid cloud-divider">
        <!-- Clouds SVG Divider -->
        <svg id="deco-clouds" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M-5 100 Q 0 20 5 100 Z
               M0 100 Q 5 0 10 100
               M5 100 Q 10 30 15 100
               M10 100 Q 15 10 20 100
               M15 100 Q 20 30 25 100
               M20 100 Q 25 -10 30 100
               M25 100 Q 30 10 35 100
               M30 100 Q 35 30 40 100
               M35 100 Q 40 10 45 100
               M40 100 Q 45 50 50 100
               M45 100 Q 50 20 55 100
               M50 100 Q 55 40 60 100
               M55 100 Q 60 60 65 100
               M60 100 Q 65 50 70 100
               M65 100 Q 70 20 75 100
               M70 100 Q 75 45 80 100
               M75 100 Q 80 30 85 100
               M80 100 Q 85 20 90 100
               M85 100 Q 90 50 95 100
               M90 100 Q 95 25 100 100
               M95 100 Q 100 15 105 100 Z">
            </path>
        </svg>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <!-- Newsletter -->
                <div class="col-lg-3 text-center res-margin my-auto">
                    <!-- Begin Mailchimp Signup Form -->
                    <div id="mc_embed_signup" style="display: none">
                        <!-- change your mailchimp URL below -->
                        <form action="//yourlist.us12.list-manage.com/subscribe/post?u=04e646927a196552aaee78a7b&amp;id=111" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll">
                                <div class="mc-field-group">
                                    <input type="email" value="" name="EMAIL" placeholder="Email address" class="form-control required email" id="mce-EMAIL">
                                </div>
                                <div id="mce-responses" class="clear foot">
                                    <div class="response mt-2" id="mce-error-response" ></div>
                                    <div class="response alert alert-success mt-2" id="mce-success-response"></div>
                                </div>
                                <div class="optionalParent">
                                    <div class="clear foot">
                                        <input type="submit" class="btn btn-primary" value="Subscribe" name="subscribe" id="mc-embedded-subscribe">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--End mc_embed_signup-->
                </div>
                <!-- /col-lg -->
                <!-- Bottom Credits -->
                <div class="col-lg-6 res-margin my-auto">
                    <a href="#page-top"><img src="<?=$assetsUrl?>img/logo.png"  alt="" class="d-block mx-auto"></a>
                    <!-- social-icons -->
                    <div class="social-media text-center mt-3">
                        <a href="#" title=""><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" title=""><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" title=""><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#" title=""><i class="fa-brands fa-pinterest"></i></a>
                        <a href="#" title=""><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
                <!-- /col-lg- -->
                <!-- Opening Hours -->
                <div class="col-lg-3 my-auto text-center">

                </div>
                <!-- /col-lg- -->
            </div>
            <!-- / row -->
        </div>
        <!-- / container -->
        <hr>

        <p class="credits">Copyright &copy; 2024  <a href="https://www.mybaby.com">mybaby.com</a></p>
        <!-- /container -->
        <!-- Go To Top Link -->
        <div class="page-scroll d-none d-lg-block">
            <a href="#page-top" class="back-to-top"><i class="fa fa-angle-up"></i></a>
        </div>
    </footer>
    <!-- /footer ends -->
    <!-- Core JavaScript Files -->
    <script src="<?=$assetsUrl?>js/jquery.min.js"></script>
    <script src="<?=$assetsUrl?>js/bootstrap.min.js"></script>
    <!-- Main Js -->
    <script src="<?=$assetsUrl?>js/main.js"></script>
    <!--Other Plugins -->
    <script src="<?=$assetsUrl?>js/plugins.js"></script>
    <!-- Isotope -->
    <script src="<?=$assetsUrl?>js/isotope.js"></script>
    <!-- Contact -->
    <script src="<?=$assetsUrl?>js/contact.js"></script>
    <!-- GreenSock -->
    <script src="<?=$assetsUrl?>layerslider/js/greensock.js" ></script>
    <!-- LayerSlider script files -->
    <script src="<?=$assetsUrl?>layerslider/js/layerslider.transitions.js" ></script>
    <script src="<?=$assetsUrl?>layerslider/js/layerslider.kreaturamedia.jquery.js" ></script>
    <script src="<?=$assetsUrl?>layerslider/js/layerslider.load.js" ></script>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage();