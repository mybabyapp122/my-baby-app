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
    'id' => 'student-finance-form',
    'options' => ['class' => 'ajax-form'],
    'action' => ['update-student-finance'],
]);

Html::hiddenInput('student_id', $student->id);

?>
<div class="row g-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="availability-calculator">
                    <div class="row">
                        <!-- Grade ID dropdown -->
                        <div class="col-lg-12 mb-3">
                            <label class="form-label"><?= Yii::t('app', 'Student Schedule Details') ?></label>
                            <div class="bg-light p-2 rounded border">
                                <?= Yii::t('app', 'Days') . ' : '  ?>
                                <strong><?= Html::encode($schedule['days']) ?></strong>

                                <p></p>
                                <?= Yii::t('app', 'Hours') . ' : '  ?>
                                <strong><?= Html::encode($schedule['hours']) ?></strong>

                                <p></p>
                                <?= Yii::t('app', 'Starting From') . ' : '  ?>
                                <strong id="starting-date"><?= Html::encode($schedule['starting_date'])?></strong>

                                <p></p>
                                <?= Yii::t('app', 'Ending on') . ' : '  ?>
                                <strong id="ending-date"><?= Html::encode($schedule['ending_date'])?></strong>
                            </div>

                        </div>

                        <!-- Editable Rate and Hours with Total Calculation -->
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex align-items-center justify-content-start">
                                <!-- Per Hour Rate -->
                                <div class="col-lg-3 me-2">
                                    <?= Html::label(Yii::t('app', 'Per Hour Rate'), 'per-hour-rate', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'per_hour_rate', $student->grade->per_hour_rate, [
                                            'class' => 'form-control',
                                            'id' => 'per-hour-rate',
                                            'min' => '0',
                                            'step' => '1',
                                            'placeholder' => Yii::t('app', 'Enter per hour rate'),
//                                            'style' => 'width: 70px;',
                                        ]) ?>
                                        <div class="input-group-text bg-light text-muted">SAR</div>
                                    </div>
                                </div>

                                <!-- Multiply Symbol -->
                                <div class="me-2 mt-4">
                                    <span class="fs-4">×</span>
                                </div>

                                <!-- Total Hours -->
                                <div class="col-lg-3 me-2">
                                    <?= Html::label(Yii::t('app', 'Total Hours'), 'total-hours', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'total_hours', $schedule['hours'], [
                                            'class' => 'form-control',
                                            'id' => 'total-hours',
                                            'min' => '0',
                                            'step' => '1',
                                            'readonly' => true,
                                            'disabled' => true,
//                                            'style' => 'width: 70px;',
                                        ]) ?>
<!--                                        <div class="input-group-text bg-light text-muted">hours</div>-->
                                    </div>
                                </div>

                                <!-- Equals Symbol -->
                                <div class="me-2 mt-4">
                                    <span class="fs-4">=</span>
                                </div>

                                <!-- Total Amount (Read-only) -->
                                <div class="col-lg-4 me-2">
                                    <?= Html::label(Yii::t('app', 'Total Amount'), 'total-amount', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('text', 'total_amount', null, [
                                            'class' => 'form-control',
                                            'id' => 'total-amount',
                                            'readonly' => true,
//                                            'style' => 'width: 80px;',
                                            'placeholder' => '0.00'
                                        ]) ?>
<!--                                        <span class="input-group-text bg-light text-muted">SAR</span>-->
                                        <div class="input-group-text bg-light text-muted"><?= Yii::t('app', 'SAR') ?></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- Optional Preferred Time Slots (Checkbox List) -->
                        <?php
                        //        $form->field($model, 'time_slots')->checkboxList($timeSlots);
                        ?>
                    </div>

                    <!-- Beautiful Note -->
                    <div class="alert alert-info mt-4 p-3 rounded">
                        <i class="fa fa-info-circle me-2"></i>
                        <?= Yii::t('app', 'An invoice will be generated automatically on the 28th of every month. If the schedule starts mid-month, an invoice will be generated from today until the upcoming 28th, followed by subsequent monthly invoices.') ?>
                    </div>

                    <div class="hstack gap-2 justify-content-end">
                        <?= Html::button(Yii::t('app', 'Generate Invoice'), ['class' => 'btn btn-primary ', 'id' => 'generate-btn']); ?>
                        <?= Html::a(Yii::t('app', 'View Invoices'), ['/payment/index'], [
                            'class' => 'btn btn-primary',
                            'target' => '_blank',
                            'rel' => 'noopener noreferrer', // Improves security by preventing access to the referring window
                        ]); ?>
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
    
    
    // Function to calculate and update the total amount
    function calculateTotal() {
        // Clear values (optional, for example purposes)
        $('#total-amount').val(''); // Clear total amount initially
    
        // Get values
        const rate = parseFloat($('#per-hour-rate').val()) || 0;
        const hours = parseFloat($('#total-hours').val()) || 0;
    
        // Perform the calculation
        const total = rate * hours;
    
        // Update the total amount field
        $('#total-amount').val(total.toFixed(2));
    }
    
    // Attach events to inputs and trigger calculation on load
    $(document).ready(function () {
        // Initialize total calculation on page load
        calculateTotal();
    
        // Attach event listeners to inputs
        $('#per-hour-rate, #total-hours').on('input', function () {
            calculateTotal();
        });
    });



    $('#generate-btn').on('click', function(event) {
        event.preventDefault(); // Prevent the default link action
        
        // Get form and specific input values
        var form = $(this).closest('form');
        var perHourRate = $('#per-hour-rate').val(); // Extract per hour rate
        var totalHours = $('#total-hours').val();   // Extract total hours
        var totalAmount = perHourRate * totalHours; // Calculate total amount
        var startDate = $('#starting-date').text();   // Extract total hours
        var endDate = $('#ending-date').text();   // Extract total hours
    
        // Prepare data for server
        var data = {
            student_id: `$student->id`,
            per_hour_rate: perHourRate,
            total_hours: totalHours,
            total_amount: totalAmount,
            starting_date: startDate,
            ending_date: endDate
        };
        
        console.log(data);
    
        // Send AJAX request to create the invoice
        $.ajax({
            url: form.attr('action'), // Use form's action URL
            type: 'POST',
            headers: {
                'X-CSRF-Token': `$crfToken`
            },
            data: data, // Send extracted data only
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    notify(response.success, response.message);
    
                    // Close modal if necessary
                    var activeModal = document.querySelector('.modal.show');
                    if (activeModal) {
                        var modalInstance = bootstrap.Modal.getInstance(activeModal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                } else {
                    // Handle error (optional)
                    notify(false, response.message, 5000);
                }
            },
            error: function (xhr, status, error) {
                notify(false, 'An error occurred: ' + error);
            }
        });
    });

    
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>
