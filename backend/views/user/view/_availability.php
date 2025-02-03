<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use common\models\Grade;
use common\models\User;



?>


<div class="mb-3">
    <h5 class="card-title text-decoration-underline mb-3"><?= Yii::t('app', 'Availability Calendar') ?></h5>
    <p class="text-muted"><?= Yii::t('app', 'To find out how many slots available on which date open the calendar page and search') ?></p>

    <?php
    $notification = ActiveForm::begin([
        'id' => 'user-notification-form',
        'options' => ['class' => 'ajax-form'],
        'action' => ['provider/send-notification'],
    ]); ?>

    <div class="gap-2 mt-3 align-content-center">
        <a href="<?=  \yii\helpers\Url::to(['/availability/show-calculator', 'school_id' => $school_id]) ?>" target="_blank" class="btn btn-sm btn-dark"><?= Yii::t('app', 'Open Calendar') ?></a>
    </div>
    <?php ActiveForm::end(); ?>
    <ul class="list-unstyled mb-0">
        <li class="d-flex">

        </li>
    </ul>
</div>
