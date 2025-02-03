<?php
use yii\helpers\Html;

foreach ($messages as $message): ?>
    <div class="card mb-2">
        <div class="card-body p-2">
            <!-- User and Timestamp -->
            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="text-primary"><?= Html::encode($message->sender->username) ?></strong>
                <span class="text-muted small"><?= Yii::$app->formatter->asDatetime($message->create_time) ?></span>
            </div>
            <!-- Message Content -->
            <p class="mb-0"><?= Html::encode($message->message) ?></p>
        </div>
    </div>
<?php endforeach; ?>