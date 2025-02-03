<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Plan;

/** @var array $plans List of available plans */
/** @var array $currentPlanInfo Information about the current plan */

// Define features for each plan
$features = [
    '1' => [
        array_merge(
            ['text' => Yii::t('app', 'Up to {n} Teachers', ['n' => Plan::PLANS['1']['max_teachers']])],
            getIcon(true)
        ),
        array_merge(
            ['text' => Yii::t('app', 'Availability Calculator')],
            getIcon(Plan::PLANS['1']['availability_calculator'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'School Stats')],
            getIcon(Plan::PLANS['1']['school_stats'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Manage Teacher\'s Access')],
            getIcon(Plan::PLANS['1']['teacher_access_management'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Arrival Notification')],
            getIcon(Plan::PLANS['1']['parent_arrival_feature'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Generate invoices for parents through MyBaby')],
            getIcon(Plan::PLANS['1']['generate_invoices_for_parents'])
        ),
    ],
    '2' =>  [
        array_merge(
            ['text' => Yii::t('app', 'Up to {n} Teachers', ['n' => Plan::PLANS['2']['max_teachers']])],
            getIcon(true)
        ),
        array_merge(
            ['text' => Yii::t('app', 'Availability Calculator')],
            getIcon(Plan::PLANS['2']['availability_calculator'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'School Stats')],
            getIcon(Plan::PLANS['2']['school_stats'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Manage Teacher\'s Access')],
            getIcon(Plan::PLANS['2']['teacher_access_management'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Arrival Notification')],
            getIcon(Plan::PLANS['2']['parent_arrival_feature'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Generate invoices for parents through MyBaby')],
            getIcon(Plan::PLANS['2']['generate_invoices_for_parents'])
        ),
    ],
    '3' =>  [
        array_merge(
            ['text' => Yii::t('app', 'Up to {n} Teachers', ['n' => Plan::PLANS['3']['max_teachers']])],
            getIcon(true)
        ),
        array_merge(
            ['text' => Yii::t('app', 'Availability Calculator')],
            getIcon(Plan::PLANS['3']['availability_calculator'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'School Stats')],
            getIcon(Plan::PLANS['3']['school_stats'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Manage Teacher\'s Access')],
            getIcon(Plan::PLANS['3']['teacher_access_management'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Arrival Notification')],
            getIcon(Plan::PLANS['3']['parent_arrival_feature'])
        ),
        array_merge(
            ['text' => Yii::t('app', 'Generate invoices for parents through MyBaby')],
            getIcon(Plan::PLANS['3']['generate_invoices_for_parents'])
        ),
    ],
];


function getIcon($is_available){
    $result = [
        'icon' => $is_available ? 'checkbox-circle-fill' : 'close-circle-fill',
        'color' => $is_available ? 'success' : 'danger'
    ];
    return $result;
}
$upgradeToList = !empty($currentPlanInfo['upgrade_to']) ? explode(',', $currentPlanInfo['upgrade_to']) : [];
?>

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="row">
            <?php foreach ($plans as $plan): ?>
                <?php
                    // Determine if this is the user's current plan
                    $isCurrentPlan = $plan->id === $currentPlanInfo['id'];

                    // Check if the plan is upgradeable
                    $isUpgradable = !$isCurrentPlan && in_array($plan->id, $upgradeToList);

                    // Determine button styling and text
                    $btnClass = $isCurrentPlan ? 'btn-soft-secondary' : ($isUpgradable ? 'btn-success' : 'btn-soft-danger');
                    $btnText = $isCurrentPlan ? Yii::t('app', 'Renew Plan') : ($isUpgradable ? Yii::t('app', 'Upgrade') : Yii::t('app', 'Not Upgradable'));
                    $planFeatures = $features[$plan->id] ?? [];

                ?>


                <div class="col-lg-4">
                    <div class="card pricing-box <?= $plan->highlighted ? 'ribbon-box right' : '' ?>">
                        <div class="card-body p-4 m-2">
                            <?php if ($plan->highlighted): ?>
                                <div class="ribbon-two ribbon-two-danger"><span><?= Yii::t('app', 'Popular') ?></span></div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold"><?= Yii::$app->language == 'en'? Html::encode($plan->name) : Html::encode($plan->name_ar) ?></h5>
                                    <p class="text-muted mb-0"><?= Yii::$app->language == 'en'? Html::encode($plan->description) : Html::encode($plan->description_ar) ?></p>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                        <i class="ri-book-mark-line fs-20"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <h2><?= Html::encode($plan->price) ?><sup><small>SAR</small></sup>
                                    <span class="fs-13 text-muted">/<?= $plan->subscription_period ?> <?= Yii::t('app', 'days') ?></span>
                                </h2>
                            </div>

                            <hr class="my-4 text-muted">

                            <!-- Features list -->
                            <ul class="list-unstyled text-muted vstack gap-3">
                                <?php foreach ($planFeatures as $feature): ?>
                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 text-<?= $feature['color'] ?> me-1">
                                                <i class="ri-<?= $feature['icon'] ?> fs-15 align-middle"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <?= $feature['text'] ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Subscribe/Upgrade button -->
                            <div class="mt-4">
                                <a href="<?= Url::to(['upgrade', 'id' => $plan->id, 'school_id' => $school_id]) ?>"
                                   class="btn <?= $btnClass ?> upgrade-btn w-100 waves-effect waves-light"
                                    <?= $isUpgradable ? '' : 'disabled' ?>>
                                    <?= $btnText ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php
$lang = Yii::$app->language;
$user_lang             = Yii::$app->language;
$crfToken             = Yii::$app->request->csrfToken;
$script = <<< JS
    
    $('.upgrade-btn').on('click', function(event) {
        event.preventDefault(); // Prevent the default link action
    
        const url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': `$crfToken`
            },
            success: function(data) {
                if (data.success) {
                    window.location.href = data.redirectUrl;
                } else {
                    notify(false, data.message);
                    // alert(data.message || 'An error occurred during the upgrade.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                notify(false, error);

                // alert('An error occurred during the request.');
            }
        });
    });

    
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>
