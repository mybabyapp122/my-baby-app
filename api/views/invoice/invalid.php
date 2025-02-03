<?php
use yii\helpers\Html;
?>

<div class="row g-3" >

</div>

<div class="container">
    <h1><?=Yii::t('app', 'Invoice')?></h1>
    <header>
        <div class="logo">
            <img src="/theme/img/mybaby.png" alt="MyBaby Logo">
        </div>
        <div class="header-content">
            <div class="company-info">

            </div>
        </div>
    </header>

    <section class="invoice-details">
        <h4><?= Yii::t('app', 'Invoice Not Found') ?></h4>
    </section>
    <section class="items">
        <p class="text-muted mb-4"><?= Yii::t('app', 'Invalid Invoice ID. Please contact Customer Care') ?></p>
    </section>

</div>