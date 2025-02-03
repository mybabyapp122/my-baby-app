<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/images/mybaby/mb-logo-sm.png" alt="" height="55">
            </span>
            <span class="logo-lg">
                <img src="/images/mybaby/mb-title-logo.png" alt="" height="55">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="/images/mybaby/mb-logo-sm.png" alt="" height="55">
            </span>
            <span class="logo-lg">
                <img src="/images/mybaby/mb-logo-lg.png" alt="" height="125">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards"><?= Yii::t('app', 'Dashboards') ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/" class="nav-link" data-key="t-analytics"> <?= Yii::t('app', 'Analytics') ?> </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-apps"><?= Yii::t('app', 'Manage') ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <?php
                                $user =  \common\models\User::findById(false);
                                if (!empty($user) && $user->role == 'school') {
                            ?>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user/view-school', 'id' => Yii::$app->user->id]) ?>"
                                   class="nav-link" role="button"
                                   aria-expanded="false"
                                   aria-controls="sidebarjobs">

                                    <span data-key="t-jobs"><?= Yii::t('app','My School') ?></span>
                                </a>
                            </li>
                            <?php } ?>

                            <?php
                                $user =  \common\models\User::findById(false);
                                if (!empty($user) && $user->role == 'school') {
                            ?>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/availability/show-calculator', 'school_id' => Yii::$app->user->id]) ?>"
                                   class="nav-link" role="button"
                                   aria-expanded="false"
                                   aria-controls="sidebarjobs">

                                    <span data-key="t-jobs"><?= Yii::t('app','Availability Calculator') ?></span>
                                </a>
                            </li>
                            <?php } ?>


                            <?php
                            $user =  \common\models\User::findById(false);
                            if (!empty($user) && $user->role == 'school') {
                                ?>
                                <li class="nav-item">
                                    <a href="<?= \yii\helpers\Url::to(['/site/subscriptions']) ?>"
                                       class="nav-link" role="button"
                                       aria-expanded="false"
                                       aria-controls="sidebarjobs">

                                        <span data-key="t-jobs"><?= Yii::t('app','Subscription Plan') ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php
                            $user =  \common\models\User::findById(false);
                            if (!empty($user) && $user->role == 'school') {
                                ?>
                                <li class="nav-item">
                                    <a href="<?= \yii\helpers\Url::to(['/payment/index']) ?>"
                                       class="nav-link" role="button"
                                       aria-expanded="false"
                                       aria-controls="sidebarjobs">

                                        <span data-key="t-jobs"><?= Yii::t('app','Payments & Invoices') ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php
                            $user = \common\models\User::findById(false);
                            if (!empty($user) && $user->role == 'admin') {
                                ?>
                                <li class="nav-item">
                                    <a href="<?= \yii\helpers\Url::to(['/user/schools']) ?>"
                                       class="nav-link" role="button"
                                       aria-expanded="false"
                                       aria-controls="sidebarjobs">

                                        <span data-key="t-jobs"><?= Yii::t('app','All Schools') ?></span>
                                        <span class="badge badge-pill bg-success" data-key="t-new"><?= Yii::t('app','Admin') ?></span>
                                    </a>
                                </li>
                            <?php } ?>


                        </ul>
                    </div>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
    </div>

<!--    <div class="sidebar-background"></div>-->
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>