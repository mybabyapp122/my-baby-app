<?php
$formatter = Yii::$app->formatter;

////////
///
/// STANDALONE UI, CAN BE SENT VIA EMAIL
///
///////
?>
<!DOCTYPE html>
<html lang="<?= $data['lang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Yii::t('app', 'Invoice') ?></title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa;">

<!-- Main Container -->
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border: 1px solid #ddd; margin: 20px auto;">
    <!-- Header -->
    <tr>
        <td style="padding: 20px; border-bottom: 1px solid #ddd; text-align: center;">
            <img src="<?= \common\libraries\CustomWidgets::apiUrl() . '/theme/img/mybaby.png' ?>" alt="MyBaby Logo" style="max-width: 100px; height: auto;">
            <h1 style="font-size: 24px; margin: 10px 0; color: #333;"><?= Yii::t('app', 'Invoice') ?></h1>
        </td>
    </tr>

    <!-- Company Info -->
    <tr>
        <td style="padding: 20px;">
            <table width="100%">
                <tr>
                    <td>
                        <h2 style="margin: 0; font-size: 18px; color: #333;"><?= $data['company_name'] ?></h2>
                        <p style="margin: 5px 0; font-size: 14px; color: #555;">
                            <?php foreach ($data['company_address'] as $address) {
                                echo $address . '<br>';
                            } ?>
                            <a href="mailto:<?= $data['company_email'] ?>" style="color: #007bff; text-decoration: none;"><?= $data['company_email'] ?></a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Invoice Details -->
    <tr>
        <td style="padding: 20px; background-color: #f8f8f8;">
            <table width="100%">
                <tr>
                    <td style="vertical-align: top;">
                        <h3 style="margin: 0 0 5px; font-size: 16px;"><?= Yii::t('app', 'Invoice To') ?></h3>
                        <p style="margin: 0; font-size: 14px; color: #555;">
                            <strong><?= $data['recipient_name'] ?></strong><br>
                            <?php foreach ($data['recipient_address'] as $address) {
                                echo $address . '<br>';
                            } ?>
                        </p>
                    </td>
                    <td style="text-align: right;">
                        <p style="margin: 0; font-size: 14px; color: #555;">
                            <strong><?= Yii::t('app', 'Invoice Number') ?>:</strong> <?= $data['invoice_id'] ?><br>
                            <strong><?= Yii::t('app', 'Invoice Date') ?>:</strong> <?= $formatter->asDate($data['invoice_date']) ?><br>
                            <strong><?= Yii::t('app', 'Payment Date') ?>:</strong> <?= empty($data['payment_date']) ? 'n/a' : $formatter->asDate($data['payment_date']) ?><br>
                            <strong><?= Yii::t('app', 'Status') ?>:</strong> <?= $data['status'] ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Items Table -->
    <tr>
        <td style="padding: 20px;">
            <h3 style="margin: 0 0 10px; font-size: 16px;"><?= Yii::t('app', 'Items') ?></h3>
            <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-size: 14px; color: #555;">
                <thead>
                <tr style="background-color: #f1f1f1; text-align: left;">
                    <th><?= Yii::t('app', 'Description') ?></th>
                    <th><?= Yii::t('app', 'Quantity') ?></th>
                    <th><?= Yii::t('app', 'Unit Price') ?></th>
                    <th><?= Yii::t('app', 'Total') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['items'] as $item) : ?>
                    <tr>
                        <td><?= $item['title'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $formatter->asCurrency($item['amount'], 'SAR') ?></td>
                        <td><?= $formatter->asCurrency($item['total'], 'SAR') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </td>
    </tr>

    <!-- Summary -->
    <tr>
        <td style="padding: 20px; text-align: right;">
            <p style="margin: 5px 0; font-size: 14px; color: #333;">
                <strong><?= Yii::t('app', 'Subtotal') ?>:</strong> <?= $formatter->asCurrency($data['subtotal'], 'SAR') ?>
            </p>
            <p style="margin: 5px 0; font-size: 14px; color: #333;">
                <strong><?= Yii::t('app', 'Value Added Tax (15%)') ?>:</strong> <?= $formatter->asCurrency($data['vat'], 'SAR') ?>
            </p>
            <p style="margin: 5px 0; font-size: 16px; color: #000;">
                <strong><?= Yii::t('app', 'Total') ?>:</strong> <?= $formatter->asCurrency($data['total'], 'SAR') ?>
            </p>
        </td>
    </tr>

    <!-- Footer with QR Code -->
    <tr>
        <td style="padding: 20px; text-align: center; background-color: #f8f8f8;">
            <p style="margin: 0; font-size: 14px;"><?= Yii::t('app', 'Scan QR Code for Invoice Details') ?></p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $data['invoice_url'] ?>" alt="QR Code" style="margin-top: 10px;">
        </td>
    </tr>
</table>

</body>
</html>