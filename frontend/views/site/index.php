<?php

/** @var yii\web\View $this */
use common\models\Plan;
$this->title = 'MyBaby';
$assetsUrl = '/themes/alphabet/html/';


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


?>

<div id="layerslider" style="width:1280px;height:600px;">
    <!-- Slide 1 -->
<!--    -->
    <!-- Slide 3 -->
    <div class="ls-slide" data-ls="transition2d:104;duration: 6000;">
        <!-- Background image -->
        <img src="<?=$assetsUrl?>img/slide3.jpg" class="ls-bg"  alt="Slide background">
        <!-- Parallax Image / hidden on mobile  -->
        <img src="<?=$assetsUrl?>img/sun.png" style="top:70px;" class="ls-l img-fluid parallax1 ls-hide-tablet ls-hide-phone" alt="" data-ls="delayin:1000;easingin:easeOutExpo;parallaxlevel:7;">
        <!-- Text -->
        <div class="ls-l" style="top:200px;margin-left:4%;width:90%;" data-ls="offsetxin:0;durationin:2000;delayin:1500;easingin:easeOutExpo;rotatexin:-90;transformoriginin:50% top 0;offsetxout:-200;durationout:1000;parallaxlevel:2;">
            <div class="header-text col-lg-5 col-xl-5">
                <h1>Any Questions?</h1>
                <p class="subtitle"> Reach out to us. We are more than happy to answer your queries</p>
                <!-- Button -->
                <div class="page-scroll">
                    <a class="btn" href="#contact">Contact us</a>
                </div>
            </div>
        </div>
        <!-- Parallax Image / hidden on mobile -->
        <img src="<?=$assetsUrl?>img/flower.png" class="ls-l img-fluid parallax2 ls-hide-tablet ls-hide-phone" alt="" style=" top:380px;left:42%;" data-ls="delayin:1500;easingin:easeOutExpo;parallaxlevel:6;">
    </div>
    <!-- Slide 4 -->

</div>
<!-- /Layerslider ends-->
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
        <div class="col-lg-8 offset-lg-2">
            <!-- Section heading -->
<!--            <div class="section-heading">-->
<!--                <h2>Our Services</h2>-->
<!--            </div>-->
        </div>
        <div class="row align-items-center">
            <!-- main text -->
            <div class="col-md-12 col-lg-6 text-center">
                <h3 class="text-center">Welcome to MyBaby: Transforming Early Childhood Management</h3>
                <p class="fw-bold">
                    At MyBaby, we understand that the foundation for a child's success starts early. Our innovative platform is designed to empower schools with seamless management solutions tailored specifically for early childhood education.
                </p>
                <p>
                    With MyBaby, educators can effortlessly track attendance, communicate daily updates, and engage parents in their child's development. Experience a new standard of excellence in school management, where nurturing young minds meets cutting-edge technology. Join us in creating a brighter future for every child!
                </p>
            </div>
            <!-- /col-sm-12-->
            <div class="col-md-12 col-lg-5 offset-lg-1">
                <!-- Image -->
                <img src="<?=$assetsUrl?>img/mb-services.png" alt="" class="img-fluid mx-auto">
            </div>
            <!-- /col-md-12-->
        </div>
        <!-- /row -->
        <div class="row mt-5 g-lg-5">
            <!-- item 1-->
            <div class="col-lg-4">
                <div class="service float">
                    <img src="<?=$assetsUrl?>img/mb-services1.jpeg" alt="" class="rounded-circle mx-auto img-fluid">
                    <h4>Teachers</h4>
                    <p class="mt-3">
                        With MyBaby, schools can easily add and manage teachers within the system, ensuring that every educator is recognized and supported in their role. Each teacher can access their own dashboard
                    </p>
                </div>
            </div>
            <!-- /col -->
            <!-- item 2-->
            <div class="col-lg-4 res-margin">
                <div class="service float">
                    <img src="<?=$assetsUrl?>img/mb-services2.jpeg" alt="" class="rounded-circle mx-auto  img-fluid">
                    <h4>Grades</h4>
                    <p class="mt-3">
                        Our platform allows schools to assign grades to teachers, enabling each educator to handle multiple classes. This flexibility ensures that every child receives specialized attention from skilled professionals.
                    </p>
                </div>
            </div>
            <!-- /col-->
            <!-- item 3-->
            <div class="col-lg-4 ">
                <div class="service float">
                    <img src="<?=$assetsUrl?>img/mb-services.png" alt="" class="rounded-circle mx-auto img-fluid">
                    <h4>Attendance</h4>
                    <p class="mt-3">
                        Teachers can efficiently record daily attendance for students, providing real-time updates that parents can access through their app. This transparency keeps parents informed about their child's participation.
                    </p>
                </div>
            </div>
            <!-- /col -->
            <!-- item 3-->
        </div>
        <!-- /row -->
    </div>
    <!-- /container-->
