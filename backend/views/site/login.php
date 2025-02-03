<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>

<div class="card overflow-hidden">
    <div class="row g-0" >

        <div class="p-lg-5 p-4">
            <div>
                <h5 class="text-primary"><?= Yii::t('app', 'Welcome Back!') ?></h5>
                <p class="text-muted"><?= Yii::t('app', 'Sign in to continue to MyBaby.') ?></p>
            </div>

            <div class="mt-4">

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-dark w-100', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
<!--                <div class="mt-5 text-center">-->
<!--                    <p class="mb-0">Don't have an account ? <a href="signup" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>-->
<!--                </div>-->
        </div>

        <!-- end col -->
    </div>
    <!-- end row -->
</div>

