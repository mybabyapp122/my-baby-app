<?php

$user = Yii::$app->user->identity;
$_info = $user->planInformation();
if ($_info['success']) {
    $current_plan_id = $_info['data']['id'];
    $current_plan_title = $_info['data']['title'];
    $current_plan_expiry = $_info['data']['subtitle'];
    $upgrade_to = explode(',', $_info['data']['upgrade_to']);
    $upgrade_to_title = '';
    if (!empty($upgrade_to)) {
        $new_plan = \common\models\Plan::findOne($upgrade_to);
        if (!empty($new_plan)) $upgrade_to_title = $new_plan->name;
    }
    $current_plan_remaining_days = $_info['data']['remaining_days'];
}

$students = count($user->getAssociatedPeople(false, false, true));
$teachers = count($user->getAssociatedPeople(true, false, false));
$grades = count($user->getAssociatedPeople(false, false, false, true));

//$announcements = \common\models\Announcement::find()->where(['IN', 'grade_id', $grades])->all();

$formatter = Yii::$app->formatter;
$sales = \common\models\Sale::getAllPaidSales();
$unpaid_sales = \common\models\Sale::getAllUnpaidSales();
$overdue_sales = \common\models\Sale::getOverdueSales();

$attendanceMetrics = $user->getSchoolAttendanceMetrics();

//print_r($attendanceMetrics);die();

$lastYearSum = array_sum($attendanceMetrics['lastYear']);
$currentYearSum = array_sum($attendanceMetrics['currentYear']);
$avgAttendance = $currentYearSum / 12;
$attendanceRate = $lastYearSum > 0 ? round((($currentYearSum / $lastYearSum) * 100), 2) : 0;
$absenceRate = $lastYearSum > 0 ? round(100 - $attendanceRate, 2) : 100;
?>

<div class="row">
    <div class="col-xxl-5">
        <div class="d-flex flex-column h-100">
            <div class="row h-100">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                <div class="flex-grow-1 text-truncate">
                                    <?php
                                        if ($current_plan_id == 1 && $current_plan_remaining_days > 0) {
                                            echo Yii::t('app', 'Your free trial expires in') .'<b>'. ' '. $current_plan_remaining_days . ' ' . '</b>'. Yii::t('app', 'days');
                                        } elseif ($current_plan_remaining_days > 0) {
                                            echo Yii::t('app', 'Your current plan expires in') .'<b>'. ' '. $current_plan_remaining_days . ' ' . '</b>'. Yii::t('app', 'days');
                                        } else {
                                            echo Yii::t('app', 'Your plan was expired on') .'<b>'. ' '. $current_plan_expiry . ' ' . '</b>';
                                        }
                                    ?>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="site/subscriptions" class="text-reset text-decoration-underline"><b><?= Yii::t('app', 'Upgrade') ?></b></a>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-sm-8">
                                    <div class="p-3">
                                        <p class="fs-16 lh-base"><?= Yii::t('app', 'Upgrade your plan from') ?> <span class="fw-semibold"><?= $current_plan_title ?></span>, <?= Yii::t('app', 'to') ?> ‘<?= $upgrade_to_title ?>’ <i class="mdi mdi-arrow-right"></i></p>
                                        <div class="mt-3">
                                            <a href="site/subscriptions" class="btn btn-success waves-effect waves-light"><?= Yii::t('app', 'Upgrade Plan!') ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="px-3">
                                        <img src="/themes/velzon/images/user-illustarator-2.png" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0"><?= Yii::t('app', 'Students') ?></p>
                                    <h6 class="mt-4 ff-secondary fw-semibold"><?= $students ?></h6>
<!--                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">-->
<!--                                                    <i class="ri-arrow-up-line align-middle"></i> 16.24 %-->
<!--                                                </span> vs. previous month</p>-->
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary rounded-circle fs-2"><i data-feather="users"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0"><?= Yii::t('app', 'Teachers') ?></p>
                                    <h6 class="mt-4 ff-secondary fw-semibold"><?= $teachers ?></h6>
<!--                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">-->
<!--                                                    <i class="ri-arrow-down-line align-middle"></i> 3.96 %-->
<!--                                                </span> vs. previous month</p>-->
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success rounded-circle fs-2">
                                                    <i data-feather="user-check"></i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0"><?= Yii::t('app', 'Grades') ?></p>
                                    <h6 class="mt-4 ff-secondary fw-semibold"><?= $grades ?>