</section>
<!-- /Section ends -->
<!-- Section Callout -->
<section id="callout" class="small-section lightblue">
    <!-- Clouds background -->
    <div class="d-none d-lg-block">
        <div class="cloud x1"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
        <div class="cloud x6"></div>
        <div class="cloud x7"></div>
    </div>
    <!-- /Clouds ends -->
    <div class="container">
        <!-- Animated Sun -->
        <div class="sun d-none d-lg-block">
            <div class="sun-face">
                <div class="sun-hlight"></div>
                <div class="sun-leye"></div>
                <div class="sun-reye"></div>
                <div class="sun-lred"></div>
                <div class="sun-rred"></div>
                <div class="sun-smile"></div>
            </div>
            <!-- Sun rays -->
            <div class="sun-anime">
                <div class="sun-ball"></div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
                <div class="sun-light"><b></b><s></s>
                </div>
            </div>
        </div>
        <!-- /Animated Sun -->
        <div class="col-lg-6 d-inline-block p-3">
            <div class="card text-center ">
                <h3>More than just an app!</h3>
                <p>
                    With features that allow schools to efficiently manage teachers, grades, and daily attendance, we ensure that both educators and parents are engaged in the growth and development of every child.
                </p>
                <div class="page-scroll">
                    <!-- Button-->
                    <a class="btn" href="#contact">Contact us</a>
                </div>
                <!-- /page-scroll -->
            </div>
            <!-- /card -->
        </div>
        <!-- /col-lg-6 -->
    </div>
    <!-- /container-->
</section>
<!-- Section Ends-->
<!-- Section About -->
<section id="about">
    <div class="container">
        <div class="col-lg-8 offset-lg-2">
            <!-- Section heading -->
            <div class="section-heading">
                <h2>About us</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-sm-12 col-lg-5">
                <!-- Carousel -->
                <div id="carousel-about" class="slider-1">
                    <div class="item">
                        <img class="img-fluid" src="<?=$assetsUrl?>img/mb-services1.jpeg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="<?=$assetsUrl?>img/mb-services2.jpeg" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="<?=$assetsUrl?>img/mb-services.png" alt="">
                    </div>
                </div>
            </div>
            <!-- text -->
            <div class="col-lg-7 col-sm-12">
                <h3>Our Philosophy</h3>
                <p>
                    At MyBaby, we believe that early childhood management should be seamless and stress-free. Our vision is to transform the traditional, cumbersome paperwork system into a streamlined, paperless experience. By leveraging technology, we aim to eliminate administrative burdens, allowing educators to focus on what truly matters: nurturing and developing young minds. We are committed to providing a platform that simplifies processes, enhances communication, and fosters a collaborative environment for everyone involved.
                </p>
                <p>
                    We envision a future where schools and parents are more connected than ever before. Our goal is to bridge the gap between educators and families, creating an open line of communication that encourages active participation in a child's educational journey. With real-time updates on attendance, daily activities, and developmental milestones, we empower parents to stay engaged and informed, fostering a strong partnership that supports every child's growth and success.
                </p>
            </div>
            <!-- /col-lg- -->
        </div>
        <!-- /row -->
        <div class="row features">
            <!-- First row -->
            <div class="row">
                <!-- item1 -->
                <div class="col-md-4 media text-center p-5">
                    <i class="flaticon-game"></i>
                    <div class="feature-body">
                        <h5 class="feature-heading">infrastructure</h5>
                        <p>
                            Robust and user-friendly platform designed for efficient management of early childhood education.
                        </p>
                    </div>
                </div>
                <!-- item2 -->
                <div class="col-md-4 media text-center p-5">
                    <i class="flaticon-fruit"></i>
                    <div class="feature-body">
                        <h5 class="feature-heading">Transparency</h5>
                        <p>
                            Real-time updates and reports that keep parents informed about their child's progress and school activities.
                        </p>
                    </div>
                </div>
                <!-- item3 -->
                <div class="col-md-4 media text-center p-5">
                    <i class="flaticon-two-1"></i>
                    <div class="feature-body">
                        <h5 class="feature-heading">Instant Messaging</h5>
                        <p>Seamless communication between teachers and parents to discuss updates, concerns, and achievements.</p>
                    </div>
                </div>
            </div>
            <!-- Second row -->
            <div class="row">
                <!-- item4 -->
                <div class="col-md-4 media text-center p-5">
                    <i class="flaticon-person-1"></i>
                    <div class="feature-body">
                        <h5 class="feature-heading">Picture Updates</h5>
                        <p>
                            Share daily snapshots of children’s activities, fostering connection and engagement between home and school.
                        </p>
                    </div>
                </div>
                <!-- item5 -->
                <div class="col-md-4 media text-center p-5">
                    <i class="flaticon-school"></i>
                    <div class="feature-body">
                        <h5 class="feature-heading">Safety First</h5>
                        <p>Prioritizing child safety with secure access controls and data protection measures for peace of mind.</p>
                    </div>
                </div>
                <!-- item6 -->
                <div class="col-md-4 media text-center p-5">
                    <i class="flaticon-interface"></i>
                    <div class="feature-body">
                        <h5 class="feature-heading">Activities</h5>
                        <p>Monitor attendance and daily activities easily, ensuring parents are always in the loop about their child's day.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row features -->
    </div>
    <!--/container-->
