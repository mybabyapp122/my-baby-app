<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Grade $model */
/** @var yii\widgets\ActiveForm $form */

// Fetch all grades for the dropdown (assuming school_id is known)
$allGrades = ArrayHelper::map(
    \common\models\Grade::find()->where(['school_id' => $school_id])->all(),
    'id',
    'title'
);

$form = ActiveForm::begin([
    'id' => 'student-form',  // Assign an ID to the form
    'options' => ['class' => 'ajax-form'],
    'action' => ['update-student'],
]); ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <div class="row g-3">
        <div class="col-xxl-12">
            <div>
                <?= $form->field($model->parent, 'email', [
                    'template' => '{label}<div>{input}</div>{error}',
                    'options' => ['class' => ''],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Enter email'],
                ])->label('Parent Email', ['class' => 'form-label']) ?>
            </div>
        </div>

        <div class="col-xxl-6">
            <div>
                <?= $form->field($model, 'id_number', [
                    'template' => '{label}<div>{input}</div>{error}',
                    'options' => ['class' => ''],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Enter ID Number'],
                ])->label('Student\'s ID #', ['class' => 'form-label']) ?>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="mb-3">
                <label class="form-label">Grade <span class="text-muted text-sm-left" style="font-size: xx-small"><?= Yii::t('app', 'Select Grade') ?></span> </label>
                <?= $form->field($model, 'grade_id')->widget(Select2::classname(), [
                    'data' => $allGrades,
                    'value' => $model->grade_id, // The IDs of the selected grades
                    'options' => [
                        'placeholder' => 'Grade',
                        'multiple' => false,
                        'tags' => false,
                    ],
                ])->label(false); ?>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <?php
                if (!$model->isNewRecord) {
                    echo Html::a('Delete', ['delete-student', 'id' => $model->id], ['class' => 'btn btn-danger']);
                }
                ?>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <?= Html::button('Save', ['class' => 'btn btn-primary submitFormThroughJson']) ?>
            </div>
        </div>

        <!--    <div class="modal-footer">-->
        <!--        -->
        <!--    </div>-->


    </div>
<?php ActiveForm::end(); ?>