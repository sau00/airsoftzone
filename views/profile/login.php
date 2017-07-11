<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = 'Login';
?>


<?php
$this->title = 'Авторизация пользователей';
?>

<div class="container">
    <div class="col-md-12 text-center">
        <h2>Авторизация на сайте</h2>
        <p>Для добавления объявлений необходимо авторизоваться или зарегистрироваться</p>
        <?php $authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['profile/auth']
        ]); ?>
            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <a href="<?= $authAuthChoice->createClientUrl($client) ?>" class="btn btn-primary">Авторизоваться через Вконтакте</a>
            <?php endforeach; ?>
        <?php AuthChoice::end(); ?>
    </div>
</div>