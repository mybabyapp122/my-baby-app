<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Grade;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */


$selectedGrades = ArrayHelper::map($model->grades, 'id', 'title');
// Fetch all grades for the dropdown (assuming school_id is known)
$allGrades = ArrayHelper::map(
    Grade::find()->where(['school_id' => $school_id])->all(),
    'id',
    'title'
);

?>

<?php
//$form = ActiveForm::begin([
//    'id' => 'teacher-form',
//    'options' => ['class' => 'ajax-form'],
//    'action' => ['update-teacher'],
//]);
?>
<?= Html::hiddenInput('User[school_id]', $school_id) ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>


<div class="row g-3">
    <!-- Email Field -->
    <div class="col-xxl-12">
        <?= $form->field($model, 'email', [
            'options' => ['class' => ''],
            'inputOptions' => ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Enter your email')],
        ]) ?>
    </div>


    <div class="col-lg-12">
        <label class="form-label"><?= Yii::t('app', 'Grade') ?> <span class="text-muted text-sm-left" style="font-size: xx-small"><?= Yii::t('app', 'Select or add grades') ?></span> </label>
        <?= $form->field($model, 'grades')->widget(Select2::classname(), [
            'data' => $allGrades,
            'value' => array_keys($selectedGrades), // The IDs of the selected grades
            'options' => [
                'placeholder' => Yii::t('app', 'Grades'),
                'id' => 'grade-select', // Set ID for Select2
                'multiple' => true,
                'tags' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'createTag' => new \yii\web\JsExpression('function(params) {
                    if (params.term.length > 0 && params.originalEvent && params.originalEvent.type === "keydown" && params.originalEvent.keyCode === 13) {
                        return {
                            id: params.term,
                            text: params.term,
                            newTag: true // Mark as a new tag
                        };
                    }
                    return null; // Do not create a tag while typing
                }'),
                'ajax' => [
                    'url' => Url::to(['grade/search']), // You will create this action
                    'dataType' => 'json',
                    'delay' => 250, // Delay for searching
                    'data' => new \yii\web\JsExpression('function(params) { 
                        return {
                            q:params.term,
                            school_id: '.$school_id.',
                            selected: $("#user-grades").val() // Send selected values to the server
                        }; 
                    }'),
                    'processResults' => new \yii\web\JsExpression('function(data) {
                        return {
                            results: data.items
                        };
                    }'),
                    'initSelection' => new \yii\web\JsExpression('function (element, callback) {
                        var data = ' . json_encode($selectedGrades) . ';
                        callback(data);
                    }'),
                ],
            ],
        ])->label(false); ?>
    </div>

    <div class="col-lg-12">
        <div class="hstack gap-2 justify-content-end">
            <?php
            if (!$model->isNewRecord) {
                echo Html::a(Yii::t('app', 'Delete'), ['delete-teacher', 'id' => $model->id], ['class' => 'btn btn-danger']);
            }
            ?>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?=Yii::t('app', 'Close')?></button>
            <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-primary submitFormThroughJson']) ?>
        </div>
    </div>

<!--    <div class="modal-footer">-->
<!--        -->
<!--    </div>-->


</div>
<?php ActiveForm::end(); ?>