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
    <link href="/themes/velzon/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <!--Swiper slider css-->
    <link href="/themes/velzon/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <?php echo $this->render('partials/head-css'); ?>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php echo $this->render('partials/menu'); ?>



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"><?= $this->title ?></h4>

                            <div class="page-title-right">
                                <?= \yii\widgets\Breadcrumbs::widget([
//                                'itemTemplate' => '<ol class="breadcrumb m-0"><li class="breadcrumb-item">{link}</li></ol>',
//                                'activeItemTemplate' => '<ol class="breadcrumb m-0"><li class="breadcrumb-item active">{link}</li></ol>',
                                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                                    'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                                    'options' => [
                                        'class' => 'breadcrumb',
                                    ],
                                    'encodeLabels' => true,
//                                'separator' => ' > ',  // Set the separator here
                                    'homeLink' => [
                                        'label' => Yii::t('app', 'Dashboard'),
                                        'url' => \yii\helpers\Url::to(['/'])
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <?php echo $this->render('partials/footer'); ?>
    <!-- end main content-->

    <?= $this->render('partials/_modals')?>
    <?= $this->render('partials/_file_uploader')?>


</div>
<!-- END layout-wrapper -->

<?php  $this->render('partials/customizer'); ?>

<script src="<?= \yii\web\JqueryAsset::register($this)->baseUrl ?>/jquery.js"></script>

<?php echo $this->render('partials/vendor-scripts'); ?>

<!-- apexcharts -->
<script src="/themes/velzon/libs/apexcharts/apexcharts.min.js"></script>

<!-- Vector map-->
<script src="/themes/velzon/libs/jsvectormap/js/jsvectormap.min.js"></script>
<script src="/themes/velzon/libs/jsvectormap/maps/world-merc.js"></script>

<!--Swiper slider js-->
<script src="/themes/velzon/libs/swiper/swiper-bundle.min.js"></script>

<!-- Dashboard init -->
<script src="/themes/velzon/js/pages/dashboard-ecommerce.init.js"></script>

<!-- App js -->
<script src="/themes/velzon/js/app.js"></script>

<script src="/themes/velzon/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>


<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>


<?php
$translation = \common\libraries\CustomWidgets::getTranslationMessages();
$script = <<< JS

function translate(_input) {
    var _t = $translation;
    for (var key in _t) {
        if (key == _input) {
            if (_t[key] == null || _t[key] == '') return _input;
            return _t[key].replaceAll('@', '');
        }
    }
    return _input;
}
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();