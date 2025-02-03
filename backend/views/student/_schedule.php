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

$grade_id = $model->grade->id;
$grade_title = $model->grade->title;

$form = yii\widgets\ActiveForm::begin([
    'id' => 'student-schedule-form',
    'options' => ['class' => 'ajax-form'],
    'action' => ['update-student-schedule'],
]);

?>
<?= Html::hiddenInput('student_id', $model->id) ?>

<div class="row g-3">
    <div class="col-lg-12">
        <label class="form-label"><?= Yii::t('app', 'Student Name') ?></label>
        <div class="bg-light p-2 rounded border">
            <strong><?= Html::encode($model->name) ?></strong>
        </div>
    </div>

    <div class="col-lg-12">
        <label class="form-label"><?= Yii::t('app', 'Selected Grade') ?> </label>
        <div class="selected-grade">
            <span class="badge bg-primary me-1"><?= Html::encode($grade_title) ?></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"> <?=Yii::t('app', 'Schedule for') . ' ' . Html::encode($grade_title) ?></h5>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <?= $form->field($model->studentSchedules[$grade_id], "[$grade_id]start_date")->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => Yii::t('app', 'Start Date')],
                            'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                        ])->label(Yii::t('app', 'Start Date')) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <?= $form->field($model->studentSchedules[$grade_id], "[$grade_id]end_date")->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => Yii::t('app', 'End Date')],
                            'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                        ])->label(Yii::t('app', 'End Date')) ?>
                    </div>
                </div>

                <?php foreach ($days as $day_ar => $day): ?>
                    <div class="col-lg-3">
                        <label><?= Yii::$app->language == 'en' ? ucfirst($day) : $day_ar?></label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <?= $form->field($model->studentSchedules[$grade_id], "[$grade_id]schedule[$day][start_time]")->widget(Select2::classname(), [
                                'data' => $timeSlots,
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Select...'),
                                    'multiple' => true,
                                    'value' => $model->studentSchedules[$grade_id]->schedule[$day]['start_time'] ?? []
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

    <div class="col-lg-12">
        <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
            <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary submitFormThroughJson']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php
$script = <<< JS

JS;
//$this->registerJs($script, \yii\web\View::POS_END);
?>
