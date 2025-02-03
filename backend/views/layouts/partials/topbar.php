<?php
$assetDir = '/theme/v2';

$_username = 'Guest';
$_admin = \common\models\User::findOne(Yii::$app->user->id);
if (isset($_admin))
$_username = $_admin->name;
?>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/images/mybaby/mb-logo-sm.png" alt="" height="55">
                        </span>
                        <span class="logo-lg">
                            <img src="/images/mybaby/mb-logo-lg.png" alt="" height="125">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/images/mybaby/mb-logo-sm.png" alt="" height="55">
                        </span>
                        <span class="logo-lg">
                            <img src="/images/mybaby/mb-logo-lg.png" alt="" height="125">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>

            <div class="d-flex align-items-center">



                <div class="dropdown ms-sm-1 header-item topbar-lang">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-lang-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-globe fs-22'></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">
                            <?= Yii::t('app', 'Select Language') ?>
                        </h6>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= \yii\helpers\Url::current(['lang' => 'en']) ?>">
<!--                            <img height="18" class="avatar avatar-xss avatar-circle me-2" src="/themes/velzon/images/flags/us.svg" alt="Flag">-->
                            <span class="text-truncate" title="English">English</span>
                        </a>
                        <a class="dropdown-item" href="<?= \yii\helpers\Url::current(['lang' => 'ar']) ?>">
<!--                            <img height="18" class="avatar avatar-xss avatar-circle me-2" src="/themes/velzon/images/flags/sa.svg"alt="Flag">-->
                            <span class="text-truncate arabic-font" title="Arabic">العربية</span>
                        </a>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                          <img class="rounded-circle header-profile-user"
                               src="<?= Yii::$app->user->identity->getSchoolDp() ?>" alt="Header Avatar">
                          <span class="text-start ms-xl-2">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                              <?= $_username ?>
                            </span>
                          </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header"><?= Yii::t('app', 'Welcome') ?>
                            <?= $_username ?>!
                        </h6>

                        <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['/user/view-school', 'id' => Yii::$app->user->id]) ?>"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle"><?= Yii::t('app', 'Dashboard') ?></span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['/site/logout']) ?>"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                                                                                                         data-key="t-logout"><?= Yii::t('app', 'Logout') ?></span></a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->