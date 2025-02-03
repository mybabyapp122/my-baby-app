<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Grade $model */
/** @var yii\widgets\ActiveForm $form */


$selectedTeachers = ArrayHelper::map($model->teachers, 'id', 'name');
// Fetch all grades for the dropdown (assuming school_id is known)
$allTeachers = ArrayHelper::map(
    $model->school->getTeachersOfSchool(),
    'id',
    'name'
);

?>

<?php $form = ActiveForm::begin([
    'id' => 'grade-form',  // Assign an ID to the form
    'options' => ['class' => 'ajax-form'],
    'action' => ['update-grade'],
]); ?>
<?= $form->field($model, 'school_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3">
                <?= $form->field($model, 'title', [
                    'options' => ['class' => ''],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Enter name'],
                ]) ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <?= $form->field($gradeRatio, 'teacher_ratio', [
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => Yii::t('app', 'No. of Teachers per Students')],
                ]) ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <?= $form->field($gradeRatio, 'student_ratio', [
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => Yii::t('app', 'No. of Students per Teacher')],
                ]) ?>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label">Teachers <span class="text-muted text-sm-left" style="font-size: xx-small"><?= Yii::t('app', 'Select or add teachers') ?></span> </label>
                <?= $form->field($model, 'teachers')->widget(Select2::classname(), [
                    'data' => $allTeachers,
                    'value' => array_keys($selectedTeachers), // The IDs of the selected grades
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select...'),
                        'multiple' => true,
                        'tags' => false,
                    ],
                ])->label(false); ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <?php
                if (!$model->isNewRecord) {
                    echo Html::a(Yii::t('app', 'Delete'), ['delete-grade', 'id' => $model->id], ['class' => 'btn btn-danger']);
                }
                ?>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
                <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary submitFormThroughJson']) ?>
            </div>
        </div>

        <!--    <div class="modal-footer">-->
        <!--        -->
        <!--    </div>-->


    </div>
<?php ActiveForm::end(); ?>