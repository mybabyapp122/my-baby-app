<?php
$lang       = Yii::$app->language;
?>

<!--<link href="/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />-->
<!--<link href="/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css" />-->

<!-- Layout config Js -->
<script src="/themes/velzon/js/layout.js"></script>

<style>
    /* Define your custom fonts */
    @font-face {
        font-family: 'MyArabicFont';
        src: url('<?= Yii::getAlias('@web') ?>/themes/velzon/fonts/SSTMedium.ttf') format('truetype');
    }

    /* Global font settings */
    /*body {*/
    /*    font-family: 'MyCustomFont', sans-serif; !* Default font for non-Arabic text *!*/
    /*}*/

    /* Apply Arabic font globally */
    body[lang="ar"] {
        font-family: 'MyArabicFont', serif; /* Font for Arabic text */
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

<!-- Bootstrap Css -->
<?php if ($lang == 'en') {?>
    <link href="/themes/velzon/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<?php } else { ?>
    <link href="/themes/velzon/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
<?php } ?>

<!-- Icons Css -->
<link href="/themes/velzon/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<?php if ($lang == 'en') {?>
    <link href="/themes/velzon/css/app.min.css" rel="stylesheet" type="text/css" />
<?php } else { ?>
    <link href="/themes/velzon/css/app-rtl.min.css" rel="stylesheet" type="text/css" />
<?php } ?>


<!-- custom Css-->
<link href="/themes/velzon/css/custom.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/themes/velzon/libs/sweetalert2/sweetalert2.min.css">
