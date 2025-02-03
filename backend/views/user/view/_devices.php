<?php
use yii\widgets\ActiveForm;

$form1 = ActiveForm::begin([
    'id' => 'devices-form',
    'options' => ['class' => 'ajax-form'],
    'action' => ['school-device-logout'],
]); ?>
    <div class="mt-4 mb-3 border-bottom pb-2">
        <div class="float-end">
<!--            <a href="javascript:void(0);" class="link-primary logout-device" data-user-id="-->
            <?php
//                echo $model->id
            ?>
<!--            " data-action="logoutAll" id="logout-all-devices">All Logout</a>-->
        </div>
        <h5 class="card-title"><?= Yii::t('app', 'Devices') ?></h5>
    </div>
<?php foreach ($devices as $device) { ?>
    <div class="d-flex align-items-center mb-3">
        <div class="flex-shrink-0 avatar-sm">
            <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                <i class="ri-tablet-line"></i>
            </div>
        </div>
        <div class="flex-grow-1 ms-3">
            <h6><?= $device->device->model ?></h6>
            <p class="text-muted mb-0">User: <?= $device->getDeviceDetail('teacher', $device->value, 'name') ?></p>
            <p class="text-muted mb-0">Last Used: <?= $device->getDeviceDetail('teacher', $device->value, 'last_used') ?></p>
        </div>
        <div>
<!--            <a href="javascript:void(0);" class="logout-device" data-user-id="-->
                <?php
//                    echo $device->value
                ?>
<!--            " data-action="logoutDevice">Logout</a>-->
        </div>
    </div>
<?php } ?>

<?php ActiveForm::end(); ?>