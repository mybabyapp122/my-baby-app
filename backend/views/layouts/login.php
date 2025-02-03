<?php
/** @var \yii\web\View $this */
/** @var string $content */

//use backend\assets\AppAsset;
//use common\widgets\Alert;
//use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
//use yii\bootstrap5\Nav;
//use yii\bootstrap5\NavBar;

$this->beginPage();
echo $this->render('partials/main');

?>

<head>
    <?php echo $this->render('partials/title-meta', array('title' => $this->title ?: 'Dashboard')); ?>
    <!-- jsvectormap css -->
    <link href="/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <!--Swiper slider css-->
    <link href="/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <?php echo $this->render('partials/head-css'); ?>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>



<!-- auth-page wrapper -->
<div style="background-image: url('/images/mybaby/login-bg.png'); background-position: bottom; background-repeat: no-repeat; background-size: 100%; background-color: white">
<div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100" >
    <!-- auth-page content -->
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 mx-auto" style="text-align: center">
                    <a href="#" class="mx-auto" style="text-align: center">
                        <img alt="Logo" src="/images/mybaby/mb-logo-lg.png" class="img-fluid h-120px">
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <?= $content; ?>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
    <?php echo $this->render('partials/footer'); ?>
</div>
</div>


<?php echo $this->render('partials/vendor-scripts'); ?>

<!-- password-addon init -->
<script src="/js/pages/password-addon.init.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
