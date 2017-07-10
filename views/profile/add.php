<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['profile/auth'],
    'popupMode' => false,
]) ?>

<?php
$this->title = 'Доска страйкбольных объявлений AirsoftZone';
?>

<div class="container">

    <h1><?=$this->title;?></h1>
    <hr />

    <h3>Панель управления</h3>

    <hr />

    <div class="row row-offcanvas row-offcanvas-right">

    </div><!--/row-->
</div>