</section>
<!--/ Section ends -->
<!-- Parallax object -->
<div class="parallax-object1 d-none d-lg-block" data-0="opacity:1;"
     data-100="transform:translatey(20%);"
     data-center-bottom="transform:translatey(-180%);">
    <!-- Image -->
    <img src="<?=$assetsUrl?>img/parallaxobject1.png" alt="">
</div>
<!-- Section activities -->
<section id="features">
    <div class="container">
        <!-- Section Heading -->
        <div class="section-heading">
            <h2>Features</h2>
        </div>
        <!--nav tabs -->
        <ul class="nav nav-tabs justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab"  aria-selected="true">Occupancy</button>
            </li>
            <!--/nav-item -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab"  aria-selected="false">Teacher Management</button>
            </li>
            <!--/nav-item -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-selected="false">Instant Payments</button>
            </li>
            <!--/nav-item -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button" role="tab" aria-selected="false">Reports</button>
            </li>
            <!--/nav-item -->
        </ul>
        <!--/nav-tabs -->
        <div class="tab-content color_block" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                <!--Tab Content 1 -->
                <div class="row g-lg-5 align-items-center">
                    <div class="col-lg-5">
                        <!-- Activity image-->
                        <img src="<?=$assetsUrl?>img/activity1.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <!-- Activity text-->
                        <h3>Calendar View</h3>
                        <div class="accordion" id="accordion1">
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Teacher Availability
                                    </button>
                                </h4>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        <p>
                                            Our dashboard provides a visually appealing calendar view to get a glance of what teachers are available for which day. This saves the school countless hours for new children registration.
                                        </p>
                                        <p>
                                            Schools are able to edit availability of any teacher from the dashboard.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Teachers per grade
                                    </button>
                                </h4>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        <p>
                                            Each grade can have multiple teachers. Each teacher can have multiple number of students according to their calibre.
                                        </p>
                                        <p>
                                            The calendar view is a very quick way to manage all this hustle.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
                                        Child Registration
                                    </button>
                                </h4>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
                                    <div class="accordion-body">
                                        <p>
                                            Through the calendar view, it is very easy to enroll new children in the school program.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/accordion item -->
                        </div>
                        <!--/accordion -->
                    </div>
                    <!-- /.col-md-7 -->
                </div>
                <!-- /.row -->
                <!--/Tab Content 1 ends -->
            </div>
            <!--/tab-pane -->
            <div class="tab-pane " id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                <!--Tab Content 1 -->
                <div class="row g-lg-5 align-items-center">
                    <div class="col-lg-5">
                        <!-- Activity image-->
                        <img src="<?=$assetsUrl?>img/activity2.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <!-- Activity text-->
                        <h3>Responsibilities</h3>
                        <div class="accordion" id="accordion2">
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                                        Teacher Roles
                                    </button>
                                </h4>
                                <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion2">
                                    <div class="accordion-body">
                                        <p>
                                            Different teachers can have different roles for different grades they teach. Some are responsible for attendance management, while some handle more advanced stuff like educational results or grading.
                                        </p>
                                        <p>
                                            MyBaby does not only make it possible, it makes it faster than ever.
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
                <!--/Tab Content 2 ends -->
            </div>
            <!--/tab-pane -->
            <div class="tab-pane" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                <!--Tab Content 4 -->
                <div class="row g-lg-5 align-items-center">
                    <div class="col-lg-5">
                        <!-- Activity image-->
                        <img src="<?=$assetsUrl?>img/activity4.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <!-- Activity text-->
                        <h3>Worry-free payment systems</h3>
                        <div class="accordion" id="accordion4">
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne4">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne">
                                        Online
                                    </button>
                                </h4>
                                <div id="collapseOne4" class="accordion-collapse collapse show" aria-labelledby="headingOne4" data-bs-parent="#accordion4">
                                    <div class="accordion-body">
                                        <p>
                                            Online transactions via famous payment methods like mada, applepay, visa or mastercard is a necessity of today.
                                        </p>
                                        <p>
                                            MyBaby supports all major payment methods
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingTwo4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo4" aria-expanded="false" aria-controls="collapseTwo">
                                        Instant Billing
                                    </button>
                                </h4>
                                <div id="collapseTwo4" class="accordion-collapse collapse" aria-labelledby="headingTwo4" data-bs-parent="#accordion4">
                                    <div class="accordion-body">
                                        <p>
                                            Schools can issue invoices which can be paid by parents through their mobile or laptop
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingThree4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseTwo">
                                        Track Payments
                                    </button>
                                </h4>
                                <div id="collapseThree4" class="accordion-collapse collapse" aria-labelledby="headingThree4" data-bs-parent="#accordion4">
                                    <div class="accordion-body">
                                        <p>
                                            Parents are able to view previous invoices and upcoming payments through their application.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/accordion item -->
                        </div>
                        <!--/accordion -->
                    </div>
                    <!-- /.col-md-7 -->
                </div>
                <!-- /.row -->
                <!--/Tab Content 4 ends -->
            </div>
            <!--/tab-pane -->
            <div class="tab-pane" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab">
                <!--Tab Content 5 -->
                <div class="row g-lg-5 align-items-center">
                    <div class="col-lg-5">
                        <!-- Activity image-->
                        <img src="<?=$assetsUrl?>img/activity5.jpg" alt="" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-lg-7">
                        <!-- Activity text-->
                        <h3>Stay up-to-date</h3>
                        <div class="accordion" id="accordion5">
                            <!--accordion item -->
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne5">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne">
                                        Daily Activities
                                    </button>
                                </h4>
                                <div id="collapseOne5" class="accordion-collapse collapse show" aria-labelledby="headingOne5" data-bs-parent="#accordion5">
                                    <div class="accordion-body">
                                        <p>
                                            Teachers can post several updates of the children so parents continue their days worry-less. From attendance time, to number of times the child naps, to the bathroom breaks, you got it all covered!
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
<section id="gallery" class="" hidden="hidden">
    <!-- svg triangle shape -->
    <svg class="triangleShadow" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path class="trianglePath1" d="M0 0 L50 100 L100 0 Z" />
    </svg>
    <div class="container">
        <!-- Section heading -->
        <div class="section-heading">
            <h2>Our Gallery</h2>
        </div>
        <!-- Navigation -->
        <div class="text-center col-md-12">
            <ul class="nav nav-pills justify-content-center cat mb-5" id="gallerytab">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"  data-toggle="tab" data-filter="*">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="tab" data-filter=".events">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="tab" data-filter=".facilities">Our Facilities</a>
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
                                <a href="<?=$assetsUrl?>img/gallery1.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 2 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery2.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery2.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 3 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery3.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery3.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 4 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 events">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery4.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery4.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 5 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery5.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery5.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 6 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery6.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery6.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 7 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 events">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery7.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery7.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 8 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 events">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery8.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery8.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 9 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery9.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery9.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 10 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery10.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery10.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 11 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery11.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery11.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Image 12 -->
                    <div class="col-sm-6 col-md-6 col-lg-4 facilities">
                        <div class="portfolio-item">
                            <div class="gallery-thumb">
                                <img class="img-fluid" src="<?=$assetsUrl?>img/gallery12.jpg" alt="">
                                <span class="overlay-mask"></span>
                                <a href="<?=$assetsUrl?>img/gallery12.jpg" class="link centered" title="You can add caption to pictures.">
                                    <i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /lightbox-->
            </div>
            <!-- /col-md-12-->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</section>
