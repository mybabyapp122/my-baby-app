<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Grade;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


?>

<div class="row g-3" >
    <div class="modal-body text-center py-5" style="background-image: url('/themes/velzon/images/modal-bg.png'); background-size: cover; background-position: center;">
        <img src="/themes/velzon/images/404-error.png" alt="Upgrade Plan" class="img-fluid mb-4" style="max-width: 450px;">
        <h4><?= Yii::t('app', 'Access Denied') ?></h4>
        <p class="text-muted mb-4"><?= Yii::t('app', 'To access this feature, please upgrade your plan.') ?></p>
        <?= Html::a(Yii::t('app', 'Upgrade Plan'), ['/site/subscriptions'], ['class' => 'btn btn-primary btn-lg']) ?>
        <div class="justify-content-center">
            <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
        </div>
    </div>
</div>