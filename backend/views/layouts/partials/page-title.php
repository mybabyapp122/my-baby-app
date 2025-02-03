<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= ($title) ? $title : '' ?></h4>

            <div class="page-title-right">
                <?= \yii\widgets\Breadcrumbs::widget([
                    'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                    'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                    'options' => [
                        'class' => 'breadcrumb',
                    ],
                    'encodeLabels' => true,
//                                'separator' => ' > ',  // Set the separator here
                    'homeLink' => [
                        'label' => Yii::t('app', 'Dashboard'),
                        'url' => \yii\helpers\Url::to(['/'])
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                ?>
<!--                <ol class="breadcrumb m-0">-->
<!--                    <li class="breadcrumb-item"><a href="javascript: void(0);">--><?//= ($pagetitle) ? $pagetitle : '' ?><!--</a></li>-->
<!--                    <li class="breadcrumb-item active">--><?//= ($title) ? $title : '' ?><!--</li>-->
<!--                </ol>-->
            </div>

        </div>
    </div>
</div>
<!-- end page title -->