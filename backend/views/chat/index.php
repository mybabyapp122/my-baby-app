<?php
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('app', $title);
$this->params['breadcrumbs'][] = $this->title;

$actionColumn = [
    'header' => Yii::t('app', 'Actions'),
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {edit}', // Define your custom template
    'buttons' => [
        'view' => function ($url, $model)  use ($view_action) {
            return Html::a(
                '<i class="ri-eye-line me-1 align-bottom"></i> Open Chat',
//                                        '#', // Use # to prevent any URL navigation
                Url::to([$view_action, 'group_id' => $model->id]),
                [
                    'class' => 'btn btn-dark entry-row-btn',
                    'target' => '_blank',
                ]
            );
        },
        'edit' => function ($url, $model)  use ($update_action) {
            return Html::a(
                '<i class="ri-edit-2-line me-1 align-bottom"></i> Edit',
                '#', // Use # to prevent any URL navigation
                [
                    'class' => 'btn btn-light',
                    'data-url' => Url::to([$update_action, 'group_id' => $model->id])
                ]
            );
        },
    ],
];


$headerColumn = [
    'format' => 'raw', // Ensures HTML is rendered as-is
    'header' => Html::button(Yii::t('app', 'New Group'), [
        'class' => 'btn btn-dark btn-sm entry-row',
        'data-url'=> Url::to([$update_action, 'group_id' => 0]),
    ]),
    'value' => function () {
        return '';
    },
];

$gridColumns = array_merge($columns, [$actionColumn], [$headerColumn]);

?>


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
                                    return ['class' => 'entry-row', 'data-url' => Url::to([$update_action, 'group_id' => $model->id])];
                                },
                            ]); ?>

                            <?php Pjax::end(); ?>
                        </div>

                    </div>
                </div>
