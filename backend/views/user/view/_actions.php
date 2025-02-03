<?php
use yii\widgets\ActiveForm;
?>

<div class="mb-3">
    <h5 class="card-title text-decoration-underline mb-3">Notifications:</h5>

    <?php
    $notification = ActiveForm::begin([
        'id' => 'user-notification-form',
        'options' => ['class' => 'ajax-form'],
        'action' => ['provider/send-notification'],
    ]); ?>
    <div class="flex-grow-1">
        <label for="directMessage" class="form-check-label fs-14">Send Notifications</label>
        <p class="text-muted">Receive notifications on all the devices you are logged in on</p>
    </div>


    <div class="vstack gap-2 mt-3">
        <input type="text" class="form-control" id="notification-title" placeholder="Title Here">
        <input type="text" class="form-control" id="notification-message" placeholder="Message Here">
    </div>
    <div class="hstack gap-2 mt-3">
        <a href="javascript:void(0);" data-action="email" class="btn btn-sm btn-light send-notification-action">Send Email</a>
        <a href="javascript:void(0);" data-action="push" class="btn btn-sm btn-light send-notification-action">Send Push Notification</a>
        <a href="javascript:void(0);" data-action="both" class="btn btn-sm btn-light send-notification-action">Send Email & Push</a>
    </div>
    <?php ActiveForm::end(); ?>
    <ul class="list-unstyled mb-0">
        <li class="d-flex">

        </li>
    </ul>
</div>