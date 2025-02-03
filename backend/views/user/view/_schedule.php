<?php
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;



//$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
$days = [
    'الاثنين' => 'monday',
    'الثلاثاء' => 'tuesday',
    'الأربعاء' => 'wednesday',
    'الخميس' => 'thursday',
    'الجمعة' => 'friday',
    'السبت' => 'saturday',
    'الأحد' => 'sunday',
];
$timeSlots = [
    'Morning Shift' => [
        '6am-7am'  => '6:00 AM - 7:00 AM',
        '7am-8am'  => '7:00 AM - 8:00 AM',
        '8am-9am'  => '8:00 AM - 9:00 AM',
        '9am-10am' => '9:00 AM - 10:00 AM',
        '10am-11am'=> '10:00 AM - 11:00 AM',
        '11am-12pm'=> '11:00 AM - 12:00 PM',
    ],
    'Afternoon Shift' => [
        '12pm-1pm' => '12:00 PM - 1:00 PM',
        '1pm-2pm'  => '1:00 PM - 2:00 PM',
        '2pm-3pm'  => '2:00 PM - 3:00 PM',
        '3pm-4pm'  => '3:00 PM - 4:00 PM',
    ],
    'Evening Shift' => [
        '4pm-5pm'  => '4:00 PM - 5:00 PM',
        '5pm-6pm'  => '5:00 PM - 6:00 PM',
        '6pm-7pm'  => '6:00 PM - 7:00 PM',
        '7pm-8pm'  => '7:00 PM - 8:00 PM',
    ],
    'Night Shift' => [
        '8pm-9pm'  => '8:00 PM - 9:00 PM',
        '9pm-10pm' => '9:00 PM - 10:00 PM',
        '10pm-11pm'=> '10:00 PM - 11:00 PM',
        '11pm-12am'=> '11:00 PM - 12:00 AM',
    ],
    'Early Morning Shift' => [
        '12am-1am' => '12:00 AM - 1:00 AM',
        '1am-2am'  => '1:00 AM - 2:00 AM',
        '2am-3am'  => '2:00 AM - 3:00 AM',
        '3am-4am'  => '3:00 AM - 4:00 AM',
        '4am-5am'  => '4:00 AM - 5:00 AM',
        '5am-6am'  => '5:00 AM - 6:00 AM',
    ]
];



$form = yii\widgets\ActiveForm::begin([
    'id' => 'schedule-form',
    'options' => ['class' => 'ajax-form'],
    'action' => ['update-teacher-schedule'],
]);

?>
<?= Html::hiddenInput('school_id', $school_id) ?>
<?= Html::hiddenInput('teacher_id', $model->id) ?>


<div class="row g-3">

    <div class="col-lg-12">
        <label class="form-label"><?= Yii::t('app', 'Teacher Name')?></label>
        <div class="bg-light p-2 rounded border">
            <strong><?= Html::encode($model->name) ?></strong>
        </div>
    </div>

    <div class="col-lg-12">
        <label class="form-label"><?= Yii::t('app', 'Selected Grades')?></label>
        <div class="selected-grades">
            <?php foreach ($selectedGrades as $gradeId => $gradeTitle): ?>
                <span class="badge bg-primary me-1"><?= Html::encode($gradeTitle) ?></span>
            <?php endforeach; ?>
        </div>
    </div>


    <!-- Teacher Schedule for each selected grade (Collapsible Sections) -->
    <div class="col-lg-12">
        <div id="grade-schedule-sections-old">
            <?php foreach ($selectedGrades as $gradeId => $gradeTitle): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <a class="collapsed" data-bs-toggle="collapse" href="#gradeSchedule-<?= $gradeId ?>" aria-expanded="false" aria-controls="gradeSchedule-<?= $gradeId ?>">
                                Schedule for <?= Html::encode($gradeTitle) ?>
                            </a>
                        </h5>
                    </div>

                    <div id="gradeSchedule-<?= $gradeId ?>" class="collapse">
                        <div class="card-body">
                            <!-- Date Range for the schedule -->
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <?= $form->field($model->gradeTeacherSchedules[$gradeId], "[$gradeId]start_date")->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => Yii::t('app', 'Start Date')],
                                        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                                    ])->label(Yii::t('app', 'Start Date')) ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <?= $form->field($model->gradeTeacherSchedules[$gradeId], "[$gradeId]end_date")->widget(DatePicker::classname(), [
                                        'options' => [
                                            'placeholder' => Yii::t('app', 'End Date')
                                        ],
                                        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                                    ])->label(Yii::t('app', 'End Date')) ?>
                                </div>
                            </div>

                            <!-- Day of the Week, Start Time, End Time -->
                            <?php foreach ($days as $day_ar => $day): ?>
                                <div class="col-lg-3">
                                    <label><?= Yii::$app->language == 'en' ? ucfirst($day) : $day_ar?></label>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <?= $form->field($model->gradeTeacherSchedules[$gradeId], "[$gradeId]schedule[$day][start_time]")->widget(Select2::classname(), [
                                            'data' => $timeSlots,
                                            'options' => [
                                                    'placeholder' => Yii::t('app', 'Select...'),
                                                    'multiple' => true,
                                                    'value' => $model->gradeTeacherSchedules[$gradeId]->schedule[$day]['start_time'] ?? []
//                                                    'class' => 'required-time-slot',
//                                                    'data-grade-id' => $gradeTitle,
//                                                    'data-day' => $day,
                                                ],
                                            'size' => Select2::SMALL,
                                            'pluginOptions' => ['allowClear' => true],
                                        ])->label(false) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-lg-12">
        <div id="grade-schedule-sections">
            <!-- Schedule sections will be loaded here via AJAX based on grade selection -->
        </div>
    </div>

    <div class="col-lg-12">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
            <?= Html::button(Yii::t('app', 'Save') , ['class' => 'btn btn-primary submitFormThroughJson']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
//
// $(document).ready(function() {
//     $('.submitFormThroughJson').on('click', function(e) {
//         var isValid = true;
//
//         // Loop through each grade and check if at least one time slot is selected for any day
//         $('.required-time-slot').each(function() {
//             var selectedTimeSlots = $(this).val();
//             var gradeId = $(this).data('grade-id');
//             var day = $(this).data('day');
//
//             if (selectedTimeSlots == null || selectedTimeSlots.length === 0) {
//                 // If no time slot is selected for a grade and day, show error and prevent submission
//                 isValid = false;
//                 alert('Please select at least one time slot for ' + day + ' in ' + gradeId);
//                 return false; // Break the loop
//             }
//         });
//
//         if (!isValid) {
//             // Prevent form submission if validation fails
//             e.preventDefault();
//             return false;
//         }
//
//         // Proceed with the form submission
//         $('#schedule-form').submit();
//     });
// });

JS;
//$this->registerJs($script, \yii\web\View::POS_END);
?>
