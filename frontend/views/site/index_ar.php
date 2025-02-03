<?php
use common\models\Plan;

/** @var yii\web\View $this */

$this->title = 'MyBaby';
$assetsUrl = '/themes/alphabet/html/';

// Define features for each plan
$features = [
    '1' => [
        array_merge(
            ['text' => Yii::t('app', 'Up to {n} Teachers', ['n' => Plan::PLANS['1']['max_teachers']])],
            getIcon(true)
        ),
        array_merge(
            ['text' => Yii::t('app', 'Availability Calculator')],
            getIcon(Plan::PLANS['1']['availability_calculator'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'School Stats')],
            getIcon(Plan::PLANS['1']['school_stats'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Manage Teacher\'s Access')],
            getIcon(Plan::PLANS['1']['teacher_access_management'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Arrival Notification')],
            getIcon(Plan::PLANS['1']['parent_arrival_feature'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Generate invoices for parents through MyBaby')],
            getIcon(Plan::PLANS['1']['generate_invoices_for_parents'])
        ),
    ],
    '2' =>  [
        array_merge(
            ['text' => Yii::t('app', 'Up to {n} Teachers', ['n' => Plan::PLANS['2']['max_teachers']])],
            getIcon(true)
        ),
        array_merge(
            ['text' => Yii::t('app', 'Availability Calculator')],
            getIcon(Plan::PLANS['2']['availability_calculator'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'School Stats')],
            getIcon(Plan::PLANS['2']['school_stats'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Manage Teacher\'s Access')],
            getIcon(Plan::PLANS['2']['teacher_access_management'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Arrival Notification')],
            getIcon(Plan::PLANS['2']['parent_arrival_feature'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Generate invoices for parents through MyBaby')],
            getIcon(Plan::PLANS['2']['generate_invoices_for_parents'])
        ),
    ],
    '3' =>  [
        array_merge(
            ['text' => Yii::t('app', 'Up to {n} Teachers', ['n' => Plan::PLANS['3']['max_teachers']])],
            getIcon(true)
        ),
        array_merge(
            ['text' => Yii::t('app', 'Availability Calculator')],
            getIcon(Plan::PLANS['3']['availability_calculator'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'School Stats')],
            getIcon(Plan::PLANS['3']['school_stats'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Manage Teacher\'s Access')],
            getIcon(Plan::PLANS['3']['teacher_access_management'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Arrival Notification')],
            getIcon(Plan::PLANS['3']['parent_arrival_feature'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Generate invoices for parents through MyBaby')],
            getIcon(Plan::PLANS['3']['generate_invoices_for_parents'])
        ),
    ],
];


function getIcon($is_available){
    $result = [
        'icon' => $is_available ? 'checkbox-circle-fill' : 'close-circle-fill',
        'color' => $is_available ? 'success' : 'danger'
    ];
    return $result;
}
$upgradeToList = !empty($currentPlanInfo['upgrade_to']) ? explode(',', $currentPlanInfo['upgrade_to']) : [];

?>

<div id="layerslider" style="width:1280px;height:600px;">
    <!-- Slide 3 -->
    <div class="ls-slide" data-ls="transition2d:104;duration: 6000;">
        <!-- Background image -->
        <img src="<?=$assetsUrl?>img/slide3.jpg" class="ls-bg" alt="خلفية الشريحة">
        <!-- Parallax Image / hidden on mobile -->
        <img src="<?=$assetsUrl?>img/sun.png" style="top:70px;" class="ls-l img-fluid parallax1 ls-hide-tablet ls-hide-phone" alt="" data-ls="delayin:1000;easingin:easeOutExpo;parallaxlevel:7;">
        <!-- Text -->
        <div class="ls-l" style="top:200px;margin-left:4%;width:90%;" data-ls="offsetxin:0;durationin:2000;delayin:1500;easingin:easeOutExpo;rotatexin:-90;transformoriginin:50% top 0;offsetxout:-200;durationout:1000;parallaxlevel:2;">
            <div class="header-text col-lg-5 col-xl-5">
                <h1>لديكم أسئلة؟</h1>
                <p class="subtitle"> تواصلوا معنا، نحن سعداء بالإجابة على استفساراتكم</p>
                <!-- Button -->
                <div class="page-scroll">
                    <a class="btn" href="#contact">تواصل معنا</a>
                </div>
            </div>
        </div>
        <!-- Parallax Image / hidden on mobile -->
        <img src="<?=$assetsUrl?>img/flower.png" class="ls-l img-fluid parallax2 ls-hide-tablet ls-hide-phone" alt="" style="top:380px;left:42%;" data-ls="delayin:1500;easingin:easeOutExpo;parallaxlevel:6;">
    </div>
</div>
<!-- /Layerslider ends -->
<!-- Clouds SVG Divider -->
<div id="cloud-home" class="container-fluid cloud-divider">
    <svg id="deco-clouds1" class="head" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
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
<!-- /Clouds SVG Divider -->
<!-- Section Services -->
<section id="services" class="color-section">
    <div class="container">
        <div class="col-lg-12 pt-2">
            <!-- Section heading -->
            <div class="section-heading">
                <h2>خدماتنا</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-6 text-center">
                <h3 class="text-center">مرحباً بكم في ماي بيبي: تحويل إدارة الطفولة المبكرة</h3>
                <p class="fw-bold">
                    في ماي بيبي، ندرك أن أساس نجاح الطفل يبدأ مبكراً. تم تصميم منصتنا المبتكرة لتمكين المدارس من حلول إدارة سلسة مخصصة خصيصاً للتعليم في مرحلة الطفولة المبكرة.
                </p>
                <p>
                    باستخدام ماي بيبي، يمكن للمعلمين تتبع الحضور بسهولة، التواصل بتحديثات يومية، وإشراك الآباء في تطور أطفالهم. تجربة جديدة لمستوى من التميز في إدارة المدارس، حيث يتلاقى نمو العقول الصغيرة مع التكنولوجيا المتطورة.
                </p>
            </div>
            <div class="col-md-12 col-lg-5 offset-lg-1">
                <img src="<?=$assetsUrl?>img/mb-services.png" alt="" class="img-fluid mx-auto">
            </div>
        </div>
        <div class="row mt-5 g-lg-5">
            <div class="col-lg-4">
                <div class="service float">
                    <img src="<?=$assetsUrl?>img/mb-services1.jpeg" alt="" class="rounded-circle mx-auto img-fluid">
                    <h4>المعلمين</h4>
                    <p class="mt-3">
                        بفضل ماي بيبي، يمكن للمدارس بسهولة إضافة وإدارة المعلمين ضمن النظام، مما يضمن أن يتم التعرف على كل معلم ودعمه في دوره.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 res-margin">
                <div class="service float">
                    <img src="<?=$assetsUrl?>img/mb-services2.jpeg" alt="" class="rounded-circle mx-auto img-fluid">
                    <h4>الفصول</h4>
                    <p class="mt-3">
                        توفر منصتنا للمدارس إمكانية تخصيص الفصول للمعلمين، مما يمكن كل معلم من التعامل مع عدة فصول.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service float">
                    <img src="<?=$assetsUrl?>img/mb-services.png" alt="" class="rounded-circle mx-auto img-fluid">
                    <h4>الحضور</h4>
                    <p class="mt-3">
                        يمكن للمعلمين تسجيل حضور الطلاب اليومي بسهولة، وتقديم تحديثات في الوقت الفعلي التي يمكن للآباء الوصول إليها.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section ends -->
<!-- Section Callout -->
<section id="callout" class="small-section lightblue">
    <div class="d-none d-lg-block">
        <div class="cloud x1"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
        <div class="cloud x6"></div>
        <div class="cloud x7"></div>
    </div>
    <div class="container">
        <div class="col-lg-6 d-inline-block p-3">
            <div class="card text-center">
                <h3>أكثر من مجرد تطبيق!</h3>
                <p>
                    مع ميزات تتيح للمدارس إدارة المعلمين، الفصول، والحضور اليومي بكفاءة، نضمن مشاركة المعلمين والآباء في نمو وتطور كل طفل.
                </p>
                <div class="page-scroll">
                    <a class="btn" href="#contact">تواصل معنا</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section ends -->
<!-- Section About -->
<section id="about">
    <div class="container">
        <div class="col-lg-12 pt-2">
            <div class="section-heading">
                <h2>من نحن</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-sm-12 col-lg-5">
                <div id="carousel-about" class="slider-1">
                    <div class="item">
                        <img class="img-fluid" src="<?=$assetsUrl?>img/about1.jpg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="<?=$assetsUrl?>img/mb-services2.jpeg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="<?=$assetsUrl?>img/about3.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-sm-12">
                <h3>فلسفتنا</h3>
                <p>
                    في ماي بيبي، نؤمن بأن إدارة الطفولة المبكرة يجب أن تكون سلسة وخالية من الإجهاد. رؤيتنا هي تحويل نظام الأعمال الورقية التقليدي إلى تجربة خالية من الورق.
                </p>
                <p>
                    نتصور مستقبلاً تتواصل فيه المدارس وأولياء الأمور أكثر من أي وقت مضى، لتكوين شراكة قوية تدعم نمو ونجاح كل طفل.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Section Features -->
<section id="features">
    <div class="container">
        <div class="section-heading">
            <h2>المزايا</h2>
        </div>
        <ul class="nav nav-tabs justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-selected="true">السعة</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-selected="false">إدارة المعلمين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-selected="false">الدفعات الفورية</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button" role="tab" aria-selected="false">التقارير</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <img src="<?=$assetsUrl?>img/activity1.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <h3>عرض التقويم</h3>
                        <div class="accordion" id="accordion1">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        توافر المعلمين
                                    </button>
                                </h4>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        <p>
                                            يوفر لنا اللوحة الأم عرض تقويم واضح لمعرفة المعلمين المتاحين في كل يوم، مما يوفر على المدارس الكثير من الوقت لتسجيل الطلاب الجدد.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        المعلمين لكل درجة
                                    </button>
                                </h4>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        <p>
                                            كل درجة يمكن أن يكون لها معلمين متعددين. يمكن لكل معلم التعامل مع عدد من الطلاب حسب كفاءته.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        تسجيل الأطفال
                                    </button>
                                </h4>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        <p>
                                            من خلال عرض التقويم، يصبح من السهل تسجيل الأطفال الجدد في البرنامج المدرسي.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <img src="<?=$assetsUrl?>img/activity2.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <h3>المسؤوليات</h3>
                        <div class="accordion" id="accordion2">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                                        أدوار المعلمين
                                    </button>
                                </h4>
                                <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordion2">
                                    <div class="accordion-body">
                                        <p>
                                            يتمتع كل معلم بدوره الخاص في إدارة الحضور أو التعامل مع نتائج التعليم والفصول.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <img src="<?=$assetsUrl?>img/activity4.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <h3>أنظمة الدفع الخالية من القلق</h3>
                        <div class="accordion" id="accordion4">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne4">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne">
                                        الدفع عبر الإنترنت
                                    </button>
                                </h4>
                                <div id="collapseOne4" class="accordion-collapse collapse show" aria-labelledby="headingOne4" data-bs-parent="#accordion4">
                                    <div class="accordion-body">
                                        <p>
                                            توفر ماي بيبي جميع وسائل الدفع الآمنة مثل مدى وآبل باي وفيزا وماستركارد.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTwo4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo">
                                        الفواتير الفورية
                                    </button>
                                </h4>
                                <div id="collapseTwo4" class="accordion-collapse collapse" aria-labelledby="headingTwo4" data-bs-parent="#accordion4">
                                    <div class="accordion-body">
                                        <p>
                                            المدارس يمكنها إصدار فواتير يمكن للآباء دفعها من خلال أجهزتهم.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingThree4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                                        تتبع المدفوعات
                                    </button>
                                </h4>
                                <div id="collapseThree4" class="accordion-collapse collapse" aria-labelledby="headingThree4" data-bs-parent="#accordion4">
                                    <div class="accordion-body">
                                        <p>
                                            يمكن للآباء الاطلاع على الفواتير السابقة والمدفوعات القادمة عبر التطبيق.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <img src="<?=$assetsUrl?>img/activity5.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <h3>ابقَ على اطلاع</h3>
                        <div class="accordion" id="accordion5">
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne5">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne">
                                        الأنشطة اليومية
                                    </button>
                                </h4>
                                <div id="collapseOne5" class="accordion-collapse collapse show" aria-labelledby="headingOne5" data-bs-parent="#accordion5">
                                    <div class="accordion-body">
                                        <p>
                                            يمكن للمعلمين نشر تحديثات حول أنشطة الأطفال يومياً، ليكون الآباء على اطلاع دائم بأحداث يوم أطفالهم، من وقت الحضور إلى أوقات النوم وأوقات الذهاب إلى الحمام.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--accordion item -->
                        </div>
                        <!--/accordion -->
                    </div>
                    <!-- /.col-md-7 -->
                </div>
                <!-- /.row -->
                <!--/Tab Content 5 ends -->
            </div>
            <!--/tab-pane -->
        </div>
        <!--/tab-content -->
    </div>
    <!-- /container -->
</section>
<!-- /Section ends -->
<!-- Parallax object -->
<div class="parallax-object2 d-none d-lg-block" data-0="opacity:1;"
     data-start="margin-top:40%"
     data-100="transform:translatey(0%);"
     data-center-bottom="transform:translatey(-220%);">
    <!-- Image -->
    <img src="<?=$assetsUrl?>img/parallaxobject2.png" alt="">
</div>
<!-- Section Gallery -->
<section id="gallery" dir="ltr" hidden="hidden">
    <!-- svg triangle shape -->
    <svg class="triangleShadow" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path class="trianglePath1" d="M0 0 L50 100 L100 0 Z" />
    </svg>
    <div class="container">
        <!-- Section heading -->
        <div class="section-heading">
            <h2>معرض الصور</h2>
        </div>
        <!-- Navigation -->
        <div class="text-center col-md-12">
            <ul class="nav nav-pills justify-content-center cat mb-5" id="gallerytab">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" data-toggle="tab" data-filter="*">الكل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="tab" data-filter=".events">الأحداث</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="tab" data-filter=".facilities">مرافقنا</a>
                </li>
            </ul>
        </div>
        <!-- Gallery -->
        <div class="row">
            <div class="col-md-12">
                <div id="lightbox">
                    <!-- Image 1 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 events">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery1.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery1.jpg" class="link centered" title="يمكنك إضافة تعليق على الصور.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Additional images omitted for brevity -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->
<!-- Section Prices -->
<section id="prices" class="color-section">
    <div class="container">
        <div class="col-lg-8">
            <div class="section-heading">
                <h2>حزمنا</h2>
            </div>
        </div>
        <!-- Pricing Plans -->
        <div class="pricing pricing-palden">
            <div class="row p-3">
                <div class="pricing-item col-lg-4">
                    <div class="pricing-deco">
                        <div class="pricing-price"><span class="pricing-currency">ريال</span>0
                            <span class="pricing-period">/  لمدة 14 يومًا</span>
                        </div>
                        <h3 class="pricing-title">فترة تجريبية مجانية</h3>
                    </div>
                    <!-- List -->
                    <ul class="pricing-feature-list">
                        <?php foreach ($features[1] as $feature) { ?>
                            <li><?= $feature['color'] == 'success' ? $feature['text'] : '' ?></li>
<!--                        <li>15 معلمين</li>-->
<!--                        <li>صف واحد لكل معلم</li>-->
<!--                        <li>التواصل الاجتماعي</li>-->
<!--                        <li>إشعارات استلام الأطفال</li>-->
                        <?php } ?>
                    </ul>
                    <!-- Button-->
                    <div class="page-scroll">
                        <a class="btn" href="#contact">تواصل معنا</a>
                    </div>
                </div>
                <div class="pricing-item pricing-item-featured col-lg-4">
                    <div class="pricing-deco pink">
                        <div class="pricing-price"><span class="pricing-currency">ريال</span>350
                            <span class="pricing-period">/ شهرياً</span>
                        </div>
                        <h3 class="pricing-title">بريميوم</h3>
                    </div>
                    <!-- List -->
                    <ul class="pricing-feature-list">
                        <?php foreach ($features[3] as $feature) { ?>
                            <li><?= $feature['color'] == 'success' ? $feature['text'] : '' ?></li>
<!--                        <li>50 معلمين</li>-->
<!--                        <li>صفوف غير محدودة لكل معلم</li>-->
<!--                        <li>التواصل الاجتماعي</li>-->
<!--                        <li>إشعارات استلام الأطفال</li>-->
<!--                        <li>الدفع عبر الإنترنت</li>-->
                        <?php } ?>

                    </ul>
                    <div class="page-scroll">
                        <a class="btn" href="#contact">تواصل معنا</a>
                    </div>
                </div>
                <div class="pricing-item col-lg-4">
                    <div class="pricing-deco">
                        <div class="pricing-price"><span class="pricing-currency">ريال</span>250
                            <span class="pricing-period">/ شهرياً</span>
                        </div>
                        <h3 class="pricing-title">أساسي</h3>
                    </div>
                    <!-- List -->
                    <ul class="pricing-feature-list">
                        <?php foreach ($features[2] as $feature) { ?>
                            <li><?= $feature['color'] == 'success' ? $feature['text'] : '' ?></li>
<!--                        <li>10 معلمين</li>-->
<!--                        <li>3 صفوف لكل معلم</li>-->
<!--                        <li>التواصل الاجتماعي</li>-->
<!--                        <li>إشعارات استلام الأطفال</li>-->
<!--                        <li>الدفع عبر الإنترنت <br><span class="text-muted">(للاشتراك المدرسي فقط)</span></li>-->
                        <?php } ?>
                    </ul>
                    <div class="page-scroll">
                        <a class="btn" href="#contact">تواصل معنا</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section ends -->


<!-- Section Call to Action -->
<section id="call-to-action" class="small-section">
    <div class="container text-center">
        <div class="col-lg-6 offset-lg-6 p-3">
            <div class="card">
                <h3>احصل على مزيد من المعلومات</h3>
                <p>
                    مع MyBaby، يمكن للمعلمين تتبع الحضور بسهولة، وتقديم تحديثات يومية، وإشراك الآباء في نمو أطفالهم. تجربة جديدة في إدارة المدارس تجمع بين تنمية العقول الشابة والتكنولوجيا المتقدمة.
                </p>
                <div class="page-scroll">
                    <a class="btn" href="#about">عنّا</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Contact -->
<section id="contact" class="color-section">
    <div class="container pb-5 pb-lg-3">
        <div class="row">
            <div class="col-lg-12 pt-2">
                <div class="section-heading">
                    <h2>اتصل بنا</h2>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <h4>معلومات</h4>
                <div class="contact-info">
                    <p><i class="flaticon-back"></i><a href="mailto:youremailaddress">info@mybaby.com</a></p>
                    <p><i class="fa fa-phone margin-icon"></i>اتصل بنا </p> <span>+966 54 485 6525</span>
                </div>
                <p>موقعنا في شارع ٤٥، الخبر، المملكة العربية السعودية</p>
                <div id="map-canvas"></div>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <h4>اكتب لنا</h4>
                <div id="error-message"></div>
                <div id="contact_form">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control input-field" placeholder="الاسم" required="">
                        <input type="email" name="email" class="form-control input-field" placeholder="البريد الإلكتروني" required="">
                        <input type="text" name="subject" class="form-control input-field" placeholder="الموضوع" required="">
                    </div>
                    <textarea name="message" id="message" class="textarea-field form-control" rows="4" placeholder="أدخل رسالتك" required=""></textarea>
                    <button type="submit" id="submit_btn" value="Submit" class="btn mx-auto">أرسل الرسالة</button>
                </div>
                <div id="contact_results"></div>
            </div>
        </div>
    </div>
</section>

<!-- Section Contact -->
<section id="contact" class="color-section">
    <div class="container pb-5 pb-lg-3">
        <div class="row">
            <div class="col-lg-12 pt-2">
                <!-- Section heading -->
                <div class="section-heading text-center">
                    <h2>حمّل التطبيق</h2>
                    <p>احصل على التطبيق للحصول على أفضل تجربة على جهازك.</p>
                </div>
            </div>
                <div class="col-6 col-md-3 offset-md-3">
                    <!-- Play Store Link -->
                    <a href="https://play.google.com/store/apps/details?id=com.mybabyapp.net" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                             alt="جوجل بلاي"
                             width="300"
                             class="img-fluid download-logo">
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <!-- App Store Link -->
                    <a href="https://apps.apple.com/us/app/mybaby-kindergarten/id6714474376" target="_blank">
                        <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                             alt="متجر آبل"
                             width="275"
                             class="img-fluid download-logo">
                    </a>
                </div>
    </div>
</section>
