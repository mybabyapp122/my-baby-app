<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;


// Example options (these should ideally come from your database or model)
$selectedOptions = explode(',', $model->value ?? ''); // Convert saved string to an array


$form = ActiveForm::begin([
'id' => 'school-form',
'options' => ['class' => 'ajax-form'],
'action' => ['update-teacher-access'],
]);
?>

<?= Html::hiddenInput('teacher_id', $teacher_id) ?>

<div class="row">

    <div class="col-lg-12">
        <div class="mb-3">
            <label for="optionsCheckboxes" class="form-label"><?= Yii::t('app', 'Homepage Access') ?></label>
            <div id="optionsCheckboxes">
                <?php foreach ($allOptions as $option): ?>
                    <div class="form-check">
                        <?= Html::checkbox(
                            "UserAttributes[value][]",
                            in_array($option, $selectedOptions),
                            ['value' => $option, 'class' => 'form-check-input', 'id' => 'option-' . $option]
                        ) ?>
                        <label class="form-check-label" for="<?= 'option-' . $option ?>">
                            <?= Yii::t('app', ucfirst(str_replace('_', ' ', $option))) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
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
