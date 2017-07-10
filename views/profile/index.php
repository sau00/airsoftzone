<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php
$this->title = 'Доска страйкбольных объявлений AirsoftZone';
?>

<div class="container">

    <div class="row">
        <div class="col-md-3">
            <h3>Панель управления</h3>
            <a href="<?=\yii\helpers\Url::to(['profile/add']);?>" class="btn btn-block btn-success">Подать объявление</a>
        </div>

        <div class="col-md-9">
            <h3>Мои объявления</h3>
        </div>

    </div>

    <div class="row row-offcanvas row-offcanvas-right">

    </div><!--/row-->
</div>
