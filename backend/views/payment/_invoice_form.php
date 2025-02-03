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

$form = ActiveForm::begin([
    'id' => 'invoice-form',
    'options' => ['class' => 'ajax-form'],
]);

?>
<div class="row g-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="availability-calculator">
                    <div class="row">
                        <!-- Grade ID dropdown -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <?= $form->field($model, 'payer_id', [
                                    'inputOptions' => ['class' => 'form-control'],
                                ])->dropDownList($all_students,
                                    ['prompt' => 'Select Student']
                                ); ?>
                            </div>
                        </div>
                        <!-- Per Hour Rate Field -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <?= Html::label('Per Hour Rate', 'per-hour-rate', ['class' => 'form-label']) ?>
                                <?= Html::input('number', 'per_hour_rate', '', [
                                    'class' => 'form-control',
                                    'id' => 'per-hour-rate',
                                    'min' => '0',
                                    'step' => '0.01',
                                    'placeholder' => 'Enter per hour rate'
                                ]) ?>
                            </div>
                        </div>
                        <!-- Total Hours Field -->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <?= Html::label('Total Hours', 'total-hours', ['class' => 'form-label']) ?>
                                <?= Html::input('number', 'total_hours', '', [
                                    'class' => 'form-control',
                                    'id' => 'total-hours',
                                    'min' => '0',
                                    'step' => '1',
                                    'placeholder' => 'Enter total hours'
                                ]) ?>
                            </div>
                        </div>
                        <!-- Optional Preferred Time Slots (Checkbox List) -->
                        <?php
                        //        $form->field($model, 'time_slots')->checkboxList($timeSlots);
                        ?>
                    </div>
                    <div class="hstack gap-2 justify-content-end">
                        <?= Html::button('Generate Invoice', ['class' => 'btn btn-primary', 'id' => 'generate-btn']); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
</div>
<?php ActiveForm::end(); ?>



<?php
$lang = Yii::$app->language;
$user_lang             = Yii::$app->language;
$crfToken             = Yii::$app->request->csrfToken;
$script = <<< JS
    
    $('.generate-btn').on('click', function(event) {
        event.preventDefault(); // Prevent the default link action
    
        const url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': `$crfToken`
            },
            success: function(data) {
                if (data.success) {
                    window.location.href = data.redirectUrl;
                } else {
                    notify(false, data.message);
                    // alert(data.message || 'An error occurred during the upgrade.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                notify(false, error);

                // alert('An error occurred during the request.');
            }
        });
    });

    
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>
