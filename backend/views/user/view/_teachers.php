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


//$this->registerCss("
//    .grid-view table tbody tr:hover {
//        background-color: #f5f5f5; /* Change to your preferred hover color */
//        cursor: pointer;
//    }
//");
//

$actionColumn = [
    'header' => Yii::t('app', 'Actions'),
    'class' => 'yii\grid\ActionColumn',
    'template' => '{schedule} {access} {edit}', // Define your custom template
    'buttons' => [
        'schedule' => function ($url, $model)  use ($update_schedule_action, $school_id) {

            if ($model->status != 'active') {
                return '';
            }
            return Html::a(
                '<i class="ri-eye-line me-1 align-bottom"></i> ' .  Yii::t('app', 'Manage Schedule'),
                '#',
                [
                    'class' => 'btn btn-dark btn-sm entry-row-btn',
                    'data-btn-url' => Url::to([$update_schedule_action, 'teacher_id' => $model->id, 'school_id' => $school_id])
                ]
            );
        },
        'access' => function ($url, $model)  use ($update_access_action, $school_id) {

            if ($model->status != 'active') {
                return '';
            }
            return Html::a(
                '<i class="ri-eye-line me-1 align-bottom"></i> ' .  Yii::t('app', 'Manage Access'),
                '#',
                [
                    'class' => 'btn btn-primary btn-sm entry-row-btn',
                    'data-btn-url' => Url::to([$update_access_action, 'teacher_id' => $model->id, 'school_id' => $school_id])
                ]
            );
        },
        'edit' => function ($url, $model)  use ($update_action, $school_id) {
            return Html::a(
                '<i class="ri-edit-2-line me-1 align-bottom"></i> ' .  Yii::t('app', 'Edit'),
                '#', // Use # to prevent any URL navigation
                [
                    'class' => 'btn btn-light btn-sm',
                    'data-url' => Url::to([$update_action, 'id' => $model->id, 'school_id' => $school_id])
                ]
            );
        },
    ],
];

$headerColumn = [
    'format' => 'raw', // Ensures HTML is rendered as-is
    'header' => Html::button( Yii::t('app', 'Add New') , [
        'class' => 'btn btn-dark btn-sm entry-row',
        'data-url'=> Url::to([$update_action, 'id' => 0, 'school_id' => $school_id]),
        'data-school-id' => $school_id
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
                'rowOptions' => function ($model) use ($update_action, $school_id) {
                    return ['class' => 'entry-row', 'data-url' => Url::to([$update_action, 'id' => $model->id, 'school_id' => $school_id])];
                },
            ]); ?>

            <?php Pjax::end(); ?>
        </div>

    </div>
</div>
<br>
<br>
