<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use common\models\Grade;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Availability */
/* @var $school_id int */
/* @var $timeSlots array */

$allGrades = ArrayHelper::map(
    Grade::find()->where(['school_id' => $school_id])->all(),
    'id',
    'title'
);
$form = ActiveForm::begin([
    'id' => 'availability-form',
    'options' => ['class' => 'ajax-form'],
]);

?>
<style>

    /* Capitalize the first letter of each button in the FullCalendar toolbar */
    .fc-button.fc-today-button,
    .fc-button.fc-dayGridMonth-button,
    .fc-button.fc-timeGridWeek-button,
    .fc-button.fc-timeGridDay-button {
        text-transform: capitalize;
    }

    /* Customize Next and Prev buttons */
    .fc-prev-button, .fc-next-button {
        color: #007bff; /* Custom color for buttons */
        background-color: #f8f9fa; /* Light background */
        border: 1px solid #ddd; /* Subtle border */
        border-radius: 4px; /* Rounded corners */
        padding: 5px 10px; /* Add padding for better spacing */
        font-size: 1em; /* Adjust font size */
    }

    /* Hover effect for Next and Prev buttons */
    .fc-prev-button:hover, .fc-next-button:hover {
        background-color: #007bff; /* Change to primary color on hover */
        color: #fff; /* White text on hover */
    }


</style>
<!-- Load FullCalendar script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<div class="row g-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="availability-calculator">
                    <!-- School ID (hidden field as it’s pre-selected) -->
                    <?= $form->field($model, 'school_id')->hiddenInput(['value' => $school_id])->label(false); ?>
                    <div class="row">
                        <!-- Grade ID dropdown -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <?= $form->field($model, 'grade_id', [
                                    'inputOptions' => ['class' => 'form-control'],
                                ])->dropDownList($allGrades,
                                    ['prompt' => Yii::t('app', 'Select Grade')]
                                ); ?>
                            </div>
                        </div>
                        <!-- Start Date -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                                ]); ?>
                            </div>
                        </div>
                        <!-- End Date -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                                    'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                                ]); ?>
                            </div>
                        </div>
                        <!-- Optional Preferred Time Slots (Checkbox List) -->
                        <?php
                        //        $form->field($model, 'time_slots')->checkboxList($timeSlots);
                        ?>
                    </div>
                    <div class="hstack gap-2 justify-content-end">
                        <?= Html::button(Yii::t('app', 'Check Availability'), ['class' => 'btn btn-primary', 'id' => 'check-availability-btn']); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
</div>
<?php ActiveForm::end(); ?>

<!-- Calendar display area -->


<div class="row row g-3">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<?php

$yearButtonText = Yii::t('app', 'Year');
$locale = Yii::$app->language == 'en' ? 'en' : 'ar';
$buttonTexts = [
    'today' => Yii::t('app', 'Today'),
    'dayGridMonth' => Yii::t('app', 'Month'),
    'timeGridWeek' => Yii::t('app', 'Week'),
    'timeGridDay' => Yii::t('app', 'Day'),
    'yearGrid' => Yii::t('app', 'Year'),
];
$left = Yii::$app->language == 'en' ? 'prev,today,next' : 'next,today,prev' ;
$right = Yii::$app->language == 'en' ? 'yearGrid,dayGridMonth,timeGridWeek,timeGridDay' : 'timeGridDay,timeGridWeek,dayGridMonth,yearGrid' ;
$slotsAvailable = Yii::t('app', 'slots available');

?>

<!-- JavaScript for initializing FullCalendar and handling the availability check -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',  // Start with the month view
            aspectRatio: 3.85, // Adjust this value for smaller boxes
            locales: [ 'en', 'ar' ],
            locale: '<?= $locale ?>',
            events: [],
            views: {
                yearGrid: {
                    type: 'dayGridMonth',
                    duration: { months: 12 },  // Show 12 months at once
                    buttonText: '<?= $yearButtonText ?>'  // Label for the custom "year" button
                }
            },
            buttonText: {
                today: '<?= $buttonTexts['today'] ?>',
                month: '<?= $buttonTexts['dayGridMonth'] ?>',
                week: '<?= $buttonTexts['timeGridWeek'] ?>',
                day: '<?= $buttonTexts['timeGridDay'] ?>',
                year: '<?= $buttonTexts['yearGrid'] ?>'
            },
            headerToolbar: {
                left: '<?= $left ?>',
                center: 'title',
                right: '<?= $right ?>',
            },
            allDaySlot: false,
            // slotMinTime: "06:00:00",
            // slotMaxTime: "20:00:00"

            // Custom rendering for event content
            // eventContent: function(arg) {
            //     const title = document.createElement('div');
            //     title.innerHTML = arg.event.title;
            //     title.style.fontWeight = 'bold';
            //
            //     const details = document.createElement('div');
            //     const eventData = arg.event.extendedProps;
            //     details.innerHTML = `Total Capacity: ${eventData.total_capacity}<br>Booked: ${eventData.booked_students}`;
            //     details.style.fontSize = '0.8em';
            //     details.style.color = 'darkgray';
            //
            //     const arrayOfDomNodes = [title, details];
            //     return { domNodes: arrayOfDomNodes };
            // }

        });
        calendar.render();

        // Handle the "Check Availability" button click
        $('#check-availability-btn').on('click', function (e) {
            e.preventDefault();

            // Serialize form data
            let formData = $('#availability-form').serialize();

            // Fetch availability data via AJAX
            $.ajax({
                url: '/availability/check-availability',  // Adjust this URL as needed
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        let events = [];

                        // Process each date in the response data
                        for (const [date, slots] of Object.entries(response.data)) {
                            if (slots.length === 0) continue; // Skip days with no available slots

                            // Process each time slot for the current date
                            for (const [timeSlot, details] of Object.entries(slots)) {
                                const [startTime, endTime] = timeSlot.split('-').map(time => {
                                    // Convert to 24-hour time format
                                    const timeParts = time.match(/(\d+)(am|pm)/);
                                    let hours = parseInt(timeParts[1]);
                                    if (timeParts[2] === 'pm' && hours !== 12) hours += 12;
                                    if (timeParts[2] === 'am' && hours === 12) hours = 0;
                                    return hours.toString().padStart(2, '0') + ':00:00';
                                });

                                events.push({
                                    title: `${details.available_slots} ` + '<?= $slotsAvailable ?>',
                                    start: `${date}T${startTime}`,
                                    end: `${date}T${endTime}`,
                                    color: details.available_slots > 0 ? 'green' : 'red',
                                    extendedProps: {
                                        total_capacity: details.total_capacity,
                                        booked_students: details.booked_students
                                    }
                                });
                            }
                        }

                        // Remove existing events and add new events to calendar
                        calendar.removeAllEvents();
                        calendar.addEventSource(events);
                        calendar.refetchEvents();
                    } else {
                        alert(response.message || 'Error fetching availability');
                    }
                },
                error: function () {
                    alert('Failed to fetch availability. Please try again.');
                }
            });
        });
    });
</script>
