<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"  class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html;  charset=<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="MyBaby">
    <meta name="keywords" content="MyBaby">
    <meta name="author" content="MyBaby">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="/theme/css/style.css">
    <?php if (Yii::$app->language == 'ar') : ?>
    <link rel="stylesheet" href="/theme/css/style_ar.css">
    <?php endif; ?>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
