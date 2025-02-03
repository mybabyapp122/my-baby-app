<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'id' => 'school-form',  // Assign an ID to the form
    'options' => ['class' => 'ajax-form'],
    'action' => ['update-school'],
]); ?>
<div class="row g-3">
    <!-- Email Field -->
    <div class="col-xxl-12">
        <?= $form->field($model, 'email', [
            'options' => ['class' => ''],
            'inputOptions' => ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Enter your email')],
        ]) ?>
    </div>

    <div class="col-lg-12">
        <div class="hstack gap-2 justify-content-end">
            <?php
            if (!$model->isNewRecord) {
                echo Html::a(Yii::t('app', 'Delete'), ['delete-school', 'id' => $model->id], ['class' => 'btn btn-danger']);
            }
            ?>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
            <?php
            if ($model->isNewRecord) {
                echo Html::button(Yii::t('app', 'Send Invitation'), ['class' => 'btn btn-primary submitFormThroughJson']);
            } else {
                echo Html::button(Yii::t('app', 'Resend Invitation'), ['class' => 'btn btn-primary submitFormThroughJson']);
            }
            ?>
        </div>
    </div>

<!--    <div class="modal-footer">-->
<!--        -->
<!--    </div>-->


</div>
<?php ActiveForm::end(); ?>
