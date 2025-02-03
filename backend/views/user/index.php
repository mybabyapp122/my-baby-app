<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', $title);
$this->params['breadcrumbs'][] = $this->title;

$actionColumn = [
    'header' => Yii::t('app', 'Actions'),
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {edit}', // Define your custom template
    'buttons' => [
        'view' => function ($url, $model) {
            $viewUrl = Url::to(['login-by-access-token', 'id' => $model->auth_key]);

            return Html::a(
                '<i class="ri-eye-line me-1 align-bottom"></i> ' .  Yii::t('app', 'Switch to School'),
                $viewUrl,
                [
                    'class' => 'btn btn-dark',
                    'target' => '_blank',
//                    'onclick' => "window.open('$viewUrl', '_blank', 'width=800,height=600,scrollbars=yes,resizable=yes'); return false;"
                ]
            );
        },
        'edit' => function ($url, $model)  use ($update_action) {
            return Html::a(
                '<i class="ri-edit-2-line me-1 align-bottom"></i> ' .  Yii::t('app', 'Edit'),
                '#', // Use # to prevent any URL navigation
                [
                    'class' => 'btn btn-light entry-row',
                    'data-url' => Url::to([$update_action, 'id' => $model->id])
                ]
            );
        },
    ],
];


$headerColumn = [
    'format' => 'raw', // Ensures HTML is rendered as-is
    'header' => Html::button(Yii::t('app', 'Invite School'), [
        'class' => 'btn btn-dark btn-sm entry-row',
        'data-url'=> Url::to([$update_action, 'id' => 0]),
    ]),
    'value' => function () {
        return '';
    },
];

$gridColumns = array_merge($columns, [$actionColumn], [$headerColumn]);

?>


<br>
<br>



<div class="row g-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><?= Yii::t('app', 'All Schools') ?></h4>
            </div><!-- end card header -->
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table-card">

                            <?php Pjax::begin(['id' => 'pjax-container']); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'options' => ['class' => 'table-responsive'], // Optional: makes the table scrollable
                                'headerRowOptions' => ['class' => 'table-light text-muted'],
                                'tableOptions' => ['class' => 'table table-borderless align-middle mb-0 table-striped'],
                                'columns' => $gridColumns,
                                'summary' => '',
                                'rowOptions' => function ($model) use ($update_action) {
                                    return ['class' => 'entry-row', 'data-url' => Url::to([$update_action, 'id' => $model->id])];
                                },
                            ]); ?>

                            <?php Pjax::end(); ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>