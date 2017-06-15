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