<!-- Section ends -->
<!-- Section Prices -->
<section id="prices" class="color-section">
    <!-- svg triangle shape -->
    <svg id="triangleShadow" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path class="trianglePath1" d="M0 0 L50 100 L100 0 Z" />
    </svg>
    <div class="container">
        <div class="col-lg-8 offset-lg-2">
            <!-- Section heading -->
            <div class="section-heading">
                <h2>Our Bundles</h2>
            </div>
        </div>
        <!-- Price tables -->
        <div class="pricing pricing-palden">
            <div class="row p-3">
                <div class="pricing-item col-lg-4">
                    <div class="pricing-deco">
                        <svg class="pricing-deco-img" enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' y='0px'>
                           <path class="deco-layer deco-layer--1" d='M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A;	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z' fill='#FFFFFF' opacity='0.6'></path>
                            <path class="deco-layer deco-layer--2" d='M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z' fill='#FFFFFF' opacity='0.6'></path>
                            <path class="deco-layer deco-layer--3" d='M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;	H42.401L43.415,98.342z' fill='#FFFFFF' opacity='0.7'></path>
                            <path class="deco-layer deco-layer--4" d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A;	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
                        </svg>
                        <div class="pricing-price"><span class="pricing-currency">SR</span>0
                            <span class="pricing-period">/ 14 days</span>
                        </div>
                        <h3 class="pricing-title">Free Trial</h3>
                    </div>
                    <!-- List -->
                    <ul class="pricing-feature-list">
                        <?php foreach ($features[1] as $feature) { ?>
                            <li><?= $feature['color'] == 'success' ? $feature['text'] : '' ?></li>
<!--                        <li>15 Teachers</li>-->
<!--                        <li>1 grade per teacher</li>-->
<!--                        <li>Social Feed</li>-->
<!--                        <li>Child pickup notifications</li>-->
                        <?php } ?>
                    </ul>
                    <!-- Button-->
                    <div class="page-scroll">
                        <a class="btn" href="#contact">Contact us</a>
                    </div>
                    <!--/page-scroll-->
                </div>
                <div class="pricing-item pricing-item-featured col-lg-4">
                    <div class="pricing-deco pink">
                        <svg class="pricing-deco-img" enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' y='0px'>
                           <path class="deco-layer deco-layer--1" d='M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A;	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z' fill='#FFFFFF' opacity='0.6'></path>
                            <path class="deco-layer deco-layer--2" d='M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z' fill='#FFFFFF' opacity='0.6'></path>
                            <path class="deco-layer deco-layer--3" d='M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;	H42.401L43.415,98.342z' fill='#FFFFFF' opacity='0.7'></path>
                            <path class="deco-layer deco-layer--4" d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A;	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
                        </svg>
                        <div class="pricing-price"><span class="pricing-currency">SR</span>350
                            <span class="pricing-period">/ month</span>
                        </div>
                        <h3 class="pricing-title">Premium</h3>
                    </div>
                    <!-- List -->
                    <ul class="pricing-feature-list">
                        <?php foreach ($features[3] as $feature) { ?>
                            <li><?= $feature['color'] == 'success' ? $feature['text'] : '' ?></li>
<!--                        <li>50 Teachers</li>-->
<!--                        <li>unlimited grade per teacher</li>-->
<!--                        <li>Social Feed</li>-->
<!--                        <li>Child pickup notifications</li>-->
<!--                        <li>Online Payments</li>-->
                        <?php } ?>
                    </ul>
                    <!-- Button-->
                    <div class="page-scroll">
                        <a class="btn" href="#contact">Contact us</a>
                    </div>
                    <!--/page-scroll-->
                </div>
                <div class="pricing-item col-lg-4">
                    <div class="pricing-deco">
                        <svg class="pricing-deco-img" enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' y='0px'>
                           <path class="deco-layer deco-layer--1" d='M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A;	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z' fill='#FFFFFF' opacity='0.6'></path>
                            <path class="deco-layer deco-layer--2" d='M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z' fill='#FFFFFF' opacity='0.6'></path>
                            <path class="deco-layer deco-layer--3" d='M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;	H42.401L43.415,98.342z' fill='#FFFFFF' opacity='0.7'></path>
                            <path class="deco-layer deco-layer--4" d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A;	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
                        </svg>
                        <div class="pricing-price"><span class="pricing-currency">SR</span>250
                            <span class="pricing-period">/ month</span>
                        </div>
                        <h3 class="pricing-title">Basic</h3>
                    </div>
                    <!-- List -->
                    <ul class="pricing-feature-list">
                        <?php foreach ($features[2] as $feature) { ?>
                            <li><?= $feature['color'] == 'success' ? $feature['text'] : '' ?></li>
<!--                        <li>15 Teachers</li>-->
<!--                        <li>3 grades per teacher</li>-->
<!--                        <li>Social Feed</li>-->
<!--                        <li>Child pickup notifications</li>-->
<!--                        <li>Online Payments <br><span class="text-muted">(for school subscription only)</span></li>-->
                        <?php } ?>
                    </ul>
                    <!-- Button-->
                    <div class="page-scroll">
                        <a class="btn" href="#contact">Contact us</a>
                    </div>
                    <!--/page-scroll-->
                </div>
                <!--/pricing-item-->
            </div>
            <!-- /row -->
        </div>
        <!-- /pricing-->
    </div>
    <!-- /container-->