<!--                                        <span class="counter-value" data-target="40">0</span>sec-->
                                    </h6>
<!--                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">-->
<!--                                                    <i class="ri-arrow-down-line align-middle"></i> 0.24 %-->
<!--                                                </span> vs. previous month</p>-->
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning rounded-circle fs-2">
                                                    <i data-feather="map"></i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0"><?= Yii::t('app', 'Fee Collected') ?></p>
                                    <h6 class="mt-4 ff-secondary fw-bold"><?= $formatter->asCurrency($sales, 'SAR') ?> </h6>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success rounded-circle fs-2"><i data-feather="dollar-sign"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0"><?= Yii::t('app', 'Pending Amount') ?></p>
                                    <h6 class="mt-4 ff-secondary fw-semibold"><?= $formatter->asCurrency($unpaid_sales, 'SAR') ?> </h6>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded-circle fs-2"><i data-feather="dollar-sign"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0"><?= Yii::t('app', 'Overdue Amount') ?></p>
                                    <h6 class="mt-4 ff-secondary fw-semibold"><?= $formatter->asCurrency($overdue_sales, 'SAR') ?> </h6>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger rounded-circle fs-2"><i data-feather="dollar-sign"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->


            </div> <!-- end row-->
        </div>
    </div> <!-- end col-->

    <div class="col-xxl-7">
        <div class="row h-100">

            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title mb-0"><?= Yii::t('app', 'Upcoming Events') ?></h4>
                </div><!-- end cardheader -->
                <div class="card-body pt-0">
                    <div class="upcoming-scheduled">
                        <input type="text" id="date-picker"  class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-deafult-date="today" data-inline-date="true">
                    </div>

                    <h6 class="text-uppercase fw-semibold mt-4 mb-3 text-muted"><?= Yii::t('app', 'Events') ?>:</h6>

                    <div id="events-container">
                        <!-- Events will be dynamically inserted here -->
                    </div>

<!--                    <div class="mt-3 text-center">-->
<!--                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">View all Events</a>-->
<!--                    </div>-->
                </div><!-- end cardbody -->
            </div><!-- end card -->




        </div> <!-- end row-->
    </div><!-- end col -->
</div> <!-- end row-->






<?php
$attendanceDataJson = \yii\helpers\Json::encode($attendanceMetrics);
$currentYear = date("Y");
$lastYear = date("Y", strtotime("-1 year"));


$currentYearMetrics = json_encode($attendanceMetrics['currentYear']);
$lastYearMetrics = json_encode($attendanceMetrics['lastYear']);


//$attendanceDataJson = \yii\helpers\Json::encode([
//    "metrics" => $attendanceMetrics,
//    "currentYear" => $currentYear,
//    "lastYear" => $lastYear
//]);

//print_r($attendanceDataJson);
$script = <<< JS


