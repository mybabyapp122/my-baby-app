<?php

/**
 * @var $this \yii\web\View
 * @var $data array
 */

$formatter = Yii::$app->formatter;
?>
<div class="container">
        <h1><?=Yii::t('app', 'Invoice')?></h1>
    <header>
        <div class="logo">
            <img src="<?= \common\libraries\CustomWidgets::apiUrl() . '/theme/img/mybaby.png' ?>" alt="MyBaby Logo">
        </div>
        <div class="header-content">
            <div class="company-info">
                <h2><?=$data['company_name']?></h2>
                <address>
                    <?php foreach ($data['company_address'] as $address) {
                        echo $address . '<br>';
                    }
                    ?>
                    <a href="mailto:<?=$data['company_email']?>"><?=$data['company_email']?></a>
                </address>
            </div>
        </div>
    </header>

    <section class="invoice-details">
        <div class="invoice-to">
            <h3><?=Yii::t('app', 'Invoice To')?></h3>
            <p>
                <strong><?=$data['recipient_name']?></strong><br>
                <?php foreach ($data['recipient_address'] as $address) {
                    echo $address . '<br>';
                }
                ?>
            </p>
        </div>
        <div class="invoice-info">
            <p><strong><?=Yii::t('app', 'Invoice Number')?>:</strong> <?=$data['invoice_id']?></p>
            <p><strong><?=Yii::t('app', 'Invoice Date')?>:</strong> <?=$formatter->asDate($data['invoice_date'])?></p>
            <p><strong><?=Yii::t('app', 'Payment Date')?>:</strong> <?=empty($data['payment_date']) ? 'n/a' : $formatter->asDate($data['payment_date'])?></p>
            <p><strong><?=Yii::t('app', 'Status')?>:</strong> <?=$data['status']?></p>
        </div>
    </section>

    <section class="items">
        <h3><?=Yii::t('app', 'Items')?></h3>
        <table>
            <thead>
            <tr>
                <th><?=Yii::t('app', 'Description')?></th>
                <th><?=Yii::t('app', 'Quantity')?></th>
                <th><?=Yii::t('app', 'Unit Price')?></th>
                <th><?=Yii::t('app', 'Total')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['items'] as $item) : ?>
                <tr>
                    <td><?=$item['title']?></td>
                    <td><?=$item['quantity']?></td>
                    <td><?=$formatter->asCurrency($item['amount'], 'SAR')?></td>
                    <td><?=$formatter->asCurrency($item['total'], 'SAR')?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="summary">
        <div class="summary-details">
            <p><strong><?=Yii::t('app', 'Subtotal')?>:</strong> <?=$formatter->asCurrency($data['subtotal'], 'SAR')?></p>
            <p><strong><?=Yii::t('app', 'Value Added Tax (15%)')?>:</strong> <?=$formatter->asCurrency($data['vat'], 'SAR')?></p>
            <p><strong><?=Yii::t('app', 'Total')?>:</strong> <?=$formatter->asCurrency($data['total'], 'SAR')?></p>
        </div>
    </section>

    <footer>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?=$data['invoice_url']?>" alt="QR Code">
    </footer>
</div>