</section>
<!-- /Section ends -->
<!-- Section Call to Action -->
<section id="call-to-action" class="small-section">
    <div class="container text-center ">
        <div class="col-lg-6 offset-lg-6 p-3">
            <div class="card">
                <!-- Section heading -->
                <h3>Get more Information</h3>
                <p>
                    With MyBaby, educators can effortlessly track attendance, communicate daily updates, and engage parents in their child's development. Experience a new standard of excellence in school management, where nurturing young minds meets cutting-edge technology. Join us in creating a brighter future for every child!
                </p>
                <!-- Button -->
                <div class="page-scroll">
                    <a class="btn" href="#about">About Us</a>
                </div>
                <!--/page-scroll -->
            </div>
            <!--/card -->
        </div>
        <!--/col-lg-6 -->
    </div>
    <!-- /container-->
</section>
<!-- Section ends -->
<!-- Section Contact -->
<section id="contact" class="color-section">
    <div class="container pb-5 pb-lg-3">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <!-- Section heading -->
                <div class="section-heading">
                    <h2>Contact us</h2>
                </div>
            </div>
            <!-- Contact -->
            <div class="col-lg-4 text-center">
                <h4>Information</h4>
                <!-- contact info -->
                <div class="contact-info">
                    <p><i class="flaticon-back"></i><a href="mailto:info@mybabyapp.net">info@mybabyapp.net</a></p>
                    <p><i class="fa fa-phone margin-icon"></i>Call us +966 54 485 6525</p>
                </div>
                <!-- address info -->
                <p>We are located at 45th st, Khobar, Saudi Arabia</p>
                <!-- Map -->
                <div id="map-canvas"></div>
            </div>
            <!-- Contact Form -->
            <div class="col-lg-7 offset-lg-1">
                <h4>Write us</h4>
                <div id="error-message"></div>
                <!-- Form Starts -->
                <div id="contact_form">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control input-field" placeholder="Name" required="">
                        <input type="email" name="email" class="form-control input-field" placeholder="Email ID" required="">
                        <input type="text" name="subject" class="form-control input-field" placeholder="Subject" required="">
                    </div>
                    <textarea name="message" id="message" class="textarea-field form-control" rows="4" placeholder="Enter your message" required=""></textarea>
                    <button type="submit" id="submit_btn" value="Submit" class="btn mx-auto">Send message</button>
                </div>
                <!-- Contact results -->
                <div id="contact_results"></div>
            </div>
            <!--/Contact form -->
        </div>
        <!-- /row-->
    </div>
    <!-- /container-->
</section>
<!--Section ends -->

<section id="download" class="color-section">
    <div class="container pb-5 pb-lg-3">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <!-- Section heading -->
                <div class="section-heading text-center">
                    <h2>Download App</h2>
                    <p>Get the app for the best experience on your device.</p>
                </div>
            </div>
        </div>
        <!-- /row-->
        <div class="row text-center">
            <div class="col-6 col-md-3 offset-md-3">
                <!-- Play Store Link -->
                <a href="https://play.google.com/store/apps/details?id=com.mybabyapp.net" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                         alt="Google Play Store"
                         width="300"
                         class="img-fluid download-logo">
                </a>
            </div>
            <div class="col-6 col-md-3">
                <!-- App Store Link -->
                <a href="https://apps.apple.com/us/app/mybaby-kindergarten/id6714474376" target="_blank">
                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                         alt="Apple App Store"
                         width="275"
                         class="img-fluid download-logo">
                </a>
            </div>
        </div>
        <!-- /row-->
    </div>
    <!-- /container-->
</section>
<!--Section ends -->
