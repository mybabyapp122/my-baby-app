<?php
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
'id' => 'school-form',
'options' => ['class' => 'ajax-form'],
'action' => ['update-school'],
]);
?>

<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

<div class="row">

    <div class="col-lg-12">
        <div class="mb-3">
            <?= $form->field($model, 'name', [
                'inputOptions' => ['placeholder' => Yii::t('app', 'Enter your name'), 'class' => 'form-control'],
            ])->textInput(['value' => $model->name]) ?>
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-6">
        <div class="mb-3">
            <?= $form->field($model, 'mobile', [
                'inputOptions' => ['placeholder' => Yii::t('app', 'Mobile Number'), 'class' => 'form-control'],
            ])->textInput(['value' => $model->mobile]) ?>
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-6">
        <div class="mb-3">
            <?= $form->field($model, 'email', [
                'inputOptions' => ['placeholder' => Yii::t('app', 'Email'), 'class' => 'form-control'],
            ])->textInput(['value' => $model->email,'readonly' => true, 'disabled' => true,]) ?>
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-12">
        <div class="mb-3">
            <label for="JoiningdatInput" class="form-label"><?= Yii::t('app', 'Joining Date') ?></label>
            <input type="text"
                   id="JoiningdatInput"
                   class="form-control"
                   placeholder="Select date"
                   data-provider="flatpickr"
                   data-date-format="Y-m-d H:i:s"
                   value="<?= Yii::$app->formatter->asDatetime($model->create_time, 'php:Y-m-d H:i:s') ?>"
                   readonly
                   disabled
            />
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-12">
        <div class="hstack gap-2 justify-content-end">
            <a href="javascript:void(0);" class="badge bg-light text-primary fs-16 submitFormThroughJson"><i class="ri-save-line align-bottom me-1"></i> <?= Yii::t('app', 'Update') ?></a>
            <!--                                                <button type="submit" class="btn btn-primary saveProviderInfo">Update</button>-->
            <!--                                                <button type="button" class="btn btn-soft-success">Cancel</button>-->
        </div>
    </div>
    <!--end col-->
</div>
<?php ActiveForm::end(); ?>