document.addEventListener("DOMContentLoaded", function() {
        
    
// Get data from PHP
// var attendanceData = JSON.parse('<?= json_encode(attendanceMetrics, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>');

// Extract year names and metrics
// var currentYearName = attendanceData.currentYear;
// var lastYearName = attendanceData.lastYear;
// var metrics = attendanceData.metrics;

// console.log(metrics);

// Audiences metrics column charts
var chartAudienceColumnChartsColors = getChartColorsArray("audiences_metrics_charts");
if (chartAudienceColumnChartsColors) {
    var columnoptions = {
        
        series: [{
            name: 'Last Year',
            data: '$lastYearMetrics',
            // data: metrics.lastYear
        }, {
            name: 'CUrrent Year',
            data: '$currentYearMetrics',
            // data: metrics.currentYear
        }],
        // series: [{
        //     name: '2023',
        //     data: [25.3, 12.5, 20.2, 18.5, 40.4, 25.4, 15.8, 22.3, 19.2, 25.3, 12.5, 20.2]
        // }, {
        //     name: 'Current Year (2024)',
        //     data: [36.2, 22.4, 38.2, 30.5, 26.4, 30.4, 20.2, 29.6, 10.9, 36.2, 22.4, 38.2]
        // }],
        chart: {
            type: 'bar',
            height: 309,
            stacked: true,
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '20%',
                borderRadius: 6,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            fontWeight: 400,
            fontSize: '8px',
            offsetX: 0,
            offsetY: 0,
            markers: {
                width: 9,
                height: 9,
                radius: 4,
            },
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        grid: {
            show: false,
        },
        colors: chartAudienceColumnChartsColors,
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: true,
                strokeDashArray: 1,
                height: 1,
                width: '100%',
                offsetX: 0,
                offsetY: 0
            },
        },
        yaxis: {
            show: false
        },
        fill: {
            opacity: 1
        }
    };
    var chart = new ApexCharts(document.querySelector("#audiences_metrics_charts"), columnoptions);
    chart.render();
}



// world map with markers
var vectorMapWorldMarkersColors = getChartColorsArray("sales-by-locations");
    if (vectorMapWorldMarkersColors) {
        var worldemapmarkers = new jsVectorMap({
            map: "world_merc",
            selector: "#sales-by-locations",
            zoomOnScroll: false,
            zoomButtons: false,
            selectedMarkers: [0, 5],
            regionStyle: {
                initial: {
                    stroke: "#9599ad",
                    strokeWidth: 0.25,
                    fill: vectorMapWorldMarkersColors[0],
                    fillOpacity: 1,
                },
            },
            markersSelectable: true,
            markers: [
                {
                    name: "Madinah",
                    coords: [24.488669261508328, 39.7200554524338],
                },
                {
                    name: "Madinah",
                    coords: [24.48226489911632, 39.71486220723259],
                },
                {
                    name: "Jeddah",
                    coords: [21.566037316761854, 39.131030944344644],
                },
                {
                    name: "Riyadh",
                    coords: [24.73624836355555, 46.779237181429274],
                },
            ],
            markerStyle: {
                initial: {
                    fill: vectorMapWorldMarkersColors[1],
                },
                selected: {
                    fill: vectorMapWorldMarkersColors[2],
                },
            },
            labels: {
                markers: {
                    render: function (marker) {
                        return marker.name;
                    },
                },
            },
            onRegionTipShow: function (e, el, code) {
                if (code !== 'SA') {
                    e.preventDefault();
                }
            },
            onViewportChange: function (viewport) {
                if (viewport.scale < 5) {
                    this.setFocus({
                        region: 'SA',
                        animate: true,
                        scale: 5,
                    });
                }
            },
        });

        // Initial focus on Saudi Arabia
        worldemapmarkers.setFocus({
            region: 'SA',
            animate: true,
            scale: 5,
        });
    }

});


    // Call the initialization function
    initFlatpickr();
    
    function initFlatpickr() {
        if (typeof flatpickr !== "undefined") {
            document.querySelector('#date-picker').flatpickr({
                inline: true,
                dateFormat: 'd M, Y',
                defaultDate: 'today',
                onChange: function(selectedDates, dateStr, instance) {
                    fetchEvents(dateStr);
                }
            });
            fetchEvents(null); //fetch for today
        } else {
            setTimeout(initFlatpickr, 100); // Retry after 100ms
        }
    }


    /// Fetch events based on the selected date
    function fetchEvents(selectedDate = null) {
        $.ajax({
            url: '/site/get-upcoming-events', // Adjust URL to your action route
            method: 'GET',
            data: { date: selectedDate },
            success: function(response) {
                var eventsHtml = '';
                response.data.forEach(function(event) {
                    eventsHtml +=
                        "<div class='mini-stats-wid d-flex align-items-center mt-3'>" +
                            "<div class='flex-shrink-0 avatar-sm'>" +
                                "<span class='mini-stat-icon avatar-title rounded-circle text-success bg-soft-success fs-4'>" +
                                    event.id +
                                "</span>" +
                            "</div>" +
                            "<div class='flex-grow-1 ms-3'>" +
                                "<h5 class='mb-1'>" + event.type + "</h6>" +
                                "<h6 class='mb-1'>" + event.title + "</h6>" +
                                "<p class='text-muted mb-0'>" + event.body + "</p>" +
                            "</div>" +
                            "<div class='flex-shrink-0'>" +
                                "<p class='text-muted mb-0'>" + event.created_by + "</p>" +
                            "</div>" +
                        "</div>";
                });
                $('#events-container').html(eventsHtml);
            },
            error: function(xhr, status, error) {
                    console.log(error);
                }
        });
    }
   


JS;
$this->registerJs($script, \yii\web\View::POS_END);