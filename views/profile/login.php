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
    <div class="col-md-12">
        <h2>Авторизоваться через Вконтакте: </h2>
        <center>
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['profile/auth'],
                'popupMode' => false,
            ]) ?>
        </center>
    </div>
</div>