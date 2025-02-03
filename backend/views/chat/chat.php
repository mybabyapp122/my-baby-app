<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $group common\models\Groups */

$this->title = Yii::t('app', 'Chat') . ' - ' . Html::encode($group->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Group Management'), 'url' => ['chat/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/chat.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);

$username = Yii::$app->user->identity->username;
$addMemberUrl = Url::to(['chat/add-member', 'group_id' => $group->id]);
$loadMessagesUrl = Url::to(['chat/load-messages', 'group_id' => $group->id]);
//$loadMessagesUrl = \common\libraries\CustomWidgets::apiUrl() . '/chat/messages'; // Url::to(['chat/load-messages', 'group_id' => $group->id]);
$this->registerJs("
    var addMemberUrl = '{$addMemberUrl}';
    var loadMessagesUrl = '{$loadMessagesUrl}';
    var groupId = '{$group->id}';
    var username = '{$username}';
", \yii\web\View::POS_HEAD);

?>

<div class="row g-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="chat-interface">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <div class="row">
                        <!-- Left Side: Group Members and Add Member Dropdown -->
                        <div class="col-lg-3">
                            <h3>Group Members</h3>
                            <ul class="list-element mb-6">
                                <?php foreach ($group->groupMembers as $member): ?>
                                    <li>
                                        <span class="text-muted">[<?= ucfirst(Html::encode($member->user->role)) ?>]</span>
                                        <strong><?= Html::encode($member->user->name) ?></strong>
                                        <span class="text-muted">(@<?= strtolower(Html::encode($member->user->username)) ?>)</span>
                                        <!-- Delete Button -->
                                        <?php
                                        if ($member->user->role != 'school') {
                                            echo Html::button('<i class="ri-delete-bin-4-line"></i>', [
                                                'class' => 'btn btn-sm',
                                                'onclick' => "
                                                if (confirm('Are you sure you want to remove this member?')) {
                                                    $.ajax({
                                                        url: '" . Url::to(['chat/remove-member']) . "',
                                                        type: 'POST',
                                                        data: {
                                                            user_id: " . $member->user->id . ",
                                                            group_id: " . $group->id . "
                                                        },
                                                        success: function(response) {
                                                            if (response.success) {
                                                                location.reload(); // Refresh the page on success
                                                            } else {
                                                                notify(false, response.message);
                                                            }
                                                        },
                                                        error: function() {
                                                            notify(false, 'An error occurred. Please try again.');
                                                        }
                                                    });
                                                }
                                            "
                                            ]);
                                        }
                                        ?>
                                        <br>


                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Dropdown list for filtered members to add to the group -->
                            <div class="mb-3">
                                <?= Html::dropDownList(
                                    'filtered_members',
                                    null,
                                    $filtered_members,
                                    [
                                        'prompt' => Yii::t('app', 'Select a member to add...'),
                                        'id' => 'member-dropdown',
                                        'class' => 'form-control',
                                    ]
                                ); ?>
                            </div>
                        </div>

                        <!-- Right Side: Chat Messages and Send Form -->
                        <div class="col-lg-9">
                            <h3>Chat Messages</h3>

                            <!-- Chat Messages Display Area -->
                            <div id="chat-messages" class="chat-messages" style="height: 400px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
                                <!-- Messages will be dynamically loaded here -->
                            </div>

                            <!-- Message Sending Form -->
                            <?php $form = ActiveForm::begin([
                                'id' => 'chat-form',
                                'action' => Url::to(['chat/send-message', 'group_id' => $group->id]),
                                'method' => 'post',
                                'options' => ['class' => 'd-flex align-items-center gap-2'],
                            ]); ?>

                            <!-- Input Field for Message -->
                            <div class="flex-grow-1">
                                <?= $form->field($model, 'message', [
                                    'inputOptions' => [
                                        'id' => 'chat-message-input',
                                        'placeholder' => Yii::t('app', 'Type your message...'),
                                        'class' => 'form-control',
                                    ],
                                ])->label(false); ?>
                            </div>

                            <!-- Send Button -->
                            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'id' => 'send-message-button']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End card -->
    </div>
</div>
