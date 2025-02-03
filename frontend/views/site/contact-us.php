<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBaby Information</title>
    <link href="/themes/velzon/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->

</head>
<body>
<div id="layout-wrapper">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Contact Information Section -->
                    <div class="section">
                        <h2 class="text-primary">Contact Information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Company Name:</strong> MyBaby</p>
                                <p><strong>Support Email:</strong> <a href="mailto:developer.mybabyapp@gmail.com" class="text-decoration-none">developer.mybabyapp@gmail.com</a></p>
                                <p><strong>Phone Number:</strong> <a href="tel:+966544856525" class="text-decoration-none">+966 54 485 6525</a></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Website:</strong> <a href="https://www.mybabyapp.net/" target="_blank" class="text-decoration-none">mybabyapp.net</a></p>
                                <p><strong>Address:</strong> 40st, Madinah, Saudi Arabia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="">
        <div class="container-fluid px-0 border-top border-gray-200 pt-lg-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="fs-16 text-gray-600 my-2">
                        <script>document.write(new Date().getFullYear())</script> &copy; MyBaby - <?= Yii::t('app', 'All Rights Reserved') ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="nav navbar">
                        <li><a href="https://mybabyapp.net"><?= Yii::t('app', 'About Website') ?></a></li>
                        <li><a href="https://dash.mybabyapp.net/site/privacy-policy"><?= Yii::t('app', 'All Rights Reserved') ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
