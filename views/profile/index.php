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
            <h3>Привет, <?=\Yii::$app->user->identity->firstname;?>!</h3>
            <hr />
            <a href="<?=\yii\helpers\Url::to(['profile/add']);?>" class="btn btn-block btn-success">Подать объявление</a>
            <a href="<?=\yii\helpers\Url::to(['profile/index']);?>" class="btn btn-block btn-primary">Мои объявления</a>
        </div>

        <div class="col-md-9">
            <h3>Мои объявления</h3>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                     'title',
                     'price',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

    </div>

    <div class="row row-offcanvas row-offcanvas-right">

    </div><!--/row-->
</div>
