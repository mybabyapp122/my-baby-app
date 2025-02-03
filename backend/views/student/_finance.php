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
                                <?= Yii::t('app', 'Days') . ' : ' ?>
                                <strong><?= Html::encode($schedule['days']) ?></strong>

                                <p></p>
                                <?= Yii::t('app', 'Hours') . ' : ' ?>
                                <strong><?= Html::encode($schedule['hours']) ?></strong>

                                <p></p>
                                <?= Yii::t('app', 'Starting From') . ' : ' ?>
                                <strong id="starting-date"><?= Html::encode($schedule['starting_date']) ?></strong>

                                <p></p>
                                <?= Yii::t('app', 'Ending on') . ' : ' ?>
                                <strong id="ending-date"><?= Html::encode($schedule['ending_date']) ?></strong>
                            </div>
                        </div>
                        <!-- Pricing Model Dropdown -->
                        <div class="col-lg-12 mb-3">
                            <?= Html::label(Yii::t('app', 'Pricing Model'), 'pricing-model', ['class' => 'form-label']) ?>
                            <div class="input-group">
                                <?= Html::dropDownList('pricing_model', '', [
                                    '' => Yii::t('app', 'Select Pricing Model'),
                                    'hourly' => Yii::t('app', 'Per Hour'),
                                    'monthly' => Yii::t('app', 'Per Month'),
                                    'semester' => Yii::t('app', 'Per Semester'),
                                    'yearly' => Yii::t('app', 'Per Year'),
                                ], [
                                    'class' => 'form-select',
                                    'id' => 'pricing-model',
                                ]) ?>
                            </div>
                        </div>

                        <!-- Editable Rate and Hours with Total Calculation -->
                        <div class="col-lg-12 mb-3 hourly_div" style="display: none">
                            <div class="d-flex align-items-center justify-content-start">
                                <!-- Per Hour Rate -->
                                <div class="col-lg-4 me-2">
                                    <?= Html::label(Yii::t('app', 'Per Hour Rate'), 'per-hour-rate', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'per_hour_rate', $student->grade->per_hour_rate, [
                                            'class' => 'form-control',
                                            'id' => 'per-hour-rate',
                                            'min' => '0',
                                            'step' => '1',
                                            'placeholder' => Yii::t('app', 'Enter per hour rate'),
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
                                        ]) ?>
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
                                            'class' => 'form-control total_amount_class',
                                            'id' => 'total-amount',
                                            'readonly' => true,
                                            'placeholder' => '0.00'
                                        ]) ?>
                                        <div class="input-group-text bg-light text-muted"><?= Yii::t('app', 'SAR') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3 monthly_div" style="display: none">
                            <div class="d-flex align-items-center justify-content-start">
                                <!-- Per Month Rate -->
                                <div class="col-lg-4 me-2">
                                    <?= Html::label(Yii::t('app', 'Per Month Rate'), 'per-month-rate', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'per_month_rate', $student->grade->per_month_rate, [
                                            'class' => 'form-control',
                                            'id' => 'per-month-rate',
                                            'min' => '0',
                                            'step' => '1',
                                            'placeholder' => Yii::t('app', 'Enter per month rate'),
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
                                    <?= Html::label(Yii::t('app', 'Total Months'), 'total-months', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'total_months', $schedule['months'], [
                                            'class' => 'form-control',
                                            'id' => 'total-months',
                                            'min' => '0',
                                            'step' => '1',
                                            'readonly' => true,
                                            'disabled' => true,
                                        ]) ?>
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
                                            'class' => 'form-control total_amount_class',
                                            'id' => 'total-amount',
                                            'readonly' => true,
                                            'placeholder' => '0.00'
                                        ]) ?>
                                        <div class="input-group-text bg-light text-muted"><?= Yii::t('app', 'SAR') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3 semester_div" style="display: none">
                            <div class="d-flex align-items-center justify-content-start">
                                <!-- Per Month Rate -->
                                <div class="col-lg-4 me-2">
                                    <?= Html::label(Yii::t('app', 'Per Semester Rate'), 'per-semester-rate', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'per_semester_rate', $student->grade->per_semester_rate, [
                                            'class' => 'form-control',
                                            'id' => 'per-semester-rate',
                                            'min' => '0',
                                            'step' => '1',
                                            'placeholder' => Yii::t('app', 'Enter per semester rate'),
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
                                    <?= Html::label(Yii::t('app', 'Total Semester'), 'total-semester', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'total_semester', $schedule['semesters'], [
                                            'class' => 'form-control',
                                            'id' => 'total-semester',
                                            'min' => '0',
                                            'step' => '1',
                                            'readonly' => true,
                                            'disabled' => true,
                                        ]) ?>
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
                                            'class' => 'form-control total_amount_class',
                                            'id' => 'total-amount',
                                            'readonly' => true,
                                            'placeholder' => '0.00'
                                        ]) ?>
                                        <div class="input-group-text bg-light text-muted"><?= Yii::t('app', 'SAR') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3 year_div" style="display: none">
                            <div class="d-flex align-items-center justify-content-start">
                                <!-- Per Month Rate -->
                                <div class="col-lg-4 me-2">
                                    <?= Html::label(Yii::t('app', 'Per Year Rate'), 'per-year-rate', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'per_year_rate', $student->grade->per_year_rate, [
                                            'class' => 'form-control',
                                            'id' => 'per-year-rate',
                                            'min' => '0',
                                            'step' => '1',
                                            'placeholder' => Yii::t('app', 'Enter per year rate'),
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
                                    <?= Html::label(Yii::t('app', 'Total Year'), 'total-year', ['class' => 'form-label']) ?>
                                    <div class="input-group">
                                        <?= Html::input('number', 'total_year', $schedule['years'], [
                                            'class' => 'form-control',
                                            'id' => 'total-year',
                                            'min' => '0',
                                            'step' => '1',
                                            'readonly' => true,
                                            'disabled' => true,
                                        ]) ?>
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
                                            'class' => 'form-control total_amount_class',
                                            'id' => 'total-amount',
                                            'readonly' => true,
                                            'placeholder' => '0.00'
                                        ]) ?>
                                        <div class="input-group-text bg-light text-muted"><?= Yii::t('app', 'SAR') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

                <!-- Beautiful Note -->
                <div class="alert alert-info mt-4 p-3 rounded">
                    <i class="fa fa-info-circle me-2"></i>
                    <?= Yii::t('app', 'An invoice will be generated automatically on the 28th of every month. If the schedule starts mid-month, an invoice will be generated from today until the upcoming 28th, followed by subsequent monthly invoices.') ?>
                </div>

                <div class="hstack gap-2 justify-content-end">
                    <?= Html::button(Yii::t('app', 'Generate Invoice'), ['class' => 'btn btn-primary', 'id' => 'generate-btn']); ?>
                    <?= Html::a(Yii::t('app', 'View Invoices'), ['/payment/index'], [
                        'class' => 'btn btn-primary',
                        'target' => '_blank',
                        'rel' => 'noopener noreferrer',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php ActiveForm::end(); ?>

<?php
$lang = Yii::$app->language;
$user_lang = Yii::$app->language;
$crfToken = Yii::$app->request->csrfToken;
$script = <<< JS
    function togglePricingFields() {
        const pricingModel = document.getElementById("pricing-model").value;
    
        document.querySelector('.hourly_div').style.display = 'none';
        document.querySelector('.monthly_div').style.display = 'none';
        document.querySelector('.semester_div').style.display = 'none';
        document.querySelector('.year_div').style.display = 'none';
        if (pricingModel === 'hourly') {
            document.querySelector('.hourly_div').style.display = 'block';
        } else if (pricingModel === 'monthly') {
            document.querySelector('.monthly_div').style.display = 'block';
        } else if (pricingModel === 'semester') {
            document.querySelector('.semester_div').style.display = 'block';
        } else if (pricingModel === 'yearly') {
            document.querySelector('.year_div').style.display = 'block';
        }
    }
    document.getElementById("pricing-model").addEventListener("change", function() {
        togglePricingFields();
        calculateTotal(); 
    });
    
    togglePricingFields();
    
    function calculateTotal() {
        const pricingModel = document.getElementById("pricing-model").value;
        let rate, totalAmount, totalTime;
    
        if (pricingModel === 'hourly') {
            const hourRate = document.getElementById("per-hour-rate").value;
            const totalHours = document.getElementById("total-hours").value;
    
            rate = parseFloat(hourRate);
            totalTime = parseFloat(totalHours);
    
            if (isNaN(rate) || isNaN(totalTime)) {
                return;
            }
    
            totalAmount = rate * totalTime;
        } else if (pricingModel === 'monthly') {
            const monthRate = document.getElementById("per-month-rate").value;
            const totalMonths = document.getElementById("total-months").value;
            rate = parseFloat(monthRate);
            totalTime = parseFloat(totalMonths);
    
            if (isNaN(rate) || isNaN(totalTime)) {
                return;
            }
    
            totalAmount = rate * totalTime;
        }
        else if (pricingModel === 'semester') {
            const semesterRate = document.getElementById("per-semester-rate").value;
            const totalSemester = document.getElementById("total-semester").value;
            rate = parseFloat(semesterRate);
            totalTime = parseFloat(totalSemester);
    
            if (isNaN(rate) || isNaN(totalTime)) {
                return;
            }
    
            totalAmount = rate * totalTime;
        }
        else if (pricingModel === 'yearly') {
            const yearRate = document.getElementById("per-year-rate").value;
            const totalYear = document.getElementById("total-year").value;
            rate = parseFloat(yearRate);
            totalTime = parseFloat(totalYear);
    
            if (isNaN(rate) || isNaN(totalTime)) {
                return;
            }
    
            totalAmount = rate * totalTime;
        }
        console.log('totalAmount' ,totalAmount);
    
        $('.total_amount_class').val(totalAmount.toFixed(2));
        // document.getElementsByClassName("total_amount_class").value = totalAmount;
    }
    
    document.getElementById("per-hour-rate").addEventListener("input", calculateTotal);
    document.getElementById("per-month-rate").addEventListener("input", calculateTotal);
    document.getElementById("per-semester-rate").addEventListener("input", calculateTotal);
    document.getElementById("per-year-rate").addEventListener("input", calculateTotal);
    
    $('#generate-btn').on('click', function(event) {
        event.preventDefault(); // Prevent the default link action
        var pricingModel = $('#pricing-model').val();
        // Get form and specific input values
        var form = $(this).closest('form');
        var Rate, total, totalAmount;

    // Get values based on the pricing model
    if (pricingModel === 'hourly') {
        Rate = $('#per-hour-rate').val(); 
        total = $('#total-hours').val();  
        totalAmount = Rate * total; // Calculate total amount for hourly
    } else if (pricingModel === 'monthly') {
        Rate = $('#per-month-rate').val(); // Ensure this ID exists in your HTML
        total = $('#total-months').val(); 
        totalAmount = Rate * total; // Calculate total amount for monthly
    } else if (pricingModel === 'semester') {
        Rate = $('#per-semester-rate').val();
        total = $('#total-semester').val();
        totalAmount = Rate * total; // Calculate total amount for semester
    } else if (pricingModel === 'yearly') {
        Rate = $('#per-year-rate').val();
        total = $('#total-year').val();
        totalAmount = Rate * total; // Calculate total amount for yearly
    }
        var startDate = $('#starting-date').text();   // Extract total hours
        var endDate = $('#ending-date').text();   // Extract total hours
    
        // Prepare data for server
        var data = {
            student_id: `$student->id`,
            pricing_model: pricingModel,
            per_hour_rate: Rate,
            total_hours: total,
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

$this->registerJs($script, yii\web\View::POS_END);

?>
