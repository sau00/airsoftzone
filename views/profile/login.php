<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php
$this->title = 'Авторизация пользователей';
?>

<div class="container">
    <div class="col-md-6">
        <h2>Авторизация</h2>
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['profile/auth'],
            'popupMode' => false,
        ]) ?>
    </div>
    <div class="col-md-6">
        <h2>Регистрация пользователя</h2>
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['profile/auth'],
            'popupMode' => false,
        ]) ?>
    </div>

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>

        </div><!--/.col-xs-12.col-sm-9-->
    </div><!--/row-->
</div>